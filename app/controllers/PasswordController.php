<?php

class PasswordController extends BaseController {
 
	public function remind()
	{
		return View::make('password.remind');
	}

	public function request()
	{
		$credentials = array('email' => Input::get('email'), 'password' => Input::get('password'));

		return Password::remind($credentials);
	}

	public function reset($token)
	{
		return View::make('password.reset')->with('token', $token);
	}

	public function update()
	{
		$credentials = Input::all();

		echo '<pre>';
		print_r($credentials);
		echo '</pre>';

		return Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

			//$user->save();
			echo '<pre>';
			print_r($user);
			echo '</pre>';
			//return Redirect::to('user.login')->with('flash', 'Your password has been reset');
		});
	}
}