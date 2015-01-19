<?php

class Discount extends \Eloquent {
	protected $fillable = ['title', 'description', 'discount_percentage', 'start_date', 'end_date', 'featured_image', 'active', 'game_id'];

	public static $rules = [
		'title' => 'required|min:2',
		'description' => 'required|min:2',
		'discount_percentage' => 'required|numeric',
		'start_date' => 'required|date',
		'end_date' => 'required|date',
		'active' => 'required|boolean',
		'featured_image' => 'required'
	];

	public function games() {
		return $this->belongsTo('Game');
	}
}