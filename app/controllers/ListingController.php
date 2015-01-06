<?php

class ListingController extends \BaseController {

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
	}

	public function showGames() 
	{
		$languages = Language::all();

		$games = Game::paginate(6);

		return View::make('games')
			->with('page_title', 'New and updated games')
			->with('page_id', 'game-listing')
			->with(compact('games'))
			->with(compact('languages'));
	}

	public function showGamesByCategory($id) 
	{
		$languages = Language::all();

		$category = Category::find($id);

		$games = Category::find($id)->games->take(3);

		$count = count($games);

		return View::make('category')
			->with('page_title', $category->category)
			->with('page_id', 'game-listing')
			->with('count', $count)
			->with(compact('category'))
			->with(compact('games'))
			->with(compact('languages'));
	}

	public function showMoreGames($id) 
	{
		$load = Input::get('load') * 3;

		$games = Category::find($id)->games()->take(3)->skip($load)->get();
		
		if (Request::ajax()) {
			foreach ($games as $game) {

				echo '<div class="item">';
					echo '<div class="thumb"><img src="/images/games/thumb-' . $game->slug . '.jpg" alt="' . $game->main_title . '"></div>';

					echo '<div class="meta">';
						echo '<p>' . $game->main_title . '</p>';
						echo '<p>P' . $game->default_price . '.00</p>';
					echo '</div>';

					echo '<div class="button"><a href="#">Buy</a></div>';
				echo '</div>';

			}
		}
	}

	public function showNews() 
	{
		$languages = Language::all();

		$news = News::paginate(3);

		return View::make('news_listing')
			->with('page_title', 'Latest news')
			->with('page_id', 'news-listing')
			->with(compact('news'))
			->with(compact('languages'));
	}

	public function showNewsByYear($year) 
	{
		$languages = Language::all();

		$news = News::where(DB::raw('YEAR(release_date)'), '=', $year)->take(3)->get();

		$count = count($news);

		return View::make('year')
			->with('page_title', $year)
			->with('title', $year)
			->with('count', $count)
			->with('page_id', 'news-listing')
			->with('news', $news)
			->with(compact('languages'));
	}

	public function showMoreNewsByYear($year) 
	{
		$languages = Language::all();

		$load = Input::get('load') * 3;

		$news = News::where(DB::raw('YEAR(release_date)'), '=', $year)->take(3)->skip($load)->get();

		if (Request::ajax()) {
			foreach ($news as $item) {
				foreach ($item->contents as $content) {

					echo '<div class="item">';
						echo '<div class="date">';
							echo '<div class="vhparent">';
								echo '<p class="vhcenter">' . Carbon::parse($item->release_date)->format('M j') . '</p>';
							echo '</div>';
						echo '</div>';

						echo '<div class="details">';
							echo '<div class="vparent">';
								echo '<div class="vcenter">';
									echo '<h3>' . $item->main_title . '</h3>';
									echo '<p>' . $content->pivot->excerpt . '</p>';
								echo '</div>';
							echo '</div>';
						echo '</div>';

						echo '<div class="readmore">';
							echo '<div>';
								echo '<a href="/news/' . $item->id . '" class="vhcenter"><i class="fa fa-angle-right"></i></a>';
							echo '</div>';
						echo '</div>';
					echo '</div>';

				}
			}
		}
	}

	public function searchGames() 
	{
		$languages = Language::all();

		$games = Game::where('main_title', 'LIKE', Input::get('search') . "%")->paginate(6);

		return View::make('search')
			->with('page_title', 'Search results')
			->with('page_id', 'game-listing')
			->with(compact('games'))
			->with(compact('languages'));
	}

}
