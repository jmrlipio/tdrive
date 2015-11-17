<?php

Event::listen('user.*', function($user) {

	if( Event::firing() == 'user.registered' )
	{
		try 
		{
			Mail::send('emails.auth.activate', array('link' => URL::route('account.activate', $user->code), 'username' => $user->username), function ($message) use ($user){
				$message->to($user->email, $user->username)			 
				 ->subject('Welcome to Tdrive!');
			});
		}
		catch (Exception $e) 
		{
			echo $e->getMessage();
		}
		

	}
	elseif( Event::firing() == 'user.resend.code' )
	{
		try 
		{
			Mail::send('emails.auth.activate', array('link' => URL::route('account.activate', $user->code), 'username' => $user->username), function ($message) use ($user){
				$message->to($user->email, $user->username)			 
				 ->subject('Activate your account');
			});
		}
		catch (Exception $e) 
		{
			echo $e->getMessage();
		}
		

	}
	return false;
});

Event::listen('user.visits.game', function($game) 
{

	$hits = $game->hits;
	$game->hits = $hits + 1;
	$game->save();

});

