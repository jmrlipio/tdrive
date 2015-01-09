<?php

use Illuminate\Database\Eloquent\Relations\Pivot;

class GamePrice extends Eloquent{
    protected $table = 'game_prices';

    public function users() {
		return $this->belongsToMany('User', 'game_sales');
	}

	public function carriers() {
		return $this->belongsToMany('Carrier', 'game_sales');
	}

	public function countries() {
		return $this->belongsToMany('Country', 'game_sales');
	}

	public function game() {
		return $this->belongsToMany('Game', 'game_sales');
	}

}