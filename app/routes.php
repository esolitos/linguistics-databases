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


Route::get('/', function()
{
	return View::make('hello');
});

Route::group(array('prefix' => 'user'), function() {
  Route::get("login", [ "as"   => "user/login", "uses" => "UserController@index" ]);
  Route::post("login", [ "as"   => "user/login", "uses" => "UserController@login" ]);

  Route::any("logout", [ "as"   => "user/logout", "uses" => "UserController@logout" ]);
});



/* Require Login for those routes */
Route::group(array('before' => 'auth'), function()
{
	Route::get('user/profile', [ "as"   => "user/profile", "uses" => "UserController@showProfile" ] );

}); // TODO: Once implemented the user-management remove this parentesis


  Route::get('double-object', 'DoubleObjectController@index');

  Route::resource('double-object/category', 'CategoryController');
  Route::get('double-object/category/{id}/delete', ['as'=>'category.delete', 'uses'=>'CategoryController@destroy']);
  
  Route::resource('double-object/occurrence', 'OccurrenceController');
  Route::get('double-object/occurrence/{id}/delete', ['as'=>'occurrence.delete', 'uses'=>'OccurrenceController@destroy']);
  
// });  // TODO: Once implemented the user-management remove the comment
