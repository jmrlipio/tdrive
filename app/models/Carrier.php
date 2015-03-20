<?php

use Jarektkaczyk\TriplePivot\TriplePivotTrait;

class Carrier extends \Eloquent {

	use TriplePivotTrait;
	
	protected $fillable = ['id','carrier','language_id'];

	public static $rules = [
		'id' => 'required|integer|unique:carriers',
        'carrier' => 'required|min:3|unique:carriers'
    ];

	public function countries() {
		return $this->belongsToMany('Country', 'country_carriers')->withPivot('id');
	}

	public function games() {
		return $this->hasMany('Game');
	}

	/**
     * @return \Jarektkaczyk\TriplePivot\TripleBelongsToMany
     */
    public function prices() {
        return $this->tripleBelongsToMany('Game', 'Country', 'game_prices' )->withPivot('price');
    }

    public function discounts() {
    	return $this->hasMany('Discounts');
    }

	// public function sales() {
	// 	return $this->belongsToMany('Game', 'sale_games');
	// }
}
