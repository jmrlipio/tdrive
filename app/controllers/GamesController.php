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
	public function show($id)
	{
		$languages = Language::all();
		$game = Game::find($id);
		$current_game = Game::find($id);
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
		/* For getting discounts */
		$discounts = Discount::all();
		$discounted_games = [];
		foreach ($discounts as $data) {
			foreach($data->games as $gm ) {
				$discounted_games[$data->id][] = $gm->id; 
			}
		}

		$ratings = Review::getRatings($game->id);
		$visitor = Tracker::currentSession();
		$country = Country::find(Session::get('country_id'));

		return View::make('game')
			->with('page_title', $game->main_title)
			->with('page_id', 'game-detail')
			->with('ratings', $ratings)
			->with('current_game', $current_game)
			->with('country', $country)
			->with(compact('languages','related_games', 'game', 'discounted_games'));
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

		foreach($game->contents as $g) {
			echo $g->pivot->content;
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

	public function getCarrierDetails($id) {	
		//$url = 'http://122.54.250.228:60000/tdrive_api/process_billing.php?app_id=' . $id . '&carrier_id=' . Input::get('carrier_id') . '&uuid=' . Auth::user()->id;
		$url = 'http://122.54.250.228:60000/tdrive_api/process_billing.php?app_id=1&carrier_id=1&uuid=1';
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
		$url = 'http://106.186.24.12/tdrive_api/purchase_status.php?uuid=1';

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
