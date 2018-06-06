<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
	


Route::group(['prefix' => 'auth', 'middleware' => 'api'], function(){
	
	Route::post('/login', 'Auth\AuthController@login')->name('login.api');
	Route::post('me', 'Auth\AuthController@me')->name('login.me');
	Route::post('logout', 'Auth\AuthController@logout');
});



Route::group(['prefix' => 'song', 'middleware' => 'api'], function(){
    Route::post('/add', 'SongsController@store')->name('song.store');
    Route::get('/edit/{song_id}', 'SongsController@editData')->name('song.edit.data');
    Route::get('/delete/{song_id}', 'SongsController@delete')->name('song.delete');
    Route::post('/update/{song_id}', 'SongsController@update')->name('song.update');
    Route::get('/', 'SongsController@getUserData')->name('song.get.user.data');
});

//Route::group([
//
//	'middleware' => 'api',
//	'prefix' => 'auth'
//
//], function ($router) {
//
//	Route::post('login', 'AuthController@login');
//	Route::post('logout', 'AuthController@logout');
//	Route::post('refresh', 'AuthController@refresh');
//	Route::post('me', 'AuthController@me');
//
//});