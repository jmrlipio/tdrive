<?php

class GameSetting extends \Eloquent {

	protected $table = 'game_settings';

	protected $fillable = ['game_thumbnails', 'game_rows', 'game_reviews', 'review_rows', 'ribbon_url'];

	public static $rules = [
		'game_thumbnails' => 'required|integer',
		'game_rows' => 'required|integer',
		'game_reviews' => 'required|integer',
		'review_rows' => 'required|integer'
	];

}