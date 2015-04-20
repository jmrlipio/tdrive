<?php

class Category extends \Eloquent {
	protected $fillable = ['category', 'slug', 'featured','order'];

	public static $rules = [
		'category' => 'required|min:3|unique:categories',
		'slug' => 'required|min:3',
		'featured' => 'min:1'
	];

	public function games() {
		return $this->belongsToMany('Game', 'game_categories')->orderBy('id', 'DESC');
	}


}
