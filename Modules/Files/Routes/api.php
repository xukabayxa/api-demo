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
    Route::group(['prefix' => 'files'], function () {
        Route::get('', 'FilesController@index')->middleware('permission:files.browse');
        Route::get('{id}', 'FilesController@show')->middleware('permission:files.browse');
        Route::post('', 'FilesController@store')->middleware('permission:files.create');
        Route::put('{id}', 'FilesController@update')->middleware('permission:files.update');
    });
});

