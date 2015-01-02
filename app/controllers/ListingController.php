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

}
