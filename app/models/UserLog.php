<?php

class UserLog extends \Eloquent {

	protected $table = 'user_logs';

	public function user() 
	{
		return $this->belongsTo('User');
	}

}