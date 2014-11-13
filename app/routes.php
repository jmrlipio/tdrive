<?php

Route::get('/', function()
{
	return View::make('index');
});

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
    Route::post('media/upload', array('as' => 'media.upload', 'uses' => 'MediaController@postUpload'));
});

Route::get('login', array('as' => 'users.login', 'uses' => 'UsersController@getLogin'));
Route::post('login', array('as' => 'login.post', 'uses' => 'UsersController@postLogin'));
Route::get('logout', array('as' => 'users.logout', 'uses' => 'UsersController@getLogout'));

Route::group(array('before' => 'auth'), function(){
	Route::resource('users', 'UsersController');
});