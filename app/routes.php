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
//Auth::loginUsingId(4);

Route::pattern('id', '[0-9]+');

Route::get('/', [
    "as"   => "home",
    "uses" => 'HomeController@index',
]);

Route::controller('password', 'RemindersController');

Route::group([ 'prefix' => 'user' ], function () {

    Route::get("login", [ "as" => "user.login", "uses" => "UserController@index" ]);

    Route::post("login", [
        "as"   => "user.login",
        "uses" => "UserController@login",
    ]);

    Route::get("sign-up", [
        "as"   => "user.register",
        "uses" => "UserController@signUp",
    ]);
    Route::post("sign-up", [
        "as"   => "user.register",
        "uses" => "UserController@register",
    ]);
});

/* Require Login for those routes */
Route::group([ 'before' => 'access' ], function () {

    Route::group([ 'prefix' => 'user' ], function () {
        Route::any("logout", [
            "as"   => "user.logout",
            "uses" => "UserController@logout",
        ]);
        Route::get('profile', [
            "as"   => "user.profile",
            "uses" => "UserController@showProfile",
        ]);
    });

    /*
     * DATABASE: Double Object
     */
    Route::group([ 'prefix' => 'o2j' ], function () {

        Route::get('/', 'DoubleObjectController@index');

        Route::resource('category', 'CategoryController');
        Route::get('category/{id}/delete', [
            'as'   => 'category.delete',
            'uses' => 'CategoryController@destroy',
        ]);


        Route::resource('occurrence', 'OccurrenceController');
        Route::get('occurrence/{id}/delete', [
            'as'   => 'occurrence.delete',
            'uses' => 'OccurrenceController@destroy',
        ]);
        Route::get('occurrence/by/{filter}/{value}', [
            'as'   => 'occurrence.get-by',
            'uses' => 'OccurrenceController@getBy',
        ]);
        Route::get('occurrence/{id}/object-properties', [
            'as'   => 'occurrence.objectProperties',
            'uses' => 'OccurrenceController@editObjectProperties',
        ]);

        Route::post('occurrence/{id}/object-properties', [
            'as'   => 'occurrence.objectProperties',
            'uses' => 'OccurrenceController@updateObjectProperties',
        ]);

        Route::get('category/{value}/occurrences', [
            'as'   => 'category.occurrences',
            'uses' => 'OccurrenceController@getByCategory',
        ]);

        Route::resource('object-property', 'ObjectPropertyController');
        Route::get('object-property/{id}/delete', [
            'as'   => 'objectProperty.delete',
            'uses' => 'ObjectPropertyController@destroy',
        ]);

        Route::get('verbs', [
            'as'   => 'verbs.list',
            'uses' => 'OccurrenceController@verbs',
        ]);

        Route::controller('statistics', 'StatisticsController');
        Route::controller('query', 'QueryController');

    });

    /*
     * Admin Pages
     */
    Route::group([ 'prefix' => 'admin' ], function () {

        /*
         * USer administration page
         */
        Route::group([ 'before' => 'userAdminCheck' ], function () {

            Route::resource("users", 'UserAdminController');
            Route::get('users/{id}/delete', [
                'as'   => 'user.delete',
                'uses' => 'UserAdminController@destroy',
            ]);

        });
    });

});



// Temporary Route
// Route::controller('migrate-old-db','MigrateOldSetupController');
