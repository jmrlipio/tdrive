<?php

class Review extends Eloquent {

	protected $table = 'game_reviews';

	public static $rules = [
		'game_id' => 'required|integer',
		'user_id' => 'required|integer',
		'review' => 'required',
		'status' => 'required|boolean'
	];

	public function user() {
		return $this->belongsTo('User');
	}

	public function game() {
		return $this->belongsTo('Game');
	}

	public static function getRatings($game_id) 
	{
		$ratings = Review::where('game_id', '=', $game_id)
							->get();

		if($ratings->isEmpty()) 
		{
			return false;
		}		

		$count = count($ratings->toArray());
		$average = 0;
		foreach($ratings as $rating) 
		{
			$average = $average + $rating->rating;
		}

		$average = round($average / $count, 1);

		return array(
				'count'   => $count,
				'average' => $average,
			);
	
		
	}

	public static function getRatingsPerUser($user_id) 
	{
		$ratings = Review::where('user_id', $user_id)
						->first();
		if($ratings) 
		{
			return $ratings->rating;
		}

		return false;				
	}
}
