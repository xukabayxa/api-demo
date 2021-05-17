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

Route::group(['middleware' => ['auth:admin']], function () {
    Route::group(['prefix' => 'friends'], function () {
        Route::get('', 'FriendsController@index')->middleware('permission:friends.browse');
        Route::get('{id}', 'FriendsController@show')->middleware('permission:friends.browse');
        Route::post('', 'FriendsController@store')->middleware('permission:friends.create');
        Route::put('{id}', 'FriendsController@update')->middleware('permission:friends.update');
    });
});

