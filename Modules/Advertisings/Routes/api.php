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
    Route::group(['prefix' => 'advertising-category'], function () {
        Route::post('', 'AdvertisingCategoryController@store');
    });
});

Route::group(['middleware' => ['auth:student', \App\Http\Middleware\ActivationStudent::class], 'namespace' => 'Student', 'prefix' => 'student'], function () {
    Route::group(['prefix' => 'advertising-category'], function () {
        Route::get('', 'AdvertisingCategoryController@index');
    });

    Route::group(['prefix' => 'advertisings'], function () {

        Route::get('', 'AdvertisingsController@index');
        Route::get('{id}', 'AdvertisingsController@show');
        Route::put('{id}', 'AdvertisingsController@update');
        Route::post('', 'AdvertisingsController@store');
        Route::post('{id}/update-status', 'AdvertisingsController@updateStatus');

        Route::post('{id}/comment', 'AdvertisingCommentController@store');
        Route::put('{id}/comment/{commentId}', 'AdvertisingCommentController@update');
        Route::delete('{id}/comment/{commentId}', 'AdvertisingCommentController@destroy');
        Route::post('{id}/comment/{commentId}/feedback', 'AdvertisingCommentController@feedbackComment');

    });
});

Route::group(['namespace' => 'Guest', 'prefix' => 'guest'], function () {
    Route::group(['prefix' => 'advertising-category'], function () {
        Route::get('', 'AdvertisingCategoryController@index');
    });

    Route::group(['prefix' => 'advertisings'], function () {
        Route::get('latest', 'AdvertisingsController@getAdvertisingLatest');

        Route::get('', 'AdvertisingsController@index');

        Route::get('{id}', 'AdvertisingsController@show');
    });

});
