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
    Route::group(['prefix' => 'comments'], function () {
        Route::get('', 'CommentsController@index')->middleware('permission:comments.browse');
        Route::get('{id}', 'CommentsController@show')->middleware('permission:comments.browse');
        Route::post('', 'CommentsController@store')->middleware('permission:comments.create');
        Route::put('{id}', 'CommentsController@update')->middleware('permission:comments.update');
    });

});

