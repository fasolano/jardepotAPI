<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller{

    private $productoRepository;

    public function __construct(){
        $this->productoRepository = new ProductRepository();
    }

    /*
     * Trataré de explicar lo mejor que pueda pero si se tiene que que hacer una modificación
     * no me hago responsable por lo mal que pueda estar :'v
     *
     */
    public function getProducts(Request $request){
        /*
         * Se optienen las categorias que se van mostrar
         */
        $nivel1 = $request->get('nivel1');
        $nivel2 = $request->get('nivel2');
        $idNivel2 = $this->productoRepository->getIdNivel2($nivel1, $nivel2);
        $response = array();
        $iterator = 0;


        /*
         * Existen los filtrados por marca
         */
        $brandFilters = explode(",", $request->get('brands'));
        $characteristicsFilters = json_decode($request->get('characteristics'), true);
        $characteristicsFilters = is_array($characteristicsFilters)? $characteristicsFilters: array();

        $stringFiltros = "";
        $filtrosValores = "";
        $filtrosOrdenados = array();

        //revisa sienen vacios los filtros
        if($brandFilters[0] == "" && count($characteristicsFilters) == 0){
            $productosCategoria = $this->productoRepository->getProducts($idNivel2);
        }else{
            if ($brandFilters[0] != ""){
                // si el nivel que se buscan son marcas la busqueda se hace por tipo de producto en vez de marca
                $stringFiltros .= $nivel1 == "Marcas"? " productos.productType in ( ":" productos.brand in (";
                foreach ($brandFilters as $key => $item) {
                    // Si son marcas a los tipo de productos se les debe de cambiar la cadena para poder encontrarlos en las consultas
                    if($nivel1 == "Marcas"){
                        if (substr($item, strlen($item)- 2, strlen($item)- 1) == 'as' || substr($item, strlen($item)- 2, strlen($item)- 1) == 'os'){
                            $item = substr($item , 0,strlen($item)- 1);
                        }else if(substr($item, strlen($item)- 2, strlen($item)- 1) == 'es' ){
                            $item = substr($item , 0,strlen($item)- 2);
                        }
                    }

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
                    $filtrosOrdenados[$item['id']] = $item;


                    if ($key == 0){
                        $filtrosValores .= " ( pc.fk_caracteristica = ".$item['id']. " AND ";
                        $stringFiltros .= $item['id'];
                    }else{
                        $filtrosValores .= " OR ( pc.fk_caracteristica = ".$item['id']. " AND ";
                        $stringFiltros .= ", ".$item['id'];
                    }

                    switch ($item['type']){
                        case 1:
                            $filtrosValores .= "pc.valor_opcion = ".$item['value'].")";
                            break;

                        case 2:
                            $filtrosValores .= "pc.valor_numero <= ".$item['value'].")";
                            break;

                        case 3:
                            $filtrosValores .= "pc.valor_binario = ".$item['value'].")";
                            break;
                    }

                }
                $stringFiltros .= ") ";

            }
            $productosCategoria = $this->productoRepository->getProductsFilters($idNivel2, $stringFiltros, count($characteristicsFilters));
        }
        foreach ($productosCategoria as $keyProducto => $item) {

            $queryProducto = false;
            if ( count($characteristicsFilters) > 0){
                $queryProducto = $this->productoRepository->getProductFiltered($item->productType . " " . $item->brand . " " . $item->mpn,
                    $filtrosValores, count($characteristicsFilters));
            }
            //Si hay filtros aplicados va a verificar
            if(count($characteristicsFilters) > 0 ){
                // Se verifica si se encontró con los filtros aplicado sino, no se agrega a los productos a mostrar
                if($queryProducto){
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
                    $response[$iterator]['availibilityCount'] = 20;
                    $response[$iterator]['cartCount'] = 0;
                    $response[$iterator]['brand'] = $item->brand;
                    $response[$iterator]['mpn'] = $item->mpn;
                    $response[$iterator]['productType'] = $item->productType;
                    $response[$iterator]['metaDescription'] = $item->metadesc;
                    $iterator++;
                }
            }else{
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
                $response[$iterator]['availibilityCount'] = 20;
                $response[$iterator]['cartCount'] = 0;
                $response[$iterator]['brand'] = $item->brand;
                $response[$iterator]['mpn'] = $item->mpn;
                $response[$iterator]['productType'] = $item->productType;
                $response[$iterator]['metaDescription'] = $item->metadesc;
                $iterator++;
            }
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
        $response = $this->model_format_products($data)[0];

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

        $response = $this->model_format_products($data);

        return json_encode($response);
    }

    public function getProductlevels(Request $request){
        $productType = $request->get('productType');
        $levels = $this->productoRepository->getProductlevels($productType);
        return json_encode($levels);
    }

    public function model_format_products($products){
        $iterator = 0;
        $response = array();
        foreach ($products as $item) {
            $img = strtolower($item->productType . "-" . $item->brand . "-" . $item->mpn);
            $response[$iterator]['id'] = $item->id;
            $response[$iterator]['name'] = $item->productType . " " . $item->brand . " " . $item->mpn;
            $response[$iterator]['images'][0]['small'] = 'assets/images/images/' . $img . '.jpg';
            $response[$iterator]['images'][0]['medium'] = 'assets/images/images/' . $img . '.jpg';
            $response[$iterator]['images'][0]['big'] = 'assets/images/images/' . $img . '.jpg';
            if ($item->PrecioDeLista == $item->priceweb ) {
                $response[$iterator]['newPrice'] = $item->priceweb;

            } else {
                $response[$iterator]['oldPrice'] = $item->PrecioDeLista;
                $response[$iterator]['newPrice'] = $item->priceweb;
            }
            if (isset($item->offer) && $item->offer == 'si') {
                $response[$iterator]['oldPrice'] = $item->PrecioDeLista;
                $response[$iterator]['discount'] = "OFERTA";
                $response[$iterator]['newPrice'] = $item->oferta;
            } else {
                $response[$iterator]['newPrice'] = $item->priceweb;
            }
            $response[$iterator]['description'] = $item->description;
            $response[$iterator]['dataSheet'] = $item->resenia;
            $response[$iterator]['availibilityCount'] = 20;
            if(isset($item->cantidad)){
                $response[$iterator]['cartCount'] = $item->cantidad;
            }else{
                $response[$iterator]['cartCount'] = 0;
            }
            $response[$iterator]['brand'] = $item->brand;
            $response[$iterator]['mpn'] = $item->mpn;
            $response[$iterator]['productType'] = $item->productType;
            $response[$iterator]['metaDescription'] = $item->metadesc;
            $iterator++;
        }
        return $response;

    }

}
