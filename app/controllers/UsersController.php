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

			$response = Event::fire('user.registered', array($user));	

			return Redirect::route('users.login')->with('success', 'Registration successful. Please check your email to verify your account.');			
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

        if (Auth::attempt($credentials) && Auth::user()->active == 1 ){

        	if(Auth::check() && !empty($remember)){
        		Auth::login(Auth::user(), true);
        	}
        	//Audit log
            Event::fire('audit.login', Auth::user());

            return Redirect::intended('/home');
        }


        elseif(Auth::attempt($credentials) && Auth::user()->active == 0) {
        	return Redirect::to('login')->with('fail','Please check your email to verify your account');
        }

        return Redirect::to('login')->with('fail','Your email/password was incorrect');
    }

    public function getLogout(){
    	Event::fire('audit.logout', Auth::user());
    	Session::forget('telco');

        Auth::logout();

        /*return Redirect::route('/');*/
        return Redirect::intended('/');
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
<<<<<<< HEAD
    			->with('success', 'Account activated, you can now rate/comment a game');    			
=======
    			->with('activate', 'Account activated, you can now rate/comment a game');    			
>>>>>>> ad6e26a8865bcf97ce759b02509ccb054e12128b
    		}
    	}

    	return Redirect::route('users.login')    		
<<<<<<< HEAD
    		->with('fail', 'We could not activate your account. Try again later.');   	
=======
    		->with('activate', 'We could not activate your account. Try again later.');   	
>>>>>>> ad6e26a8865bcf97ce759b02509ccb054e12128b
    }

}
