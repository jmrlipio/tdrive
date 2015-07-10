<?php

class ListingController extends \BaseController {

	public function __construct() 
	{
		parent::__construct();

		$this->beforeFilter('csrf', array('on'=>'post'));
	}

	public function showGames() 
	{
		$languages = Language::all();
		$page = 3;
		$count = 6;
		$country = Country::find(Session::get('country_id'));

		$cid = Session::get('carrier');
	
		$games = Game::whereHas('apps', function($q) use ($cid)
		  {
		      $q->where('carrier_id', '=', $cid)->where('status', '=', Constant::PUBLISH);

		  })->paginate($count);

		$games_all = Game::all();

		$count = count($games_all);
		$discounts = Discount::getDiscountedGames();

		return View::make('games')
			->with('page_title', 'New and updated games')
			->with('page_id', 'game-listing')
			->with('page', $page)
			->with('count', $count)
			->with('country', $country)
			->with(compact('games'))
			->with(compact('languages', 'discounts'));
	}

	public function showAllMoreGames() 
	{
		$languages = Language::all();

		$page = Input::get('page');
		$cid = Session::get('carrier');
		$count = 3;

		try 
		{
			Paginator::setCurrentPage($page);
			$games = Game::whereHas('apps', function($q) use ($cid)
			  {
			      $q->where('carrier_id', '=', $cid)->where('status', '=', Constant::PUBLISH);

			  })->paginate($count);

			$country = Country::find(Session::get('country_id'));
			
			/* For getting discounts */
			$discounts = Discount::getDiscountedGames();

			if (Request::ajax()) {
				return View::make('_partials/ajax-games')
					->with('country', $country)
					->with(compact('games', 'discounts', 'languages'));
			}
		}
		catch (Exception $e) 
		{
			return Response::json(array(
					'error' => $e->getMessage(),
			));
		}

	}

	public function showGamesByCategory($id) 
	{
		$languages = Language::all();
		$page = 3;
		$count = 6;
		$category = Category::find($id);

		$country = Country::find(Session::get('country_id'));

		$cid = Session::get('carrier');

		$games = Game::whereHas('apps', function($q) use ($cid)
		  {
		      $q->where('carrier_id', '=', $cid)->where('status', '=', Constant::PUBLISH);
	
		  })->whereHas('categories', function ( $query ) use ($id){
              
                $query->where('category_id','=', $id );
         
          })->paginate($count);
           	
		//$games_all = Category::find($id)->games;
		//$count = count($games_all);
			
		$discounts = Discount::getDiscountedGames();

		return View::make('category')
			->with('page_title', $category->category)
			->with('page_id', 'game-listing')
			->with('country', $country)
			->with('page', $page)
			->with('games', $games)
			->with(compact('category','discounts'))
			->with(compact('languages'));
	}

	public function showMoreGamesByCategory() 
	{
		$category_id = Input::get('category_id');
		$page = Input::get('page');
		$cid = Session::get('carrier');
		$count = 3;

		try
		{
			Paginator::setCurrentPage($page);
			$games = Game::whereHas('apps', function($q) use ($cid)
			  {
		     	 $q->where('carrier_id', '=', $cid)->where('status', '=', Constant::PUBLISH);
	
		  			})->whereHas('categories', function ( $query ) use ($category_id){
              
                	$query->where('category_id','=', $category_id );
         
         	  })->paginate($count);

			$country = Country::find(Session::get('country_id'));
			/* For getting discounts */
			$discounts = Discount::getDiscountedGames();

			if (Request::ajax()) {
				return View::make('_partials/ajax-category')
					->with('country', $country)
					->with(compact('games', 'discounts'));
			}
		} 
		catch (Exception $e) 
		{
			return Response::json(array(
					'error' => $e->getMessage(),
			));
		}
		
	}

	public function showRelatedGames($id) 
	{
		$languages = Language::all();
		$cid = Session::get('carrier');
		$country = Country::find(Session::get('country_id'));
		$game = Game::find($id);
		$page = 3;
		$count = 6;

		 $categories = array();
		 foreach($game->categories as $cat) 
		 {
		 	$categories[] = $cat->id;
		 }

		Paginator::setCurrentPage(1);
		$games = Game::whereHas('categories', function($q) use ($categories)
		{
		    $q->whereIn('category_id', $categories);

		})->get();

		$test = [];

		//$games = Game::all();
	
		/* For getting discounts */
		$dt = Carbon::now();
		$discounts = Discount::whereActive(1)
			->where('start_date', '<=', $dt->toDateString())
			->where('end_date', '>=',  $dt->toDateString())		
			->get();

		$discounted_games = [];
		foreach ($discounts as $data) {
			foreach($data->games as $gm ) {
				$discounted_games[$data->id][] = $gm->id; 
			}
		}

		$count = count($games);

		// dd(count($related_games));

		return View::make('related')
			->with('page_title', 'Related games')
			->with('page_id', 'game-listing')
			->with('country', $country)
			->with('count', $count)
			->with('game_id', $game->id)
			// ->with('game_slug', $game->slug)
			->with(compact('games', 'discounted_games','games', 'game', 'page'))
			->with(compact('languages'));
	}

