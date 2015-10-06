<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	Lang::setLocale(Session::get('locale'));

	/** 		   
		* Purpose: For detecting users device
		* Date: 01/16/2015
	*/

	if(Agent::isDesktop() && Request::segment(1) != 'admin' )
	{
		$user_location = GeoIP::getLocation();
		Session::put('locale', $user_location['isoCode']);
		$locale = strtolower(Session::get('locale'));
		Lang::setLocale($locale);
		
		return View::make('desktop.index')
	 		->with('page_title', 'Desktop')
	 		->with('page_id', 'form');
	}

});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/
Route::filter('carrier_check', function() {
    if ( !Session::has('carrier') ) { 
        return Redirect::to('/');
    }
});

Route::filter('admin', function($route, $request)
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	} else if (Auth::user()->role == 'member' ) {
		return Response::make('Unauthorized', 401);
	}
});

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		// Save the attempted URL
		// Session::put('pre_login_url', URL::current());

		// // Redirect to login
		// return Redirect::to('login');
		
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});

Route::filter('auth.basic', function()
{
	return Auth::basic();
});

Route::filter('role', function()
{ 
  if ( Auth::user()->role !== 'superadmin') {
     // do something
    return Response::make('Unauthorized', 401);
   }
}); 

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('auth_trans', function($route)
{
    $id = $route->getParameter('id');
    if( Auth::check() && Auth::user()->id != $id) {
        return Redirect::to(route('profile.transactions', Auth::user()->id));
    }
});