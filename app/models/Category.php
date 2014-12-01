<?php

class Category extends \Eloquent {
	protected $fillable = ['category', 'slug'];

	public static $rules = [
		'category' => 'required|min:3|unique:categories',
		'slug' => 'required|min:3'
	];

	public function games() {
		return $this->belongsToMany('Game', 'game_categories');
	}
}