	public function showMoreRelatedGames($id) 
	{
		$load = Input::get('load');
		$game_id = $id;
		$languages = Language::all();

		$country = Country::find(Session::get('country_id'));

		$game = Game::find($id);

		$categories = [];

		foreach($game->categories as $cat) {
			$categories[] = $cat->id;
		}

		$ids = Input::get('ids');

		$games = Game::whereHas('categories', function($q) use ($categories, $ids)
		{
		    $q->whereIn('category_id', $categories);

		})->whereNotIn('id', $ids)->take(6)->get();

		
		$dt = Carbon::now();
		$discounts = Discount::whereActive(1)
			->where('start_date', '<=', $dt->toDateString())
			->where('end_date', '>=',  $dt->toDateString())		
			->get();
		
		$discounted_games = [];
		foreach ($discounts as $data) {
			foreach($data->games as $gm ) {
				$discounted_games[$data->id][] = $gm->id; 
			}
		}


		if (Request::ajax()) {
			return View::make('_partials/ajax-related')
				->with('country', $country)
				->with(compact('games', 'languages','discounted_games'));
		}
	}

	public function showNews() 
	{
		$languages = Language::all();

		$news = News::where('status', 'live')->orderBy('created_at', 'DESC')->take(6)->get();

		$news_all = News::all();

		$year = $news_all;

		$count = count($news_all);

		/* For displaying year dynamically in select form */

		$arr_yrs = [];	
		
		foreach ($year as $yrs) {			
			$year = date('Y', strtotime($yrs->created_at));
			$arr_yrs[$year] = $year;
			$year = array_unique($arr_yrs);
		}
		
	/* END */



		return View::make('news_listing')
			->with('page_title', 'Latest news')
			->with('page_id', 'news-listing')
			->with('count', $count)
			->with('live_news', $news)
			->with(compact('languages', 'year'));
	}

	public function showMoreNews() 
	{
		$load = Input::get('load') * 6;

		$news = News::where('status', 'live')->take(6)->skip($load)->get();

		
		if (Request::ajax()) {
			return View::make('_partials/ajax-news')->with(compact('news'));
		}
	}

	public function showNewsByYear($year) 
	{
		$languages = Language::all();

		$news = News::where(DB::raw('YEAR(created_at)'), '=', $year)->whereStatus('live')->orderBy('created_at', 'DESC')->take(6)->get();

		$news_all = News::all();

		$count = count($news_all);

		$year .= ' news archive';

		return View::make('year')
			->with('page_title', $year)
			->with('title', $year)
			->with('count', $count)
			->with('page_id', 'news-listing')
			->with('news', $news)
			->with(compact('languages'));
	}

	public function showMoreNewsByYear() 
	{
		$languages = Language::all();

		$load = Input::get('load') * 6;

		$year = Input::get('year');

		$news = News::where(DB::raw('YEAR(created_at)'), '=', $year)->where('status', 'live')->orderBy('created_at', 'DESC')->take(6)->skip($load)->get();

		if (Request::ajax()) {
			return View::make('_partials/ajax-year')->with(compact('news'));
		}
	}

	public function searchGames() 
	{
		$languages = Language::all();
		$cid = Session::get('carrier');

		//$games = Game::where('main_title', 'LIKE', "%" . Input::get('search') . "%")->take(6)->get();
		
		$games = Game::whereHas('apps', function($q) use ($cid)
		{
		  $q->where('carrier_id', '=', $cid)
		  	->where('main_title', 'LIKE', "%" . Input::get('search') . "%")
		  	->where('status', '=', Constant::PUBLISH);

		})->get();

		$count = count($games);

		$country = Country::find(Session::get('country_id'));

		/* For getting discounts */
		$dt = Carbon::now();
		$discounts = Discount::whereActive(1)
			->where('start_date', '<=', $dt->toDateString())
			->where('end_date', '>=',  $dt->toDateString())  
			->get();

		$discounted_games = [];
		foreach ($discounts as $data) {
			foreach($data->games as $gm ) {
				$discounted_games[$data->id][] = $gm->id; 
			}
		}

		return View::make('search')
			->with('page_title', 'Search results')
			->with('page_id', 'game-listing')
			->with('count', $count)
			->with('country', $country)
			->with(compact('games'))
			->with(compact('languages','discounted_games'))
			->with('search', Input::get('search'));
	}

