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


Route::group(['prefix' => 'v1'], function () {

    /*
    Authentication
    */

    Route::post('/login', 'Auth\AuthController@login')->name('login.api');
    Route::post('/register', 'Auth\ApiRegisterController@register')->name('register.api');
    Route::get('/roles', 'RoleController@getRoles')->name('get.roles');


    Route::group(['prefix' => 'auth', 'middleware' => 'jwt'], function () {
        /*
            Authenticated
        */

        Route::post('me', 'Auth\AuthController@me')->name('login.me');
        Route::post('logout', 'Auth\AuthController@logout')->name('logout.api');
    });
    /*
        Songs
    */

    Route::group(['prefix' => 'songs'], function () {
        Route::group(['middleware' => 'roles'], function () {
            Route::post('/', [
                'uses' => 'SongsController@store',
                'as' => 'song.store',
                'role' => 'dj'
            ]);

            Route::get('/', [
                'uses' => 'SongsController@getUserData',
                'as' => 'song.get.user.data',
                'role' => 'dj'
            ]);
            Route::get('/{song_id}', [
                'uses' => 'SongsController@editData',
                'as' => 'song.edit.data',
                'role' => 'dj'
            ]);
            Route::delete('/{song_id}', [
                'uses' => 'SongsController@delete',
                'as' => 'song.delete',
                'role' => 'dj'
            ]);
            Route::put('/{song_id}', [
                'uses' => 'SongsController@update',
                'as' => 'song.update',
                'role' => 'dj'
            ]);
        });
    });

    /*
     *      Parties --- Started/Not finished
     */

    Route::group(['prefix' => 'parties'], function () {
        Route::group(['middleware' => 'roles'], function () {
            Route::get('/', [
                'uses' => 'PartyController@getUserData',
                'as' => 'get.party.user',
                'role' => 'party'
            ]);
            Route::post('/', [
                'uses' => 'PartyController@store',
                'as' => 'party.store',
                'role' => 'party'
            ]);
        });
    });
});
