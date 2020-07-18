<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/products/{cat_id}', 'CategoryProductsController@index')->name('category_products');//

//Cart routes group

Route::group([
    'prefix' => 'cart',
    'as' => 'cart.',
], function(){
 // Add to cart
    Route::post('/', 'CartController@store')->name('store');
});
