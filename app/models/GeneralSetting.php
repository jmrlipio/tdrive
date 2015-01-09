<?php

class GeneralSetting extends \Eloquent {
	protected $table = 'general_settings';

	protected $fillable = ['setting', 'value'];

	public static $rules = [
		'value' => 'required|min:2'
	];
}