<?php

class IPFilter extends \Eloquent {
	protected $fillable = ['ip_address'];

	protected $table = 'ipfilters';
	public $timestamps = false;

	public static $rules = [
		'ip_address' => 'required'
	];
}