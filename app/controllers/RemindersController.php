<?php

class RemindersController extends Controller {

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getRemind()
	{
		$languages = Language::all();

		return View::make('password.remind')
			->with('page_title', 'Forgot Password')
			->with('page_id', 'form')
			->with(compact('languages'));
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind()
	{
		$user = User::whereEmail(Input::only('email'));

		switch ($response = Password::remind(Input::only('email'), function($message) use ($user)
		{
		    $message->subject('Password Reminders');
		}))
		
		{
			case Password::INVALID_USER:
				return Redirect::back()->with('fail', Lang::get($response));

			case Password::REMINDER_SENT:
				//return Redirect::back()->with('status', Lang::get($response));
				return Redirect::back()->with('success', 'Email sent to reset password');
		}

	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token)) App::abort(404);

		$languages = Language::all();

		return View::make('password.reset')->with('token', $token)
			->with('page_title', 'Reset Password')
			->with('page_id', 'form')
			->with(compact('languages'));

	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

			$user->save();
		});

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return Redirect::back()->with('error', Lang::get($response));

			case Password::PASSWORD_RESET:
				return Redirect::to('/')->with('success','Password reset successful');
		}
	}

	public function getChangePassword()
	{
		$languages = Language::all();

		return View::make('password.change')
			->with('page_title', 'Change Password')
			->with('page_id', 'form')
			->with(compact('languages'));
	}

	public function postChangePassword()
	{		
		$id = Input::get('id');
		$old_password  = Input::get('old_password');
		$new_password = Input::get('confirm_password');
		$user = User::find($id);

		if( Hash::check(($old_password), $user->password) ) {

    		$user->password = Hash::make($new_password);

    		$user->save();
			
			return Redirect::back()->with('success', 'Password changed');

		} else{
			
			return Redirect::back()->with('fail', 'old password incorrect');
		}

	}

}