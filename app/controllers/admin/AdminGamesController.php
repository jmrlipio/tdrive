<?php
class AdminGamesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /admingames
	 *
	 * @return Response
	 */
	public function index($category = NULL)
	{

		$games = Game::all();

		$game_category = Category::all();

		$categories = ['all' => 'All'];
		

		foreach ($game_category as $gc) {

			$categories[$gc->id] = ucfirst($gc->category);		
		
		}

		
		return View::make('admin.games.index')
			->with('games', $games)
			->with('categories', $categories)
			->with('selected', 'all');

	}
	/**
	 * Show the form for creating a new resource.
	 * GET /admingames/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$carriers = [];

		foreach(Carrier::all() as $carrier) {
			$carriers[$carrier->id] = $carrier->carrier;
		}

		return View::make('admin.games.create')
			->with(compact('carriers'));
	}
	/**
	 * Store a newly created resource in storage.
	 * POST /admingames
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Game::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		$game = Game::create($data);
		Event::fire('audit.games.create', Auth::user());

		return Redirect::route('admin.games.edit', Input::get('id'))->with('message', 'You have successfully added a game.');
	}
	/**
	 * Display the specified resource.
	 * GET /admingames/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}
	/**
	 * Show the form for editing the specified resource.
	 * GET /admingames/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $this->loadGameValues($id);
	}
	/**
	 * Update the specified resource in storage.
	 * PUT /admingames/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$game = Game::find($id);

		$edit_rules = Game::$rules;

		$edit_rules['id'] = 'required|integer|unique:games,id,' . $id;
		$edit_rules['main_title'] = 'required|min:2|unique:games,main_title,' . $id;

		$validator = Validator::make($data = Input::all(), $edit_rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$game->update($data);
		$new_id = $game->id;
		Event::fire('audit.games.update', Auth::user());

		$url = URL::route('admin.games.edit', $new_id);

		return Redirect::to($url)->with('message', 'You have successfully updated the game details.');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /admingames/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$game = Game::find($id);

		if($game) {
			$game->delete();
			return Redirect::route('admin.games.index')
				->with('message', 'Game deleted')
				->with('sof', 'success');
		}

		return Redirect::route('admin.games.index')
			->with('message', 'Something went wrong. Try again.')
			->with('sof', 'failed');

		//Event::fire('audit.games.delete', Auth::user());

	}

	public function updateContent($id)
	{
		$language_id = Input::get('language_id');
		$titles = Input::get('titles');
		$contents = Input::get('contents');
		$excerpts = Input::get('excerpts');
		$lid = Input::get('lid');

		$game = Game::find($id);

		$game->categories()->sync(Input::get('category_id'));
		$game->languages()->sync($language_id);

		foreach($game->contents as $content) {
			$game->contents()->detach($content->pivot->language_id);
		}

		for($i = 0; $i < count($lid); $i++) {
			$game->contents()->attach($lid[$i], array('title' => $titles[$i], 'content' => $contents[$i], 'excerpt' => $excerpts[$i]));
		}

		return $this->loadGameValues($id);
	}

	public function updateFields($id)
	{
		$game = Game::find($id);
		$url = URL::route('admin.games.edit', $game->id) . '#custom-fields';

		$validator = Validator::make($data = Input::all(), Game::$fieldRules);

		if ($validator->fails())
		{
			return Redirect::to($url)->withErrors($validator)->withInput();
		}

		$game->categories()->sync(Input::get('category_id'));
		$game->languages()->sync(Input::get('language_id'));

		return Redirect::to($url)->with('message', 'You have successfully updated the game fields.');
	}

	public function updateMedia($id)
	{
		$game = Game::find($id);

		if(Input::hasFile('promo')) {
			$promo = Input::file('promo');
			$promo_name = $this->saveMedia($promo, 'promos');
			$this->syncMedia($game, 'promos', $promo_name);
		}
		
		if(Input::hasFile('icon')) {
			$icon = Input::file('icon');
			$icon_name = $this->saveMedia($icon, 'icons');
			$this->syncMedia($game, 'icons', $icon_name);
		}

		if(Input::get('video') != '') {
			$video = Input::get('video');
			$this->syncMedia($game, 'video', $video);
		} else {
			foreach($game->media as $media) {
				if($media->type == 'video') {
					$game->media()->detach($media->id);
				}
			}
		}

		if(Input::hasFile('homepage')) {
			$homepage = Input::file('homepage');
			$homepage_name = $this->saveMedia($homepage, 'homepage');
			$this->syncMedia($game, 'homepage', $homepage_name);
		}

		$orientation = Input::get('image_orientation');

		$game->update(array('image_orientation' => $orientation));

		$screenshots = Input::file('screenshots');
		$ssid = Input::get('ssid');

		foreach($screenshots as $screenshot) {
			if($screenshot != null) {
				$screenshot_name = $this->saveMedia($screenshot, 'screenshots', $orientation);
				$this->syncMedia($game, 'screenshots', $screenshot_name, $ssid);
			}
		}

		$url = URL::route('admin.games.edit', $game->id) . '#media';

		return Redirect::to($url)->with('message', 'You have successfully updated the game media.');
	}

	private function saveMedia($media_file, $folder, $orientation = '') {
		if($orientation != '') $orientation .= '-';

		$media_name = time() . "_" . $media_file->getClientOriginalName();
		$media_path = public_path('assets/games/' . $folder . '/' . $orientation . $media_name);
		Image::make($media_file->getRealPath())->save($media_path);

		return $media_name;
	}

	private function syncMedia($game, $type, $media_name, $ssid = '') {
		$details = [
			'url' => $media_name,
			'type' => $type
		];

		$new_media = Media::create($details);

		foreach($game->media as $media) {

			if($media->type == $type) {

				if($type == 'screenshots') {

					if(!in_array($media->id, $ssid)) $game->media()->detach($media->id);

				} else $game->media()->detach($media->id);

			}
			
		}

		$game->media()->attach($new_media->id);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /admingames/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function loadGameValues($id) {
		$game = Game::find($id);

		$carrier = Carrier::find($game->carrier_id);

		$selected_categories = [];
		$selected_languages = [];
		$selected_media = [];
		$selected_countries = [];

		foreach($game->categories as $category) {
			$selected_categories[] = $category->id;
		}

		foreach($game->languages as $language) {
			$selected_languages[] = $language->id;
		}

		$count = 0;
		$root = Request::root();

		foreach($game->media as $media) {
			$orientation = '';
			if($media->type == 'screenshots') $orientation = $game->image_orientation . '-';

			if($media->type == 'video') $media_url = $media->url;
			else $media_url = $root . '/assets/games/' . $media->type . '/' . $orientation . $media->url;

			$selected_media[$count]['media_id'] = $media->id;
			$selected_media[$count]['media_url'] = $media_url;
			$selected_media[$count]['type'] = $media->type;
			$count++;
		}

		$categories = [];
		$languages = [];
		$selected_countries = [];
		$prices = [];
		$countries = Country::all();
		$carriers = [];

		foreach(Carrier::all() as $carrier) {
			$carriers[$carrier->id] = $carrier->carrier;
		}

		foreach(Category::orderBy('category')->get() as $category) {
			$categories[$category->id] = $category->category;
		}

		foreach(Language::orderBy('language')->get() as $language) {
			$languages[$language->id] = $language->language;
		}

		foreach($carrier->countries as $country) {
			$selected_countries[$country->id] = $country->currency_code;
		}

		foreach($game->prices as $price) {
			if($price->pivot->carrier_id == $game->carrier_id) {
				$prices[$price->pivot->country_id] = $price->pivot->price;
			}
	    }

		return View::make('admin.games.edit')
			->with('game', $game)
			->with('selected_categories', $selected_categories)
			->with('selected_languages', $selected_languages)
			->with('selected_media', $selected_media)
			->with('categories', $categories)
			->with('languages', $languages)
			->with('countries', $countries)
			->with('selected_countries', $selected_countries)
			->with('prices', $prices)
			->with('carriers', $carriers);
	}

	public function getLanguageContent($id, $language_id) {
		$game = Game::find($id);
		$language = Language::find($language_id);

		$title = '';
		$content = '';
		$excerpt = '';

		foreach($game->contents as $game_content) {
			if($game_content->pivot->language_id == $language_id) {
				$excerpt = $game_content->pivot->excerpt;
				$title = $game_content->pivot->title;
		    	$content = $game_content->pivot->content;
			}
	    }

		return View::make('admin.games.content')
			->with('game', $game)
			->with('language_id', $language_id)
			->with('language', $language)
			->with('content', $content)
			->with('title', $title)
			->with('excerpt', $excerpt);
	}

	public function updateLanguageContent($id, $language_id) {
		$game = Game::find($id);
		$language = Language::find($language_id);

		foreach($game->contents as $content) {
			if($content->pivot->language_id == $language_id) {
				$game->contents()->detach($content->pivot->language_id);
			}	
		}

		$game->contents()->attach($language_id, array('title' => Input::get('title'), 'content' => Input::get('content'), 'excerpt' => Input::get('excerpt')));

		return Redirect::back()->with('message', 'You have successfully updated this game content');
	}

	public function getPriceContent($id, $carrier_id) {
		$game = Game::find($id);
		$carrier = Carrier::find($carrier_id);
		$countries = Country::all();
		$prices = [];

		foreach($game->prices as $price) {
			if($price->pivot->carrier_id == $carrier_id) {
				$prices[$price->pivot->country_id] = $price->pivot->price;
			}
	    }

	    $carrier = Carrier::find($carrier_id);

		$selected_countries = [];

		foreach($carrier->countries as $country) {
			$selected_countries[$country->id] = $country->currency_code;
		}

	    return View::make('admin.games.price')
	    	->with('game', $game)
	    	->with('countries', $countries)
	    	->with('selected_countries', $selected_countries)
	    	->with('prices', $prices)
	    	->with('carrier', $carrier);
	}

	public function updatePriceContent($id, $carrier_id) {
		$game = Game::find($id);
		$carrier = Carrier::find($carrier_id);

		$url = URL::route('admin.games.edit', $game->id) . '#game-content';

		$game->prices()->detach($carrier_id);

		foreach(Input::get('prices') as $country_id => $price) {
			$game->prices()->attach([$carrier_id, $country_id], array('price' => $price));
		}

		return Redirect::to($url)->with('message', 'You have successfully updated this game content');
	}

	public function getGameByCategory() 
    {
    	
		$selected_cat = Input::get('game_category');
    	
    	$game_category = Category::all(); 
    	
    	$categories = ['all' => 'All'];	

		foreach ($game_category as $gc) {

			$categories[$gc->id] = ucfirst($gc->category);		
		
		}

		if($selected_cat != 'all'){

	    	$games = Game::whereHas('categories', function($q) use($selected_cat) {
	    		
	    		$q->where('category_id', '=', $selected_cat);
	    	
	    	})->get();   
    		
    	} else {

    		$games = Game::all();

    	}

		return View::make('admin.games.index')
			->with('games', $games)
			->with('categories', $categories)
			->with('selected', $selected_cat);
    }

    public function getGameReviews($id) {
    	$game = Game::find($id);

    	return View::make('admin.games.reviews')
    		->with('game', $game);
    	
    }
}