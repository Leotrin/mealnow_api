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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/V1/getRestaurants', 'ApiV1\ShopController@index');
Route::post('/V1/getUsers', 'ApiV1\UserCallController@index');
Route::post('/V1/deactivateUser', 'ApiV1\UserCallController@deactivateUser');
Route::post('/V1/activeUsers', 'ApiV1\UserCallController@activeUsers');
Route::post('/V1/inactiveUsers', 'ApiV1\UserCallController@inactiveUsers');
Route::post('/V1/deleteUser', 'ApiV1\UserCallController@deleteUser');
Route::post('/V1/insertUser', 'ApiV1\UserCallController@insertUser');
Route::post('/V1/updatePassword', 'ApiV1\UserCallController@updatePassword');
Route::post('/V1/searchRestaurants','ApiV1\ShopController@searchRestaurants');
Route::post('/V1/singleRestaurant','ApiV1\ShopController@singleRestaurant');
Route::post('/V1/checkProduct','ApiV1\ShopController@checkProduct');
Route::post('/V1/setAddress', 'ApiV1\UserCallController@setAddress');
Route::post('/V1/test', 'ApiV1\ShopController@test');
Route::post('/V1/multipleProdCheck','ApiV1\ShopController@multipleProdCheck');
Route::post('/V1/payment','ApiV1\CheckoutController@payment');
Route::post('/V1/delete','ApiV1\UserCallController@deleteAccount');


Route::group([
    'prefix' => 'V1/auth'
], function () {
    Route::post('login', 'ApiV1\AuthController@login');
    Route::post('signup', 'ApiV1\AuthController@signup');
    Route::post('verifyCode', 'ApiV1\AuthController@verifyCode');
    Route::post('reSendCode', 'ApiV1\AuthController@reSendCode');

  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::get('userWithOrders', 'AuthController@getUserWithOrders');

    });
});