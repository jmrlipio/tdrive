<?php

class AdminLog extends \Eloquent {

	protected $table = 'admin_logs';

	public function user() 
	{
		return $this->belongsTo('User');
	}

	public static function createLogs($_activity) 
	{
		$log = new AdminLog;
     	$log->user_id = Auth::user()->id;
     	$log->activity = $_activity;
      	$log->save();

      	return $log;
	}

}