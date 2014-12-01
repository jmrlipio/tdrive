<?php

class LanguagesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /languages
	 *
	 * @return Response
	 */
	public function index()
	{
		$languages = Language::orderBy('language')->paginate(10);

		return View::make('admin.languages.index')->with('languages', $languages);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /languages/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.languages.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /languages
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Language::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Language::create($data);

		return Redirect::route('admin.languages.create')->with('message', 'You have successfully added a language.');
	}

	/**
	 * Display the specified resource.
	 * GET /languages/{id}
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
	 * GET /languages/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$language = Language::findOrFail($id);

		return View::make('admin.languages.edit')->with('language', $language);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /languages/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$language = Language::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Language::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$language->update($data);

		return Redirect::route('admin.languages.edit', $id)->with('message', 'You have successfully updated this language.');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /languages/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$language = Language::find($id);

		if($language) {
			$language->delete();
			return Redirect::route('admin.languages.index')
				->with('message', 'Language deleted')
				->with('sof', 'success');
		}

		return Redirect::route('admin.languages.index')
			->with('message', 'Something went wrong. Try again.')
			->with('sof', 'success');
	}

}