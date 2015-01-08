<?php

class Review extends Eloquent {

	protected $table = 'game_reviews';

	public static $rules = [
		'game_id' => 'required|integer',
		'user_id' => 'required|integer',
		'review' => 'required',
		'status' => 'required|boolean'
	];

	public function user() {
		return $this->belongsTo('User');
	}

	public function game() {
		return $this->belongsTo('Game');
	}

}
