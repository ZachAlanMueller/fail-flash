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
Route::get('/summoner/{id}', array('as' => 'display-summoner', 'uses' => 'MainController@displaySummoner'));
Route::get('/summoner/{id}/softUpdate', array('as' => 'summoner-soft-update', 'uses' => 'MainController@softUpdate'));
Route::get('/summoner/{id}/mediumUpdate', array('as' => 'summoner-medium-update', 'uses' => 'MainController@mediumUpdate'));
Route::get('/summoner/{id}/hardUpdate', array('as' => 'summoner-hard-update', 'uses' => 'MainController@hardUpdate'));


//Admin routes
Route::get('/admin/updates', array('as' => 'admin-updates', 'uses' => 'AdminController@updates'));
Route::post('/admin/updates', array('as' => 'update-database', 'uses' => 'UpdateController@databaseUpdates'));

Route::get('/foobar' array('as', => 'foobar', 'uses' => 'MainController@foobar'));



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