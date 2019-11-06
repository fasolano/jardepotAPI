<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{

    private $productoRepository;

    public function __construct(){
        $this->productoRepository = new ProductRepository();
    }

    public function getProducts(){
        $nivel1 = $_GET['nivel1'];
        $nivel2 = $_GET['nivel2'];
        $idNivel2 = $this->productoRepository->getIdNivel2($nivel1, $nivel2);
        $secciones = $this->productoRepository->getCategoriasNivel3($idNivel2);
        $response = array();
        $iterator = 0;

        foreach ($secciones as $key => $value) {

            $productosCategoria = $this->productoRepository->getProducts($value->idCategoriasNivel3);

            foreach ($productosCategoria as $keyProducto => $item) {
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
                $response[$iterator]['idSeccion'] = $value->idCategoriasNivel3;
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

    public function getSections(){
        $nivel1 = $_GET['nivel1'];
        $nivel2 = $_GET['nivel2'];
        $idNivel2 = $this->productoRepository->getIdNivel2($nivel1, $nivel2);
        $secciones = $this->productoRepository->getCategoriasNivel3($idNivel2);
        $response = array();
        foreach ($secciones as $key => $seccion) {

            $response[$key]['name'] = $seccion->nombreCategoriaNivel3;
            $response[$key]['id'] = $seccion->idCategoriasNivel3;
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
