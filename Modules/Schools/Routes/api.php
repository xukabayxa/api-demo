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
    Route::group(['prefix' => 'schools'], function () {
        Route::get('', 'SchoolsController@index')->middleware('permission:schools.browse');
        Route::get('{id}', 'SchoolsController@show')->middleware('permission:schools.browse');
        Route::post('', 'SchoolsController@store')->middleware('permission:schools.create');
        Route::put('{id}', 'SchoolsController@update')->middleware('permission:schools.update');
    });
});

