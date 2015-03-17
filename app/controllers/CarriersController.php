<?php

class CarriersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /carriers
	 *
	 * @return Response
	 */

	public function index()
	{
		$carriers = Carrier::orderBy('carrier')->paginate(10);

		return View::make('admin.carriers.index')->with('carriers', $carriers);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /carriers/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$countries = [];
		$languages = [];

		foreach(Language::orderBy('language')->get() as $language) {
			$languages[$language->id] = $language->language;
		}

		foreach(Country::orderBy('full_name')->get() as $country) {
			$countries[$country->id] = $country->full_name;
		}

		return View::make('admin.carriers.create')
			->with('countries', $countries)
			->with('languages', $languages);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /carriers
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Carrier::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Carrier::create($data);

		$carrier = Carrier::find(Input::get('id'));

		$countries = Input::get('country_id');

		foreach($countries as $country_id) {
			$carrier->countries()->attach($country_id);
		}

		return Redirect::route('admin.carriers.create')->with('message', 'You have successfully added a carrier.');
	}

	/**
	 * Display the specified resource.
	 * GET /carriers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /carriers/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$carrier = Carrier::with('countries')->get()->find($id);

		$selected_countries = [];
		$countries = [];

		foreach($carrier->countries as $country) {
			$selected_countries[] = $country->id;
		}

		foreach(Country::orderBy('full_name')->get() as $country) {
			$countries[$country->id] = $country->full_name;
		}

		return View::make('admin.carriers.edit')
			->with('carrier', $carrier)
			->with('selected_countries', $selected_countries)
			->with('countries', $countries);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /carriers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$carrier = Carrier::with('countries')->get()->find($id);

		$selected_countries = [];

		foreach($carrier->countries as $country) {
			$selected_countries[] = $country->id;
		}

		$edit_rules = Carrier::$rules;

		$edit_rules['carrier'] = 'required|min:3|unique:carriers,carrier,' . $id;

		$validator = Validator::make($data = Input::all(), $edit_rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$carrier->update($data);

		$countries = Input::get('country_id');

		foreach($selected_countries as $scid) {
			if(!in_array($scid, $countries)) {
				$carrier->countries()->detach($scid);
			}
		}

		foreach($countries as $country_id) {
			if(!in_array($country_id, $selected_countries)) {
				$carrier->countries()->attach($country_id);
			}
		}

		return Redirect::route('admin.carriers.edit', $id)->with('message', 'You have successfully updated this carrier.');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /carriers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$carrier = Carrier::find($id);

		if($carrier) {
			$carrier->delete();
			return Redirect::route('admin.carriers.index')
				->with('message', 'Carrier deleted')
				->with('sof', 'success');
		}

		return Redirect::route('admin.carriers.index')
			->with('message', 'Something went wrong. Try again.')
			->with('sof', 'success');
	}

	public function loadCarrier() {
		$carrier = Carrier::with('countries')->get()->find(Input::get('carrier_id'));

		$selected_countries = [];

		foreach($carrier->countries as $country) {
			$selected_countries[$country->id] = $country->currency_code;
		}

		return $selected_countries;
	}

}