	public function searchRelatedGames() 
	{
		$languages = Language::all();
		$cid = Session::get('carrier');
		$categories = Input::get('categories');

		$games = Game::	whereHas('categories', function($q) use ($categories)
		{
		    $q->whereIn('category_id', $categories);

		})->get();

		$count = count($games);

		$country = Country::find(Session::get('country_id'));

		/* For getting discounts */
		$dt = Carbon::now();
		$discounts = Discount::whereActive(1)
			->where('start_date', '<=', $dt->toDateString())
			->where('end_date', '>=',  $dt->toDateString())  
			->get();

		$discounted_games = [];
		foreach ($discounts as $data) {
			foreach($data->games as $gm ) {
				$discounted_games[$data->id][] = $gm->id; 
			}
		}

		return View::make('search')
			->with('page_title', 'Search results')
			->with('page_id', 'game-listing')
			->with('count', $count)
			->with('country', $country)
			->with(compact('games'))
			->with(compact('languages','discounted_games'))
			->with('search', Input::get('search'));
	}

	public function searchGamesByCategory() 
	{
		$id = Input::get('id');

		$cid = Session::get('carrier');
		$languages = Language::all();

		// $searched_games = Game::where('main_title', 'LIKE', "%" . Input::get('search') . "%")
		// 	->whereStatus(1)
		// 	->get();

		$searched_games = Game::whereHas('apps', function($q) use ($cid)
		  {
		      $q->where('carrier_id', '=', $cid)
		      	->where('main_title', 'LIKE', "%" . Input::get('search') . "%")
		      	->where('status', '=', Constant::PUBLISH);

		  })->get();
		
		
		$games = [];

		/* For getting discounts */
		$dt = Carbon::now();
		$discounts = Discount::whereActive(1)
			->where('start_date', '<=', $dt->toDateString())
			->where('end_date', '>=',  $dt->toDateString())  
			->get();

		$discounted_games = [];
		foreach ($discounts as $data) {
			foreach($data->games as $gm ) {
				$discounted_games[$data->id][] = $gm->id; 
			}
		}

		foreach($searched_games as $game) {
			foreach($game->categories as $category) {
				if($category->id == $id) {
					$games[] = $game;
				}
			}
		}

		$count = count($games);

		$country = Country::find(Session::get('country_id'));

		return View::make('search')
			->with('page_title', 'Search results')
			->with('page_id', 'game-listing')
			->with('count', $count)
			->with('country', $country)
			->with(compact('games'))
			->with(compact('languages','discounted_games'))
			->with('search', Input::get('search'));
	}

	public function searchMoreGames() 
	{
		$load = Input::get('load') * 6;

		$games = Game::where('main_title', 'LIKE', "%" . Input::get('search') . "%")->take(6)->skip($load)->get();
		
		$country = Country::find(Session::get('country_id'));
		
		if (Request::ajax()) {
			return View::make('_partials/ajax-search')
				->with('country', $country)
				->with(compact('games'));
		}
	}

	public function showGameCategories() 
	{
		$categories = Category::all();
		//$categories = [];
		$game_settings = GameSetting::all();
		$cat_list = [];
		foreach($categories as $cat)
		{
			$apps = Game::getAppsPerCategory($cat->id); 
			$variant = Category::checkVariant($cat->id, Language::getLangID(Session::get('locale')));
			if(!$apps)
			{
				continue; 
			}

			if(!$variant)
			{
				continue; 
			}
			
			$cat_list[$cat->id] = array(
				'cat_id' => $cat->id,
				'cat_name' => $cat->category
				);

		} 

		$languages = Language::all();

		return View::make('category_listing')
			->with('page_title', 'Category List')
			->with('page_id', 'category-listing')
			->with(compact('limit','cat_list'))		
			->with(compact('categories'));
	}

	public function showMoreDownloadedGames() 
	{
		$languages = Language::all();
		
		$page = Input::get('page');
		$cid = Session::get('carrier');
		$count = Constant::CATEGORY_GAME_PAGING;

		try 
		{
			Paginator::setCurrentPage($page);
			$games = Game::whereHas('apps', function($q) use ($cid)
			  {
			      $q->where('carrier_id', '=', $cid)->where('status', '=', Constant::PUBLISH);

			  })->paginate($count);

			$country = Country::find(Session::get('country_id'));			

			if (Request::ajax()) {
				return View::make('_partials/ajax-downloaded_games')
					->with('country', $country)
					->with(compact('games', 'languages'));
			}
		}
		catch (Exception $e) 
		{
			return Response::json(array(
				'error' => $e->getMessage(),
			));
		}

	}

}
