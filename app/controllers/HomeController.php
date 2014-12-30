<?php

class HomeController extends BaseController {

	public function index()
	{
		$languages = Language::all();
		$games = Game::all();
		$latest_news = News::all()->take(2);
		$previous_news = News::all()->take(3);
		$faqs = Faq::all();

		return View::make('index')
			->with('page_title', 'Home')
			->with('page_id', 'home')
			->with('previous_news', $previous_news)
			->with('latest_news', $latest_news)
			->with(compact('games'))
			->with(compact('faqs'))
			->with(compact('languages'));
	}

}
