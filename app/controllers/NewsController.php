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

	// public function show($id, $slug) {
    public function show($id) {
		$languages = Language::all();

		$news = News::find($id);

		$page_title = $news->main_title;
		//page tracker
		$visitor = Tracker::currentSession();

		return View::make('news')
			->with('page_title', $page_title)
			->with('page_id', 'news-detail')
			->with(compact('news'))
			->with(compact('languages'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($category = NULL)
	{		
		$news = News::all();

		$categories = ['all' => 'All'];

		$news_category = NewsCategory::all();

		foreach($news_category as $nc){
			$categories[$nc->id] = ucfirst($nc->category);
		}

		return View::make('admin.news.index')
			->with('news', $news)
			->with('categories', $categories)
			->with('selected', 'all');
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

		if(Input::hasFile('featured_image')) {
			$featured = Input::file('featured_image');
			$filename = time() . "_" . $featured->getClientOriginalName();
			$path = public_path('assets/news/' . $filename);
			Image::make($featured->getRealPath())->save($path);

			$data['featured_image'] = $filename;

			$homepage = Input::file('homepage_image');
			$filename = time() . "_" . $homepage->getClientOriginalName();
			$path = public_path('assets/news/' . $filename);
			Image::make($homepage->getRealPath())->save($path);

			$data['homepage_image'] = $filename;

			switch($data['status']){

				case 1:
					$data['status'] = 'draft';
					break;

				case 2:
					$data['status'] = 'live';
					break;

			}
		}

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$news = News::create($data);
		Event::fire('audit.news.create', Auth::user());

		return Redirect::route('admin.news.edit',$news->id)->with('message', 'You have successfully added a news.');
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
		$news = News::find($id);
		$languages = [];
		$news_categories = [];
		$selected_languages = [];
		
		foreach($news->languages as $language) {
			$selected_languages[] = $language->id;
		}
		
		foreach (NewsCategory::all() as $news_cat) {
			$news_categories[$news_cat->id] = $news_cat->category;
		}

		foreach(Language::orderBy('language')->get() as $language) {
			$languages[$language->id] = $language->language;
		}

		return View::make('admin.news.edit')
			->with('news', $news)
			->with('news_categories', $news_categories)
			->with('languages', $languages)
			->with('selected_languages', $selected_languages);		
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$news = News::find($id);

		// dd(Input::all());

		$edit_rules = News::$rules;

		/*$edit_rules['featured_image'] = '';
		$edit_rules['homepage_image'] = '';*/

		$validator = Validator::make($data = Input::all(), $edit_rules);

		/*if(Input::hasFile('featured_image')) {
			$featured = Input::file('featured_image');
			$filename = time() . "_" . $featured->getClientOriginalName();
			$path = public_path('assets/news/' . $filename);
			Image::make($featured->getRealPath())->save($path);

			$data['featured_image'] = $filename;
		} else {
			$data['featured_image'] = $news->featured_image;
		}

		if(Input::hasFile('homepage_image')) {
			$homepage = Input::file('homepage_image');
			$filename = time() . "_" . $homepage->getClientOriginalName();
			$path = public_path('assets/news/' . $filename);
			Image::make($homepage->getRealPath())->save($path);

			$data['homepage_image'] = $filename;
		} else {
			$data['homepage_image'] = $news->homepage_image;
		}*/
		
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}		
		
		//TODO: add update call, what?
		Event::fire('audit.faqs.update', Auth::user());	

		$news->update($data);

		return Redirect::back()->with('message', 'You have successfully updated this news details.');

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
		
		if($news)
		{
			$news->delete();
			Event::fire('audit.news.delete', Auth::user());

			$featured_img = public_path().'/assets/news/'.$news->featured_image;
			$homepage_img = public_path().'/assets/news/'.$news->homepage_image;

			if($featured_img && $homepage_img)
			{
				File::delete($featured_img, $homepage_img);
			}

			return Redirect::route('admin.news.index')
				->with('message', 'News deleted')
				->with('sof', 'success');	


		}

		return Redirect::route('admin.news.index')
			->with('message', 'Something went wrong. Try again.')
			->with('sof', 'failed');
	}

	public function updateFields($id)
	{
		$news = News::find($id);
		$url = URL::route('admin.news.edit', $news->id) . '#custom-fields';

		$validator = Validator::make($data = Input::all(), News::$fieldRules);

		if ($validator->fails())
		{
			return Redirect::to($url)->withErrors($validator)->withInput();
		}

		$news->languages()->sync(Input::get('language_id'));

		return Redirect::to($url)->with('message', 'You have successfully updated the news fields.');
	}

	public function getLanguageContent($id, $language_id) {
		$news = News::find($id);
		$language = Language::find($language_id);

		$title = '';
		$content = '';
		$excerpt = '';

		foreach($news->contents as $news_content) {
			if($news_content->pivot->language_id == $language_id) {
				$excerpt = $news_content->pivot->excerpt;
				$title = $news_content->pivot->title;
		    	$content = $news_content->pivot->content;
			}
	    }

		return View::make('admin.news.content')
			->with('news', $news)
			->with('language_id', $language_id)
			->with('language', $language)
			->with('content', $content)
			->with('title', $title)
			->with('excerpt', $excerpt);
	}

	public function updateLanguageContent($id, $language_id) {
		$news = News::find($id);
		$language = Language::find($language_id);

		foreach($news->contents as $content) {
			if($content->pivot->language_id == $language_id) {
				$news->contents()->detach($content->pivot->language_id);
			}	
		}

		$news->contents()->attach($language_id, array('title' => Input::get('title'), 'content' => Input::get('content'), 'excerpt' => Input::get('excerpt')));

		return Redirect::back()->with('message', 'You have successfully updated this news content');
	}

	public function getNewsByCategory() 
    {
    	
		$selected_cat = Input::get('cat');
    	$news_category = NewsCategory::all();  
    	$categories = ['all' => 'All'];

    	foreach($news_category as $nc){
			$categories[$nc->id] = ucfirst($nc->category);
		}


		if($selected_cat != 'all'){

	    	$news = News::whereHas('NewsCategory', function($q) use($selected_cat) {
	    		$q->where('id', '=', $selected_cat);
	    	})->get();   
    		
    	} else {

    		$news = News::all();

    	}

		return View::make('admin.news.index')
			->with('news', $news)
			->with('categories', $categories)
			->with('selected', $selected_cat);
    }

    public function addVariant($id) {
    	$news = News::findOrFail($id);
		$languages = [];

		foreach(Language::all() as $language) {
			$languages[$language->id] = $language->language;
		}

		return View::make('admin.news.variant.create')
			->with(compact('news', 'languages'));
    }

    public function storeVariant($id) {
    	$news = News::findOrFail($id);
		$language_id = Input::get('language_id');
		$languages = [];

		$data = [
			'title' => Input::get('title'),
			'content' => Input::get('content'),
			'excerpt' => Input::get('excerpt')
		];

		$news->languages()->attach($language_id, $data);

		foreach(Language::all() as $language) {
			$languages[$language->id] = $language->language;
		}

		return Redirect::route('admin.news.variant.edit', array('id' => $id, 'language_id' => $language_id))
			->with(compact('news', 'languages', 'data'))
			->with('language_id', $language_id)
			->with('message', 'You have successfully added a variant.');
    }

    public function editVariant($news_id, $language_id) {
    	$news = News::findOrFail($news_id);
		$languages = [];
		
		$data = [];

		foreach(Language::all() as $language) {
			$languages[$language->id] = $language->language;
		}

		foreach($news->languages as $nw) {
			if($nw->pivot->language_id == $language_id) {
				$data['title'] = $nw->pivot->title;
				$data['content'] = $nw->pivot->content;
				$data['excerpt'] = $nw->pivot->excerpt;
			}
		}

		return View::make('admin.news.variant.edit')
			->with(compact('news', 'languages', 'data'))
			->with('language_id', $language_id);
    }

    public function updateVariant($id, $language_id) {
		$news = News::findOrFail($id);

		$validator = Validator::make($data = Input::all(), News::$content_rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$data = [
			'title' => Input::get('title'),
			'content' => Input::get('content'),
			'excerpt' => Input::get('excerpt')
		];

		$news->languages()->updateExistingPivot($language_id, $data);
		
		return Redirect::back()->with('message', 'You have successfully updated this variant.');
	}

	public function deleteVariant($id, $language_id) {
		$news = News::findOrFail($id);

		$news->languages()->detach($language_id);
		$message = 'Successfully deleted variant.';

		return Redirect::route('admin.news.index')
			->with('message', $message);
	}

	public function updatePostMedia($id)
	{
		$news = News::find($id);

		if(Input::file('featured_image')) 
		{
			$featured = Input::file('featured_image');
			$filename = time() . "_" . $featured->getClientOriginalName();
			$path = public_path('assets/news/' . $filename);
			$media = Image::make($featured->getRealPath())->save($path);

			if($media)
			{
				File::delete(public_path('assets/news/' . $news->featured_image));
			}	

			$news->featured_image = $filename;
			$news->save();	

			return Response::json(array('message'=>"update successful"));
		}

		if(Input::file('homepage_image')) 
		{
			$homepage_image = Input::file('homepage_image');
			$filename = time() . "_" . $homepage_image->getClientOriginalName();
			$path = public_path('assets/news/' . $filename);
			$media = Image::make($homepage_image->getRealPath())->save($path);

			if($media)
			{
				File::delete(public_path('assets/news/' . $news->homepage_image));
			}	

			$news->homepage_image = $filename;
			$news->save();	

			return Response::json(array('message'=>"update successful"));
		}
	}


}
