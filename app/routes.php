<?php

Route::get('/', function()
{
	return View::make('hello');
});

Route::group(array('prefix' => 'admin'), function() {

	Route::get('/', array('uses' => 'AdminUsersController@index'));

});