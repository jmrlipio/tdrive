<?php

class GameApp extends \Eloquent {
	protected $fillable = ['game_id', 'carrier_id', 'language_id', 'app_id', 'title', 'content', 'excerpt', 'price', 'currency_code', 'status'];

	protected $table = 'apps';

	public static $rules = [
		'app_id' => 'required',
		'title' => 'required',
		'content' => 'required|max:10000',
		'excerpt' => 'required',
		'price' => 'required|numeric'
	];

	public static $messages = [
		'unique' => 'An app with the same ID already exists.'
	];
}