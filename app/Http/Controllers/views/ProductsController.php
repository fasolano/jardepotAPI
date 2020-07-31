<?php


namespace App\Http\Controllers\views;


use App\Http\Controllers\Controller;
use App\Http\Controllers\MenuController;

class ProductsController extends Controller {

    public function productList($categoryLevel1, $categoryLevel2){
        $menuController = new MenuController();
        $sidebar = $menuController->getSidebar();
        $productController = new \App\Http\Controllers\ProductController();
        $products = $productController->getProductsList($categoryLevel1, $categoryLevel2);
        $products = $this->porductModelFormat($products);


        return view('pages/products', compact('sidebar', 'categoryLevel1', 'categoryLevel2', 'products'));
    }

    function porductModelFormat($productosCategoria){
        $response = array();
        $iterator = 0;
        $this->comprobarMoneyFormat();
        foreach ($productosCategoria as $keyProducto => $item) {

            $img = strtolower($item->productType . "-" . $item->brand . "-" . $item->mpn);
            //Si hay filtros aplicados va a verificar
            $response[$iterator]['id'] = $item->id;
            $response[$iterator]['name'] = $item->productType . " " . $item->brand . " " . $item->mpn;
            $response[$iterator]['images'][0]['small'] = 'assets/images/productos/' . $img . '.jpg';
            $response[$iterator]['images'][0]['medium'] = 'assets/images/productos/' . $img . '.jpg';
            $response[$iterator]['images'][0]['big'] = 'assets/images/productos/zoom/' . $img . '.jpg';
            //empieza la seccion de precios
            if (isset($item->offer) && $item->offer == 'si') {
                $response[$iterator]['discount'] = "Oferta";

                if ($item->PrecioDeLista > $item->oferta) {
                    $response[$iterator]['oldPrice'] = money_format('%.2n',$item->PrecioDeLista);
                    $response[$iterator]['newPrice'] = money_format('%.2n',$item->oferta);
                }
                else {
                    $response[$iterator]['newPrice'] = money_format('%.2n',$item->oferta);
                }
            }
            else {
                if ($item->PrecioDeLista > $item->price) {
                    $response[$iterator]['oldPrice'] = money_format('%.2n',$item->PrecioDeLista);
                    $response[$iterator]['newPrice'] = money_format('%.2n',$item->price);
                }
                else {
                    $response[$iterator]['newPrice'] = money_format('%.2n',$item->price);

                }
            }
            //termina seccion de precios
            $response[$iterator]['description'] = $item->descriptionweb;
            $response[$iterator]['dataSheet'] = $item->resenia;
            $response[$iterator]['availibilityCount'] = 100;
            $response[$iterator]['stock'] = $item->availability == 'in stock' ? true : false;
            if (isset($item->cantidad)) {
                $response[$iterator]['cartCount'] = $item->cantidad;
            }
            else {
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
