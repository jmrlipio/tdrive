<?php

class GameApp extends \Eloquent {
	protected $fillable = ['game_id', 'carrier_id', 'language_id', 'app_id', 'title', 'content', 'excerpt', 'price', 'currency_code', 'status'];

	protected $table = 'apps';

	public static $rules = [
		'app_id' => 'required|unique:apps',
		'title' => 'required|max:255',
		'content' => 'required|max:10000',
		'excerpt' => 'required|max:255',
		'price' => 'required|numeric'
	];

	public static $messages = [
		'unique' => 'An app with the same ID already exists.'
	];

    public function transactions() {
        return $this->hasMany('Transaction', "app_id");
    }

}