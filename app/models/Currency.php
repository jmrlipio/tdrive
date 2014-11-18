<?php

class Currency extends \Eloquent {
	protected $fillable = [];

	public function games() {
		return $this->belongsToMany('Game', 'game_categories');
	}
}