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
		// echo "<pre>";
		// dd(Input::all());
		// echo "</pre>";
		

		$validator = Validator::make($data = Input::all(), Game::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$game = Game::create($data);

		$platforms = Input::get('platform_id');
		$categories = Input::get('category_id');
		$languages = Input::get('language_id');

		foreach($platforms as $platform_id) {
			$game->platforms()->attach($platform_id);
		}

		foreach($categories as $category_id) {
			$game->categories()->attach($category_id);
		}

		foreach($languages as $language_id) {
			$game->languages()->attach($language_id);
		}
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
		//
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
		//
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