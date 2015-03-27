<?php 

class GameDiscount{

	public static function checkDiscountedGames($game_id, $discounted_games){

		foreach ($discounted_games as $key => $discount) {
			if(in_array($game_id, $discount) ){
				$dc = Discount::find($key);

				foreach($dc->games as $game) {
					if($game->pivot->game_id == $game_id) {
						if($game->pivot->user_count < $dc->user_limit) {
							return $dc->discount_percentage;
						}
					}
				}

				
			}
		}
		return 0;
	}

}


?>