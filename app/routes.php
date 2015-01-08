<?php

//Route::get('/', array('as' => 'carrier', 'uses' => 'HomeController@index'));
Route::get('/', array('as' => 'home.show', 'uses' => 'HomeController@home'));
//Route::post('home', array('as' => 'home.post', 'uses' => 'HomeController@home'));

Route::get('news', array('as' => 'news.all', 'uses' => 'ListingController@showNews'));
Route::post('news/more', array('as' => 'news.all.post', 'uses' => 'ListingController@showMoreNews'));
Route::get('news/{id}', array('as' => 'news.show', 'uses' => 'NewsController@show'));
Route::get('news/year/{year}', array('as' => 'news.year.show', 'uses' => 'ListingController@showNewsByYear'));
Route::post('news/year/{year}', array('as' => 'news.year.show.post', 'uses' => 'ListingController@showNewsByYear'));
Route::post('news/more/{year}', array('as' => 'news.year.more.show', 'uses' => 'ListingController@showMoreNewsByYear'));

Route::get('game/{id}', array('as' => 'game.show', 'uses' => 'GamesController@show'));
Route::get('category/{id}', array('as' => 'category.show', 'uses' => 'ListingController@showGamesByCategory'));
Route::post('category/more', array('as' => 'category.more.show', 'uses' => 'ListingController@showMoreGamesByCategory'));
Route::get('games', array('as' => 'games.all', 'uses' => 'ListingController@showGames'));
Route::post('games/all/more', array('as' => 'games.all.more', 'uses' => 'ListingController@showAllMoreGames'));
Route::post('games/more', array('as' => 'games.more.show', 'uses' => 'ListingController@showMoreGames'));

Route::get('profile/{id}', array('as' => 'user.profile', 'uses' => 'ProfileController@index'));

Route::get('reviews/{id}', array('as' => 'reviews', 'uses' => 'ReviewsController@index'));

Route::post('search', array('as' => 'search', 'uses' => 'ListingController@searchGames'));
Route::post('search/more', array('as' => 'search.more', 'uses' => 'ListingController@searchMoreGames'));

Route::post('language', array(
	'before' => 'csrf',
	'as' => 'choose_language',
	'uses' => 'LanguagesController@chooseLanguage'
));

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
    
