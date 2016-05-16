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

Route::get('/home', array('uses' => 'MainController@redirectHome'));
Route::get('/register', array('uses' => 'MainController@redirectHome'));
Route::get('/', array('as' => 'home', 'uses' => 'MainController@landingPage'));
Route::post('/search-summoner', array('as' => 'search-summoner', 'uses' => 'MainController@searchSummoner'));
//User Profile
Route::get('/user/profile', array('as' => 'profile-edit', 'uses' => 'MainController@editProfile'));
Route::post('/user/profile', array('as' => 'update-profile', 'uses' => 'MainController@saveProfile'));
//Search User


//Update Summoner (Poor Optimization..)
Route::get('/summoner-update/{id}', array('as' => 'summoner-update-id', 'uses' => 'UpdateController@updateSummonerById'));
Route::get('/summoner-update/{name}', array('as' => 'summoner-update-name', 'uses' => 'UpdateController@updateSummonerByName'));

//Admin routes
Route::get('/admin/updates', array('as' => 'admin-updates', 'uses' => 'AdminController@updates'));
Route::post('/admin/updates', array('as' => 'update-database', 'uses' => 'UpdateController@databaseUpdates'));



// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@getLogout');
Route::get('/register', 'Auth\AuthController@getRegister');
Route::post('/register', 'Auth\AuthController@postRegister');