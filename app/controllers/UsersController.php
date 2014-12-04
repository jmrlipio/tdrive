<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /user
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /user/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /user
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /user/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /user/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /user/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /user/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


/** 
* Added by: Jone   
* Purpose: For user registration
* Date: 12/04/2014
*/

	public function getSignup() {
		return View::make('users.signup');
	}

	public function postRegister(){
		$validator = Validator::make(Input::all(), User::$rules);
		$user = new User;
		if($validator->passes()){
			
			$user->username= Input::get('username');
			$user->first_name= Input::get('first_name');
			$user->last_name= Input::get('last_name');
			$user->password=  Hash::make(Input::get('password'));
			
			$user->save();			
			return Redirect::route('users.login')->with('message', 'Registration successfull. Please sign in.');			
		}

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
	}

/* END */
	public function getLogin(){
        return View::make('users.login');
    }

    public function postLogin(){
        $data = Input::all();

        $validator = Validator::make($data, User::$auth_rules);
        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $remember = Input::get('remember');
        $credentials = array(
        	'username' => Input::get('username'), 
        	'password' => Input::get('password')
        	);
        echo $remember;
        if (Auth::attempt($credentials)){        	
        	
        	if(!empty($remember)){
        		Auth::login(Auth::user(), true);
        	}
        	return Redirect::intended('/');
        }

        return Redirect::route('login');
    }

    public function getLogout(){
        Auth::logout();
        return Redirect::route('users.login');
    }

}