/** 
* Added by: Jone   
* Purpose: For role filtering
* Date: 01/06/2015
*/

        Route::post('games/{id}/edit-carriers', array('as' => 'admin.games.update-carriers', 'uses' => 'AdminGamesController@updateCarrier'));
        Route::post('games/{id}/edit-media', array('as' => 'admin.games.update-media', 'uses' => 'AdminGamesController@updateMedia'));
        Route::post('games/{id}/update-fields', array('as' => 'admin.games.update-fields', 'uses' => 'AdminGamesController@updateFields'));
        Route::get('games/{id}/edit/content/{language}', array('as' => 'admin.games.edit.content', 'uses' => 'AdminGamesController@getLanguageContent'));
        Route::post('games/{id}/edit/content/{language}', array('as' => 'admin.games.edit.content', 'uses' => 'AdminGamesController@updateLanguageContent'));
        Route::get('games/{id}/edit/prices/{carrier}', array('as' => 'admin.games.edit.prices', 'uses' => 'AdminGamesController@getPriceContent'));
        Route::post('games/{id}/edit/prices/{language}', array('as' => 'admin.games.edit.prices', 'uses' => 'AdminGamesController@updatePriceContent'));
        Route::resource('categories', 'CategoriesController');
        Route::resource('languages', 'LanguagesController');
        Route::resource('carriers', 'CarriersController');

    // Route::post('games/{id}/edit-carriers', array('as' => 'admin.games.update-carriers', 'uses' => 'AdminGamesController@updateCarrier'));
    // Route::post('games/{id}/edit-media', array('as' => 'admin.games.update-media', 'uses' => 'AdminGamesController@updateMedia'));
    // Route::post('games/{id}/update-fields', array('as' => 'admin.games.update-fields', 'uses' => 'AdminGamesController@updateFields'));
    // Route::post('games/{id}/update-media', array('as' => 'admin.games.update-media', 'uses' => 'AdminGamesController@updateMedia'));
    // Route::get('games/{id}/edit/content/{language}', array('as' => 'admin.games.edit.content', 'uses' => 'AdminGamesController@getLanguageContent'));
    // Route::post('games/{id}/edit/content/{language}', array('as' => 'admin.games.edit.content', 'uses' => 'AdminGamesController@updateLanguageContent'));
    // Route::get('games/{id}/edit/prices/{carrier}', array('as' => 'admin.games.edit.prices', 'uses' => 'AdminGamesController@getPriceContent'));
    // Route::post('games/{id}/edit/prices/{language}', array('as' => 'admin.games.edit.prices', 'uses' => 'AdminGamesController@updatePriceContent'));

    Route::resource('news', 'NewsController');
    Route::post('news/{id}/update-fields', array('as' => 'admin.news.update-fields', 'uses' => 'NewsController@updateFields'));
    Route::get('news/{id}/edit/content/{language}', array('as' => 'admin.news.edit.content', 'uses' => 'NewsController@getLanguageContent'));
    Route::post('news/{id}/edit/content/{language}', array('as' => 'admin.news.edit.content', 'uses' => 'NewsController@updateLanguageContent'));
    Route::post('news/{id}/edit-media', array('as' => 'admin.news.update-media', 'uses' => 'NewsController@updateMedia'));
    Route::resource('media', 'MediaController');
   
    Route::resource('faqs', 'FaqsController');
    
    Route::resource('siteoptions', 'SiteOptionsController');
    Route::get('reports', array('as' => 'admin.reports.index', 'uses' => 'ReportsController@index'));
   /* Route::get('reports/sales', array('as' => 'admin.reports.sales', 'uses' => 'ReportsController@sales'));*/
    Route::get('reports/downloads', array('as' => 'admin.reports.downloads', 'uses' => 'ReportsController@downloads'));
    Route::get('reports/adminlogs', array('as' => 'admin.reports.adminlogs', 'uses' => 'ReportsController@adminlogs'));
    Route::get('reports/visitorlogs', array('as' => 'admin.reports.visitorlogs', 'uses' => 'ReportsController@visitorlogs'));
    Route::get('reports/inquiries', array('as' => 'admin.reports.inquiries', 'uses' => 'ReportsController@inquiries'));
    Route::post('media/upload', array('as' => 'media.upload', 'uses' => 'MediaController@postUpload'));
    // Route::get('media/load', array('as' => 'media.load', 'uses' => 'MediaController@showAllMedia'));
   
    Route::group(array('prefix' => 'reports', 'before' => 'reports'), function(){
        
        Route::get('sales/lists', array('as' => 'admin.reports.sales.list', 'uses' => 'ReportsController@salesList'));
        Route::get('sales/chart', array('as' => 'admin.reports.sales.chart', 'uses' => 'ReportsController@salesChart'));
        Route::post('sales/filter/{id?}/{filter?}', array('as' => 'admin.reports.sales.filter', 'uses' => 'ReportsController@salesFilter'));
        Route::post('sales/overall', array('as' => 'admin.reports.sales.overall', 'uses' => 'ReportsController@overallGamesSales'));
        Route::post('inquiries/{id?}/reply', array('as' => 'admin.reports.inquiries.reply', 'uses' => 'InquiriesController@reply'));
        Route::get('inquiries/settings', array('as' => 'admin.reports.inquiries.settings', 'uses' => 'InquiriesController@settings'));
        Route::post('inquiries/settings/save', array('as' => 'admin.reports.inquiries.save-settings', 'uses' => 'InquiriesController@saveSettings'));
        Route::get('inquiries/links', array('as' => 'admin.reports.inquiries.links', 'uses' => 'InquiriesController@linkTo'));
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

