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

     	//$log->carrier = $carrier;
     	//$log->country = $_action;

      	$log->save();

      	return $log;
	}

	public static function addCarrier($id, $telco) 
    {
    	dd($id);
        //$user = User::find($id);
        $log = ActivityLog::find($id);
        $log->carrier = $telco;
        //$user->last_login = Carbon::today('Asia/Manila');
        $log->save();

        return $log;
    }

}