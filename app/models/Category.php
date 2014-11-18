<?php

class Category extends \Eloquent {
	protected $fillable = [];

	public function games() {
		return $this->belongsToMany('Game', 'game_categories');
	}
}