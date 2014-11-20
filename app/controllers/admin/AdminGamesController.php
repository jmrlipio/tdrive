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
		// $types = array();

		// foreach(GameType::orderBy('name')->get() as $type) {
		// 	$types[$type->id] = $type->name;
		// }

		$categories = [];
		$platforms = [];
		$languages = [];
		$currencies = [];

		foreach(Category::orderBy('category')->get() as $category) {
			$categories[$category->id] = $category->category;
		}

		foreach(Platform::orderBy('platform')->get() as $platform) {
			$platforms[$platform->id] = $platform->platform;
		}

		foreach(Language::orderBy('language')->get() as $language) {
			$languages[$language->id] = $language->language;
		}

		foreach(Currency::orderBy('currency')->get() as $currency) {
			$currencies[$currency->id] = $currency->currency;
		}

		return View::make('admin.games.create')
			->with('categories', $categories)
			->with('platforms', $platforms)
			->with('languages', $languages)
			->with('currencies', $currencies);
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
		echo "<pre>";
		dd($data);
		echo "</pre>";
		

		// if($validator->fails())
		// {
		// 	return Redirect::back()->withErrors($validator)->withInput();	
		// }

		// Game::create($data);

		// return Redirect::route('admin.games.index');
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