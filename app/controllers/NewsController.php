<?php

class NewsController extends \BaseController {

	public function usersindex()
	{		
		$news_article = News::orderBy('created_at', 'DESC')->with('media')->get();
		$root = Request::root();
		$thumbnails = array();
		$arr_yrs = array();
                                                 
		foreach($news_article as $news) {
			$year = date('Y', strtotime($news->created_at));
			$arr_yrs[$year] = $year;
			$years = array_unique($arr_yrs);

			foreach($news->media as $media) {
				if($media->pivot->type == 'featured') {
					$thumbnails[] = $root. '/images/uploads/' . $media->url;
				}
			}
		}
		reset($arr_yrs);
		$first_key = key($arr_yrs);


		return View::make('pages.news.index', array('className' => 'news'))
			->with('thumbnails', $thumbnails)
			->with('news_article', $news_article)	
			->with('years', $years)
			->with('selected', $first_key);
	}

	 public function getNewsByYear() {
    	$selected_year = Input::get('year');
		$news_article = News::whereYear('created_at', '=', $selected_year)->with('media')->get();

		$years = News::orderBy('created_at', 'DESC')->with('media')->get();
		
		$root = Request::root();
		$thumbnails = array();
		$arr_yrs = array();
                                                 
		foreach($news_article as $news) {			

			foreach($news->media as $media) {
				if($media->pivot->type == 'featured') {
					$thumbnails[] = $root. '/images/uploads/' . $media->url;
				}
			}
		}

		foreach ($years as $yrs) {
			$year = date('Y', strtotime($yrs->created_at)); 
			$arr_yrs[$year] = $year;
			$years = array_unique($arr_yrs);
		}


    	return View::make('pages.news.index' , array('className' => 'news'))
			->with('thumbnails', $thumbnails)
			->with('news_article', $news_article)	
			->with('years', $years)
			->with('selected', $selected_year);
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
	public function getSingleNews($id)
	{
		$count = 0;
		$news_article = News::find($id);
		$root = Request::root();
/*		$thumbnails = array();
*/		$selected_media = array();
		$media = $news_article->media[0]['url'];
		$thumbnail = $root . '/images/uploads/' . $news_article->media[0]['url']; 
		//echo $news_article->media[0]['url'];

/*		foreach($news_article->media as $media) {
			if($media->pivot->type == 'featured') {
					$thumbnails[] = $root. '/images/uploads/' . $media->url;
				}
			$count++;
		}
*/
		return View::make('pages.news.view', array('className' => 'news-detail'))
			->with('thumbnail', $thumbnail)
			->with('news_article', $news_article);
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
		$mediable = Mediable::find($id);
		
		if($news){
		 
		   $news->delete();
		   $mediable->delete();

		return Redirect::route('admin.news.index');		
		}

		return Redirect::route('admin.news.index')
			->with('message','Something went wrong, please try again.');
	}

}
