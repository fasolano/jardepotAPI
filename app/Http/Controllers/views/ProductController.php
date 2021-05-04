<?php


namespace App\Http\Controllers\views;


use App\Http\Controllers\Controller;
use App\Http\Controllers\MenuController;
use App\Repositories\ProductRepository;
use App\Repositories\SpareRepository;
use Illuminate\Http\Request;

class ProductController extends Controller {

    private $productoRepository;
    private $unwanted_array;

    //Todas las consultas tienen join con inventario, si se implementa openjardepot se deberan de quitar esos left join con  sus groupby
    public function __construct(){
        setlocale(LC_MONETARY, 'en_US');
        $this->comprobarMoneyFormat();
        $this->productoRepository = new ProductRepository();
        $this-> unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
    }

    public function product($marca, $productType, $brand, $mpn){
        $linkSpare = ["productType"=>$productType, "brand"=>$brand, "mpn"=>$mpn];
        $menu = new MenuController();
        $categoriasNivel1 = $menu->getSidebar();
        foreach ($categoriasNivel1 as $key => $categoria1) {
            $categoriasNivel1[$key]->nombreCategoriaNivel1 = $categoria1->nombreCategoriaNivel1;
            $niv1 = str_replace(' ','-', $categoria1->nombreCategoriaNivel1);
            $href1 = strtr($niv1, $this->unwanted_array);
            $categoriasNivel1[$key]->href = strtolower($href1);
            foreach ($categoria1->nivel2 as $key2 => $categoria2){
                $niv2 = str_replace(' ','-',$categoria2->name);
                $href = strtr($niv2, $this->unwanted_array);
                $categoriasNivel1[$key]->nivel2[$key2]->href = strtolower($href);
            }
        }
        $sidebar = $categoriasNivel1;
        if($productType.'-'.$brand == 'hilo-nylon'){
            $productType = $productType.'-'.$brand;
            $brand = explode("-", $mpn)[0];
            $mpn1 = explode("-", $mpn)[1];
            if(isset( explode("-", $mpn)[2])){
                $mpn = $mpn1.'-'.explode("-", $mpn)[2];
            }else{
                $mpn = $mpn1;
            }
        }else if($this->productoRepository->brandExiste($brand) == false){

            if(isset( explode("-", $mpn)[2])){

                $brand = $brand.'-'. explode("-", $mpn)[0];
                $mpn = explode("-", $mpn)[1].'-'.explode("-", $mpn)[2];

            }else if(isset( explode("-", $mpn)[1])){

                $brand = $brand.'-'. explode("-", $mpn)[0];
                $mpn = explode("-", $mpn)[1];
            }
        }
        $brand = str_replace("-", " ", $brand);

        $ipl = $this->productoRepository->getIpls($productType, $brand, $mpn);
        $ipl = count($ipl);
        $data = $this->productoRepository->getProduct($productType, $brand, $mpn);
        if(count($data)>0){
            $spareRepository = new SpareRepository();
            $product= $this->model_format_products($data,'product')[0];

            $data2 = $this->productoRepository->getProductsRelated($productType, $brand, $mpn);
            $productsRelated = $this->model_format_products($data2,'related');
            $canonical = url()->current();

            $ipls = $spareRepository->getIpls($productType, $brand, $mpn);
            $producto = ucfirst($productType)."-".ucfirst($brand)."-".ucfirst($mpn);

            return view('pages/product',compact('sidebar','product','productsRelated', 'ipl', 'linkSpare','canonical', 'ipls','producto'));
        }else{
            return view('errors/404');
        }
    }

    public function sendSearch(Request $request) {
//        $form =json_encode($request->get('forms'));
        $forms =  (object) $request->json('forms');
        // $forms = json_decode($forms);
        $busqueda = $request->json('textoBuscado');
        $res = $this->productoRepository->sendBusqueda($forms, $busqueda);
        return json_encode(['resultado' => $res]);
    }

