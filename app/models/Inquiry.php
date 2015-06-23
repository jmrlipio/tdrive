<?php

class Inquiry extends \Eloquent {

	protected $table = 'inquiries';
	protected $fillable = ['name', 'email', 'game_title', 'message', 'country', 'os', 'app_store'];

	public static $rules = [
		'name' => 'required|min:3|max:255',
		'email' => 'required|email|min:3',
		'game_title' => 'required',
		'message' => 'required|min:3|max:2000',
		'country' => 'required',
		'os' => 'required',
		'app_store' => 'required',
		'captcha' => 'required|captcha',
	];

	public static $reply_rules = [
		'message' => 'required|min:3',
	];

}
