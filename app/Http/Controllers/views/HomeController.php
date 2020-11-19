<?php

namespace App\Http\Controllers\views;

use App\Http\Controllers\Controller;
use App\Http\Controllers\fedex\TrackService\Track;
use App\Repositories\MenuRepository;
use App\Repositories\ProductRepository;
use App\Repositories\IpRepository;
use Illuminate\Http\Request;

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
        return view('pages/home',compact('menuAdditional','descriptionLevel2'));
    }

    /*public function prueba(){
        $track = new Track('JoQrF0bbDKa4dj4p', 'YqI0f9C9bjXVluyL7uc7Hm9F0', '510087860', '119177249');
        $req = $track->getByTrackingId('772128949168');
        print_r($req);
        return 1;

    }*/


    public function prueba(){
        $key = "JoQrF0bbDKa4dj4p";
        $password = "YqI0f9C9bjXVluyL7uc7Hm9F0";
        $accountNo = "510087860";
        $meterNo = "119177249";
        $id = "772128949168";
        // Build Authentication
        $request['WebAuthenticationDetail'] = array(
            'UserCredential' => array(
                'Key'=> $key, //Replace it with FedEx Key,
                'Password' => $password //Replace it with FedEx API Password
            )
        );


        //Build Client Detail
        $request['ClientDetail'] = array(
            'AccountNumber' => $accountNo, //Replace it with Account Number,
            'MeterNumber'   => $meterNo //Replace it with Meter Number
        );


        // Build Customer Transaction Id
        $request['TransactionDetail'] = array(
            'CustomerTransactionId' => "API request by using PHP"
        );


        // Build API Version info
        $request['Version'] = array(
            'ServiceId'    => "trck",
            'Major'        => 19, // You can change it based on you using api version
            'Intermediate' => 0, // You can change it based on you using api version
            'Minor'        => 0 // You can change it based on you using api version
        );


        // Build Tracking Number info
        $request['SelectionDetails'] = array(
            'PackageIdentifier' => array(
                'Type'  => 'TRACKING_NUMBER_OR_DOORTAG',
                'Value' => $id //Replace it with FedEx tracking number
            )
        );

        $wsdlPath = asset("TrackService_v19.wsdl");
        $endPoint = "https://wsbeta.fedex.com:443/web-services"; //You will get it when requesting to FedEx key. It might change based on the API Environments

        $client = new \SoapClient($wsdlPath, array('trace' => true));
        $client->__setLocation($endPoint);

        $apiResponse = $client->track($request);

        echo $this->printp($apiResponse);
        return 1;

    }

    public function printp($arr){
        $retStr = '<ul>';
        if (is_object($arr)){
            foreach ($arr as $key=>$val){
                if (is_object($val)){
                    $retStr .= '<li>' . $key . ' => ' . $this->printp($val) . '</li>';
                }else if (is_array($val)){
                    $retStr .= '<li>' . $key . ' => ' . $this->pp($val) . '</li>';
                }else{
                    $retStr .= '<li>' . $key . ' => ' . $val . '</li>';
                }
            }
        }
        $retStr .= '</ul>';
        return $retStr;
    }

    function pp($arr){
        $retStr = '<ul>';
        if (is_array($arr)){
            foreach ($arr as $key=>$val){
                if (is_array($val)){
                    $retStr .= '<li>' . $key . ' => ' . $this->pp($val) . '</li>';
                }else if (is_object($val)){
                    $retStr .= '<li>' . $key . ' => ' . $this->printp($val) . '</li>';
                }else{
                    $retStr .= '<li>' . $key . ' => ' . $val . '</li>';
                }
            }
        }
        $retStr .= '</ul>';
        return $retStr;
    }

/*    public function getIpClient(Request $request){return $request->ip().''.$request->url();}*/
}
