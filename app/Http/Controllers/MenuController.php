<?php

namespace App\Http\Controllers;

use App\Repositories\MenuRepository;
use Symfony\Component\HttpFoundation\Request;


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

    public function getSidebar(){
        $data = $this->menuRepository->getNivel1Sidebar();
        foreach ($data as $key => $datum) {
            $data[$key]->nivel2 = $this->menuRepository->getNivel2($datum->idCategoriasNivel1);
        }
        return $data;
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
                $dataFormato[$key]['image'] = 'assets/images/brands/'.strtolower($item->name).'.jpg';
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

    /*INICIA SECCIÓN DE BREADCRUMB*/
    public function getBreadcrumb(Request $request){
        $component = $request->get('component');
        $params = json_decode($request->get('params'));
        $previousUrl = urldecode($request->get('previousUrl'));
        $breadcrumbs = array();
        if(isset($params->product)){
            $breadcrumbs = $this->setBreadcrumbProduct($params->product, $previousUrl);
        }else{
            $breadcrumbs = $this->setBreadcrumbSection($params);
        }
        return json_encode($breadcrumbs);
    }

    public function setBreadcrumbSection($params){
        $breadcrumbs = array();
        if(isset($params->search)){
            $level1 = "Busqueda";
            $level2 = $params->search;
            array_push($breadcrumbs, [
                'name'=> $level1,
                'url' => '#!',
                'level1' => '',
                'level2' => ''
            ]);
            array_push($breadcrumbs, [
                'name'=> $level2,
                'url' => '#!',
                'level1' => '',
                'level2' => ''
            ]);
        } else {
            $breadcrumbs = $this->comesFromOferta($params);
        }
        return $breadcrumbs;
    }

    public function comesFromOferta($params){
        $breadcrumbs = array();
        if (!isset($params->nivel1) && !isset($params->nivel2)) {
            $level1 = 'Ofertas';
            array_push($breadcrumbs, [
                'name'=> $level1,
                'url' => '#!',
                'level1' => '',
                'level2' => ''
            ]);
        } else {
            $level1 = $params->nivel1;
            $level2 = $params->nivel2;
            $level1 = str_replace("-", " ", $level1);
            $level2 = str_replace("-", " ", $level2);
            array_push($breadcrumbs, [
                'name'=> $level1,
                'url' => '#!',
                'level1' => '',
                'level2' => ''
            ]);
            array_push($breadcrumbs, [
                'name'=> $level2,
                'url' => '#!',
                'level1' => '',
                'level2' => ''
            ]);
        }
        return $breadcrumbs;
    }

    public function setBreadcrumbProduct($product, $previousUrl){
        $product = str_replace("-", " ", $product);
        $product = str_replace("_", "-", $product);
        $breadcrumbs = array();
        if($previousUrl == ""){
            $breadcrumbs = $this->productWithoutPreviusUrl($product);
        }else{
            $breadcrumbs = $this->productWithPreviousUrl($product, $previousUrl);
        }
        return $breadcrumbs;
    }

    public function productWithPreviousUrl($product, $previousUrl){
        $previusTemp = explode("/", $previousUrl);
        $level1 = str_replace("-", " ", $previusTemp[count($previusTemp) -2]);
        $level2 = str_replace("-", " ", $previusTemp[count($previusTemp) -1]);
        $breadcrumbs = array();
        if ( strtolower($level2) == 'ofertas') {
            array_push($breadcrumbs, [
                'name'=> $level2,
                'url' => '#!',
                'level1' => '',
                'level2' => ''
            ]);
            array_push($breadcrumbs, [
                'name'=> $product,
                'url' => '#!',
                'level1' => '',
                'level2' => ''
            ]);
        }else{
            array_push($breadcrumbs, [
                'name' => $level1,
                'url' => '#!',
                'level1' => '',
                'level2' => ''
            ]);
            array_push($breadcrumbs, [
                'name' => $level2,
                'url' => '/',
                'level1' => $previusTemp[count($previusTemp) -2],
                'level2' => $previusTemp[count($previusTemp) -1]
            ]);
            array_push($breadcrumbs, [
                'name'=> $product,
                'url' => '#!',
                'level1' => '',
                'level2' => ''
            ]);
        }
        return $breadcrumbs;
    }

    public function productWithoutPreviusUrl($product){
        $productController = new ProductController();
        $productType = explode(" ", $product)[0];
        $level = $productController->getProductlevels($productType);
        $breadcrumbs = array();
        array_push($breadcrumbs, [
            'name'=> 'Equipos',
            'url' => '#!',
            'level1' => '',
            'level2' => ''
        ]);
        array_push($breadcrumbs, [
            'name'=> $level->name,
            'url' => '/',
            'level1' => $level->level1,
            'level2' => $level->name
        ]);
        array_push($breadcrumbs, [
            'name'=> $product,
            'url' => '#!',
            'level1' => '',
            'level2' => ''
        ]);
        return $breadcrumbs;
    }
    /*TERMINA SECCIÓN DE BREADCRUMB*/

    //Vistas
    public static function getMenuNavbarView(){
        $unwanted_array = array('Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
            'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
            'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y');

        $menuRepository = new MenuRepository();
        $menuNavbar = array();
        $categoriasNivel1 = $menuRepository->getNivel1();
        foreach ($categoriasNivel1 as $key => $categoria1) {
            $menuNavbar[$key]['nivel1'] = $categoria1->nombreCategoriaNivel1;
            $categoriasNivel2 = $menuRepository->getNivel2($categoria1->idCategoriasNivel1);
            foreach ($categoriasNivel2 as $key2 => $categoria2){
                $menuNavbar[$key]['nivel2'][$key2]['name'] = $categoria2->name;
                $niv1 = str_replace(' ','-', $categoria1->nombreCategoriaNivel1);
                $niv2 = str_replace(' ','-',$categoria2->name);
                $href = strtr($niv1.'/'.$niv2, $unwanted_array);
                $menuNavbar[$key]['nivel2'][$key2]['href'] = strtolower($href);
            }
        }
        return $menuNavbar;
    }
}
