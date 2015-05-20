<?php

class APIController extends \BaseController {


	public function getUser($token, $app_id) 
	{	

	}

	public function authorizeToken($token) 
	{
		$auth = Authentication::getUser($token);

		if($auth) 
		{
			return Response::json(array(
					'code' => 200,
					'token' => $token,
					'data' => array(
								'user' => $auth 
							)
					));
		}

		return Response::json(array(
				'code' => 404,
				'message' => 'No token available',
				));
	}

	public function authLoginAPI($app_id) 
	{
		return View::make('api-login')
					->with('app_id', $app_id)
					->with('page_title', 'Login')
					->with('page_id', 'form');
	}

	public function authLoginPost() 
	{
		$credentials = array('username' => Input::get('username'), 'password' => Input::get('password')); 
		if (Auth::attempt($credentials)) 
		{
			Auth::login(Auth::user(), true);
			$user = Authentication::getAuthorizeUser(Auth::user()->id, Input::get('app_id'));
			$user_data = array(
							'id' => Auth::user()->id,
							'username' => Auth::user()->username,
							'email' => Auth::user()->email,
							'first_name' => Auth::user()->first_name,
							'last_name' => Auth::user()->last_name,
							'mobile_no' => Auth::user()->mobile_no,
						);
			if($user)
			{
				//return user information
				return Response::json(array(
						'code' => 200,
						'token' => $user->authentication_token,
						'data' => array(
									'appid' => Input::get('app_id'),
									'user' => $user_data 
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
									'user' => $user_data ,
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

	public function authLogoutAPI($token) 
	{
		$user = Authentication::destroyToken($token);
		if($user)
			return Response::json(array(
						'code' => 200,
						'message' => 'Logout Successful',
				));

		return Response::json(array(
						'code' => 500,
						'message' => 'Internal Server Error',
				));
	}

	public function checkPurchaseStatus($app_id, $uuid) 
	{
		$_app_id = '526243';
		$_uuid = '00010201';

		$response = file_get_contents('http://106.187.43.219/tdrive_api/purchase_status.php?uuid=1&app_id=00050101');
		dd($response);
/*		if($response != '-1001') 
		{
			$xml = simplexml_load_string($response);
			$values = $this->object2array($xml);

			//dd($values);
			return Response::json(array(
					'message' => $values
			));
		}
		else 
		{
			return Response::json(array(
					'message' => 'error'
			));
		}*/

	}

	private function object2array($object) 
	{ 
		return @json_decode(@json_encode($object),1); 
	} 

}


?>