    //esta externamente en otras dos funciones y en el repository
    public function model_format_products($products,$type){
        $iterator = 0;
        $response = array();
        foreach ($products as $item) {
            $img = strtolower( str_replace(' ','-',$item->productType) . "-" . str_replace(' ','-',$item->brand) . "-" . $item->mpn);
            $response[$iterator]['id'] = $item->id;
            $response[$iterator]['name'] = $item->productType . " " . $item->brand . " " . $item->mpn;

            $productType = str_replace(' ','-',$item->productType);
            $brand = str_replace(' ','-',$item->brand);
            $mpn = str_replace(' ','-',$item->mpn);
            $href = strtolower($productType . "-" . $brand . "-" . $mpn);
            $response[$iterator]['href'] = strtr('catalogo/'.strtolower($brand).'/'.$href, $this-> unwanted_array);

            if(file_exists(strtr(base_path().'/public/assets/images/productos/'.$img.'.jpg', $this-> unwanted_array))){
                $response[$iterator]['images'][0]['small'] = 'assets/images/productos/' . $img . '.jpg';
                $response[$iterator]['images'][0]['medium'] = 'assets/images/productos/' . $img . '.jpg';
                $response[$iterator]['images'][0]['big'] = 'assets/images/productos/zoom/' . $img . '.jpg';
            }else{
                $response[$iterator]['images'][0]['small'] = 'assets/images/productos/generico2.jpg';
                $response[$iterator]['images'][0]['medium'] = 'assets/images/productos/generico2.jpg';
                $response[$iterator]['images'][0]['big'] = 'assets/images/productos/zoom/generico2.jpg';
            }
            $contadorCarrusel = 1;
            while (file_exists(strtr(base_path().'/public/assets/images/productos/'.$img.'-'.$contadorCarrusel.'.jpg', $this-> unwanted_array )) && $contadorCarrusel < 4) {
                $response[$iterator]['images'][$contadorCarrusel]['small'] = 'assets/images/productos/' . $img . '-'.$contadorCarrusel.'.jpg';
                $response[$iterator]['images'][$contadorCarrusel]['medium'] = 'assets/images/productos/' . $img . '-'.$contadorCarrusel.'.jpg';
                $response[$iterator]['images'][$contadorCarrusel]['big'] = 'assets/images/productos/zoom/' . $img . '-'.$contadorCarrusel.'.jpg';
                $contadorCarrusel ++;
            }
            //empieza la seccion de precios
            if (isset($item->offer) && $item->offer == 'si') {
                $response[$iterator]['discount'] = "Oferta";

                if ($item->PrecioDeLista > $item->price ) {
                    $response[$iterator]['oldPrice'] = money_format('%.2n', $item->PrecioDeLista);;
                    $response[$iterator]['newPrice'] = money_format('%.2n', $item->price);
                    $response[$iterator]['newPriceFloat'] = $item->price;
                } else {
                    $response[$iterator]['newPrice'] = money_format('%.2n', $item->price);
                    $response[$iterator]['oldPrice'] = false;
                    $response[$iterator]['newPriceFloat'] = $item->price;
                }
            } else {
                $response[$iterator]['discount'] = "No Oferta";
                if ($item->PrecioDeLista > $item->price ) {
                    $response[$iterator]['oldPrice'] =  money_format('%.2n', $item->PrecioDeLista);
                    $response[$iterator]['newPrice'] =  money_format('%.2n', $item->price);
                    $response[$iterator]['newPriceFloat'] = $item->price;
                } else {
                    $response[$iterator]['newPrice'] =  money_format('%.2n', $item->price);
                    $response[$iterator]['oldPrice'] = false;//se puse false por que daba error en vista
                    $response[$iterator]['newPriceFloat'] = $item->price;
                }
            }
            //termina seccion de precios


            $response[$iterator]['availibilityCount'] = 100;
           // $response[$iterator]['stock'] = $item->availability == 'in stock' ? true : false;
            if ($item->availability == 'in stock' && $item->priceVisible > 0){
                $response[$iterator]['stock'] = true;
            }else{
                $response[$iterator]['stock'] = false;
            }
            if(isset($item->cantidad)){
                $response[$iterator]['cartCount'] = $item->cantidad;
            }else{
                $response[$iterator]['cartCount'] = 0;
            }
            $response[$iterator]['brand'] = $item->brand;
            $response[$iterator]['mpn'] = $item->mpn;
            $response[$iterator]['productType'] = $item->productType;

            if($type == 'product'){

                // if(strlen($item->descriptionweb ) > 200){//esto esta mientras se reducen todas las descripciones
                //     $response[$iterator]['description'] = substr($item->descriptionweb,0,200).'...';
                // }else{
                //     $response[$iterator]['description'] = $item->descriptionweb;
                // }
                $response[$iterator]['description'] = $item->descriptionweb;
                $response[$iterator]['dataSheet'] = $item->resenia;
//                Metas
                $response[$iterator]['keywords'] = $item->productType;
                if ($item->metadesc == ''){
                    $response[$iterator]['metaDescription'] = $item->productType.' '.$item->brand.' '.$item->mpn;
                }else{
                    $response[$iterator]['metaDescription'] = $item->metadesc;
                }
                if (!isset($item->titleweb) || $item->titleweb == ''){
                    $response[$iterator]['metaTitle'] = $item->productType.' '.$item->brand.' '.$item->mpn;
                }else{
                    $response[$iterator]['metaTitle'] = $item->titleweb;
                }
            }

            $response[$iterator]['inventory'] = $item->cantidadInventario;

            $response[$iterator]['video'] = isset($item->video)?$item->video:"";
            if(file_exists(strtr(base_path().'/public/assets/images/brands/'.strtolower($brand).'.png', $this-> unwanted_array))){
                $response[$iterator]['imgBrand']= 'assets/images/brands/' . $brand . '.png';
            }
      /*      else{
                $response[$iterator]['imgBrand'] = 'assets/images/brands/nobrand.png';
            }*/

            $iterator++;
        }
        return $response;

    }

