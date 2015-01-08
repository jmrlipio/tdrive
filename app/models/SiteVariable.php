<?php

class SiteVariable extends \Eloquent {

	protected $table = 'site_variables';

	protected $fillable = ['variable_name', 'variable_value'];

	public static $rules = [
		'variable_value' => 'required|min:2'
	];
}