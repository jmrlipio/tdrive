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

	public function getRegister() {
		$languages = Language::all();

		return View::make('register')
			->with('page_title', 'Register')
			->with('page_id', 'form')
			->with(compact('languages'));
	}

	public function postRegister(){
		$validator = Validator::make(Input::all(), User::$rules);
		$user = new User;
		$code = str_random(60);
		$username = Input::get('username');

		if($validator->passes()){
			
			$user->email= Input::get('email');
			$user->username= Input::get('username');
			$user->first_name= Input::get('first_name');
			$user->last_name= Input::get('last_name');
			$user->password=  Hash::make(Input::get('password'));			
			$user->code = $code;

			$user->save();	

			Mail::send('emails.auth.activate', array('link' => URL::route('account.activate', $code), 'username' => $username), function ($message) use ($user){
				$message->to($user->email, $user->username)->subject('Activate your Account');
			});

			return Redirect::route('users.login')->with('message', 'Registration successful. Please sign in.');			
		}

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
	}

/* END */
	public function getLogin(){
		$languages = Language::all();

		return View::make('login')
			->with('page_title', 'Login')
			->with('page_id', 'form')
			->with(compact('languages'));
    }

    public function postLogin(){
        $credentials = array('username' => Input::get('username'), 'password' => Input::get('password')); 		
       
        $remember = Input::get('remember');

        if (Auth::attempt($credentials)){

        	if(Auth::check() && !empty($remember)){
        		Auth::login(Auth::user(), true);
        	}
            return Redirect::intended('/');
        }
        return Redirect::to('login')->withErrors('Your email/password was incorrect');
    }

    public function getLogout(){
        Auth::logout();
        return Redirect::route('users.login');
    }

/*    public function getForgotPassword(){

    	return View::make('users.forgot');
    }*/

   /* public function postForgotPassword(){
    	$validator = Validator::make(Input::all(), 
    		array('email'=>'required|email')
    		);

    	if ($validator->fails())
        {
           ======= return Redirect::back()->withErrors($validator)->withInput();
            return Redirect::route('users.forgot')
            	->withErrors($validator)
            	->withInput();
        
        } else {

        	$user = User::where('email', '=', Input::get('email'));

        	if($user->count()) {
        		$user = $user->first();

        		=====Generate new code and password

        		$code = str_random(60);
        		$password = str_random(60);

        		$user->code = $code;
        		$user->password_temp = Hash::make($password);

        		if($user->save()) {
        			die();
        		}
        	}
        }

    	==========return View::make('users.forgot');
    }*/

    public function getActivate($code){
    	$user = User::where('code', '=', $code)->where('active', '=', 0);

    	if($user->count()){
    		$user = $user->first();

    		//Update users to allow adding comment and review
    		$user->active = 1;
    		$user->code = '';

    		if($user->save()){
    			
    		return Redirect::route('users.login')
    			->with('message', 'Account activated, you can now rate/comment a game');    			
    		}
    	}

    	return Redirect::route('users.login')    		
    		->with('message', 'We could not activate your account. Try again later.');   	
    }

}
