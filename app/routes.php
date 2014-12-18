<?php

Route::get('/', function()
{
	return View::make('index');
});

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
    Route::get('users/roles', array('as' => 'admin.users.roles', 'uses' => 'AdminUsersController@getUsersByRole'));
    Route::resource('users', 'AdminUsersController');
    Route::post('games/{id}/edit-content', array('as' => 'admin.games.update-content', 'uses' => 'AdminGamesController@updateContent'));
    // Route::get('games/{id}/edit-content', array('as' => 'admin.games.edit-content', 'uses' => 'AdminGamesController@editContent'));
    Route::post('games/{id}/edit-carriers', array('as' => 'admin.games.update-carriers', 'uses' => 'AdminGamesController@updateCarrier'));
    // Route::get('games/{id}/edit-carriers', array('as' => 'admin.games.edit-carriers', 'uses' => 'AdminGamesController@editCarrier'));
    Route::post('games/{id}/edit-carriers', array('as' => 'admin.games.update-media', 'uses' => 'AdminGamesController@updateMedia'));
    // Route::get('games/{id}/edit-carriers', array('as' => 'admin.games.edit-carriers', 'uses' => 'AdminGamesController@editCarrier'));
    Route::resource('games', 'AdminGamesController');
    Route::resource('news', 'NewsController');
    Route::resource('media', 'MediaController');
    Route::resource('categories', 'CategoriesController');
    Route::resource('languages', 'LanguagesController');
    Route::resource('carriers', 'CarriersController');
    Route::resource('faqs', 'FaqsController');
    Route::get('reports', array('as' => 'admin.reports.index', 'uses' => 'ReportsController@index'));
    Route::get('reports/sales', array('as' => 'admin.reports.sales', 'uses' => 'ReportsController@sales'));
    Route::get('reports/downloads', array('as' => 'admin.reports.downloads', 'uses' => 'ReportsController@downloads'));
    Route::get('reports/adminlogs', array('as' => 'admin.reports.adminlogs', 'uses' => 'ReportsController@adminlogs'));
    Route::get('reports/visitorlogs', array('as' => 'admin.reports.visitorlogs', 'uses' => 'ReportsController@visitorlogs'));
    Route::get('reports/inquiries', array('as' => 'admin.reports.inquiries', 'uses' => 'ReportsController@inquiries'));
    Route::post('media/upload', array('as' => 'media.upload', 'uses' => 'MediaController@postUpload'));
    // Route::get('media/load', array('as' => 'media.load', 'uses' => 'MediaController@showAllMedia'));
});
/** 
* Added by: Jone   
* Purpose: For admin news creation
* Date: 12/04/2014
*/
//Route::post('admin_news', array('as' => 'admin.news.createnews', 'uses' => 'NewsController@postCreatenews'));
/*END*/
Route::get('login', array('as' => 'users.login', 'uses' => 'UsersController@getLogin'));
Route::post('login', array('as' => 'login.post', 'uses' => 'UsersController@postLogin'));
Route::get('logout', array('as' => 'users.logout', 'uses' => 'UsersController@getLogout'));
Route::get('signup', array('as' => 'users.signup', 'uses' => 'UsersController@getSignup'));
Route::post('register', array('as' => 'users.register', 'uses' => 'UsersController@postRegister'));

Route::group(array('before' => 'auth'), function(){
	Route::resource('users', 'UsersController');
});