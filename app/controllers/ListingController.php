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

		$country = Country::find(Session::get('country_id'));

		$games = Game::all()->take(6);

		$games_all = Game::all();

		$count = count($games_all);

		return View::make('games')
			->with('page_title', 'New and updated games')
			->with('page_id', 'game-listing')
			->with('count', $count)
			->with('country', $country)
			->with(compact('games'))
			->with(compact('languages'));
	}

	public function showAllMoreGames() 
	{
		$load = Input::get('load') * 6;

		$games = Game::take(6)->skip($load)->get();

		$country = Country::find(Session::get('country_id'));
		
		if (Request::ajax()) {
			return View::make('_partials/ajax-games')
				->with('country', $country)
				->with(compact('games'));
		}
	}

	public function showGamesByCategory($id) 
	{
		$languages = Language::all();

		$category = Category::find($id);

		$country = Country::find(Session::get('country_id'));

		$games = Category::find($id)->games->take(6);

		$games_all = Category::find($id)->games;

		$count = count($games_all);

		return View::make('category')
			->with('page_title', $category->category)
			->with('page_id', 'game-listing')
			->with('count', $count)
			->with('country', $country)
			->with(compact('category'))
			->with(compact('games'))
			->with(compact('languages'));
	}

	public function showMoreGamesByCategory() 
	{
		$load = Input::get('load') * 6;
		$category_id = Input::get('category_id');

		$games = Category::find($category_id)->games()->take(6)->skip($load)->get();
		
		$country = Country::find(Session::get('country_id'));
		
		if (Request::ajax()) {
			return View::make('_partials/ajax-category')
				->with('country', $country)
				->with(compact('games'));
		}
	}

	public function showRelatedGames($id) 
	{
		$languages = Language::all();

		$country = Country::find(Session::get('country_id'));

		$game = Game::find($id);

		$categories = [];

		foreach($game->categories as $cat) {
			$categories[] = $cat->id;
		}

		$games = Game::all();

		$related_games = [];

		foreach($games as $gm) {
			$included = false;
			foreach($gm->categories as $rgm) {
				if(in_array($rgm->id, $categories) && $gm->id != $game->id) {
					if(!$included) {
						$related_games[] = $gm;
						$included = true;
					}
				}
			}
		}

		$count = count($related_games);

		return View::make('related')
			->with('page_title', 'Related games')
			->with('page_id', 'game-listing')
			->with('country', $country)
			->with('count', $count)
			->with('game_id', $game->id)
			->with(compact('related_games'))
			->with(compact('languages'));
	}

	public function showMoreRelatedGames() 
	{
		$load = Input::get('load') * 6;
		$game_id = Input::get('game_id');

		$game = Game::find($game_id);

		$categories = [];

		foreach($game->categories as $cat) {
			$categories[] = $cat->id;
		}

		$games = Game::all();

		$related_games = [];

		foreach($games as $gm) {
			$included = false;
			foreach($gm->categories as $rgm) {
				if(in_array($rgm->id, $categories) && $gm->id != $game->id) {
					if(!$included) {
						$related_games[] = $gm;
						$included = true;
					}
				}
			}
		}
		
		if (Request::ajax()) {
			return View::make('_partials/ajax-related')
				->with('country', $country)
				->with(compact('games'));
		}
	}

	public function showNews() 
	{
		$languages = Language::all();


		$news = News::where('status', 'live')->orderBy('created_at', 'DESC')->take(6)->get();

		$news_all = News::all();

		$count = count($news_all);

		// dd($news->toArray());

		return View::make('news_listing')
			->with('page_title', 'Latest news')
			->with('page_id', 'news-listing')
			->with('count', $count)
			->with('live_news', $news)
			->with(compact('languages'));
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

		$games = Game::where('main_title', 'LIKE', "%" . Input::get('search') . "%")->take(6)->get();
		$count = count($games);

		$country = Country::find(Session::get('country_id'));

		return View::make('search')
			->with('page_title', 'Search results')
			->with('page_id', 'game-listing')
			->with('count', $count)
			->with('country', $country)
			->with(compact('games'))
			->with(compact('languages'))
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

}
