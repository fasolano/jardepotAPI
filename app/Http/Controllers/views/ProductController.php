<?php


namespace App\Http\Controllers\views;


class ProductController {

    public function productList(){

        return view('pages/products');
    }

    public function product(){
        return view('pages/product');
    }
}
