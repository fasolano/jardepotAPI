<?php


namespace App\Http\Controllers\views;


use App\Http\Controllers\Controller;
use App\Http\Controllers\MenuController;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductsController extends Controller {

    private $unwanted_array;

    public function __construct() {
        setlocale(LC_MONETARY, 'en_US');
        $this->comprobarMoneyFormat();
        $this->unwanted_array = array('Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y');
    }

    public function productsList($categoryLevel1, $categoryLevel2){
        $categoryLevel1 = str_replace("-", " ", ucfirst($categoryLevel1));
        $categoryLevel2 = str_replace("-", " ", ucfirst($categoryLevel2));
        $menuController = new MenuController();
        $sidebar = $menuController->getSidebar();
        $productController = new \App\Http\Controllers\ProductController();
        $products = $productController->getProductsList($categoryLevel1, $categoryLevel2);
        $products = $this->porductModelFormat($products);
        $numberPages = count($products) / 8;
        $filters = $productController->getSectionsLevel3($categoryLevel1, $categoryLevel2);
        $descriptionLevel2 = $productController->getDescriptionLevel2($categoryLevel1, $categoryLevel2);

        $textFilter = "";
        if($categoryLevel1 == "marcas" || $categoryLevel1 == "refacciones"){
            $textFilter = "equipos";
        }else{
            $textFilter = "marcas";
        }

        return view('pages/products', compact('sidebar', 'categoryLevel1', 'categoryLevel2', 'products', 'numberPages', 'filters', 'textFilter', 'descriptionLevel2'));
    }

    public function getProductsListSearch($word){
        $productRepository = new ProductRepository();
        $menuController = new MenuController();
        $sidebar = $menuController->getSidebar();
        $categoryLevel1 = "Busqueda";
        $categoryLevel2 = $word;
        $numberPages = 0;
        $descriptionLevel2 = new \stdClass();
        $descriptionLevel2->metadescription = "Busca los productos que necesites Jardepot";
        $descriptionLevel2->keywords = "Busca los productos que necesites Jardepot";
        $descriptionLevel2->metatitle = "Jardepot, el lugar donde encuentras todo lo que necesitas";

        $word = trim($word);
        $cant = 0;
        $productsListSearch = array();
        if (!$word) {
            return view('pages/products', compact('sidebar', 'categoryLevel1', 'categoryLevel2', 'productsListSearch', 'numberPages', 'descriptionLevel2'));
        }

        $matches= $productRepository->getProductsSearch2($word);
        //$productsListSearch = $productRepository->getProductsSearch($word);
        foreach ( $matches as $matchNivel) {
            foreach ($matchNivel as $key => $match) {
                array_push($productsListSearch, $match);
            }
        }
        $productsListSearch = $this->porductModelFormat($productsListSearch);
        $numberPages = count($productsListSearch) / 8;

        return view('pages/products', compact('sidebar', 'categoryLevel1', 'categoryLevel2', 'productsListSearch', 'numberPages', 'descriptionLevel2'));
    }

    public function productsSearchOrdered(Request $request){
        $productRepository = new ProductRepository();
        $word = $request->get('word');
        $orderBy = $request->get('order');

        $productsListSearch = array();
        $matches= $productRepository->getProductsSearch2($word);
        //$productsListSearch = $productRepository->getProductsSearch($word);
        foreach ( $matches as $matchNivel) {
            foreach ($matchNivel as $key => $match) {
                array_push($productsListSearch, $match);
            }
        }
        $productsListSearch = $this->porductModelFormat($productsListSearch);

        if($orderBy == 'DESC'){
            usort($productsListSearch, function ($item1, $item2) {
                return $item2['newPriceFloat'] <=> $item1['newPriceFloat'];
            });
        }elseif ($orderBy == 'ASC'){
            usort($productsListSearch, function ($item1, $item2) {
                return $item1['newPriceFloat'] <=> $item2['newPriceFloat'];
            });
        }
        return json_encode($productsListSearch);
    }

    public function productsListFiltered(Request $request){
        $productRepository = new ProductRepository();
        $categoryLevel1 = $request->get('level1');
        $categoryLevel2 = $request->get('level2');
        $filters = $request->get('filters');
        $orderBy = $request->get('order');
        $idLevel2 = $productRepository->getIdNivel2($categoryLevel1,$categoryLevel2);
        if($filters){
            $products = $productRepository->getProductsFiltered($idLevel2, $filters);
        }else{
            $products = $productRepository->getProducts($idLevel2);
        }
        $products = $this->porductModelFormat($products);
        if($orderBy == 'DESC'){
            usort($products, function ($item1, $item2) {
                return $item2['newPriceFloat'] <=> $item1['newPriceFloat'];
            });
        }elseif ($orderBy == 'ASC'){
            usort($products, function ($item1, $item2) {
                return $item1['newPriceFloat'] <=> $item2['newPriceFloat'];
            });
        }
        return json_encode($products);
    }

    public function sendSearchFailed(Request $request){
        $productRepository = new ProductRepository();
        $name = $request->get('name');
        $phone = $request->get('phone');
        $coment = $request->get('coments');
        $search = $request->get('search');
        $form = new \stdClass();
        $form->nombre = $name;
        $form->telefono = $phone;
        $form->comentario = $coment;
        $form->busqueda = $search;


        $res = $productRepository->sendBusqueda($form, $search);
        return json_encode(['resultado' => $res]);
    }

    function porductModelFormat($productosCategoria){
        $response = array();
        $iterator = 0;
        foreach ($productosCategoria as $keyProducto => $item) {

            $img = strtolower($item->productType . "-" . $item->brand . "-" . $item->mpn);
            //Si hay filtros aplicados va a verificar
            $response[$iterator]['id'] = $item->id;
            $response[$iterator]['name'] = $item->productType . " " . $item->brand . " " . $item->mpn;
            if(file_exists(strtr(base_path() . '/public/assets/images/productos/' . $img . '.jpg', $this->unwanted_array))){
                $response[$iterator]['images'][0]['medium'] = 'assets/images/productos/' . $img . '.jpg';
            }else{
                $response[$iterator]['images'][0]['medium'] = 'assets/images/productos/generico2.jpg';
            }
            //empieza la seccion de precios
            if (isset($item->offer) && $item->offer == 'si') {
                $response[$iterator]['discount'] = "Oferta";

                if ($item->PrecioDeLista > $item->oferta) {
                    $response[$iterator]['oldPrice'] = money_format('%.2n',$item->PrecioDeLista);
                    $response[$iterator]['newPrice'] = money_format('%.2n',$item->oferta);
                    $response[$iterator]['newPriceFloat'] = $item->oferta;
                }
                else {
                    $response[$iterator]['newPrice'] = money_format('%.2n',$item->oferta);
                    $response[$iterator]['newPriceFloat'] = $item->oferta;
                }
            }
            else {
                if ($item->PrecioDeLista > $item->price) {
                    $response[$iterator]['oldPrice'] = money_format('%.2n',$item->PrecioDeLista);
                    $response[$iterator]['newPrice'] = money_format('%.2n',$item->price);
                    $response[$iterator]['newPriceFloat'] = $item->price;
                }
                else {
                    $response[$iterator]['newPrice'] = money_format('%.2n',$item->price);
                    $response[$iterator]['newPriceFloat'] = $item->price;
                }
            }
            //termina seccion de precios
            $response[$iterator]['description'] = $item->descriptionweb;
            $response[$iterator]['stock'] = $item->availability == 'in stock';
            $response[$iterator]['brand'] = $item->brand;
            $response[$iterator]['mpn'] = $item->mpn;
            $response[$iterator]['productType'] = $item->productType;
            $response[$iterator]['inventory'] = $item->cantidadInventario;
            $iterator++;
        }
        return $response;
    }

    function comprobarMoneyFormat(){
        if (!function_exists('money_format')) {
            function money_format($format, $number)
            {
                $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
                    '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
                if (setlocale(LC_MONETARY, 0) == 'C') {
                    setlocale(LC_MONETARY, '');
                }
                $locale = localeconv();
                preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
                foreach ($matches as $fmatch) {
                    $value = floatval($number);
                    $flags = array(
                        'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
                            $match[1] : ' ',
                        'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
                        'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                            $match[0] : '+',
                        'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
                        'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
                    );
                    $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
                    $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
                    $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
                    $conversion = $fmatch[5];

                    $positive = true;
                    if ($value < 0) {
                        $positive = false;
                        $value  *= -1;
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
                    $space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

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
