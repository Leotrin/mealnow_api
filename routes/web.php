<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@frontend');
Auth::routes();
Route::get('/home', 'HomeController@home');
Route::get('/about', 'HomeController@about');
Route::get('/contact', 'HomeController@contact');
//Route::get('/JoinNow', 'HomeController@joinNow');
Route::get('/session', 'OrderController@clear_session');
Route::get('/not-allowed', 'HomeController@notAllowed');
Route::post('/not-allowed', 'HomeController@notAllowed');
Route::get('logout', 'Auth\LoginController@logout');

// FrontEnd Routes
Route::group(['prefix'=>'frontend'], function(){
    Route::get('/', 'HomeController@frontend');
    Route::post('/', 'HomeController@frontend');
    Route::get('/shops', 'ShopController@shops');
    Route::post('/shops', 'ShopController@shops');
    Route::get('/shop/{id}', 'ShopController@shop');

    //Cart Management products
    Route::get('/{id}/addToCart', 'OrderController@addToCart');
    Route::post('/shop/{id}/addToCart', 'OrderController@addToCart');
    Route::post('/shop/{id}/changeservice/{service}', 'OrderController@changeService');
    Route::post('/shop/{id}/changetime/{time}', 'OrderController@changeTime');
    Route::post('/shop/{id}/delete/{key}', 'OrderController@deleteProduct');
    Route::post('/shop/{id}/scheduleOrder', 'OrderController@scheduleOrder');
    Route::post('/shop/{id}/changeAddress', 'OrderController@changeAddress');
    Route::post('/shop/{id}/checkout', 'OrderController@cart');

    Route::post('/shop/{id}/cupon', 'CuponController@enter_cupon');

    Route::match(['get','post'],'/shop/{id}/checkout/register', 'CheckoutController@register');
    Route::match(['get','post'],'/shop/{id}/checkout/payment', 'CheckoutController@payment');
    Route::get('/payment/processed', 'CheckoutController@processed');

});

Route::group(['prefix'=>'shop'], function() {
    Route::middleware('auth')->group(function () {
        Route::match(['get'],'/','Shop\ShopController@index');
        Route::match(['get'],'/order/{id}','Shop\ShopController@order');
        Route::match(['post'],'/order/confirmation/{id}','Shop\ShopController@confirmation');
        Route::match(['post'],'/order/reject/{id}','Shop\ShopController@reject');
        Route::match(['post'],'/order/complete/{id}','Shop\ShopController@complete');
        Route::match(['get'],'/completed_orders','Shop\ShopController@completed');
        Route::match(['post'],'/order/adjust/{id}','Shop\ShopController@adjust');

    });
});
Route::group(['prefix'=>'customer'], function() {
    Route::middleware('auth')->group(function () {
        Route::match(['get'],'/','Customer\CustomerController@index');
        Route::match(['get'],'/previous_orders','Customer\CustomerController@previous');
        Route::match(['get'],'/order/{id}','Customer\CustomerController@order');
        Route::match(['post'],'/order/complete/{id}','Customer\CustomerController@complete');
        Route::match(['post'],'/order/reject/{id}','Customer\CustomerController@reject');
        Route::get('/order/complete/{id}','Customer\CustomerController@complete');
        Route::match(['post'],'/order/adjust/{id}','AdjustmentsController@adjustment');
    });
});

