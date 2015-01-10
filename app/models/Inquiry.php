<?php

class Inquiry extends \Eloquent {

	protected $table = 'inquiries';
	protected $fillable = ['name', 'email', 'game_title', 'message'];

	public static $rules = [
		'name' => 'required|min:3',
		'email' => 'required|email|min:3',
		'game_title' => 'required',
		'message' => 'required|min:3',
		'captcha' => 'required|captcha'
	];

	public static $reply_rules = [
		'message' => 'required|min:3',
	];


}
