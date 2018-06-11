<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These    deleteFromStorage('Authorization');
window.location = "/";
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'Auth\AuthController@login')->name('login.api');
Route::post('/register_user', 'Auth\ApiRegisterController@register')->name('register.api');

Route::group(['prefix' => 'auth', 'middleware' => 'api'], function () {
    Route::post('me', 'Auth\AuthController@me')->name('login.me');
    Route::post('logout', 'Auth\AuthController@logout')->name('logout.api');
    Route::get('/getRoles', 'RoleController@getRoles')->name('get.roles');
});


Route::group(['prefix' => 'song', 'middleware' => 'jwt'], function () {

    Route::post('/add', 'SongsController@store')->name('song.store');

    Route::group(['middleware' => 'userRole'], function () {
        Route::get('/', [
            'uses' => 'SongsController@getUserData',
            'as' => 'song.get.user.data',
            'role' => 'dj'
        ]);
        Route::get('/getParty', [
            'uses' => 'OrganizationController@getUserData',
            'as' => 'get.party.user',
            'role' => 'party'
        ]);
        Route::get('/edit/{song_id}', [
            'uses' => 'SongsController@editData',
            'as' => 'song.edit.data',
            'role' => 'dj'
        ]);
        Route::delete('/delete/{song_id}', [
            'uses' => 'SongsController@delete',
            'as' => 'song.delete',
            'role' => 'dj'
        ]);
        Route::post('/update/{song_id}', [
            'uses' => 'SongsController@update',
            'as' => 'song.update',
            'role' => 'dj'
        ]);
    });
});
