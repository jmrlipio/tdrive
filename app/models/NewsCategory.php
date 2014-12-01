<?php

class NewsCategory extends \Eloquent {
	protected $fillable = [];

	public function news() {
    	return $this->hasMany('News');
    }
}