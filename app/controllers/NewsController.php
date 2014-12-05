<?php

class NewsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$news = News::orderBy('id')->paginate(10);
		return View::make('admin.news.index')->with('news', $news);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$news_categories = array();
		foreach (NewsCategory::all() as $news_cat) {
			$news_categories[$news_cat->id] = $news_cat->category;
		}

		return View::make('admin.news.create')
			->with('news_categories', $news_categories);

	}

	public function postCreatenews()
	{
		$validator = Validator::make(Input::all(), News::$rules);

		$news = new News;
		//$excerpt = Input::get('excerpt');
		
/*		if($validator->passes()){
			
			$news->user_id= Input::get('user_id');
			$news->title= Input::get('title');
			$news->status= Input::get('status');
			$news->content= Input::get('content');
			$news->excerpt = $excerpt.'...';
			$news->news_category_id = Input::get('category_id');
			$news->media()->sync(array(Input::get('featured_img_id') => array('type' => 'news')));
			$news->save();			
			return Redirect::route('admin.news.create')->with('message', 'Adding news successful.');	

		}*/

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$news = News::create($data);
		$news->media()->sync(array(Input::get('featured_img_id') => array('type' => 'news')));
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// echo '<pre>';
		// print_r(Input::all());
		// echo '</pre>';

		$validator = Validator::make($data = Input::all(), News::$rules);
		
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$news = News::create($data);
		$news->media()->sync(array(Input::get('featured_img_id') => array('type' => 'news')));
		
		return Redirect::route('admin.news.create')->with('message', 'Adding news successful.');

	}


	/**
	 * Display the specified resource.
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
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{	
		/*$news = News::orderBy('id')->paginate(10);
		return View::make('admin.news.edit')->with('news', $news);*/
		$news = News::find($id);
		var_dump($news->slug);

		$news_categories = array();
		foreach (NewsCategory::all() as $news_cat) {
			$news_categories[$news_cat->id] = $news_cat->category;
		}

		return View::make('admin.news.edit')
			->with('news_categories', $news_categories)
			->with('news', $news);
	}


	/**
	 * Update the specified resource in storage.
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
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
