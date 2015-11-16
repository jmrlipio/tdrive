<?php

class IPFilter extends \Eloquent {
	protected $fillable = ['ip_address'];

	protected $table = 'ipfilters';

	public static $rules = [
		'ip_address' => 'required'
	];

	public function user()
    {
        return $this->belongsTo('User', 'added_by', 'id');
    }
}