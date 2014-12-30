<?php

class Inquiry extends \Eloquent {

	protected $table = 'inquiries';
	protected $fillable = ['name', 'email', 'message'];

	public static $rules = [
		'name' => 'required|min:3',
		'email' => 'required|email|unique:inquiries',
		'message' => 'required|min:3'
	];

	public static $reply_rules = [
		'message' => 'required|min:3',
	];


}