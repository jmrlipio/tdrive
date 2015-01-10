<?php

use Illuminate\Database\Eloquent\Relations\Pivot;

class GameSales extends Eloquent{
    protected $table = 'game_prices';

    public function users() {

		//return $this->belongsToMany('User', 'game_sales', 'id');

		return $this->belongsToMany('User', 'prices');

	}

	public function sales() {
		return $this->HasMany('Sales');
	}

	public function carrier() 
	{
		return $this->belongsTo('Carrier');
	}

	public function game() 
	{
		return $this->belongsTo('Game');
	}

	public function country() 
	{
		return $this->belongsTo('Country');
	}

}