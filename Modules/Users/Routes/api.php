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

Route::group(['prefix' => 'auth/users'], function (){
    Route::post('/login', 'AuthController@login');

});
Route::group(['middleware' => ['auth:admin']], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('', 'UsersController@index')->middleware('permission:users.browse');
        Route::get('{id}', 'UsersController@show')->middleware('permission:users.browse');
        Route::post('', 'UsersController@store')->middleware('permission:users.create');
        Route::put('{id}', 'UsersController@update')->middleware('permission:users.update');
    });
});

