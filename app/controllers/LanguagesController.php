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
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('message', 'Adding language failed.')
				->with('sof', 'fail');

		}

		Language::create($data);

		return Redirect::back()->with('message', 'You have successfully added a language.');
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
			->with('sof', 'fail');
	}

	public function chooseLanguage()
	{
		Session::forget('locale');
		Session::put('locale', Input::get('locale'));
	}

	public function getLanguage()
	{
		/* TODO: check if session has carrier */
		if (!Session::has('carrier')) {
			
			Session::put('country_id', Input::get('country_id'));
			Session::put('carrier', Input::get('selected_carrier'));
			$country = Country::find(Input::get('country_id'));
			$first_visit = true;
					
		} else {			
			
			$country = Country::find(Session::get('country_id'));
			$first_visit = false;
		}



		if(!Session::has('country_id')) {
			$user_location = GeoIP::getLocation();
			$country = Country::where('name', $user_location['country'])->first();
			$country_id = $country->id;
		}

		$carrier = Carrier::find(Session::get('carrier'));
		$countries = [];

		if(!Session::has('locale')) {
			Session::put('locale', strtolower($carrier->language->iso_code));
		}

		Session::put('carrier_name', $carrier->carrier);		
		Session::put('user_country', $country->full_name);

		return Redirect::route('home.show');
	}

}
