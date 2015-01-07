<?php

class CategoriesController extends \BaseController {

	public function __construct(){

		parent::__construct();
		$this->beforeFilter('role', array('only'=> array('create', 'store', 'edit', 'update', 'destroy')));
	}

	/**
	 * Display a listing of the resource.
	 * GET /categories
	 *
	 * @return Response
	 */
	public function index()
	{
		$categories = Category::orderBy('category')->paginate(10);

		return View::make('admin.categories.index')->with('categories', $categories);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /categories/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.categories.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /categories
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Category::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Category::create($data);

		return Redirect::route('admin.categories.create')->with('message', 'You have successfully added a category.');
	}

	/**
	 * Display the specified resource.
	 * GET /categories/{id}
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
	 * GET /categories/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$category = Category::findOrFail($id);

		return View::make('admin.categories.edit')->with('category', $category);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /categories/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$category = Category::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Category::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$category->update($data);

		return Redirect::route('admin.categories.edit', $id)->with('message', 'You have successfully updated this category.');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /categories/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$category = Category::find($id);

		if($category) {
			$category->delete();
			return Redirect::route('admin.categories.index')
				->with('message', 'Category deleted')
				->with('sof', 'success');
		}

		return Redirect::route('admin.categories.index')
			->with('message', 'Something went wrong. Try again.')
			->with('sof', 'success');
	}

}