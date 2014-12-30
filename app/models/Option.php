<?php

	/*
	  List of option names

	  	-inquiry_email_subject
	  	-inquiry_email_automated_message

	 */

class Option extends \Eloquent {
	
	protected $table = 'options';
    protected $fillable = ['option_name', 'option_value'];

    /*temp*/
    public static function saveOption($data) 
    {
    	$option = Option::where('option_name', '=', $data['option_name'])
                        ->first();
    	
    	if($option) 
    	{
    		$option->update($data);
    		return $option;
    	}

        //create new
        $option = Option::create($data);
    	return $option;
    }

    public static function get($value) 
    {
        $option = Option::where('option_name', '=', $value)
                        ->first();
        
        if($option) 
        {
            return $option->option_value;
        }

        return false;

    }

    public static function boot() 
    {
        parent::boot();

        static::created(function()
        {
          $log = new UserLog;
          $log->user_id = Auth::user()->id;
          $log->activity = sprintf(Constant::LOGS_OPTIONS_CREATE, Auth::user()->username, $option->option_name, Carbon::parse($option->created_at)->toDayDateTimeString()  );
          $log->save();
        });

        static::updated(function($option)
        {
          $log = new UserLog;
          $log->user_id = Auth::user()->id;
          $log->activity = sprintf(Constant::LOGS_OPTIONS_UPDATE, Auth::user()->username, $option->option_name, Carbon::parse($option->created_at)->toDayDateTimeString()  );
          $log->save();
        });
    }


}