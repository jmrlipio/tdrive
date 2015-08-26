<?php

Event::listen('user.*', function($user) {

	if( Event::firing() == 'user.registered' )
	{

		Mail::send('emails.auth.activate', array('link' => URL::route('account.activate', $user->code), 'username' => $user->username), function ($message) use ($user){
			$message->to($user->email, $user->username)			 
			 ->subject('Welcome to Tdrive!');
		});

	}
	elseif( Event::firing() == 'user.resend.code' )
	{

		Mail::send('emails.auth.activate', array('link' => URL::route('account.activate', $user->code), 'username' => $user->username), function ($message) use ($user){
			$message->to($user->email, $user->username)			 
			 ->subject('Activate your account');
		});

	}
	return false;
});

Event::listen('user.visits.game', function($game) 
{

	$hits = $game->hits;
	$game->hits = $hits + 1;
	$game->save();

});

