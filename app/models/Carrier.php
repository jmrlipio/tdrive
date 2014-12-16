<?php

use Jarektkaczyk\TriplePivot\TriplePivotTrait;

class Carrier extends \Eloquent {

	use TriplePivotTrait;
	
	protected $fillable = ['carrier'];

	public static $rules = [
        'carrier' => 'required|min:3|unique:carriers'
    ];

	public function countries() {
		return $this->belongsToMany('Country', 'country_carriers');
	}

	public function games() {
		return $this->belongsToMany('Game', 'game_carriers');
	}

	/**
     * @return \Jarektkaczyk\TriplePivot\TripleBelongsToMany
     */
    public function prices() {
        return $this->tripleBelongsToMany('Game', 'Country', 'game_prices' )->withPivot('price');
    }

	// public function sales() {
	// 	return $this->belongsToMany('Game', 'sale_games');
	// }
}