    function comprobarMoneyFormat(){
        if (!function_exists('money_format')) {
            function money_format($format, $number){
                $regex = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?' . '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
                if (setlocale(LC_MONETARY, 0) == 'C') {
                    setlocale(LC_MONETARY, '');
                }
                $locale = localeconv();
                preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
                foreach ($matches as $fmatch) {
                    $value = floatval($number);
                    $flags = array(
                        'fillchar' => preg_match('/\=(.)/', $fmatch[1], $match) ?
                            $match[1] : ' ',
                        'nogroup' => preg_match('/\^/', $fmatch[1]) > 0,
                        'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                            $match[0] : '+',
                        'nosimbol' => preg_match('/\!/', $fmatch[1]) > 0,
                        'isleft' => preg_match('/\-/', $fmatch[1]) > 0
                    );
                    $width = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
                    $left = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
                    $right = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
                    $conversion = $fmatch[5];

                    $positive = true;
                    if ($value < 0) {
                        $positive = false;
                        $value *= -1;
                    }
                    $letter = $positive ? 'p' : 'n';

                    $prefix = $suffix = $cprefix = $csuffix = $signal = '';

                    $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
                    switch (true) {
                        case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                            $prefix = $signal;
                            break;
                        case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                            $suffix = $signal;
                            break;
                        case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                            $cprefix = $signal;
                            break;
                        case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                            $csuffix = $signal;
                            break;
                        case $flags['usesignal'] == '(':
                        case $locale["{$letter}_sign_posn"] == 0:
                            $prefix = '(';
                            $suffix = ')';
                            break;
                    }
                    if (!$flags['nosimbol']) {
                        $currency = $cprefix .
                            ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                            $csuffix;
                    } else {
                        $currency = '';
                    }
                    $space = $locale["{$letter}_sep_by_space"] ? ' ' : '';

                    $value = number_format($value, $right, $locale['mon_decimal_point'],
                        $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
                    $value = @explode($locale['mon_decimal_point'], $value);

                    $n = strlen($prefix) + strlen($currency) + strlen($value[0]);
                    if ($left > 0 && $left > $n) {
                        $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
                    }
                    $value = implode($locale['mon_decimal_point'], $value);
                    if ($locale["{$letter}_cs_precedes"]) {
                        $value = $prefix . $currency . $space . $value . $suffix;
                    } else {
                        $value = $prefix . $value . $space . $currency . $suffix;
                    }
                    if ($width > 0) {
                        $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                            STR_PAD_RIGHT : STR_PAD_LEFT);
                    }
                    $format = str_replace($fmatch[0], $value, $format);
                }
                return $format;
            }
        }
    }
}
