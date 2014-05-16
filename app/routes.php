<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::pattern('id', '[0-9]+');

Route::get("user/login", [ "as"   => "user/login", "uses" => "UserController@index" ]);
Route::post("user/login", [ "as"   => "user/login", "uses" => "UserController@login" ]);

Route::any("user/logout", [ "as"   => "user/logout", "uses" => "UserController@logout" ]);


/* Require Login for those routes */
Route::group(array('before' => 'auth'), function()
{
	Route::get('user/profile', [ "as"   => "user/profile", "uses" => "UserController@showProfile" ] );
	
	
});


Route::get('/', function()
{
	return View::make('hello');
});

