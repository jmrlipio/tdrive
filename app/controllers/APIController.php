<?php

class APIController extends \BaseController {


	public function getUser($token, $app_id) 
	{	

	}

	public function createToken($data) 
	{
		
	}

	public function authorizeLogin($app_id) 
	{
		return View::make('api-login')
					->with('app_id', $app_id)
					->with('page_title', 'Login')
					->with('page_id', 'form');
	}

	public function authorizeLoginPost() 
	{
		$credentials = array('username' => Input::get('username'), 'password' => Input::get('password')); 
		//dd($credentials);
		if (Auth::attempt($credentials)) 
		{
			Auth::login(Auth::user(), true);
			$user = Authentication::getAuthorizeUser(Auth::user()->id, Input::get('app_id'));
			//dd(Input::get('app_id'));
			if($user)
			{
				//return user information
				return Response::json(array(
						'code' => 200,
						'token' => $user->authentication_token,
						'data' => array(
									'appid' => Input::get('app_id'),
									'user' => Auth::user()
								)
						));
			}
			else 
			{
				$hash = Auth::user()->ID;
				$token = Authentication::createToken($hash);
				$data = array(
							'user_id' => Auth::user()->id,
							'app_id' => Input::get('app_id'),
							'authentication_token' => $token,
							);
				$auth = Authentication::storeToken($data);
				
				return Response::json(array(
						'code' => 200,
						'token' => $auth->authentication_token,
						'data' => array(
									'appid' => Input::get('app_id'),
									'user' => Auth::user(),
								)
						));
			}
		} 
		else 
		{
			return Response::json(array(
					'code' => 404,
					'message' => 'Username and password invalid',
					));
		}

	}
}

?>