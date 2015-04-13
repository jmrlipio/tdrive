<?php

class Authorization extends \Eloquent {

	protected $table = 'authorizations';

	public function user() 
	{
		return $this->belongsTo('User');
	}

}