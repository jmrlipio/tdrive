<?php

class Authentication extends \Eloquent {

	protected $table = 'authentications';
	public $timestamps = false;

	public function user() 
	{
		return $this->belongsTo('User');
	}
	
	public static function createToken($hash) 
	{
		return md5(uniqid(mt_rand(), true) . $hash);
	}

	public static function getToken($id, $app_id) 
	{
		$user = Authentication::where('user_id', '=', $id )
								->where('app_id', '=', $app_id)
								->first();
		if($user) 
		{
			return $user->authorization_token;
		}

		return false;
	}

	public static function getAuthorizeUser($id, $app_id) 
	{
		$user = Authentication::where('user_id', '=', $id)
							  	->where('app_id', '=', $app_id)
								->first();
		if($user) return $user;

		return false;						
	}

	public static function storeToken($data) 
	{
		$token = new Authentication;
		$token->app_id = $data['app_id'];
		$token->user_id = $data['user_id'];
		$token->authentication_token = $data['authentication_token'];
		$token->save();

		return $token;
	}

	public static function destroyToken($token) 
	{
		try 
		{
			$token = Authentication::where('authentication_token', '=', $token)
									->firstOrFail();
			if($token->delete()) 
				return true;
		}
		catch (Exception $e) 
		{
			return false;
		}

	}

	public static function getUser($token) 
	{
		$auth = Authentication::where('authentication_token', '=', $token)
								->first();
		if($auth) 
		{
			$user = User::find($auth->user_id);
			
			$user_data = array(
				'id' => $user->id,
				'username' => $user->username,
				'email' => $user->email,
				'first_name' => $user->first_name,
				'last_name' => $user->last_name,
				'mobile_no' => $user->mobile_no,
			);

			return $user_data;

		}

		return false;
	}

}