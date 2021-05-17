<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

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
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization, X-API-KEY');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('unauthorized', function () {
    return response()->json(array_merge_recursive([
        'meta' => [
            'code' => 401,
            'message' => 'UNAUTHORIZED_REQUEST'
        ]
    ]))->setStatusCode(401);
})->name('unauthorized');

Route::post('get-client-intent', function (){
    $stripe = new Cartalyst\Stripe\Stripe(config('services.stripe.secret'));

    $paymentIntent = $stripe->paymentIntents()->create([
        'amount' => 2000,
        'currency' => 'usd',
        'payment_method_types' => [
            'card',
        ],
    ]);

    return response()->json([
        'client_secret' => $paymentIntent['client_secret']
    ]);
});
