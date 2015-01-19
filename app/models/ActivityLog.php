<?php

class ActivityLog extends \Eloquent {

	protected $table = 'activity_logs';

	public function user() 
	{
		return $this->belongsTo('User');
	}

	public static function createLogs($_activity, $_action) 
	{
		$log = new ActivityLog;
     	$log->user_id = Auth::user()->id;
     	$log->activity = $_activity;
        $log->action = $_action;
     	$log->carrier = Session::get('carrier_name');
        $log->country = Session::get('user_country');

      	$log->save();

      	return $log;
	}

}