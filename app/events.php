<?php

Event::listen('user.*', function($user) {

	if( Event::firing() == 'user.registered' ){

		Mail::send('emails.auth.activate', array('link' => URL::route('account.activate', $user->code), 'username' => $user->username), function ($message) use ($user){
			$message->to($user->email, $user->username)
			 ->from('jigzen.test@gmail.com')
			 ->subject('Activate your Account');
		});

	}
	return false;
});

