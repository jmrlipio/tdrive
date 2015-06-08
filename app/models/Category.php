<?php

class Category extends \Eloquent {
	protected $fillable = ['category', 'slug', 'featured','order'];

	public static $rules = [
		'category' => 'required|min:3|unique:categories|max:255',
		'slug' => 'required|min:3|max:255',
		'featured' => 'min:1'
	];

	public function games() {
		return $this->belongsToMany('Game', 'game_categories')->orderBy('id', 'DESC');
	}

	public function languages() {
    	return $this->BelongsToMany('Language', 'category_languages')->withPivot('language_id','variant', 'id');
    }


}
