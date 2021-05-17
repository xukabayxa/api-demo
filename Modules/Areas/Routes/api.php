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
    Route::group(['prefix' => 'areas'], function () {
        Route::get('', 'AreasController@index')->middleware('permission:areas.browse');
        Route::get('{id}', 'AreasController@show')->middleware('permission:areas.browse');
        Route::post('', 'AreasController@store')->middleware('permission:areas.create');
        Route::put('{id}', 'AreasController@update')->middleware('permission:areas.update');
    });
});

