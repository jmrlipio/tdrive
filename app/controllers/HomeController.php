<?php 

class HomeController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		Session::forget('carrier_name');
		Session::forget('carrier');
		$languages = Language::all();
		$filters = IPFilter::lists('ip_address');
		$user_location = GeoIP::getLocation();
		
		//erick test
		/* THAILAND TEST*/
		//$user_location['country'] = 'Thailand';
		//Session::put('locale', 'TH');

		/*TEST FOR NO CARRIER FOR SPECIFIC COUNTRY */
		//$user_location['country'] = 'Afghanistan';

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

		if(!$selected_carriers || in_array($_SERVER['REMOTE_ADDR'], $filters)) 
		{	
			unset($selected_carriers);
			$carriers_all = Carrier::all();
			foreach($carriers_all as $carrier)
			{
				$selected_carriers[] = $carrier;
			}

		}

		$carrier_all = [];

		foreach(Carrier::all() as $crr) {
			$carrier_all[$crr->id] = $crr->carrier;
		}
		
		$carrier_count = 0;
		$arr_store = array();

		foreach($selected_carriers as $sc)
		{
			$carrier_count++;
			$arr_store[] = array(
				'id' => $sc->id,
				'store' => $sc->carrier 
			);		
		}

		if($carrier_count == 1)
		{	
			$carrier = Carrier::find($arr_store[0]['id']);
			Session::put('carrier', $arr_store[0]['id']);
			Session::put('locale', strtolower($carrier->language->iso_code));	
			
			//return $this->home();
			return Redirect::route('home.lang');
		}
		

		return View::make('carrier')
			->with('page_title', 'Select App Store')
			->with('selected_carriers', $selected_carriers)
			->with('country_id', $country_id)
			->with('page_id', 'form')
			->with('page_class', 'select_carrier')
			->with(compact('languages'))
			->with('carrier_all', $carrier_all);
	}

	public function home()
	{	
		$latest_news = News::whereStatus('live')->orderby('created_at', 'desc')->take(2)->get();
		$previous_news = News::whereStatus('live')->orderby('created_at', 'desc')->take(3)->skip(2)->get();
		$faqs = Faq::all();
		$year = News::all();

		

		$locale = Language::where('iso_code', '=', strtoupper(Session::get('locale')))->first();

		// print_r(Session::all());

		/* For displaying game discount alert */

		$discounts = Discount::getDiscountsEvent();

		/* END */
		$ctr = 0;

	/* For displaying news alert */	

		$news_alert = News::whereNewsCategoryId(2)
			->whereStatus('live')
			->get();


	/* END */

	/* For displaying year dynamically in select form */

		$arr_yrs = [];	
		
		foreach ($year as $yrs) {
			// $year = date('Y', strtotime($yrs->created_at)) . ' news archive'; 
			$year = date('Y', strtotime($yrs->created_at));
			$arr_yrs[$year] = $year;
			$year = array_unique($arr_yrs);
		}
		
	/* END */

		$languages = [];

		$user_location = GeoIP::getLocation();

		$categories = [];

		$game_settings = GameSetting::all();

		$featured_games = Game::where('featured', 1)
			/*->whereCarrierId(Session::get('carrier'))*/
			->orderBy('created_at', 'DESC')			
			->get();

		// $games = Game::all()->take($game_settings[0]->game_thumbnails);

		/* Get all games by carrier id */

		//$games = Game::whereCarrierId(Session::get('carrier'))->get();
		//$games = Game::all();		

		/* End */
		$limit = $game_settings[0]->game_thumbnails;

		foreach(Category::orderby('order')->get() as $cat) {
			if ($cat->featured == 1) {
				$categories[] = $cat;
			}
		}

		$languages = Language::all();

		// foreach(Language::all() as $language) {
		// 	$languages[$language->id] = $language->language;
		// }

		/*BaseController::test(Input::get('country_id'));*/
		
		//Redirects to / if carrier is null
		if(!Session::has('carrier')) {
			return Redirect::to('/');	
		}
		
		if (!Session::has('carrier')) 
		{			
			$first_visit = true;
		} 
		else 
		{		
			$first_visit = false;
		}
		$carrier = Carrier::find(Session::get('carrier'));

		/* For displaying slider images dynamically ordered from database */

		$games_slide = [];
		$news_slide = [];

		$sliders = Slider::all();

		foreach($sliders as $slider) {
			if($slider->slideable_type == 'Game') $selected_games[] = $slider->slideable_id;
			else if($slider->slideable_type == 'News') $selected_news[] = $slider->slideable_id;
		}		
		
		$games_slide = Game::getAllGames();
		$cid = Session::get('carrier');		
	
		$games = Game::orderBy('main_title', 'ASC')->whereHas('apps', function($q) use ($cid)
		  {
		    $q->where('carrier_id', '=', $cid);

		  })->get();
		

		foreach(News::all() as $nw) {
			//$news_slide[$nw->id] = $nw->homepage_image;
			$news_slide[$nw->id] = array(
				'image' => $nw->homepage_image,
				'id' => $nw->id,
				'title' => $nw->main_title
			);

		}

		$_default_location = Country::where('iso_3166_2','=', $user_location['isoCode'])->get();
		$default_location = array();
		
		foreach($_default_location as $df)
		{
			$default_location = array(
				'id' => $df->id,
				'name' => $df->full_name
			);
		}

		$country = Country::where('name', $user_location['country'])->get();
		$country_id = '';

		foreach($country as $key) {
			$country_id = $key->id;
		}

		$filters = IPFilter::lists('ip_address');
		$carriers = Country::with('carriers')->where('country_code', '=', $country_id)->get();

		$selected_carriers = [];
		foreach($carriers as $c) {
			foreach($c->carriers as $i) {
				$selected_carriers[] = $i;
			}
		}

		if(!$selected_carriers || in_array($_SERVER['REMOTE_ADDR'], $filters)) 
		{	
			unset($selected_carriers);
			$carriers_all = Carrier::all();
			foreach($carriers_all as $carrier)
			{
				$selected_carriers[] = $carrier;
			}
		}

		/* END */
		$game_list = array();
		$has_app = true;
		foreach($games as $game)
		{
			foreach($game->apps as $app)
			{
				if(Language::getLangID(Session::get('locale')) == $app->pivot->language_id)
				{
					$game_list[] = ( $has_app ? $app->pivot->title : $game->main_title);
				}				
			}
		}
		
		return View::make('index')
			->with('page_title', 'Home')
			->with('page_id', 'home')
			->with('previous_news', $previous_news)
			->with('latest_news', $latest_news)
			->with('year', $year)
			->with('news_alert', $news_alert)
			->with('first_visit', $first_visit)
			->with('carrier', $carrier)
			->with('country', $country)
			->with('categories', $categories)
			->with('discounts', $discounts)
			->with('limit', $limit)
			->with('selected_carriers', $selected_carriers)
			->with(compact('game_list','games','featured_games', 'faqs', 'languages', 'games_slide','news_slide','sliders', 'default_location'));
	
	}

}
