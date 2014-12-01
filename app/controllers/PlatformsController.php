<?php

class PlatformsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /platforms
	 *
	 * @return Response
	 */
	public function index()
	{
		$platforms = Platform::orderBy('platform')->paginate(10);;

		return View::make('admin.platforms.index')->with('platforms', $platforms);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /platforms/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.platforms.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /platforms
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$validator = Validator::make($data = Input::all(), Platform::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Platform::create($data);

		return Redirect::route('admin.platforms.create')->with('message', 'You have successfully added a platform.');
	}

	/**
	 * Display the specified resource.
	 * GET /platforms/{id}
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
	 * GET /platforms/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$platform = Platform::findOrFail($id);

		return View::make('admin.platforms.edit')->with('platform', $platform);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /platforms/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$platform = Platform::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Platform::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$platform->update($data);

		return Redirect::route('admin.platforms.edit', $id)->with('message', 'You have successfully updated this platform.');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /platforms/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$platform = Platform::find($id);

		if($platform) {
			$platform->delete();
			return Redirect::route('admin.platforms.index')
				->with('message', 'Platform deleted')
				->with('sof', 'success');
		}

		return Redirect::route('admin.platforms.index')
			->with('message', 'Something went wrong. Try again.')
			->with('sof', 'success');
	}

}