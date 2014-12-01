<?php

class Platform extends \Eloquent {
	protected $fillable = ['platform', 'slug'];

	public static $rules = [
		'platform' => 'required|min:3|unique:platforms',
		'slug' => 'required|min:3'
	];

	public function games() {
		return $this->belongsToMany('Game', 'game_categories');
	}
}