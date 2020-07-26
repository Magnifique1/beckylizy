<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/products/{cat_id}', 'CategoryProductsController@index')->name('category_products');//

Route::group([
    'namespace' => 'Auth',
    'as' => 'auth.',
], function () {
    Route::get('register', 'AuthController@showRegisterForm')->name('register');
    Route::post('register', 'AuthController@register')->name('register');
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
});