Route::group(['prefix'=>'admin'], function(){
    Route::middleware('auth')->group(function () {
        Route::get('/', 'Admin\AdminController@index')->name('admin');
        //SUPPORT TICKETS
        Route::match(['get','post'],'/support', 'SupportTicketsController@tickets');
        Route::get('/support/view/{id}', 'SupportTicketsController@view_ticket');
        Route::post('/support/replay/{id}', 'SupportTicketsController@replay_ticket');
        Route::post('/support/topic', 'SupportTicketsController@add_topic');
        Route::get('/support/delete/topic/{id}', 'SupportTicketsController@delete_topic');
        Route::get('/support/ticket/{id}/complete', 'SupportTicketsController@complete');

        Route::middleware('permission:CuponManagement')->group(function () {
            Route::match(['get', 'post'], '/cupons', 'Admin\CuponController@cupons');
            Route::match(['get'], '/cupons/delete/{id}', 'Admin\CuponController@delete_cupons');
        });

        Route::middleware('permission:ShopManagement')->group(function () {
            Route::get('/shops', 'Admin\ShopController@new_list');
            Route::post('/shops/add', 'Admin\ShopController@new_list');
            Route::match(['get','post'],'/shops/edit/{id}', 'Admin\ShopController@edit_shop');

            Route::get('/shop/{id}/menu/create', 'Admin\ShopController@shop_menu');
            Route::post('/shop/{id}/menu/clone', 'Admin\ShopController@shop_menu_clone');
            Route::post('/shop/{id}/menu/create/save', 'Admin\ShopController@shop_menu_save');
            Route::match(['get','post'],'/shop/{id}/availability', 'Admin\ShopController@availability');

            Route::match(['get','post'],'/shop/{id}/contact_methods', 'Admin\ShopController@contact_methods');
            Route::match(['get','post'],'/shop/{id}/contact_methods/edit/{cm_id}', 'Admin\ShopController@contact_methods_edit');
            Route::match(['get'],'/shop/{id}/contact_methods/delete/{cm_id}', 'Admin\ShopController@contact_methods_delete');


            Route::match(['get','post'],'/shop/{id}/additional_information', 'Admin\AdditionalInfoController@moreInfo');
        });

        Route::middleware('permission:OrderManagement')->group(function () {
            Route::get('/orders', 'Admin\OrderController@orders');
            Route::get('/order/view/{id}', 'Admin\OrderController@order');
            Route::get('/order/call/{id}', 'Admin\OrderController@call');
            Route::post('/order/reject/{id}', 'Admin\OrderController@reject');
            Route::post('/orders/phone_confirmation/{id}', 'Admin\OrderController@phone_confirmation');
            //Route::post('/order/shop_confirmation/{id}', 'Admin\OrderController@shop_confirmation');
            Route::get('/order/release/{id}', 'Admin\OrderController@release');
            Route::post('/order/complete/{id}', 'Admin\OrderController@complete');
        });

        Route::middleware('permission:UserManagement')->group(function () {
            Route::get('/users', 'Admin\AdminController@users');
            Route::post('/users/add', 'Admin\AdminController@users');

            Route::post('/user/{id}/change_password', 'Admin\AdminController@change_password');

            Route::get('/users/edit/{id}', 'Admin\AdminController@edit_users');
            Route::get('/users/delete/{id}', 'Admin\AdminController@delete_users');
            Route::get('/users/activate/{id}', 'Admin\AdminController@activate_users');
            Route::post('/users/edit/{id}', 'Admin\AdminController@edit_users');

            Route::get('/user/groups', 'Admin\AdminController@group');
            Route::post('/user/groups', 'Admin\AdminController@group');
            Route::get('/user/groups/edit/{id}', 'Admin\AdminController@edit_group');
            Route::post('/user/groups/edit/{id}', 'Admin\AdminController@edit_group');

            Route::get('/user/groups/delete/{id}', 'Admin\AdminController@delete_group');

            Route::get('/user/group/{id}', 'Admin\AdminController@group_permission');
            Route::post('/user/group/{id}', 'Admin\AdminController@group_permission')->name('update_group_permission');

            Route::get('/user/groups/function', 'Admin\AdminController@group_function');
            Route::post('/user/groups/function', 'Admin\AdminController@group_function');
            Route::get('/user/groups/function/{id}/delete', 'Admin\AdminController@group_function_delete');

            Route::match(['get','post'],'/user/assign', 'Admin\AdminController@assign_permissions');
            Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
        });
    });
});
