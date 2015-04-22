<?php

Route::get('/', array('as' => 'carrier', 'uses' => 'HomeController@index'));
Route::get('home', array('as' => 'home.show', 'uses' => 'HomeController@home'));
Route::post('home', array('as' => 'home.post', 'uses' => 'HomeController@home'));

Route::get('news', array('as' => 'news.all', 'uses' => 'ListingController@showNews'));
Route::post('news/more', array('as' => 'news.all.post', 'uses' => 'ListingController@showMoreNews'));
Route::get('news/{id}', array('as' => 'news.show', 'uses' => 'NewsController@show'));
Route::get('news/year/{year}', array('as' => 'news.year.show', 'uses' => 'ListingController@showNewsByYear'));
Route::post('news/year/{year}', array('as' => 'news.year.show.post', 'uses' => 'ListingController@showNewsByYear'));
Route::post('year/more', array('as' => 'news.year.more.show', 'uses' => 'ListingController@showMoreNewsByYear'));

//Route::get('game/{id}/{slug}-{carrier}-{language}', array('as' => 'game.show', 'uses' => 'GamesController@show'));
// Route::get('game/{id}/{slug}/{carrier}/{language}', array('as' => 'game.show', 'uses' => 'GamesController@show'));
// Route::get('game/{id}/{app_id}', array('as' => 'game.show', 'uses' => 'GamesController@show'));

Route::post('game/{id}', array('as' => 'game.show.post', 'uses' => 'GamesController@show'));
Route::get('category/{id}', array('as' => 'category.show', 'uses' => 'ListingController@showGamesByCategory'));
Route::post('category/load/more', array('as' => 'category.more.show', 'uses' => 'ListingController@showMoreGamesByCategory'));
Route::get('games', array('as' => 'games.all', 'uses' => 'ListingController@showGames'));
Route::post('games/all/more', array('as' => 'games.all.more', 'uses' => 'ListingController@showAllMoreGames'));

Route::get('games/related/{id}', array('as' => 'games.related', 'uses' => 'ListingController@showRelatedGames'));
Route::post('games/related/more/{id}', array('as' => 'games.related.more', 'uses' => 'ListingController@showMoreRelatedGames'));

Route::get('profile/{id}', array('as' => 'user.profile', 'uses' => 'ProfileController@index'));

Route::get('reviews/{id}', array('as' => 'reviews', 'uses' => 'ReviewsController@index'));
Route::post('review/{id}/{app_id}/post', array('as' => 'review.post', 'uses' => 'ReviewsController@postReview'));

Route::post('search', array('as' => 'search', 'uses' => 'ListingController@searchGames'));
Route::post('search/more', array('as' => 'search.more', 'uses' => 'ListingController@searchMoreGames'));

Route::post('category/search', array('as' => 'search', 'uses' => 'ListingController@searchGamesByCategory'));

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

Route::post('games/load/content/{id}', array('as' => 'games.content.load', 'uses' => 'GamesController@loadGameContent'));

Route::group(array('prefix' => 'admin'), function() {
    Route::get('login', array('as' => 'admin.login', 'uses' => 'AdminUsersController@getLogin'));
    Route::post('login', array('as' => 'admin.login.post', 'uses' => 'AdminUsersController@postLogin'));
    Route::get('logout', array('as' => 'admin.logout', 'uses' => 'AdminUsersController@getLogout'));
});

