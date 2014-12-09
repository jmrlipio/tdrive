<?php

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));


Route::get('path', function(){
    return public_path();
});

Route::get('media/load', array('as' => 'media.load', 'uses' => 'MediaController@showAllMedia'));
Route::get('carrier/load', array('as' => 'carrier.load', 'uses' => 'CarriersController@loadCarrier'));

Route::group(array('prefix' => 'admin'), function() {
	Route::get('login', array('as' => 'admin.login', 'uses' => 'AdminUsersController@getLogin'));
    Route::post('login', array('as' => 'admin.login.post', 'uses' => 'AdminUsersController@postLogin'));
    Route::get('logout', array('as' => 'admin.logout', 'uses' => 'AdminUsersController@getLogout'));
});

Route::group(array('prefix' => 'admin', 'before' => 'admin'), function(){
    Route::get('dashboard', array('as' => 'admin.dashboard', 'uses' => 'AdminUsersController@getDashboard'));
    Route::resource('users', 'AdminUsersController');
    Route::resource('games', 'AdminGamesController');
    Route::resource('news', 'NewsController');
    Route::resource('media', 'MediaController');
    Route::resource('categories', 'CategoriesController');
    Route::resource('languages', 'LanguagesController');
    Route::resource('platforms', 'PlatformsController');
    Route::resource('carriers', 'CarriersController');
    Route::post('media/upload', array('as' => 'media.upload', 'uses' => 'MediaController@postUpload'));
    // Route::get('media/load', array('as' => 'media.load', 'uses' => 'MediaController@showAllMedia'));
});
/** 
* Added by: Jone   
* Purpose: For admin news creation
* Date: 12/04/2014
*/
Route::get('games', array('as' => 'games', 'uses' => 'GamesController@index'));
Route::get('news', array('as' => 'news', 'uses' => 'NewsController@usersindex'));

/*END*/
Route::get('login', array('as' => 'users.login', 'uses' => 'UsersController@getLogin'));
Route::post('login', array('as' => 'login.post', 'uses' => 'UsersController@postLogin'));
Route::get('logout', array('as' => 'users.logout', 'uses' => 'UsersController@getLogout'));
Route::get('signup', array('as' => 'users.signup', 'uses' => 'UsersController@getSignup'));
Route::post('register', array('as' => 'users.register', 'uses' => 'UsersController@postRegister'));

Route::group(array('before' => 'auth'), function(){
	Route::resource('users', 'UsersController');
});