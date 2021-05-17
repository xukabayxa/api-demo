<?php

use Illuminate\Http\Request;
use App\Http\Middleware\ActivationStudent;

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
    Route::group(['prefix' => 'motels'], function () {
        Route::get('', 'MotelsController@index');
        Route::get('{id}', 'MotelsController@show');
    });
});

Route::group(['middleware' => ['auth:student', ActivationStudent::class], 'namespace' => 'Student', 'prefix' => 'student'], function () {

    Route::group(['prefix' => 'motels'], function () {
        Route::get('', 'MotelsController@index');
        Route::get('{id}', 'MotelsController@show');
        Route::post('', 'MotelsController@store');
        Route::put('{id}', 'MotelsController@update');
        Route::put('{id}/update-status', 'MotelsController@updateStatus');
        Route::delete('{id}', 'MotelsController@destroy');

        Route::post('{id}/comment', 'MotelCommentController@store');
        Route::put('{id}/comment/{commentId}', 'MotelCommentController@update');
        Route::delete('{id}/comment/{commentId}', 'MotelCommentController@destroy');

        Route::post('{id}/comment/{commentId}/feedback', 'MotelCommentController@feedbackComment');

    });

});

Route::group(['namespace' => 'Guest', 'prefix' => 'guest'], function () {
    Route::group(['prefix' => 'motels'], function () {
        Route::get('', 'MotelsController@index');
        Route::get('{id}', 'MotelsController@show');
    });
});

Route::get('/motel/status', function (){
    $statuses = \Modules\Motels\Entities\MotelStatus::query()->get();

    return response()->json([
        'data' => $statuses
    ],200);
});

Route::get('/motel/intent', function (){
    $intents = \Modules\Motels\Entities\MotelIntent::query()->get();

    return response()->json([
        'data' => $intents
    ],200);
});
