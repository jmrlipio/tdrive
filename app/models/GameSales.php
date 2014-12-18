<?php

use Illuminate\Database\Eloquent\Relations\Pivot;

class GameSales extends Pivot{
    protected $table = 'game_prices';

    public function users() {
		return $this->belongsToMany('User', 'game_sales');
	}
}