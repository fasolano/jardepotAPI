<?php


namespace App\Http\Controllers\views;


use App\Http\Controllers\MenuController;

class ProductController {

    public function productList($categoryLevel1, $categoryLevel2){
        $menu = new MenuController();
        $sidebar = $menu->getSidebar();

        return view('pages/products', compact('sidebar'));
    }

    public function product(){
        $menu = new MenuController();
        $sidebar = $menu->getSidebar();
        return view('pages/product',compact('sidebar'));
    }
}
