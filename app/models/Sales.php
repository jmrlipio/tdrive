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

}