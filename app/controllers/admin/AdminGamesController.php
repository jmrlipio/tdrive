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
		$categories = [];
		$platforms = [];
		$languages = [];
		$carriers = [];

		foreach(Category::orderBy('category')->get() as $category) {
			$categories[$category->id] = $category->category;
		}

		foreach(Platform::orderBy('platform')->get() as $platform) {
			$platforms[$platform->id] = $platform->platform;
		}

		foreach(Language::orderBy('language')->get() as $language) {
			$languages[$language->id] = $language->language;
		}

		foreach(Carrier::orderBy('carrier')->get() as $carrier) {
			$carriers[$carrier->id] = $carrier->carrier;
		}

		return View::make('admin.games.create')
			->with('categories', $categories)
			->with('platforms', $platforms)
			->with('languages', $languages)
			->with('carriers', $carriers);
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

		$game->platforms()->sync(Input::get('platform_id'));
		$game->categories()->sync(Input::get('category_id'));
		$game->languages()->sync(Input::get('language_id'));
		$game->carriers()->sync(Input::get('carrier_id'));
		$game->media()->sync(array(Input::get('featured_img_id') => array('type' => 'featured')));

		foreach(Input::get('screenshot_id') as $scid) {
			$game->media()->attach(array($scid => array('type' => 'screenshot')));
		}

		foreach(Input::get('carrier_id') as $carrier_id) {
			foreach(Input::get('prices'.$carrier_id) as $country_id => $price) {
				$game->prices()->attach([$carrier_id, $country_id], array('price' => $price));
			}
		}
		
		return Redirect::route('admin.games.index')->with('message', 'You have successfully added a game.');
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
		$tables = ['categories','platforms','languages','media', 'carriers'];

	    $game = Game::with($tables)->get()->find($id);

		$selected_categories = [];
		$selected_platforms = [];
		$selected_languages = [];
		$selected_media = [];
		$selected_carriers = [];
		$selected_countries = [];

		foreach($game->categories as $category) {
			$selected_categories[] = $category->id;
		}

		foreach($game->platforms as $platform) {
			$selected_platforms[] = $platform->id;
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
		$platforms = [];
		$languages = [];
		$carriers = [];
		$prices = [];

		foreach(Category::orderBy('category')->get() as $category) {
			$categories[$category->id] = $category->category;
		}

		foreach(Platform::orderBy('platform')->get() as $platform) {
			$platforms[$platform->id] = $platform->platform;
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

	    $countries = Country::find($selected_countries);

		return View::make('admin.games.edit')
			->with('game', $game)
			->with('selected_categories', $selected_categories)
			->with('selected_platforms', $selected_platforms)
			->with('selected_languages', $selected_languages)
			->with('selected_media', $selected_media)
			->with('selected_carriers', $selected_carriers)
			->with('categories', $categories)
			->with('platforms', $platforms)
			->with('languages', $languages)
			->with('carriers', $carriers)
			->with('prices', $prices)
			->with('countries', $countries);

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
		$tables = ['categories','platforms','languages','media', 'carriers'];

		$game = Game::with($tables)->get()->find($id);

		$validator = Validator::make($data = Input::all(), Game::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$game->update($data);

		$game->platforms()->sync(Input::get('platform_id'));
		$game->categories()->sync(Input::get('category_id'));
		$game->languages()->sync(Input::get('language_id'));
		$game->carriers()->sync(Input::get('carrier_id'));
		
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

		foreach($game->prices as $price) {
			$game->prices()->detach($price->pivot->carrier_id);
		}

		foreach(Input::get('carrier_id') as $carrier_id) {
			foreach(Input::get('prices'.$carrier_id) as $country_id => $price) {
				$game->prices()->attach([$carrier_id, $country_id], array('price' => $price));
			}
		}

		return Redirect::back()->with('message', 'You have successfully edited this game.');
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

}