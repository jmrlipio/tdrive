<?php

class Platform extends \Eloquent {
	protected $fillable = [];

	public function games() {
		return $this->belongsToMany('Game', 'game_categories');
	}
}