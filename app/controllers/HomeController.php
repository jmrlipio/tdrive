<?php 

class HomeController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		Session::forget('telco');
		Session::forget('carrier');
		$languages = Language::all();

		$user_location = GeoIP::getLocation();   

		$country = Country::where('name', $user_location['country'])->get();
		$country_id = '';

		foreach($country as $key) {
			$country_id = $key->id;
		}

		$carriers = Country::with('carriers')->where('country_code', '=', $country_id)->get();
		$selected_carriers = [];

		foreach($carriers as $c) {
			foreach($c->carriers as $i) {
				$selected_carriers[] = $i;
			}
		}

		$carrier_all = [];

		foreach(Carrier::all() as $crr) {
			$carrier_all[$crr->id] = $crr->carrier;
		}

		return View::make('carrier')
			->with('page_title', 'Select carrier')
			->with('selected_carriers', $selected_carriers)
			->with('country_id', $country_id)
			->with('page_id', 'form')
			->with('page_class', 'select_carrier')
			->with(compact('languages'))
			->with('carrier_all', $carrier_all);
	}

	public function home()
	{		

		$latest_news = News::all()->take(2);
		//$latest_news = News::orderby('release_date', 'desc')->get()->take(2);
		$previous_news = News::take(3)->skip(2)->get();
		$faqs = Faq::all();
		$languages = [];

		$years = News::all();

		
		/* For displaying year dynamically in select form */

		$arr_yrs = array();
		
		foreach ($years as $yrs) {
			$year = date('Y', strtotime($yrs->release_date)); 
			$arr_yrs[$year] = $year;
			$year = array_unique($arr_yrs);
			
		}
		
		/* END */

		$user_location = GeoIP::getLocation();

		$categories = [];

		$game_settings = GameSetting::all();

		$featured_games = Game::where('featured', 1)->orderBy('created_at', 'DESC')->get();

		$games = Game::all()->take($game_settings[0]->game_thumbnails);

		foreach(Category::all() as $cat) {
			if ($cat->featured == 1) {
				$categories[] = $cat;
			}
		}

		foreach(Language::all() as $language) {
			$languages[$language->id] = $language->language;
		}
		
		/* TODO: check if session has carrier */
		if (!Session::has('carrier')) {
			Session::put('country_id', Input::get('country_id'));
			Session::put('carrier', Input::get('selected_carrier'));
			$country = Country::find(Input::get('country_id'));
		} else {			
			$country = Country::find(Session::get('country_id'));
		}

		$carrier = Carrier::find(Session::get('carrier'));
		$countries = [];
		
		Session::put('telco', $carrier->carrier);		

		Session::put('user_country', $country->full_name);
		
		return View::make('index')
			->with('page_title', 'Home')
			->with('page_id', 'home')
			->with('previous_news', $previous_news)
			->with('latest_news', $latest_news)
			->with('year', $year)
			->with('carrier', $carrier)
			->with('country', $country)
			->with('categories', $categories)
			->with(compact('featured_games'))
			->with(compact('games'))
			->with(compact('faqs'))
			->with(compact('languages'));
	
	}

}
