<?php

use Illuminate\Database\Eloquent\Relations\Pivot;

class GamePrices extends Pivot{
    protected $table = 'game_prices';

    public function users() {
		return $this->belongsToMany('User', 'game_sales');
	}
}