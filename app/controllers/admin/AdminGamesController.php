<?php
class AdminGamesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /admingames
	 *
	 * @return Response
	 */
	public function index()
	{
		$games = Game::orderBy('id')->paginate(8);
		
		return View::make('admin.games.index')->with('games', $games);
	}
	/**
	 * Show the form for creating a new resource.
	 * GET /admingames/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.games.create');
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

		return Redirect::route('admin.games.edit',$game->id)->with('message', 'You have successfully added a game.');
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

		$edit_rules['main_title'] = 'required|min:2|unique:games,main_title,' . $id;

		$validator = Validator::make($data = Input::all(), $edit_rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$game->update($data);

		return Redirect::back()->with('message', 'You have successfully updated the game details.');
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
		//
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

		$game->carriers()->sync(Input::get('carrier_id'));
		$game->categories()->sync(Input::get('category_id'));
		$game->languages()->sync(Input::get('language_id'));

		return Redirect::to($url)->with('message', 'You have successfully updated the game fields.');
	}

	public function updateMedia($id)
	{
		$game = Game::find($id);

		$orientation = Input::get('orientation');

		$promo = Input::file('promo_image');
		$promo_name = time() . "_" . $promo->getClientOriginalName();
		$promo_path = public_path('assets/games/promo/' . $promo_name);
		Image::make($promo->getRealPath())->save($promo_path);

		$promo_details = [
			'url' => $promo_name,
			'type' => 'promo'
		];

		$promo_media = Media::create($promo_details);

		foreach($game->media as $media) {
			if($media->type == 'promo') {
				$game->media()->detach($media->id);
			}
		}

		$game->media()->attach($promo_media->id);

		$icon = Input::file('icon');
		$icon_name = time() . "_" . $icon->getClientOriginalName();
		$icon_path = public_path('assets/games/icons/' . $icon_name);
		Image::make($icon->getRealPath())->save($icon_path);

		$screenshots = Input::file('screenshots');

		$icon_details = [
			'url' => $icon_name,
			'type' => 'icon'
		];

		$icon_media = Media::create($icon_details);

		foreach($game->media as $media) {
			if($media->type == 'icon') {
				$game->media()->detach($media->id);
			}
		}

		$game->media()->attach($icon_media->id);

		foreach($screenshots as $screenshot) {
			$screenshot_name = time() . "_" . $screenshot->getClientOriginalName();
			$screenshot_path = public_path('assets/games/screenshots/' . $orientation . '_' . $screenshot_name);
			Image::make($screenshot->getRealPath())->save($screenshot_path);

			foreach($game->media as $media) {
				if($media->type == 'screenshot') {
					$game->media()->detach($media->id);
				}
			}

			Image::make($screenshot->getRealPath())->save($screenshot_path);

			$screenshot_details = [
				'url' => $icon_name,
				'type' => 'screenshot'
			];

			$screenshot_media = Media::create($screenshot_details);
		}

		$url = URL::route('admin.games.edit', $game->id) . '#media';

		return Redirect::to($url)->with('message', 'You have successfully updated the game media.');
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

		$selected_categories = [];
		$selected_languages = [];
		$selected_media = [];
		$selected_carriers = [];
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
			$selected_media[$count]['media_id'] = $media->id;
			$selected_media[$count]['media_url'] = $root. '/images/uploads/' . $media->url;
			$selected_media[$count]['type'] = $media->pivot->type;
			$count++;
		}

		foreach($game->carriers as $carrier) {
			$selected_carriers[] = $carrier->id;
		}

		$categories = [];
		$languages = [];
		$carriers = [];

		foreach(Category::orderBy('category')->get() as $category) {
			$categories[$category->id] = $category->category;
		}

		foreach(Language::orderBy('language')->get() as $language) {
			$languages[$language->id] = $language->language;
		}

		foreach(Carrier::orderBy('carrier')->get() as $carrier) {
			$carriers[$carrier->id] = $carrier->carrier;
		}

		return View::make('admin.games.edit')
			->with('game', $game)
			->with('selected_categories', $selected_categories)
			->with('selected_languages', $selected_languages)
			->with('selected_media', $selected_media)
			->with('selected_carriers', $selected_carriers)
			->with('categories', $categories)
			->with('languages', $languages)
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

		$game->prices()->detach($carrier_id);

		foreach(Input::get('prices') as $country_id => $price) {
			$game->prices()->attach([$carrier_id, $country_id], array('price' => $price));
		}

		return Redirect::back()->with('message', 'You have successfully updated this game content');
	}
}