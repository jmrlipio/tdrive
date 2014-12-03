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
		echo "<pre>";
		dd(Input::all());
		echo "</pre>";

		// $validator = Validator::make($data = Input::all(), Game::$rules);

		// if ($validator->fails())
		// {
		// 	return Redirect::back()->withErrors($validator)->withInput();
		// }

		// $game = Game::create($data);

		// $game->platforms()->sync(Input::get('platform_id'));
		// $game->categories()->sync(Input::get('category_id'));
		// $game->languages()->sync(Input::get('language_id'));
		// $game->media()->sync(array(Input::get('featured_img_id') => array('type' => 'featured')));
		// $game->media()->sync(Input::get('screenshot_id'));

		// return Redirect::route('admin.games.index')->with('message', 'You have successfully added a game.');
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