Route::group(array('prefix' => 'admin', 'before' => 'admin'), function(){
    Route::get('dashboard', array('as' => 'admin.dashboard', 'uses' => 'AdminUsersController@getDashboard'));
    Route::get('users/roles', array('as' => 'admin.users.roles', 'uses' => 'AdminUsersController@getUsersByRole'));
    Route::get('news/categories', array('as' => 'admin.news.category', 'uses' => 'NewsController@getNewsByCategory'));
    Route::get('game/categories', array('as' => 'admin.game.category', 'uses' => 'AdminGamesController@getGameByCategory'));
    Route::resource('users', 'AdminUsersController');
    Route::resource('games', 'AdminGamesController');

    Route::post('games/{id}/edit-carriers', array('as' => 'admin.games.update-carriers', 'uses' => 'AdminGamesController@updateCarrier'));
    Route::post('games/{id}/edit-media', array('as' => 'admin.games.update-media', 'uses' => 'AdminGamesController@updateMedia'));
    Route::post('games/{id}/update-fields', array('as' => 'admin.games.update-fields', 'uses' => 'AdminGamesController@updateFields'));
    Route::get('games/{id}/edit/content/{language}', array('as' => 'admin.games.edit.content', 'uses' => 'AdminGamesController@getLanguageContent'));
    Route::post('games/{id}/edit/content/{language}', array('as' => 'admin.games.edit.content', 'uses' => 'AdminGamesController@updateLanguageContent'));
    Route::get('games/{id}/create/app', array('as' => 'admin.games.create.app', 'uses' => 'AdminGamesController@getCreateApp'));
    Route::get('games/{id}/edit/{app}', array('as' => 'admin.games.edit.app', 'uses' => 'AdminGamesController@getEditApp'));
    Route::post('games/{id}/edit/{app}', array('as' => 'admin.games.update.app', 'uses' => 'AdminGamesController@postUpdateApp'));
    Route::delete('games/{id}/{app}/delete', array('as' => 'admin.games.delete.app', 'uses' => 'AdminGamesController@postDeleteApp'));
    Route::post('games/{id}/create/app', array('as' => 'admin.games.store.app', 'uses' => 'AdminGamesController@postStoreApp'));
    Route::post('games/{id}/edit/prices/{language}', array('as' => 'admin.games.edit.prices', 'uses' => 'AdminGamesController@updatePriceContent'));
    Route::get('games/{id}/reviews', array('as' => 'admin.game.reviews', 'uses' => 'AdminGamesController@getGameReviews'));
    Route::post('games/{id}/languages/default', array('as' => 'admin.game.languages.default', 'uses' => 'AdminGamesController@updateDefaultLanguage'));
    Route::post('categories/featured', array('as' => 'admin.categories.featured', 'uses' => 'CategoriesController@update_featured'));
    Route::resource('categories', 'CategoriesController');
    Route::resource('languages', 'LanguagesController');
    Route::resource('carriers', 'CarriersController');
    Route::resource('discounts', 'DiscountsController');



    // Site Options Routes
    Route::get('general-settings', array('as' => 'admin.general-settings', 'uses' => 'SiteOptionsController@showGeneralSettings'));
    Route::post('general-settings', array('as' => 'admin.general-settings.update', 'uses' => 'SiteOptionsController@updateGeneralSettings'));
    Route::get('variables', array('as' => 'admin.variables', 'uses' => 'SiteOptionsController@showVariables'));
    Route::post('variables', array('as' => 'admin.variables.update', 'uses' => 'SiteOptionsController@updateVariables'));
    Route::get('game-settings', array('as' => 'admin.game-settings', 'uses' => 'SiteOptionsController@showGameSettings'));
    Route::put('game-settings/{id}/edit', array('as' => 'admin.game-settings.update', 'uses' => 'SiteOptionsController@updateGameSettings'));
    Route::get('featured', array('as' => 'admin.featured', 'uses' => 'SiteOptionsController@showFeatured'));
    Route::post('featured', array('as' => 'admin.featured.update', 'uses' => 'SiteOptionsController@updateFeatured'));
    Route::post('featured/categories', array('as' => 'admin.featured.categories.update', 'uses' => 'SiteOptionsController@updateCategories'));

    Route::get('ip-filters', array('as' => 'admin.ip-filters', 'uses' => 'SiteOptionsController@getIPfilters'));
    Route::post('ip-filters', array('as' => 'admin.ip-filters.create', 'uses' => 'SiteOptionsController@addIPfilters'));
    Route::delete('ip-filters/{id}', array('as' => 'admin.ip-filters.delete', 'uses' => 'SiteOptionsController@deleteIPFilter'));

    //added for admin reviews - transfer later on
    Route::post('reviews/status', array('as' => 'admin.reviews.status', 'uses' => 'ReviewsController@update_status'));
    Route::get('reviews', array('as' => 'admin.reviews.index', 'uses' => 'ReviewsController@admin_index'));
   
    Route::resource('media', 'MediaController');
    Route::resource('news', 'NewsController');
    Route::post('news/{id}/update-fields', array('as' => 'admin.news.update-fields', 'uses' => 'NewsController@updateFields'));
    Route::get('news/{id}/create/variant', array('as' => 'admin.news.variant.create', 'uses' => 'NewsController@addVariant'));
    Route::post('news/{id}/store/variant', array('as' => 'admin.news.variant.store', 'uses' => 'NewsController@storeVariant'));
    Route::get('news/{id}/edit/variant/{language}', array('as' => 'admin.news.variant.edit', 'uses' => 'NewsController@editVariant'));
    Route::put('news/{id}/update/variant/{language}', array('as' => 'admin.news.variant.update', 'uses' => 'NewsController@updateVariant'));
    Route::delete('news/{id}/delete/variant/{language}', array('as' => 'admin.news.variant.delete', 'uses' => 'NewsController@deleteVariant'));
    
    Route::resource('faqs', 'FaqsController');
    Route::get('faq/{id}/variant', array('as' => 'admin.faqs.variant', 'uses' => 'FaqsController@addVariant'));
    Route::get('faq/{id}/create/variant', array('as' => 'admin.faqs.variant.create', 'uses' => 'FaqsController@addVariant'));
    Route::post('faq/{id}/create/variant', array('as' => 'admin.faqs.variant.store', 'uses' => 'FaqsController@storeVariant'));
    Route::get('faq/{id}/edit/variant/{language}', array('as' => 'admin.faqs.variant.edit', 'uses' => 'FaqsController@editVariant'));
    Route::put('faq/{id}/update/variant/{language}', array('as' => 'admin.faqs.variant.update', 'uses' => 'FaqsController@updateVariant'));
    Route::delete('faq/{id}/delete/variant/{language}', array('as' => 'admin.faqs.variant.delete', 'uses' => 'FaqsController@deleteVariant'));
    
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
        
        Route::get('visitors/pageviews', array('as' => 'admin.reports.visitors.pageviews', 'uses' => 'ReportsController@visitorsPagesViews'));
        Route::post('visitors/chart/pageviews', array('as' => 'admin.reports.visitors.pageviews-chart', 'uses' => 'ReportsController@visitorsPagesViewsChart'));
        Route::get('visitors/userviews', array('as' => 'admin.reports.visitors.userviews', 'uses' => 'ReportsController@visitorsUsersViews'));
        Route::get('visitors/ratings', array('as' => 'admin.reports.visitors.ratings', 'uses' => 'ReportsController@visitorsRatingsViews'));
        Route::get('visitors/statistics', array('as' => 'admin.reports.visitors.statistics', 'uses' => 'ReportsController@visitorsStatisticViews'));
        Route::get('visitors/statistics/{id?}/buy', array('as' => 'admin.reports.visitors.statistics.buy', 'uses' => 'ReportsController@visitorsBuyStatisticViews'));
        Route::get('visitors/statistics/{id?}/download', array('as' => 'admin.reports.visitors.statistics.download', 'uses' => 'ReportsController@visitorsDownloadStatisticViews'));
        Route::get('visitors/analytics', array('as' => 'admin.reports.visitors.analytics', 'uses' => 'ReportsController@visitorsGoolgeAnaylitcsViews'));
        Route::get('visitors/activity', array('as' => 'admin.reports.visitors.activity', 'uses' => 'ReportsController@visitorActivityUsers'));

        Route::get('sales/lists', array('as' => 'admin.reports.sales.list', 'uses' => 'ReportsController@salesList'));
        Route::get('sales/chart', array('as' => 'admin.reports.sales.chart', 'uses' => 'ReportsController@salesChart'));
        Route::post('sales/chart/{id?}/{filter?}', array('as' => 'admin.reports.sales.filter', 'uses' => 'ReportsController@salesFilter'));
        Route::post('sales/chart/overall', array('as' => 'admin.reports.sales.overall', 'uses' => 'ReportsController@overallGamesSales'));
        Route::post('inquiries/{id?}/reply', array('as' => 'admin.reports.inquiries.reply', 'uses' => 'InquiriesController@reply'));
        Route::get('inquiries/settings', array('as' => 'admin.reports.inquiries.settings', 'uses' => 'InquiriesController@settings'));
        Route::post('inquiries/settings/save', array('as' => 'admin.reports.inquiries.save-settings', 'uses' => 'InquiriesController@saveSettings'));
        Route::get('inquiries/links', array('as' => 'admin.reports.inquiries.links', 'uses' => 'InquiriesController@linkTo'));
        Route::resource('inquiries', 'InquiriesController', array('except' => array('create', 'update', 'edit', 'store')));
    
    });

});

