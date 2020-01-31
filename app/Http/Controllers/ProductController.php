<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller{

    private $productoRepository;
    private $unwanted_array;
    //Todas las consultas tienen join con inventario, si se implementa openjardepot se deberan de quitar esos left join con  sus groupby
    public function __construct(){
        $this->productoRepository = new ProductRepository();
        $this-> unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

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
                $stringFiltros .= " c3.nombreCategoriaNivel3 in ( ";
                foreach ($brandFilters as $key => $item) {
                    // Si son marcas a los tipo de productos se les debe de cambiar la cadena para poder encontrarlos en las consultas
                    /*if($nivel1 == "Marcas"){
                        if (substr($item, strlen($item)- 2, strlen($item)- 1) == 'as' || substr($item, strlen($item)- 2, strlen($item)- 1) == 'os'){
                            $item = substr($item , 0,strlen($item)- 1);
                        }else if(substr($item, strlen($item)- 2, strlen($item)- 1) == 'es' ){
                            $item = substr($item , 0,strlen($item)- 2);
                        }
                    }*/

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
                    $response[$iterator]['images'][0]['small'] = 'assets/images/productos/' . $img . '.jpg';
                    $response[$iterator]['images'][0]['medium'] = 'assets/images/productos/' . $img . '.jpg';
                    $response[$iterator]['images'][0]['big'] = 'assets/images/productos/' . $img . '.jpg';
                    //empieza la seccion de precios
                    if (isset($item->offer) && $item->offer == 'si') {
                        $response[$iterator]['discount'] = "Oferta";

                        if ($item->PrecioDeLista > $item->oferta ) {
                            $response[$iterator]['oldPrice'] = $item->PrecioDeLista;
                            $response[$iterator]['newPrice'] = $item->oferta;
                        } else {
                            $response[$iterator]['newPrice'] = $item->oferta;
                        }
                    } else {
                        if ($item->PrecioDeLista > $item->priceweb ) {
                            $response[$iterator]['oldPrice'] = $item->PrecioDeLista;
                            $response[$iterator]['newPrice'] = $item->priceweb;
                        } else {
                            $response[$iterator]['newPrice'] = $item->priceweb;

                        }
                    }
                    //termina seccion de precios
                    $response[$iterator]['description'] = $item->descriptionweb;
                    $response[$iterator]['dataSheet'] = $item->resenia;
                    $response[$iterator]['availibilityCount'] = 100;
                    $response[$iterator]['stock'] = $item->availability == 'in stock' ?true:false;
                    if(isset($item->cantidad)){
                        $response[$iterator]['cartCount'] = $item->cantidad;
                    }else{
                        $response[$iterator]['cartCount'] = 0;
                    }
                    $response[$iterator]['brand'] = $item->brand;
                    $response[$iterator]['mpn'] = $item->mpn;
                    $response[$iterator]['productType'] = $item->productType;
                    $response[$iterator]['metaDescription'] = $item->metadesc;
                    $response[$iterator]['metaTitle'] = $item->titleweb;
                    $response[$iterator]['inventory'] = $item->cantidadInventario;
                    $iterator++;
                }
            }else{
                $img = strtolower($item->productType . "-" . $item->brand . "-" . $item->mpn);
                $response[$iterator]['id'] = $item->id;
                $response[$iterator]['name'] = $item->productType . " " . $item->brand . " " . $item->mpn;
                $response[$iterator]['images'][0]['small'] = 'assets/images/productos/' . $img . '.jpg';
                $response[$iterator]['images'][0]['medium'] = 'assets/images/productos/' . $img . '.jpg';
                $response[$iterator]['images'][0]['big'] = 'assets/images/productos/' . $img . '.jpg';
                //empieza la seccion de precios
                if (isset($item->offer) && $item->offer == 'si') {
                    $response[$iterator]['discount'] = "Oferta";

                    if ($item->PrecioDeLista > $item->oferta ) {
                        $response[$iterator]['oldPrice'] = $item->PrecioDeLista;
                        $response[$iterator]['newPrice'] = $item->oferta;
                    } else {
                        $response[$iterator]['newPrice'] = $item->oferta;
                    }
                } else {
                    if ($item->PrecioDeLista > $item->priceweb ) {
                        $response[$iterator]['oldPrice'] = $item->PrecioDeLista;
                        $response[$iterator]['newPrice'] = $item->priceweb;
                    } else {
                        $response[$iterator]['newPrice'] = $item->priceweb;

                    }
                }
                //termina seccion de precios
                $response[$iterator]['description'] = $item->descriptionweb;
                $response[$iterator]['dataSheet'] = $item->resenia;
                $response[$iterator]['availibilityCount'] = 100;
                $response[$iterator]['stock'] = $item->availability == 'in stock' ?true:false;
                if(isset($item->cantidad)){
                    $response[$iterator]['cartCount'] = $item->cantidad;
                }else{
                    $response[$iterator]['cartCount'] = 0;
                }
                $response[$iterator]['brand'] = $item->brand;
                $response[$iterator]['mpn'] = $item->mpn;
                $response[$iterator]['productType'] = $item->productType;
                $response[$iterator]['metaDescription'] = $item->metadesc;
                $response[$iterator]['metaTitle'] = $item->titleweb;
                $response[$iterator]['inventory'] = $item->cantidadInventario;
                $iterator++;
            }
        }
        return json_encode($response);
    }

    public function getProduct(Request $request){
        $product = $request->get('product');
        $product = explode("-", $product);
        if($product[0].'-'.$product[1] == 'Hilo-Nylon' || $product[0].'-'.$product[1] == 'hilo-nylon'){
            $productType = 'Hilo-Nylon';
            $brand = str_replace("_", " ", $product[2]);
            $brand = ucfirst($brand);
            $conta = 4;
            $mpnTemp = $product[3];
            while(isset($product[$conta])){
                $mpnTemp .= "-".$product[$conta];
                $conta++;
            }
            $mpn = str_replace("_", "-", $mpnTemp);
            $brand = ucfirst($brand);
        } else {
            $productType = str_replace("_", " ", $product[0]);
            $productType = ucfirst($productType);
            $brand = str_replace("_", " ", $product[1]);
            $brand = ucfirst($brand);
            $conta = 3;
            $mpnTemp = $product[2];
            while(isset($product[$conta])){
                $mpnTemp .= "-".$product[$conta];
                $conta++;
            }
            $mpn = str_replace("_", "-", $mpnTemp);
            $brand = ucfirst($brand);
        }
//        $productType = str_replace("_", " ", $product[0]);
//        $brand = str_replace("_", " ", $product[1]);
//        $mpn = str_replace("_", "-", $product[2]);

        $data = $this->productoRepository->getProduct($productType, $brand, $mpn);
        $productResponse = $this->model_format_products($data);
        $response = count($productResponse)>0?$productResponse[0]:0;

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
        $ptemp = $product[0].'-'.$product[1];
        if($ptemp == 'Hilo-Nylon'){
            $productType = 'Hilo-Nylon';
            $brand = str_replace("_", " ", $product[2]);
            $mpn = str_replace("_", "-", $product[3]);
        } else {
            $productType = str_replace("_", " ", $product[0]);
            $brand = str_replace("_", " ", $product[1]);
            $mpn = str_replace("_", "-", $product[2]);
        }
        $data = $this->productoRepository->getProductsRelated($productType, $brand, $mpn);
        $response = array();
        $iterator = 0;

        $response = $this->model_format_products($data);

        return json_encode($response);
    }

    public function getProductlevels($productType){
        return $this->productoRepository->getProductlevels($productType);
    }

     //esta externamente en otras dos funciones y en el repository
    public function model_format_products($products){
        $iterator = 0;
        $response = array();
        foreach ($products as $item) {
            $img = strtolower($item->productType . "-" . $item->brand . "-" . $item->mpn);
            $response[$iterator]['id'] = $item->id;
            $response[$iterator]['name'] = $item->productType . " " . $item->brand . " " . $item->mpn;
            $response[$iterator]['images'][0]['small'] = 'assets/images/productos/' . $img . '.jpg';
            $response[$iterator]['images'][0]['medium'] = 'assets/images/productos/' . $img . '.jpg';
            $response[$iterator]['images'][0]['big'] = 'assets/images/productos/' . $img . '.jpg';
            $contadorCarrusel = 1;
            while (file_exists(strtr(public_path().'/assets/images/productos/'.$img.'-'.$contadorCarrusel.'.jpg', $this-> unwanted_array )) && $contadorCarrusel < 4) {
                $response[$iterator]['images'][$contadorCarrusel]['small'] = 'assets/images/productos/' . $img . '-'.$contadorCarrusel.'.jpg';
                $response[$iterator]['images'][$contadorCarrusel]['medium'] = 'assets/images/productos/' . $img . '-'.$contadorCarrusel.'.jpg';
                $response[$iterator]['images'][$contadorCarrusel]['big'] = 'assets/images/productos/' . $img . '-'.$contadorCarrusel.'.jpg';
                $contadorCarrusel ++;
            }
            //empieza la seccion de precios
            if (isset($item->offer) && $item->offer == 'si') {
                $response[$iterator]['discount'] = "Oferta";

                if ($item->PrecioDeLista > $item->oferta ) {
                    $response[$iterator]['oldPrice'] = $item->PrecioDeLista;
                    $response[$iterator]['newPrice'] = $item->oferta;
                } else {
                    $response[$iterator]['newPrice'] = $item->oferta;
                }
            } else {
                if ($item->PrecioDeLista > $item->priceweb ) {
                    $response[$iterator]['oldPrice'] = $item->PrecioDeLista;
                    $response[$iterator]['newPrice'] = $item->priceweb;
                } else {
                    $response[$iterator]['newPrice'] = $item->priceweb;

                }
            }
            //termina seccion de precios
            $response[$iterator]['description'] = $item->descriptionweb;
            $response[$iterator]['dataSheet'] = $item->resenia;
            $response[$iterator]['availibilityCount'] = 100;
            $response[$iterator]['stock'] = $item->availability == 'in stock' ?true:false;
            if(isset($item->cantidad)){
                $response[$iterator]['cartCount'] = $item->cantidad;
            }else{
                $response[$iterator]['cartCount'] = 0;
            }
            $response[$iterator]['brand'] = $item->brand;
            $response[$iterator]['mpn'] = $item->mpn;
            $response[$iterator]['productType'] = $item->productType;

//                Metas
            $response[$iterator]['keywords'] = $item->productType.', '.$item->brand.', '.$item->mpn;
            if ($item->metadesc == ''){
                $response[$iterator]['metaDescription'] = $item->productType.' '.$item->brand.' '.$item->mpn;
            }else{
                $response[$iterator]['metaDescription'] = $item->metadesc;
            }
            if ($item->titleweb == ''){
                $response[$iterator]['metaTitle'] = $item->productType.' '.$item->brand.' '.$item->mpn;
            }else{
                $response[$iterator]['metaTitle'] = $item->titleweb;
            }

            $response[$iterator]['inventory'] = $item->cantidadInventario;

            $iterator++;
        }
        return $response;

    }

   public function getProductsSearch(Request $request){

        $search = $request->get('valorSearch');
        if ($search == ''){
            return json_encode('vacio');
        }
        $productos = $this->productoRepository->getProductsSearch($search);
        if(count($productos) == 0){
            $productos='emptyProducts';
        }
        return json_encode($productos);
   }

   public function getProductsOffer(Request $request){
        $productos = $this->productoRepository->getProductsOffer();
        if(count($productos) == 0){
            $productos='emptyProducts';
        }
       $productos = $this->model_format_products($productos);
        return json_encode($productos);
   }

   public function getDescriptionNivel2(Request $request){
        $nivel1= $request->get('nivel1');
        $nivel2= $request->get('nivel2');
        if($nivel1 != 'index' && $nivel2 != 'index'){
            $idNivel2 = $this->productoRepository->getIdNivel2($nivel1, $nivel2);
            $texto = $this->productoRepository->getDescriptionNivel2($idNivel2);
        }else{
            $texto = $this->productoRepository->getDescriptionNivel2(0);
        }
        return json_encode(['result'=>$texto]);
   }

   public function sendSearch(Request $request){
        $forms = json_decode($request->get('forms'));
        $busqueda = $request->get('textoBuscado');
        $res = $this -> productoRepository -> sendBusqueda($forms,$busqueda);
        return json_encode(['resultado'=> $res]);
   }

    public function validateImages(){
        $products = $this->productoRepository->validateImages();
        $iterator = 0;
        $response = array();
        foreach ($products as $item) {
            $img = strtolower($item->productType . "-" . $item->brand . "-" . $item->mpn);
            $contadorCarrusel = 1;
            $ima=file_exists(strtr(base_path().'/../jardepot/assets/images/productos/'.$img.'.jpg', $this-> unwanted_array));
            if(!$ima){
                echo "Nombre imagen: ".$img." Nombre producto: ".$item->productType . " " . $item->brand . " " . $item->mpn;
                echo "<br>";
            }

        }
    }

    public function singular($pal) {
        $palabraAr = explode(" ", $pal);
        $palabra= strtolower($palabraAr[0]);
        $lng=mb_strlen($palabra,'UTF-8'); // Obtener la longitud de la palabra
        $ultima=mb_substr($palabra,$lng-1,1,'UTF-8');	// Extraer el último carácter
        $penultima=mb_substr($palabra,$lng-2,1,'UTF-8');	// Extraer el penúltimo carácter

        if($ultima =='s' ){
            if ($penultima != 'e' || $palabra == 'aceites' ){
                return substr($palabra,0,-1);
            }else{
                return substr($palabra,0,-2);
            }
        }else{
            return $palabra;
        }
    }

}
