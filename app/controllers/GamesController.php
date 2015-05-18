<?php

use Nathanmac\Utilities\Parser\Parser;

class GamesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /games
	 *
	 * @return Response
	 */
	public function index()
	{
		$games = Game::with('media')->get();
		$root = Request::root();
		$thumbnails = array();

		foreach($games as $game) {
			foreach($game->media as $media) {
				if($media->pivot->type == 'featured') {
					$thumbnails[] = $root. '/images/uploads/' . $media->url;
				}
			}
		}
		return View::make('pages.games')
			->with('thumbnails', $thumbnails)
			->with('games', $games);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /games/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /games
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /games/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, $app_id)
	{
		$languages = Language::all();
		$game = Game::find($id);
		$current_game = Game::find($id);
		$categories = [];
		$user_id = (Auth::check()) ? Auth::user()->id : 0;
		$show = 0;

		$has_appid = GameApp::where('app_id', '=', $app_id)
					->first();
		if(!$has_appid) 
		{
			App::abort(404);
		}
/*
		echo '<pre>';
		dd($game->review);
		echo '</pre>';*/

		// echo '<pre>';
		// print_r($game->review);
		// echo '</pre>';

		// $test = Review::find($user_id);

		// $test2 = Review::whereHas('review', function($q){
		// 	$q->where()
		// })->get();

		// echo $user_id;

		// $test2 = Review::where('user_id', '=', $user_id);

		// echo Review::where('user_id', '=', $user_id)->exists();
		
		// echo $id;

		$user_commented = true;

		if(Review::where('user_id', '=', $user_id)->where('game_id', '=', $id)->exists()){
			$user_commented = true;	
		} else {
			$user_commented = false;
		}

		foreach($game->categories as $cat) {
			$categories[] = $cat->id;
		}

		if(!Session::has('carrier')) {
			$uri = explode("/", "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
			end($uri);
			$key = key($uri);

			$app_id = $uri[$key];

			$digits = str_split($app_id, 4);

			$game_id = ltrim($digits[0], "0");

			$cl = str_split($digits[1], 2);

			$carrier_id = ltrim($cl[0], "0");
			$language_id = ltrim($cl[1], "0");

			foreach(Carrier::all() as $carrier) {
				if($carrier->id == $carrier_id) {
					Session::put('carrier', $carrier->id);
					Session::put('carrier_name', $carrier->carrier);
					break;
				}
			}

			foreach(Language::all() as $language) {
				if($language->id == $language_id) {
					Session::put('locale', strtolower($language->iso_code));
					break;
				}
			}
		}

		$cid = Session::get('carrier');
		$games = Game::whereHas('apps', function($q) use ($cid)
				 {
				    $q->where('carrier_id', '=', $cid)->where('status', '=', Constant::PUBLISH);
				 })->get();
		
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

		$ratings = Review::getRatings($game->id);
		$visitor = Tracker::currentSession();
		$country = Country::find(Session::get('country_id'));
		$game_id = $game->id;

		return View::make('game')
			->with('game', $game)
			->with('page_title', $game->main_title)
			->with('page_id', 'game-detail')
			->with('ratings', $ratings)
			->with('current_game', $current_game)
			->with('country', $country)
			->with('app_id', $app_id)
			->with('user_id', $user_id)
			->with(compact('languages','related_games', 'discounted_games', 'game_id', 'games', 'user_commented'));
			/*->with(compact('related_games'))
			->with(compact('game'));*/
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /games/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /games/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /games/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function loadGameContent() 
	{
		$game = Game::find(Input::get('id'));

		foreach($game->apps as $g) {
			if($g->pivot->app_id == Input::get('app_id')){
				echo $g->pivot->content;
			}
			
		}
	}

	public function loadGames() 
	{
		$games = Game::with('media')->get();

		return $games->toJson();
	}

	public function getAPICarrier($id) {

		// $url = 'http://122.54.250.228:60000/tdrive_api/select_carrier.php?app_id' . $id;

		$ch = curl_init();
		// curl_setopt($ch, CURLOPT_URL,'http://122.54.250.228:60000/tdrive_api/select_carrier.php?app_id=1');
		curl_setopt($ch, CURLOPT_URL,'http://106.186.24.12/tdrive_api/select_carrier.php?app_id=1');
		curl_setopt($ch, CURLOPT_FAILONERROR,1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		$response = curl_exec($ch);    
		curl_close($ch);

		// $response = file_get_contents('http://122.54.250.228:60000/tdrive_api/select_carrier.php?app_id=1');

		$xml = simplexml_load_string($response);

		$values = $this->object2array($xml);

		$carrier_ids = [];

		foreach($xml as $crr) {
			$carrier_ids[] = intval($crr->attributes()->id);
		}

		$carriers = [];

		for($i = 0; $i < count($values['carrier']); $i++) {
			$carriers[$carrier_ids[$i]] = $values['carrier'][$i];
		}

		return json_encode($carriers);
	}

	public function getCarrier() 
	{
		$game = Game::find(Input::get('id'));
		$languages = Language::all();

		$carriers = [];	

		foreach($game->apps as $app) 
		{
			$lang = '';
			foreach($languages as $language) 
			{
				if($language->id == $app->pivot->language_id)
					$lang = $language->language;

			}
			  if($app->pivot->status == Constant::PUBLISH )
	            {
					$carriers[] = array(
								'app_id' =>  $app->pivot->app_id,
								'carrier' => $app->carrier . ' - ' . $lang,
								'cid' => $app->pivot->carrier_id
						);
				}
		}
		dd($carriers);

		return json_encode($carriers);

	}


	public function getCarrierDetails($id) {	
		//$url = 'http://122.54.250.228:60000/tdrive_api/process_billing.php?app_id=' . $id . '&carrier_id=' . Input::get('carrier_id') . '&uuid=' . Auth::user()->id;
		$data = explode("-",Input::get('selected-carrier'));
		$app_id = $data[0];
		$carrier_id = $data[1];

		//$url = 'http://122.54.250.228:60000/tdrive_api/process_billing.php?app_id=1&carrier_id=1&uuid=1';
		$url = 'http://122.54.250.228:60000/tdrive_api/process_billing.php?app_id='.$app_id.'&carrier_id='.$carrier_id.'&uuid='.Auth::user()->id;
		
		$response = file_get_contents($url);

		return $response;
	}

	private function object2array($object) { 
		return @json_decode(@json_encode($object),1); 
	}

	public function getPaymentInfo($id) {
		return View::make('payment')
			->with('page_title', 'Payment')
			->with('page_id', 'form')
			->with('app_id', $id);
	}

	public function getPurchaseStatus($id) {
		// $url = 'http://122.54.250.228:60000/tdrive_api/purchase_status.php?uuid=' . Auth::user()->id;

		// $url = 'http://106.186.24.12/tdrive_api/purchase_status.php?uuid=1';
		$url = 'http://106.186.24.12/tdrive_api/purchase_status.php?uuid='. Auth::user()->id;

		$response = file_get_contents($url);

		$xml = simplexml_load_string($response);

		$values = $this->object2array($xml);

		$purchased = [];
		$purchased['transaction_id'] = (string) $xml->transaction[2]->attributes()->id;
		$purchased['receipt'] = $values['transaction'][2]['receipt'];
		$purchased['status'] = $values['transaction'][2]['status'];


		// foreach($xml as $purchase) {
		// 	if($purchase->app_id == $id) {
		// 		$status = $purchase->status;
		// 	}
		// }

		return $purchased;
	}

}
