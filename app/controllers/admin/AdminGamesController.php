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
		$games = Game::all();

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
		$prices = [];
		$contents = [];

		foreach(Category::orderBy('category')->get() as $category) {
			$categories[$category->id] = $category->category;
		}

		foreach(Language::orderBy('language')->get() as $language) {
			$languages[$language->id] = $language->language;
		}

		foreach(Carrier::orderBy('carrier')->get() as $carrier) {
			$carriers[$carrier->id] = $carrier->carrier;
		}

		$count = 0;

		foreach($game->prices as $price) {
			$prices[$count]['country_id'] = $price->pivot->country_id;
			$prices[$count]['carrier_id'] = $price->pivot->carrier_id;
			$prices[$count]['price'] = $price->pivot->price;
			$selected_countries[] = $price->pivot->country_id;
			$count++;
	    }

	    $count = 0;

	    foreach($game->contents as $content) {
	    	$contents[$count]['language_id'] = $content->pivot->language_id;
	    	$contents[$count]['title'] = $content->pivot->title;
	    	$contents[$count]['content'] = $content->pivot->content;
	    	$contents[$count]['excerpt'] = $content->pivot->excerpt;
	    	$count++;
	    }

	    $countries = Country::find($selected_countries);

		return View::make('admin.games.edit')
			->with('game', $game)
			->with('selected_categories', $selected_categories)
			->with('selected_languages', $selected_languages)
			->with('selected_media', $selected_media)
			->with('selected_carriers', $selected_carriers)
			->with('categories', $categories)
			->with('languages', $languages)
			->with('carriers', $carriers)
			->with('prices', $prices)
			->with('countries', $countries)
			->with('contents', $contents);
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

		$validator = Validator::make($data = Input::all(), Game::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$game->update($data);

		return $this->loadGameValues($game);
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

		return $this->loadGameValues($game);
	}

	public function updateCarrier($id)
	{
		$game = Game::find($id);

		$game->carriers()->sync(Input::get('carrier_id'));

		foreach($game->prices as $price) {
			$game->prices()->detach($price->pivot->carrier_id);
		}

		foreach(Input::get('carrier_id') as $carrier_id) {
			foreach(Input::get('prices'.$carrier_id) as $country_id => $price) {
				$game->prices()->attach([$carrier_id, $country_id], array('price' => $price));
			}
		}

		return $this->loadGameValues($game);
	}

	public function updateMedia($id)
	{
		$game = Game::find($id);

		$new_media = Input::get('screenshot_id');
		$game->media()->sync($new_media);

		$game2 = Game::with('media')->get()->find($id);

		foreach($game2->media as $media) {
			if($media->pivot->type != 'featured') {
				$media->pivot->type = 'screenshot';
				$media->pivot->save();
			}
		}

		$game->media()->attach(Input::get('featured_img_id'), array('type' => 'featured'));

		return $this->loadGameValues($game);
	}

	public function loadGameValues($game) {
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
		$prices = [];
		$contents = [];

		foreach(Category::orderBy('category')->get() as $category) {
			$categories[$category->id] = $category->category;
		}

		foreach(Language::orderBy('language')->get() as $language) {
			$languages[$language->id] = $language->language;
		}

		foreach(Carrier::orderBy('carrier')->get() as $carrier) {
			$carriers[$carrier->id] = $carrier->carrier;
		}

		$count = 0;

		foreach($game->prices as $price) {
			$prices[$count]['country_id'] = $price->pivot->country_id;
			$prices[$count]['carrier_id'] = $price->pivot->carrier_id;
			$prices[$count]['price'] = $price->pivot->price;
			$selected_countries[] = $price->pivot->country_id;
			$count++;
	    }

	    $count = 0;

	    foreach($game->contents as $content) {
	    	$contents[$count]['language_id'] = $content->pivot->language_id;
	    	$contents[$count]['title'] = $content->pivot->title;
	    	$contents[$count]['content'] = $content->pivot->content;
	    	$contents[$count]['excerpt'] = $content->pivot->excerpt;
	    	$count++;
	    }

	    $countries = Country::find($selected_countries);

		return View::make('admin.games.edit')
			->with('game', $game)
			->with('selected_categories', $selected_categories)
			->with('selected_languages', $selected_languages)
			->with('selected_media', $selected_media)
			->with('selected_carriers', $selected_carriers)
			->with('categories', $categories)
			->with('languages', $languages)
			->with('carriers', $carriers)
			->with('prices', $prices)
			->with('countries', $countries)
			->with('contents', $contents);
	}

}