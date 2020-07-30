<?php


namespace App\Http\Controllers\views;


use App\Http\Controllers\Controller;
use App\Http\Controllers\MenuController;

class ProductsController extends Controller {

    public function productList($categoryLevel1, $categoryLevel2){
        $menu = new MenuController();
        $sidebar = $menu->getSidebar();

        return view('pages/products', compact('sidebar'));
    }

}
