<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Modules\Advertisings\Helpers\AdvertisingCategoryHelper;

Route::prefix('advertisings')->group(function() {
    Route::get('/', 'AdvertisingsController@index');
});
Route::get('test', function () {
//    $arr = [];
//    \Modules\Advertisings\Helpers\AdvertisingCategoryHelper::getChildrenCategory(9, $arr);


    $categoryIds = [1, 4];
    $cateIds = [];
    foreach ($categoryIds as $categoryId) {
        AdvertisingCategoryHelper::getChildrenCategory($categoryId, $cateIds);
    }
    dd(array_unique($cateIds));
});
