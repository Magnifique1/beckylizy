<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/products/{cat_id}', 'CategoryProductsController@index')->name('category_products');//
Route::get('/myorders', 'OrderHistoryController@index')->name('order_history');//
Route::get('/contactus', 'ContactUsController@index')->name('contactus');

Route::group([
    'namespace' => 'Auth',
    'as' => 'auth.',
], function () {
    Route::get('register', 'AuthController@showRegisterForm')->name('register');
    Route::post('register', 'AuthController@register')->name('register');
    Route::get('login', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@login')->name('login');
});

//Cart routes group
Route::group([
    'prefix' => 'cart',
    'as' => 'cart.',
], function () {
    // View cart
    Route::get('/', 'CartController@index')->name('index');
    // Add to cart
    Route::post('/', 'CartController@store')->name('store');
    // Update cart
    Route::put('/', 'CartController@update')->name('update');
    // Remove product from the cart
    Route::get('/{id}', 'CartController@destroy')->name('remove');
    Route::post('/create-order', 'CartController@createOrder')->name('create-order')
        ->middleware('auth');
});
