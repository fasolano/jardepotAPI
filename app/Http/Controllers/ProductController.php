<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller{

    private $productoRepository;

    public function __construct(){
        $this->productoRepository = new ProductRepository();
    }

    public function getProducts(Request $request){
        $nivel1 = $request->get('nivel1');
        $nivel2 = $request->get('nivel2');
        $idNivel2 = $this->productoRepository->getIdNivel2($nivel1, $nivel2);
        $secciones = $this->productoRepository->getCategoriasNivel3($idNivel2);
        $response = array();
        $iterator = 0;
        $brandFilters = explode(",", $request->get('brands'));
        $characteristicsFilters = json_decode($request->get('characteristics'), true);
        $characteristicsFilters = is_array($characteristicsFilters)? $characteristicsFilters: array();

        $stringFiltros = "";
        $stringFiltros1 = "";

        //revisa sienen vacios los filtros
        if($brandFilters[0] == "" && count($characteristicsFilters) == 0){
            $productosCategoria = $this->productoRepository->getProducts($idNivel2);
        }else{
            if ($brandFilters[0] != ""){
                $stringFiltros .= " productos.brand in (";
                foreach ($brandFilters as $key => $item) {
                    if ($key == 0){
                        $stringFiltros .= "'$item'";
                    }else{
                        $stringFiltros .= ", '$item'";
                    }
                }
                $stringFiltros .= ") ";
                $stringFiltros .= count($characteristicsFilters) > 0?"AND ":"";
            }
            if (count($characteristicsFilters) > 0){
                $stringFiltros .= " pc.fk_caracteristica in (";
                foreach ($characteristicsFilters as $key => $item) {


                    if ($key == 0){
                        $stringFiltros .= $item['id'];
                    }else{
                        $stringFiltros .= ", ".$item['id'];
                    }

                    /*if ($key != 0){
                        $stringFiltros1 .= " OR ";
                    }

                    $stringFiltros1 .= " (pc.fk_caracteristica = ".$item['id']." AND ";


                    switch ($item['type']){
                        case 1:
                            $stringFiltros1 .= " opc.nombre = ".$item['value']." )";
                            break;
                        case 2:
                            $stringFiltros1 .= " pc.valor_numero <= ".$item['value']." )";
                            break;
                        case 3:
                            $stringFiltros1 .= "pc.valor_binario = 1 )";
                            break;
                    }*/
                }
                $stringFiltros .= ") ";

            }
            $productosCategoria = $this->productoRepository->getProductsFilters($idNivel2, $stringFiltros.$stringFiltros1, count($characteristicsFilters));
        }

        foreach ($productosCategoria as $keyProducto => $item) {
            $img = strtolower($item->productType . "-" . $item->brand . "-" . $item->mpn);
            $response[$iterator]['id'] = $item->id;
            $response[$iterator]['name'] = $item->productType . " " . $item->brand . " " . $item->mpn;
            $response[$iterator]['images'][0]['small'] = 'assets/images/images/' . $img . '.jpg';
            $response[$iterator]['images'][0]['medium'] = 'assets/images/images/' . $img . '.jpg';
            $response[$iterator]['images'][0]['big'] = 'assets/images/images/' . $img . '.jpg';
            if (isset($item->offer) && $item->offer == 'si') {
                $response[$iterator]['oldPrice'] = $item->priceweb;
                $response[$iterator]['discount'] = "OFERTA";
                $response[$iterator]['newPrice'] = $item->oferta;
            } else {
                $response[$iterator]['newPrice'] = $item->priceweb;
            }
            $response[$iterator]['newPrice'] = $item->priceweb;
            $response[$iterator]['description'] = $item->description;
            $response[$iterator]['dataSheet'] = $item->resenia;
            $response[$iterator]['availibilityCount'] = 5;
            $response[$iterator]['cartCount'] = 0;
            $response[$iterator]['brand'] = $item->brand;
            $response[$iterator]['mpn'] = $item->mpn;
            $response[$iterator]['productType'] = $item->productType;
            $response[$iterator]['metaDescription'] = $item->metadesc;
            $iterator++;
        }
        return json_encode($response);
    }

    public function getProduct(Request $request){
        $product = $request->get('product');
        $product = explode("-", $product);
        $productType = str_replace("_", " ", $product[0]);
        $brand = str_replace("_", " ", $product[1]);
        $mpn = str_replace("_", "-", $product[2]);

        $data = $this->productoRepository->getProduct($productType, $brand, $mpn);
        $response = array();
        foreach ($data as $key => $value) {
            $img = strtolower($value->productType . "-" . $value->brand . "-" . $value->mpn);
            $response['id'] = $value->id;
            $response['name'] = $value->productType . " " . $value->brand . " " . $value->mpn;
            $response['images'][0]['small'] = 'assets/images/images/' . $img . '.jpg';
            $response['images'][0]['medium'] = 'assets/images/images/' . $img . '.jpg';
            $response['images'][0]['big'] = 'assets/images/images/' . $img . '.jpg';
            if ($value->offer == "si") {
                $response['oldPrice'] = $value->priceweb;
                $response['discount'] = 15;
                $response['newPrice'] = $value->oferta;
            } else {
                $response['newPrice'] = $value->priceweb;
            }
            $response['newPrice'] = $value->priceweb;
            $response['description'] = $value->description;
            $response['dataSheet'] = $value->resenia;
            $response['availibilityCount'] = 5;
            $response['cartCount'] = 0;
            $response['brand'] = $value->brand;
            $response['mpn'] = $value->mpn;
            $response['productType'] = $value->productType;
            $response['metaDescription'] = $value->metadesc;
        }
        return json_encode($response);
    }

    public function getSections(Request $request){
        $nivel1 = $request->get('nivel1');
        $nivel2 = $request->get('nivel2');
        $idNivel2 = $this->productoRepository->getIdNivel2($nivel1, $nivel2);
        $secciones = $this->productoRepository->getCategoriasNivel3($idNivel2);
        $response = array();
        foreach ($secciones as $key => $seccion) {

            $response[$key]['name'] = $seccion->nombreCategoriaNivel3;
            $response[$key]['id'] = $seccion->idCategoriasNivel3;
        }

        return json_encode($response);

    }

    public function getFilters(Request $request){
        $productType = $request->get('productType');
        $caracteristicas = $this->productoRepository->getCaracteristicas($productType);
        $response = array();
        foreach ($caracteristicas as $key => $caracteristica) {
            $id = $caracteristica->id_caracterisca;
            $response[$key]['measure'] = $caracteristica->medida;
            $response[$key]['name'] = $caracteristica->nombre;
            $response[$key]['characteristic'] = $id;
            $response[$key]['type'] = $caracteristica->tipo;
            switch ($caracteristica->tipo){
                case 1:
                    $response[$key]['values'] = $this->productoRepository->getProductosCaracteristicaOpciones($caracteristica->id_caracterisca);
                    break;

                case 2:
                    $response[$key]['valueMax'] = $this->productoRepository->getProductosCaracteristicaValorMax($id);
                    $response[$key]['valueMin'] = $this->productoRepository->getProductosCaracteristicaValorMin($id);
                    break;

                case 3:
                    break;
            }
        }

        return json_encode($response);

    }

    public function getProductsRelated(Request $request){
        $product = $request->get('product');
        $product = explode("-", $product);
        $productType = str_replace("_", " ", $product[0]);
        $brand = str_replace("_", " ", $product[1]);
        $mpn = str_replace("_", "-", $product[2]);

        $data = $this->productoRepository->getProductsRelated($productType, $brand, $mpn);
        $response = array();
        $iterator = 0;

        foreach ($data as $keyProducto => $item) {
            $img = strtolower($item->productType . "-" . $item->brand . "-" . $item->mpn);
            $response[$iterator]['id'] = $item->id;
            $response[$iterator]['name'] = $item->productType . " " . $item->brand . " " . $item->mpn;
            $response[$iterator]['images'][0]['small'] = 'assets/images/images/' . $img . '.jpg';
            $response[$iterator]['images'][0]['medium'] = 'assets/images/images/' . $img . '.jpg';
            $response[$iterator]['images'][0]['big'] = 'assets/images/images/' . $img . '.jpg';
            if (isset($value->offer)) {
                $response[$iterator]['oldPrice'] = $item->priceweb;
                $response[$iterator]['discount'] = 15;
                $response[$iterator]['newPrice'] = $item->oferta;
            } else {
                $response[$iterator]['newPrice'] = $item->priceweb;
            }
            $response[$iterator]['newPrice'] = $item->priceweb;
            $response[$iterator]['description'] = $item->description;
            $response[$iterator]['dataSheet'] = $item->resenia;
            $response[$iterator]['availibilityCount'] = 5;
            $response[$iterator]['cartCount'] = 0;
            $response[$iterator]['brand'] = $item->brand;
            $response[$iterator]['mpn'] = $item->mpn;
            $response[$iterator]['productType'] = $item->productType;
            $response[$iterator]['metaDescription'] = $item->metadesc;
            $iterator++;
        }

        return json_encode($response);
    }

}
