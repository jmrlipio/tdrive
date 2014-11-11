<?php

class GameType extends \Eloquent {
	protected $fillable = [];

	public function games() {
		return $this->hasMany('Game');
	}
}