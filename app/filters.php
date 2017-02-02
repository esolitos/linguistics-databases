<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/


App::before(function ($request) {
    //
});

App::after(function ($request, $response) {
    //
});


Route::filter('auth.basic', function () {
    return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function () {
    if (Auth::check()) {
        return Redirect::to('/');
    }
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function () {
    if (Session::token() != Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

/*
|--------------------------------------------------------------------------
| Access Filter
|--------------------------------------------------------------------------
|
| Check permission for every route.
|
*/

Route::filter('access', function (Illuminate\Routing\Route $route, Illuminate\Http\Request $request) {

    if (Auth::guest()) {
        return Redirect::guest('user/login');
    }

    // we need this because laravel delete form sends POST request with {_method: 'DELETE'} as parameter
    //$method = $request->has('_method') ? $request->input('_method') : $request->server('REQUEST_METHOD');

    //if ( ! Authority::can($method, $route->getName())) {
    //    App::abort(403);
    //}
});

/*
 *
 */
Route::filter('userAdminCheck', function (Illuminate\Routing\Route $route, Illuminate\Http\Request $request) {

    if (Auth::guest()) {
        return Redirect::guest('user/login');
    }

    if ( Authority::cannot(Permission::ADMINISTER, 'User')) {
        App::abort(403);
    }
});

