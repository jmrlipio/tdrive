<?php

class Message extends \Eloquent {

	protected $fillable = ['success','error'];

	public static $rules = [
		'success' => 'required',
		'error' => 'required'
	]; 

}