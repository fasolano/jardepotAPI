<?php

namespace App\Http\Controllers;

use App\Repositories\MenuRepository;
use Symfony\Component\HttpFoundation\Request;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

class MenuController extends Controller{

    private $menuRepository;


    public function __construct(){
        $this->menuRepository = new MenuRepository();
    }

    public function getMenuNavbar(){
        $menuNavbar = array();
        $categoriasNivel1 = $this->menuRepository->getNivel1();
        foreach ($categoriasNivel1 as $key => $categoria1) {
            $menuNavbar[$key]['nivel1'] = $categoria1->nombreCategoriaNivel1;
            $categoriasNivel2 = $this->menuRepository->getNivel2($categoria1->idCategoriasNivel1);
            foreach ($categoriasNivel2 as $key2 => $categoria2){
                $menuNavbar[$key]['nivel2'][$key2] = $categoria2->name;
            }

        }
        return json_encode($menuNavbar);
    }

    public function getProductTypes(Request $request){
        $idCategoria = $this->menuRepository->getIdProductTypes();
        if($idCategoria){
            $data  = $this->menuRepository->getNivel2($idCategoria->id);
        }else{
            $data = array();
        }

        return json_encode($data);

    }

    public function getBrands(Request $request){
        $idCategoria = $this->menuRepository->getIdBrands();
        if($idCategoria){
            $data  = $this->menuRepository->getNivel2($idCategoria->id);
            $dataFormato = array();
            foreach ($data as $key => $item) {
                $nombre = strtolower($item->name);
                $dataFormato[$key]['name'] = $item->name;
                $dataFormato[$key]['image'] = 'assets/images/brands/'.strtolower($item->name).'.png';
            }
        }else{
            $dataFormato = array();
        }
        return json_encode($dataFormato);

    }

    public function getAdditional(Request $request){
        $categorias = $this->menuRepository->getAdditional();
        $data = array();
        foreach ($categorias as $keyCategoria => $itemCategoria) {
            $data[$keyCategoria]['name'] = $itemCategoria->name;
            $opciones = $this->menuRepository->getNivel2($itemCategoria->id);

            $data[$keyCategoria]['options'] = $opciones;
        }
        return json_encode($data);
    }


}
