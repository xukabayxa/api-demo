<?php

use Illuminate\Http\Request;
use App\Http\Middleware\ActivationStudent;
use Illuminate\Support\Facades\Route;
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
/** auth students */
Route::group(['prefix' => 'auth/students', 'namespace' => 'Student'], function () {
    Route::post('login', 'AuthStudentController@login');
    Route::post('register', 'AuthStudentController@register');
});

Route::group(['middleware' => ['auth:admin']], function () {
    Route::group(['prefix' => 'customers'], function () {
        Route::get('', 'CustomersController@index')->middleware('permission:customers.browse');
        Route::get('{id}', 'CustomersController@show')->middleware('permission:customers.browse');
        Route::post('', 'CustomersController@store')->middleware('permission:customers.create');
        Route::put('{id}', 'CustomersController@update')->middleware('permission:customers.update');
    });
});

Route::group(['middleware' => ['auth:student', ActivationStudent::class], 'namespace' => 'Student'], function () {
    Route::group(['prefix' => 'students'], function () {
        Route::get('me', 'StudentsController@me');
        Route::put('change-password', 'StudentsController@updatePassword');
    });
});



