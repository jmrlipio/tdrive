<?php

class LoginHistory extends \Eloquent {

	protected $table = 'login_history';

	public function user() 
	{
		return $this->belongsTo('User');
	}


	public static function addLoginHistory() 
    {
       
        $login = new LoginHistory;

        $login->logins = Carbon::now(); 

        $login->user_id = Auth::user()->id;

        $login->save();

        return $login;
    }

}