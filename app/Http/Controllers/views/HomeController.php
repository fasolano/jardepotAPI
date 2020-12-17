<?php

namespace App\Http\Controllers\views;

use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;
use App\Repositories\ProductRepository;
use App\Repositories\IpRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct(){
        $this -> unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
    }

    public function index(){
        $menuRepository = new MenuRepository();
        $productoRepository = new ProductRepository();
        $categoriasNivel1 = $menuRepository->getAdditional2();
        foreach ($categoriasNivel1 as $key => $categoria1) {
            $menuAdditional[$key]['nivel1'] = $categoria1->name;
            $categoriasNivel2 = $menuRepository->getNivel2($categoria1->id);
            foreach ($categoriasNivel2 as $key2 => $categoria2){
                $menuAdditional[$key]['nivel2'][$key2]['name'] = $categoria2->name;
                $niv1 = str_replace(' ','-', $categoria1->name);
                $niv2 = str_replace(' ','-',$categoria2->name);
                $href = strtr($niv1.'/'.$niv2, $this->unwanted_array);
                $menuAdditional[$key]['nivel2'][$key2]['href'] = strtolower($href);
            }
        }
        $descriptionLevel2 = $productoRepository->getDescriptionNivel2(0);
//        Obtenemos las imagenes del banner
        $path = public_path() . '/assets/images/banner';
        $dir = opendir($path);
        $images = [];
        $cont=0;
        // Leo todos los ficheros de la carpeta
        while ($elemento = readdir($dir)) {
            if ($elemento != "." && $elemento != "..") {
                // Si no es una carpeta
                if (!is_dir($path . $elemento)) {
                    $images[$cont] = $elemento;
                    $cont++;
                }
            }
        }
        return view('pages/home',compact('menuAdditional','descriptionLevel2','images'));
    }

    /*public function prueba(){
        $track = new Track('JoQrF0bbDKa4dj4p', 'YqI0f9C9bjXVluyL7uc7Hm9F0', '510087860', '119177249');
        $req = $track->getByTrackingId('772128949168');
        print_r($req);
        return 1;

    }*/


    /*    public function getIpClient(Request $request){return $request->ip().''.$request->url();}*/
}
