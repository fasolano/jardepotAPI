<?php


namespace App\Http\Controllers\views;


use App\Http\Controllers\Controller;

class ProductController extends Controller {

    public function product(){
        $menu = new MenuController();
        $sidebar = $menu->getSidebar();
        return view('pages/product',compact('sidebar'));
    }
}
