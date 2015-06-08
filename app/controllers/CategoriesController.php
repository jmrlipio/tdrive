<?php

class CategoriesController extends \BaseController {

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
		$languages = [];

		foreach(Language::all() as $language) {
			$languages[$language->id] = $language->language;
		}
		return View::make('admin.categories.create')
					->with('languages', $languages);
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

		$rules = array(
		        'category'=>'required|unique:categories,category,'.$id 
		        );

		$validator = Validator::make($data = Input::all(), $rules);

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

	public function update_featured()
	{
		$data = Input::all();
        
        if(Request::ajax())
        {
            $id = $data['id'];
            $featured = Category::where('id', $id)->first();
            $featured->featured = $data['featured'];
            $featured->update();
        }
	}

	public function addVariant($id) 
	{
		$category = Category::findOrFail($id);
		$languages = [];
		$has_languages = [];
		$all_languages = Language::all();

		foreach($all_languages as $language) 
		{
			$languages[$language->id] = $language->language;
		}

		return View::make('admin.categories.variant.create')
			->with(compact('category', 'languages'));
	}

	public function storeVariant($id) 
	{
		$category = Category::findOrFail($id);
		$language_id = Input::get('language_id');
		$variant = Input::get('variant');

		//$category->languages()->attach($language_id, array('variant' => $variant, 'answer' => $answer));
		DB::table('category_languages')->insert(
			    array(	'language_id' => Input::get('language_id'), 
			    		'category_id' => $id,
			    		'variant' => Input::get('variant'),
			    		)
			);

		return Redirect::route('admin.categories.index');

	}

	public function editVariant($cat_id, $variant_id) 
	{
		$variant = DB::table('category_languages')
					 ->where('id', $variant_id)
					 ->first();
		$category = Category::findOrFail($cat_id);

		return View::make('admin.categories.variant.edit')
					->with('variant', $variant)
					->with('category', $category);
	}

	public function updateVariant($id) 
	{
		$variant = DB::table('category_languages')
					 ->where('id', $id)
					 ->update(array('variant' => Input::get('variant')));

		return Redirect::back()
						->with('message', 'Update Successfully');
	}

	public function deleteVariant($id) 
	{
		$variant = DB::table('category_languages')
					->where('id', $id)
					->delete();
		return Redirect::route('admin.categories.index');
	}

}