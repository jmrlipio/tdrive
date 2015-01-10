<?php

class Review extends Eloquent {

	protected $table = 'game_reviews';

	protected $fillable = ['game_id', 'user_id', 'review', 'rating', 'status'];

	public static $rules = [
		'game_id' => 'required|integer',
		'user_id' => 'required|integer',
		'review' => 'required',
		'rating' => 'required',
		'captcha' => 'required|captcha',
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
		$ratings = Review::where('game_id', '=', $game_id)->get();

		$five = 0;
		$four = 0;
		$three = 0;
		$two = 0;
		$one = 0;

		if($ratings->isEmpty()) 
		{
			return false;
		}		

		$count = count($ratings->toArray());
		$average = 0;

		foreach($ratings as $rating) {
			$average = $average + $rating->rating;

			if ($rating->rating == 5) {
				$five++;
			} else if ($rating->rating == 4) {
				$four++;
			} else if ($rating->rating == 3) {
				$three++;
			} else if ($rating->rating == 2) {
				$two++;
			} else if ($rating->rating == 1) {
				$one++;
			}
		}

		$average = round($average / $count, 1);

		return array(
			'count'   => $count,
			'average' => $average,
			'five' => $five,
			'four' => $four,
			'three' => $three,
			'two' => $two,
			'one' => $one,
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

	public static function getReviewPerUser($user_id) 
	{
		$ratings = Review::where('user_id', $user_id)->first();

		if($ratings) 
		{
			return $ratings->review;
		}

		return false;				
	}
}
