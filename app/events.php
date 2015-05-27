<?php

Event::listen('user.*', function($user) {

	if( Event::firing() == 'user.registered' )
	{

		Mail::send('emails.auth.activate', array('link' => URL::route('account.activate', $user->code), 'username' => $user->username), function ($message) use ($user){
			$message->to($user->email, $user->username)			 
			 ->subject('Activate your Account');
		});

	}
	elseif( Event::firing() == 'user.resend.code' )
	{

		Mail::send('emails.auth.activate', array('link' => URL::route('account.activate', $user->code), 'username' => $user->username), function ($message) use ($user){
			$message->to($user->email, $user->username)			 
			 ->subject('Activate your Account');
		});

	}
	return false;
});

