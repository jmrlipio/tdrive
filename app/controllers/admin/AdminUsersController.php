<?php

class AdminUsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /adminusers
	 *
	 * @return Response
	 */
	public function index()
	{

		$users = User::all();	

		/*$users = User::orderBy('id')->paginate(5);

		$roles = ['all' => 'All'];

		foreach(DB::table('users')->select('role')->groupby('role')->get() as $role) 
		{
			$roles[$role->role] = ucfirst($role->role);
		}

		return View::make('admin.users.index')
			->with('users', $users)
			->with('roles', $roles)
			->with('selected', 'all');*/
		return View::make('admin.users.index')
			->with('users', $users);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /adminusers/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /adminusers
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), User::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		User::create($data);



		return Redirect::route('admin.users.index');
	}

	/**
	 * Display the specified resource.
	 * GET /adminusers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::find($id);
		$games = Game::all();
		$carriers = Carrier::all();
		$countries = Country::all();

		$selected_games = [];



		$count = 0;
		foreach($user->sales as $gm) {
			
			foreach($games as $game) {
				if($game->id == $gm->game_id) {
					$selected_games[$count]['game_title'] = $game->main_title;
				}
			}

			foreach($carriers as $carrier) {
				if($carrier->id == $gm->carrier_id) {
					$selected_games[$count]['carrier'] = $carrier->carrier;
				}
			}

			foreach($countries as $country) {
				if($country->id == $gm->country_id) {
					$selected_games[$count]['country'] = $country->full_name;
					$selected_games[$count]['currency'] = $country->currency_code;
					$selected_games[$count]['price'] = $gm->price;
				}
			}
			$count++;
		}


		return View::make('admin.users.view')
			->with('user', $user)
			->with('games', $selected_games);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /adminusers/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);

		return View::make('admin.users.edit')->with('user', $user);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /adminusers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::findOrFail($id);

		$validator = Validator::make($data = Input::all(), User::$rules);
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$user->update($data);

		return Redirect::route('admin.users.show', $user->id);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /adminusers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function getLogin(){
        return View::make('admin.login');
    }

    public function postLogin()
    {
        $data = Input::all();

        $validator = Validator::make($data, User::$auth_rules);
        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password'))))
        {
            //Audit log
            Event::fire('audit.login', Auth::user());
            
            return Redirect::intended('admin/dashboard');
        }

        return Redirect::route('admin.login');
    }

    public function getLogout()
    {

    	Event::fire('audit.logout', Auth::user());
        Auth::logout();
        return Redirect::route('admin.login');
    }

    public function getDashboard()
    {
    	return View::make('admin.dashboard.index');
    }

    public function postSearch()
    {

    	if (!Request::ajax()) {
		        return null;
		    }
		
		$keyword = Input::get('keyword');
		$user = User::where('username', 'LIKE', '%'.$keyword.'%')->get();

		return $user;
	}

    public function getUsersByRole() 
    {
    	$selected_role = Input::get('role');

    	if($selected_role == 'all') $users = User::orderBy('id')->paginate(5);
    	else $users = User::where('role', '=', Input::get('role'))->paginate(5);

    	$roles = ['all' => 'All'];

		foreach(DB::table('users')->select('role')->groupby('role')->get() as $role) 
		{
			$roles[$role->role] = ucfirst($role->role);
		}

    	return View::make('admin.users.index')
			->with('users', $users)
			->with('roles', $roles)
			->with('selected', $selected_role);
    }
}