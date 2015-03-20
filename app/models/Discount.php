<?php

class Discount extends \Eloquent {
	protected $fillable = ['title', 'description', 'carrier_id','discount_percentage', 'start_date', 'end_date', 'featured_image', 'active', 'user_limit'];

	public static $rules = [
		'title' => 'required|min:2',
		'description' => 'required|min:2',
		'carrier_id' => 'required|integer',
		'discount_percentage' => 'required|numeric',
		'start_date' => 'required|date',
		'end_date' => 'required|date',
		'active' => 'required|boolean',
		'featured_image' => 'required',
		'user_limit' => 'required|integer'
	];

	public function carrier() {
		return $this->belongsTo('Carrier');
	}

	public function games() {
		return $this->belongsToMany('Game', 'game_discounts');
	}

}