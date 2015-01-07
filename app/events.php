<?php

Event::listen('user.registered', function($user) {

	Mail::queue('emails.auth.activate', array('link' => URL::route('account.activate', $user->code), 'username' => $user->username), function ($message) use ($user){
		$message->to($user->email, $user->username)->subject('Activate your Account');
	});

	return false;
});