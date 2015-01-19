<?php

class DiscountsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /discounts
	 *
	 * @return Response
	 */
	public function index()
	{
		$discounts = Discount::all();

		return View::make('admin.discounts.index')
			->with('discounts', $discounts);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /discounts/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$games = [];

		foreach(Game::all() as $game) {
			$games[$game->id] = $game->main_title;
		}

		return View::make('admin.discounts.create')
			->with('games', $games);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /discounts
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Discount::$rules);

		if(Input::hasFile('featured_image')) {
			$featured = Input::file('featured_image');
			$filename = time() . "_" . $featured->getClientOriginalName();
			$path = public_path('assets/discounts/' . $filename);
			Image::make($featured->getRealPath())->save($path);

			$data['featured_image'] = $filename;
		}

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		$discount = Discount::create($data);
		
		return Redirect::route('admin.discounts.edit',$discount->id)->with('message', 'You have successfully added a discount.');
	}

	/**
	 * Display the specified resource.
	 * GET /discounts/{id}
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
	 * GET /discounts/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$discount = Discount::find($id);

		$games = [];

		foreach(Game::all() as $game) {
			$games[$game->id] = $game->main_title;
		}

		return View::make('admin.discounts.edit')
			->with('discount', $discount)
			->with('games', $games);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /discounts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$discount = Discount::find($id);

		$edit_rules = Discount::$rules;

		$edit_rules['featured_image'] = '';

		$validator = Validator::make($data = Input::all(), $edit_rules);

		if(Input::hasFile('featured_image')) {
			$featured = Input::file('featured_image');
			$filename = time() . "_" . $featured->getClientOriginalName();
			$path = public_path('assets/discounts/' . $filename);
			Image::make($featured->getRealPath())->save($path);

			$data['featured_image'] = $filename;
		} else {
			$data['featured_image'] = $discount->featured_image;
		}
		
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}		

		$discount->update($data);

		return Redirect::back()->with('message', 'You have successfully updated this discount item.');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /discounts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$discount = Discount::find($id);
		
		if($discount)
		{
			$discount->delete();
			// Event::fire('audit.discount.delete', Auth::user());

			return Redirect::route('admin.discounts.index')
				->with('message', 'News deleted')
				->with('sof', 'success');	
		}

		return Redirect::route('admin.discounts.index')
			->with('message', 'Something went wrong. Try again.')
			->with('sof', 'failed');
	}

}