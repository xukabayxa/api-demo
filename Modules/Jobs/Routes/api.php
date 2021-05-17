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
Route::group(['middleware' => ['auth:admin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::group(['prefix' => 'job-category'], function () {
        Route::post('', 'JobCategoryController@store');
    });
});

Route::group(['middleware' => ['auth:student', \App\Http\Middleware\ActivationStudent::class], 'namespace' => 'Student', 'prefix' => 'student'], function () {
    Route::group(['prefix' => 'job-category'], function () {
        Route::get('', 'JobCategoryController@index');
    });

    Route::group(['prefix' => 'jobs'], function () {

        Route::get('', 'JobsController@index');
        Route::get('{id}', 'JobsController@show');
        Route::post('', 'JobsController@store');
        Route::put('{id}', 'JobsController@update');
        Route::delete('{id}', 'JobsController@destroy');
        Route::post('{id}/update-status', 'JobsController@updateStatus');

        Route::post('{id}/comment', 'JobCommentController@store');
        Route::put('{id}/comment/{commentId}', 'JobCommentController@update');
        Route::delete('{id}/comment/{commentId}', 'JobCommentController@destroy');
        Route::post('{id}/comment/{commentId}/feedback', 'JobCommentController@feedbackComment');

    });
});


