<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/songs', 'SongsController@index')->name('song.index');
Route::get('/party', 'OrganizationController@index')->name('organization.index');
Route::get('/edit/{song_id}', 'SongsController@editIndex')->name('song.edit.index');
Route::get('/user/{user_id}', 'SongsController@user')->name('user.view');

//Route::group(['middleware' => 'auth:api'], function(){
//
//});