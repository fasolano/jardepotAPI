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

Route::get('/', function () {
    return view('pages/home');
})->name('home');

Route::get('/products/getProductsFiltered' , 'views\ProductsController@productsListFiltered');

Route::get('/products/getProductsOrdered' , 'views\ProductsController@productsSearchOrdered');

Route::get('/busqueda/{word}' , 'views\ProductsController@getProductsListSearch')->name('search');

Route::get('/{categoryLevel1}/{categoryLevel2}' , 'views\ProductsController@productsList')->name('products');

Route::get('/catalogo/{marca}/{productType}-{brand}-{mpn}' , 'views\ProductController@product')->name('product');

Route::post('product/sendSearch', 'views\ProductController@sendSearch');
