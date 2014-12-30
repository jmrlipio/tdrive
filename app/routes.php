<?php

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));


Route::get('path', function(){
    return public_path();
});

Route::get('media/load', array('as' => 'media.load', 'uses' => 'MediaController@showAllMedia'));
Route::get('carrier/load', array('as' => 'carrier.load', 'uses' => 'CarriersController@loadCarrier'));
Route::get('games/load', array('as' => 'games.load', 'uses' => 'GamesController@loadGames'));

Route::group(array('prefix' => 'admin'), function() {
	Route::get('login', array('as' => 'admin.login', 'uses' => 'AdminUsersController@getLogin'));
    Route::post('login', array('as' => 'admin.login.post', 'uses' => 'AdminUsersController@postLogin'));
    Route::get('logout', array('as' => 'admin.logout', 'uses' => 'AdminUsersController@getLogout'));
});

Route::group(array('prefix' => 'admin', 'before' => 'admin'), function(){
    Route::get('dashboard', array('as' => 'admin.dashboard', 'uses' => 'AdminUsersController@getDashboard'));
    Route::get('users/roles', array('as' => 'admin.users.roles', 'uses' => 'AdminUsersController@getUsersByRole'));
    Route::resource('users', 'AdminUsersController');
    Route::resource('games', 'AdminGamesController');
    // Route::post('games/{id}/edit' . rawurlencode('#') . 'content', array('as' => 'admin.games.update-content', 'uses' => 'AdminGamesController@updateContent'));
    // Route::get('games/{id}/edit-content', array('as' => 'admin.games.edit-content', 'uses' => 'AdminGamesController@editContent'));
    Route::post('games/{id}/edit-carriers', array('as' => 'admin.games.update-carriers', 'uses' => 'AdminGamesController@updateCarrier'));
    // Route::get('games/{id}/edit-carriers', array('as' => 'admin.games.edit-carriers', 'uses' => 'AdminGamesController@editCarrier'));
    Route::post('games/{id}/edit-media', array('as' => 'admin.games.update-media', 'uses' => 'AdminGamesController@updateMedia'));
    // Route::get('games/{id}/edit-carriers', array('as' => 'admin.games.edit-carriers', 'uses' => 'AdminGamesController@editCarrier'));
    Route::post('games/{id}/update-fields', array('as' => 'admin.games.update-fields', 'uses' => 'AdminGamesController@updateFields'));
    Route::get('games/{id}/edit/content/{language}', array('as' => 'admin.games.edit.content', 'uses' => 'AdminGamesController@getLanguageContent'));
    Route::post('games/{id}/edit/content/{language}', array('as' => 'admin.games.edit.content', 'uses' => 'AdminGamesController@updateLanguageContent'));
    Route::get('games/{id}/edit/prices/{carrier}', array('as' => 'admin.games.edit.prices', 'uses' => 'AdminGamesController@getPriceContent'));
     Route::post('games/{id}/edit/prices/{language}', array('as' => 'admin.games.edit.prices', 'uses' => 'AdminGamesController@updatePriceContent'));

    Route::resource('news', 'NewsController');
    Route::resource('media', 'MediaController');
    Route::resource('categories', 'CategoriesController');
    Route::resource('languages', 'LanguagesController');
    Route::resource('carriers', 'CarriersController');
    Route::resource('faqs', 'FaqsController');
    Route::resource('siteoptions', 'SiteOptionsController');
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
Route::get('games', array('as' => 'games', 'uses' => 'GamesController@index'));
Route::get('news', array('as' => 'news', 'uses' => 'NewsController@usersindex'));
Route::get('news/show/{id}', array('as' => 'news.show', 'uses' => 'NewsController@getSingleNews'));
/*Route::get('news/year/{id}', array('as' => 'news.show', 'uses' => 'NewsController@getNewsByYear'));*/
/*Route::controller('news/show', 'NewsController');*/
Route::get('news/year', array('as' => 'news.year', 'uses' => 'NewsController@getNewsByYear'));
Route::get('users/activate/{code}', array('as' => 'account.activate', 'uses' => 'UsersController@getActivate'));

//Password Reminder & Reset
Route::get('password/remind', array('as' => 'password.remind', 'uses' => 'RemindersController@getRemind'));
Route::post('password/request', array('as' => 'password.request', 'uses' => 'RemindersController@postRemind'));
Route::get('password/reset/{token}', array('as' => 'password.reset', 'uses' => 'RemindersController@getReset'));
Route::post('password/reset/{token}', array('as' => 'password.update', 'uses' => 'RemindersController@postReset'));
//END

//Search route for admin

Route::post('admin/users/search', array('as' => 'admin.users.search', 'uses' => 'AdminUsersController@postSearch'));

//END

/*END*/
Route::get('login', array('as' => 'users.login', 'uses' => 'UsersController@getLogin'));
Route::post('login', array('as' => 'login.post', 'uses' => 'UsersController@postLogin'));
Route::get('logout', array('as' => 'users.logout', 'uses' => 'UsersController@getLogout'));
Route::get('signup', array('as' => 'users.signup', 'uses' => 'UsersController@getSignup'));
Route::post('register', array('as' => 'users.register', 'uses' => 'UsersController@postRegister'));

Route::group(array('before' => 'auth'), function(){
	Route::resource('users', 'UsersController');
});

/*Route::get('allnews', function() {    
    $year = 2013;  
    $news_article = News::whereYear('created_at', '=', $year)->with('media')->get();
   
    foreach ($news_article as $na) {
        echo $na->title;
    }
});*/
