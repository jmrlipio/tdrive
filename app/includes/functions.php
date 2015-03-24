<?php 

class GameDiscount{

	public static function checkDiscountedGames($game_id, $discounted_games){

		foreach ($discounted_games as $key => $discount) {
			if(in_array($game_id, $discount)){
				$dc = Discount::find($key);

				return $dc->discount_percentage;
			}
		}
		return 0;
	}

}


?>