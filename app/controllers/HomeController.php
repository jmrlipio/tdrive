<?php class HomeController extends BaseController {

	public function index()
	{
		$languages = Language::all();
		$carriers = Carrier::all();

		$user_location = GeoIP::getLocation();   

		$country = $user_location['country'];

		return View::make('carrier')
			->with('page_title', 'Select carrier')
			->with('page_id', 'form')
			->with(compact('languages'))
			->with(compact('carriers'));
	}

	public function home()
	{
		$games = Game::all();
		$latest_news = News::all()->take(2);
		$previous_news = News::take(3)->skip(2)->get();
		$faqs = Faq::all();
		$languages = Language::all();

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
