<?php


namespace App\Http\Controllers\views;


use App\Http\Controllers\Controller;
use App\Http\Controllers\MenuController;
use App\Repositories\ProductRepository;
use App\Repositories\SpareRepository;
use Illuminate\Http\Request;

class SpareController extends Controller {
    private $spareRepository;

    public function __construct(){
        $this->spareRepository = new SpareRepository();
        $this-> unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
        setlocale(LC_MONETARY, 'en_US.UTF-8');
    }

    public function index($productType, $brand, $mpn){
        $menu = new MenuController();
        $productoRepository = new ProductRepository();
        if($productType.'-'.$brand == 'hilo-nylon'){
            $productType = $productType.'-'.$brand;
            $brand = explode("-", $mpn)[0];
            $mpn1 = explode("-", $mpn)[1];
            if(isset( explode("-", $mpn)[2])){
                $mpn = $mpn1.'-'.explode("-", $mpn)[2];
            }else{
                $mpn = $mpn1;
            }
        }else if($productoRepository->brandExiste($brand) == false){

            if(isset( explode("-", $mpn)[2])){

                $brand = $brand.'-'. explode("-", $mpn)[0];
                $mpn = explode("-", $mpn)[1].'-'.explode("-", $mpn)[2];

            }else if(isset( explode("-", $mpn)[1])){

                $brand = $brand.'-'. explode("-", $mpn)[0];
                $mpn = explode("-", $mpn)[1];
            }
        }
        $brand = str_replace("-", " ", $brand);
        $producto = ucfirst($productType)."-".ucfirst($brand)."-".ucfirst($mpn);

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

        $ipls = $this->spareRepository->getIpls($productType, $brand, $mpn);


        return view('pages/spare', compact('productType', 'brand', 'mpn', 'sidebar', 'ipls', 'producto'));
    }

    public function getMarcadores(Request $request){
        $ipl = $request->get('ipl');
        return json_encode($this->spareRepository->getMarcadores($ipl));
    }

    /*public function addCarrito(Request $request){
        $pieza = $request->get('pieza');
        $cantidad = $request->get('cantidad');
        $modelo = $request->get('modelo');
        $numero = $this->refaccionesRepository->addPieza($pieza, $cantidad, $modelo);
        $refaccion = $this->refaccionesRepository->getRefaccion($pieza,$numero);
        $total = $this->refaccionesRepository->actualizarTotal();
        $total = number_format($total, 2, '.', ',');
        $numero = count(session('carrito'));
        return json_encode(['numero' => $numero-1, 'articulo' => $refaccion, 'total' => $total]);
    }

    public function carrito(Request $request){
        $carrito = session('carrito', null);
        if ($carrito !== null) {
            $refacciones = $this->refaccionesRepository->getCarrito($carrito);
            $total = $this->refaccionesRepository->actualizarTotal();
            $total = number_format($total, 2, '.', ',');
            $numero = count(session('carrito'));
            return json_encode(['numero' => $numero-1, 'articulos' => $refacciones, 'total' => $total]);
        }else{
            return json_encode(['numero' => 0]);
        }
    }

    public function deleteRefaccion(Request $request){
        $pieza = $request->get('pieza');
        return $this->refaccionesRepository->deleteRefaccion($pieza);
    }

    public function enviarRefacciones(Request $request){
        $nombre = $request->get('nombre');
        $telefono = $request->get('telefono');
        $mail = $request->get('mail');
        $comentarios = $request->get('comentarios');
        $this->refaccionesRepository->enviarCotizacion($nombre, $telefono, $mail, $comentarios);
        return 1;
    }*/

}
