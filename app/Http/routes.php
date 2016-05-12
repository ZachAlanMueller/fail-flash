<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
<<<<<<< HEAD
Route::get('/', array('as' => 'home', 'uses' => 'MainController@home'));
=======

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function() {
	return view('welcome');
});
>>>>>>> 56da2ff42c513ff1ecf2c9c1f66b8fe247a9a0cf
Route::get('/testing', function() {
	return view('main');
});



// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::auth();

Route::get('/home', 'HomeController@index');
