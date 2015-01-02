<?php

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
Route::get('game/{id}', array('as' => 'game.show', 'uses' => 'GamesController@show'));
Route::get('news/{id}', array('as' => 'news.show', 'uses' => 'NewsController@show'));
Route::get('category/{id}', array('as' => 'category.show', 'uses' => 'ListingController@showGameCategories'));
Route::get('news/year/{year}', array('as' => 'news.year.show', 'uses' => 'ListingController@showNewsByYear'));
Route::get('games/new', array('as' => 'games.new.show', 'uses' => 'ListingController@showGames'));

Route::get('loadmore', function()
{
	$games = Game::all();

	return View::make('_partials.games')
		->with(compact('games'));
});

Route::get('loadmore/{id}', function($id) 
{
	$category = Category::find($id);
	$games = Category::find($id)->games;

	return View::make('_partials.category')
		->with(compact('category'))
		->with(compact('games'));
});

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
    Route::post('games/{id}/edit-carriers', array('as' => 'admin.games.update-carriers', 'uses' => 'AdminGamesController@updateCarrier'));
    Route::post('games/{id}/edit-media', array('as' => 'admin.games.update-media', 'uses' => 'AdminGamesController@updateMedia'));
    Route::post('games/{id}/update-fields', array('as' => 'admin.games.update-fields', 'uses' => 'AdminGamesController@updateFields'));
    Route::get('games/{id}/edit/content/{language}', array('as' => 'admin.games.edit.content', 'uses' => 'AdminGamesController@getLanguageContent'));
    Route::post('games/{id}/edit/content/{language}', array('as' => 'admin.games.edit.content', 'uses' => 'AdminGamesController@updateLanguageContent'));
    Route::get('games/{id}/edit/prices/{carrier}', array('as' => 'admin.games.edit.prices', 'uses' => 'AdminGamesController@getPriceContent'));
     Route::post('games/{id}/edit/prices/{language}', array('as' => 'admin.games.edit.prices', 'uses' => 'AdminGamesController@updatePriceContent'));

    Route::resource('news', 'NewsController');
    Route::post('news/{id}/update-fields', array('as' => 'admin.news.update-fields', 'uses' => 'NewsController@updateFields'));
    Route::get('news/{id}/edit/content/{language}', array('as' => 'admin.news.edit.content', 'uses' => 'NewsController@getLanguageContent'));
    Route::post('news/{id}/edit/content/{language}', array('as' => 'admin.news.edit.content', 'uses' => 'NewsController@updateLanguageContent'));
    Route::post('news/{id}/edit-media', array('as' => 'admin.news.update-media', 'uses' => 'NewsController@updateMedia'));
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
   
    Route::group(array('prefix' => 'reports', 'before' => 'reports'), function(){
        
        Route::post('inquiries/{id?}/reply', array('as' => 'admin.reports.inquiries.reply', 'uses' => 'InquiriesController@reply'));
        Route::get('inquiries/settings', array('as' => 'admin.reports.inquiries.settings', 'uses' => 'InquiriesController@settings'));
        Route::post('inquiries/settings/save', array('as' => 'admin.reports.inquiries.save-settings', 'uses' => 'InquiriesController@saveSettings'));
        Route::resource('inquiries', 'InquiriesController', array('except' => array('create', 'update', 'edit')));
    });

});

/** 
* Added by: Jone   
* Purpose: For admin news creation
* Date: 12/04/2014
*/
/*Route::get('games', array('as' => 'games', 'uses' => 'GamesController@index'));
Route::get('games/{id}', array('as' => 'games.show', 'uses' => 'GamesController@show'));
Route::get('news', array('as' => 'news', 'uses' => 'NewsController@usersindex'));
Route::get('news/show/{id}', array('as' => 'news.show', 'uses' => 'NewsController@getSingleNews'));
/*Route::get('news/year/{id}', array('as' => 'news.show', 'uses' => 'NewsController@getNewsByYear'));
/*Route::controller('news/show', 'NewsController');*/
//Route::get('news/year', array('as' => 'news.year', 'uses' => 'NewsController@getNewsByYear'));
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
Route::get('register', array('as' => 'users.register', 'uses' => 'UsersController@getRegister'));
Route::post('register', array('as' => 'users.register.post', 'uses' => 'UsersController@postRegister'));

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

