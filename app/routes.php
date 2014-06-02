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
  
  Route::resource('double-object/object-property', 'ObjectPropertyController');
  Route::get('double-object/object-property/{id}/delete', ['as'=>'objectProperty.delete', 'uses'=>'ObjectPropertyController@destroy']);

  Route::get('double-object/occurrence/{id}/define-properties', ['as'=>'objectProperty.properties', 'uses'=>'OccurrenceController@defineObjectProperties']);
  Route::post('double-object/occurrence/{id}/define-properties', ['as'=>'objectProperty.properties', 'uses'=>'OccurrenceController@storeObjectProperties']);

  Route::get('double-object/occurrence/{id}/edit-properties', ['as'=>'objectProperty.editProperties', 'uses'=>'OccurrenceController@editObjectProperties']);
  Route::post('double-object/occurrence/{id}/edit-properties', ['as'=>'objectProperty.editProperties', 'uses'=>'OccurrenceController@updateObjectProperties']);
  
// });  // TODO: Once implemented the user-management remove the comment



  // Temporary Route
  Route::controller('migrate-old-db','MigrateOldSetupController');