/** 
* Added by: Jone   
* Purpose: For admin news creation
* Date: 12/04/2014
*/
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

Route::post('reports/inquiries', array('as' => 'reports.inquiries.store-inquiry', 'uses' => 'InquiriesController@storeInquiry'));
//Route::get('games/{id}/carrier', array('as' => 'games.carrier', 'uses' => 'GamesController@getAPICarrier'));
Route::get('games/{id}/carrier', array('as' => 'games.carrier', 'uses' => 'GamesController@getCarrier'));
Route::get('games/{id}/carrier/details', array('as' => 'games.carrier.details', 'uses' => 'GamesController@getCarrierDetails'));
Route::get('games/{id}/status', array('as' => 'games.status', 'uses' => 'GamesController@getPurchaseStatus'));

Route::get('games/{id}/payment', array('as' => 'games.payment', 'uses' => 'GamesController@getPaymentInfo'));

/*Route::get('allnews', function() {    
    $year = 2013;  
    $news_article = News::whereYear('created_at', '=', $year)->with('media')->get();
   
    foreach ($news_article as $na) {
        echo $na->title;
    }
});*/


Route::get('categories', array('as' => 'categories.all', 'uses' => 'ListingController@showGameCategories'));
Route::post('export', array('as' => 'admin.export.selectedDB', 'uses' => 'AdminUsersController@exportDB'));
Route::post('approve/review', array('as' => 'review.approve', 'uses' => 'ReviewsController@apprroveReview'));
route::resource('review', 'ReviewsController');
Route::post('/admin/destroy/review', array('before' => 'csrf', 'as' => 'admin.destroy.review','uses' => 'ReviewsController@handleDestroy'));
Route::get('admin/games/preview/{id}/{app_id}', array('as' => 'admin.games.preview', 'uses' => 'AdminGamesController@previewGame'));
Route::get('game/{id}/{app_id}', array('as' => 'game.show', 'uses' => 'GamesController@show'));


/*API*/
//Route::get('auth/{appid?}/{token?}', array('as' => 'authorize.token', 'uses' => 'APIController@authorizeToken'));
Route::get('auth/login/{app_id?}', array('as' => 'authorize.login', 'uses' => 'APIController@authLoginAPI'));
Route::post('auth/login', array('as' => 'auth.login.post', 'uses' => 'APIController@authLoginPost'));
Route::get('auth/logout/{token?}', array('as' => 'auth.logout.post', 'uses' => 'APIController@authLogoutAPI'));
Route::get('auth/user/{token?}', array('as' => 'auth.logout.post', 'uses' => 'APIController@authorizeToken'));
//Route::post('authorize/{appid}/{token}', array('as' => 'authorize.user', 'uses' => 'APIController@authorizeLoginPost'));
