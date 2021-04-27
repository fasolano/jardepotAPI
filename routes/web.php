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
use App\Http\Middleware\urlVerify;

Route::get('/', 'views\HomeController@index')->name('home');

Route::get('/index.php', function(){
    return Redirect::to('/', 301);
});
Route::get('/cuenta/login', function (){
    return view('pages.login');
});
Route::get('/cuenta/registro', function (){
    return view('pages.registro');
});

Route::get('/business', function (){
    return view('pages.business.index');
});

Route::get('/business/login', function (){
    return view('pages.business.login');
});
Route::get('/business/registro', function (){
    return view('pages.business.registro');
});
Route::post('/business/registro', 'iews\BusinessController@registro');


Route::get('/prueba', 'views\HomeController@moveImages');

Route::get('/ofertas', 'views\ProductsController@productsSaleList')->name('sales')->middleware(urlVerify::class);

Route::get('/products/getProductsFiltered', 'views\ProductsController@productsListFiltered');

Route::get('/products/getProductsOrdered', 'views\ProductsController@productsSearchOrdered');

Route::get('/catalogo/refacciones/{productType}-{brand}-{mpn}', 'views\SpareController@index')->name('spare')->middleware(urlVerify::class);

Route::get('/catalogo/refacciones/marcadores', 'views\SpareController@getMarcadores');

Route::get('/busqueda/{word}', 'views\ProductsController@getProductsListSearch')->name('search');

Route::get('/c0nf1rm4c10n/p4yp4l/{state}', 'views\ConfirmController@confirmPaypal');

Route::get('/c0nf1rm4c10n/m3rc4d0p4g0/{state}', 'views\ConfirmController@confirmMercadopago');

Route::get('/{categoryLevel1}/{categoryLevel2}', 'views\ProductsController@productsList')->name('products')->middleware(urlVerify::class);

Route::get('/catalogo/{marca}/{productType}-{brand}-{mpn}' , 'views\ProductController@product')->name('product')->middleware(urlVerify::class);

Route::get('/{categoryLevel1}/{categoryLevel2}/{categoryLevel3}', 'views\ProductsController@productsListLevel3')->name('products2');

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
Route::get('tracking', function () {
    return view('pages/tracking');
});

Route::post('tracking/getGuia', 'views\TrackingController@getGuia')->name('getguia');

