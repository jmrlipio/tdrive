<?php

class NewsController extends \BaseController {

	public function usersindex()
	{
		$news = News::orderBy('id')->paginate(10);
		return View::make('pages.news')->with('news', $news);
	}


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

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$validator = Validator::make($data = Input::all(), News::$rules);
		
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$news = News::create($data);
		$news->media()->sync(array(Input::get('featured_img_id') => array('type' => 'featured')));
		
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
		$count = 0;
		$news = News::find($id);
		$root = Request::root();
		$news_categories = array();
		$selected_media = array();
		
		foreach (NewsCategory::all() as $news_cat) {
			$news_categories[$news_cat->id] = $news_cat->category;
		}

		
		foreach($news->media as $media) {
			$selected_media[$count]['media_id'] = $media->url;
			$selected_media[$count]['media_url'] = $root. '/images/uploads/' . $media->url;
			$selected_media[$count]['type'] = $media->pivot->type;
			$count++;
		}

		/*echo '<pre>';
		dd($selected_media);
		echo '</pre>';*/

		return View::make('admin.news.edit')
			->with('news_categories', $news_categories)
			->with('news', $news)
			->with('selected_media', $selected_media);		
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$count = 0;
		$root = Request::root();		
		$news = News::find($id);	
		$validator = Validator::make($data = Input::all(), News::$rules);
		$news_categories = array();
		$selected_media = array();

		foreach (NewsCategory::all() as $news_cat) {
			$news_categories[$news_cat->id] = $news_cat->category;
		}

		foreach($news->media as $media) {
			$selected_media[$count]['media_id'] = $media->url;
			$selected_media[$count]['media_url'] = $root. '/images/uploads/' . $media->url;
			$selected_media[$count]['type'] = $media->pivot->type;
			$count++;
		}
		
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		$news->update($data);
		$news->media()->sync(array(Input::get('featured_img_id') => array('type' => 'featured')));		
		
		return View::make('admin.news.edit')
			->with('news_categories', $news_categories)
			->with('news', $news)
			->with('selected_media', $selected_media)
			->with('message', 'Update news successful.');

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$news = News::find($id);
		/*$count = 0;
		$root = Request::root();
		$selected_media = array();*/
		$mediable = Mediable::find($id);
		
		if($news){
		 
		   $news->delete();
		   $mediable->delete();

		   /*foreach($news->media as $media) {
				File::delete($root. '/images/uploads/' . $media->url);
			}*/

		return Redirect::route('admin.news.index');		
		}

		return Redirect::route('admin.news.index')
			->with('message','Something went wrong, please try again.');
	}

}
