<?php 

class HomeController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		Session::forget('telco');
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
		$previous_news = News::take(3)->skip(2)->get();
		$faqs = Faq::all();
		$languages = [];

		$user_location = GeoIP::getLocation();

		$categories = [];

		$game_settings = GameSetting::all();

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

		foreach(Country::orderBy('full_name')->get() as $country) {
			$countries[$country->id] = $country->full_name;
		}
		
	
		if(Session::get('telco') == NULL ) {

			Session::put('telco', $carrier->carrier);		
		} 

		Session::put('user_country', $country->full_name);
		
		return View::make('index')
			->with('page_title', 'Home')
			->with('page_id', 'home')
			->with('previous_news', $previous_news)
			->with('latest_news', $latest_news)
			->with('carrier', $carrier)
			->with('country', $country)
			->with('categories', $categories)
			->with(compact('games'))
			->with(compact('faqs'))
			->with(compact('languages'));
	
	}

}
