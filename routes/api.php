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



Route::get('products', 'ProductController@getProducts');
Route::get('products/sections', 'ProductController@getSections');
Route::get('products/filters', 'ProductController@getFilters');
Route::get('product', 'ProductController@getProduct');
Route::get('product/levels', 'ProductController@getProductlevels');
Route::get('products/related', 'ProductController@getProductsRelated');
Route::get('products/search', 'ProductController@getProductsSearch');

Route::get('menu/navbar', 'MenuController@getMenuNavbar');
Route::get('menu/additional', 'MenuController@getAdditional');
Route::get('menu/additional/options', 'MenuController@getOptionsAdditional');
Route::get('menu/brands', 'MenuController@getBrands');
Route::get('menu/productsTypes', 'MenuController@getProductTypes');


Route::get('cart/productos', 'CartController@getCartProducts');
Route::get('session', 'ApiTokenController@getSession');

Route::post('cart/addProduct', 'CartController@addProduct');
Route::get('cart/products', 'CartController@getCartProducts');
Route::delete('cart/removeProduct', 'CartController@removeProductCart');


Route::get('checkout', 'CheckoutController@index');
Route::get('checkout/createOrder', 'CheckoutController@createOrder');

