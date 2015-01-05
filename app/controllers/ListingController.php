<?php

class ListingController extends \BaseController {

	public function showGameCategories($id) 
	{
		$languages = Language::all();

		$category = Category::find($id);

		$games = Category::find($id)->games;

		return View::make('category')
			->with('page_title', $category->category)
			->with('page_id', 'game-listing')
			->with(compact('category'))
			->with(compact('games'))
			->with(compact('languages'));
	}

	public function showGames() 
	{
		$languages = Language::all();

		$games = Game::all();

		return View::make('games')
			->with('page_title', 'New and updated games')
			->with('page_id', 'game-listing')
			->with(compact('games'))
			->with(compact('languages'));
	}

	public function showNewsByYear($year) 
	{
		$languages = Language::all();

		$news = News::find();

		return View::make('year')
			->with('page_title', $news)
			->with('page_id', 'archives')
			->with(compact('news'))
			->with(compact('languages'));
	}

}
