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

Route::get('/' , 'views\HomeController@index')->name('home');

Route::get('/ofertas/productos' , 'views\ProductsController@productsSaleList')->name('sales');

Route::get('/products/getProductsFiltered' , 'views\ProductsController@productsListFiltered');

Route::get('/products/getProductsOrdered' , 'views\ProductsController@productsSearchOrdered');

Route::get('/busqueda/{word}' , 'views\ProductsController@getProductsListSearch')->name('search');

Route::get('/c0nf1rm4c10n/paypal/{state}' , 'views\ConfirmController@confirmPaypal');

Route::get('/confirmacion/mercadopago/{state}' , 'views\ConfirmController@confirmMercadopago');

Route::get('/{categoryLevel1}/{categoryLevel2}' , 'views\ProductsController@productsList')->name('products');

Route::get('/catalogo/{marca}/{productType}-{brand}-{mpn}' , 'views\ProductController@product')->name('product');

Route::post('product/sendSearch', 'views\ProductController@sendSearch');

Route::post('products/searchFailed', 'views\ProductsController@sendSearchFailed');

Route::get('/cart', function () {
    return view('pages/cart');
});
Route::get('/cart/products/get', 'views\CartController@getCartProducts')->name('productsCart');
Route::post('cart/addProduct', 'views\CartController@addProduct');
Route::delete('cart/removeProduct', 'views\CartController@removeProductCart');

Route::get('/checkout', function () {
    return view('pages/checkout');
});
