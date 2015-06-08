<?php

class Sales extends Eloquent{

    protected $table = 'game_sales';

    public function user() {
		return $this->belongsTo('User');
	}

	public function prices() 
	{
		return $this->belongsTo('GameSales', 'game_price_id', 'id');
	}

	public static function getTotalSales($game_id) 
	{
    	$prices = GameSales::where('game_id', '=', $game_id)
				->get();


		$games = array();
		
		$total = 0;
		foreach($prices as $_prices) 
		{
			$sales 	= Sales::where('game_price_id', '=', $_prices->id)
							->get();
			$count = count($sales->toArray());
			$total = $total + $count;

			$array = array(
					'game_title' => $_prices->game->main_title,
					'carrier' => $_prices->carrier->carrier,
					'country' => $_prices->country->capital,
					'total' => $total,
				);

			$games[] = $array; 
		}

		return $games;	

	}

	public static function getTotal($game_id)
	{
		$prices = GameSales::where('game_id', '=', $game_id)
				->get();
		$total = 0;		
		foreach($prices as $_prices) 
		{
			$sales 	= Sales::where('game_price_id', '=', $_prices->id)
							->get();
			$count = count($sales->toArray());
			$total = $total + $count;
		}

		return $total;	
	}

}