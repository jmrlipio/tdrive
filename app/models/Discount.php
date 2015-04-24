<?php

class Discount extends \Eloquent {
	protected $fillable = ['title', 'description', 'carrier_id','discount_percentage', 'start_date', 'end_date', 'featured_image', 'active', 'user_limit'];

	public static $rules = [
		'title' => 'required|min:2',
		'description' => 'required|min:2',
		'carrier_id' => 'required|integer',
		'discount_percentage' => 'required|numeric',
		'start_date' => 'required|date',
		'end_date' => 'required|date',
		'active' => 'required|boolean',
		'featured_image' => 'required',
		'user_limit' => 'required|integer'
	];

	public function carrier() {
		return $this->belongsTo('Carrier');
	}

	public function games() {
		return $this->belongsToMany('Game', 'game_discounts')->withPivot('user_count', 'game_id');
	}

	public static function getDiscountedGames() 
	{
		$dt = Carbon::now();
		$discounts = Discount::whereActive(1)
			->where('start_date', '<=', $dt->toDateString())
			->where('end_date', '>=',  $dt->toDateString())	
			->where('carrier_id', '=',  Session::get('carrier'))	
			->get();

		$discounted_games = [];
			foreach ($discounts as $data) {
				foreach($data->games as $game ) {
					$discounted_games[] = array(
								'game_id' => $game->id,
								'discount' => $data->discount_percentage,
								'featured_image' => $data->featured_image,
								'title' => $data->title,
								'description' => $data->description
						);
				}
			
		}
		if($discounted_games)
			return $discounted_games;

		return null;
	}

	public static function checkDiscountedGame($game_id) 
	{
		$discounts = Discount::getDiscountedGames(); 
		foreach($discounts as $discount) 
		{
			if($discount['game_id'] == $game_id) 
			{
				return true;
			}
		}

		return false;
	}

}