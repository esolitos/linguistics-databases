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


Route::get('/', 'HomeController@index');
Route::controller('password', 'RemindersController');

Route::group(array('prefix' => 'user'), function() {
  Route::get("login", [ "as"   => "user.login", "uses" => "UserController@index" ]);
  Route::post("login", [ "as"   => "user.login", "uses" => "UserController@login" ]);
  
  Route::any("logout", [ "as"   => "user.logout", "uses" => "UserController@logout" ]);

  Route::get("sign-up", [ "as"   => "user.register", "uses" => "UserController@signUp" ]);
  Route::post("sign-up", [ "as"   => "user.register", "uses" => "UserController@register" ]);
});



/* Require Login for those routes */
Route::group(array('before' => 'auth'), function()
{
	Route::get('user/profile', [ "as"   => "user.profile", "uses" => "UserController@showProfile" ] );


  Route::get('double-object', 'DoubleObjectController@index');

  Route::resource('double-object/category', 'CategoryController');
  Route::get('double-object/category/{id}/delete', ['as'=>'category.delete', 'uses'=>'CategoryController@destroy']);
  
  Route::resource('double-object/occurrence', 'OccurrenceController');
  Route::get('double-object/occurrence/{id}/delete', ['as'=>'occurrence.delete', 'uses'=>'OccurrenceController@destroy']);
  Route::get('double-object/occurrence/by/{filter}/{value}', ['as'=>'occurrence.get-by', 'uses'=>'OccurrenceController@getBy']);
  Route::get('double-object/category/{value}/occurrences', ['as'=>'category.occurrences', 'uses'=>'OccurrenceController@getByCategory']);
  
  Route::resource('double-object/object-property', 'ObjectPropertyController');
  Route::get('double-object/object-property/{id}/delete', ['as'=>'objectProperty.delete', 'uses'=>'ObjectPropertyController@destroy']);

  Route::get('double-object/occurrence/{id}/object-properties', ['as'=>'occurrence.objectProperties', 'uses'=>'OccurrenceController@editObjectProperties']);
  Route::post('double-object/occurrence/{id}/object-properties', ['as'=>'occurrence.objectProperties', 'uses'=>'OccurrenceController@updateObjectProperties']);

  Route::get('double-object/verbs', ['as'=>'verbs.list', 'uses'=>'OccurrenceController@verbs']);
  
  Route::controller('double-object/statistics','StatisticsController');
  Route::controller('double-object/query','QueryController');
  
});



  // Temporary Route
  // Route::controller('migrate-old-db','MigrateOldSetupController');
