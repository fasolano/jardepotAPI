<?php

namespace App\Http\Controllers\views;

use App\Http\Controllers\Controller;
use App\Repositories\TrackingRepository;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function __construct(){
        $this->trackingRepository = new TrackingRepository();
    }

    public function getGuia(){
//        return $this->getTracking(772137131206);
        return $this->getTracking(771840259266);
        if (isset($_POST['form'])){
            $guias = $this->trackingRepository->getGuia(json_decode($_POST['form']));
            if(count($guias) > 0){
                $arr=[];
                foreach ($guias as $key=>$guia){
                    $arr[$key]['guia']=$guia->guia;
                    $arr[$key]['nombre']=$guia->nombre;
                    if($guia->nombre == 'Fedex'){
                        $arr[$key]['table'] = $this->getTracking($guia->guia);
                    }
                }
                return ['status'=>'success','data'=>$arr];
            }else{
                return ['status'=>'notfound','data'=>$guias];
            }
        }else{
            return ['status'=>'error'];
        }
    }
//    public function getTracking(){
    public function getTracking($id){
       // Test
//        $key = "JoQrF0bbDKa4dj4p";
//        $password = "YqI0f9C9bjXVluyL7uc7Hm9F0";
//        $accountNo = "510087860";
//        $meterNo = "119177249";
//        $id = "770626226008";
        // Producton
        $key = "pBoaTCrFmGJiKE8T";
        $password = "nIeSnZs88z6vVbhjUQq1FsFZe";
        $accountNo = "375208199";
        $meterNo = "252633061";

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
            'CustomerTransactionId' => "https://ws.fedex.com:443/web-services",
//            'CustomerTransactionId' => "https://wsbeta.fedex.com:443/web-services",
            'Localization' => ['LanguageCode'=>'ES','LocaleCode'=>'ES']
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
            ),
        );
        $request['ProcessingOptions']= 'INCLUDE_DETAILED_SCANS' ;

        $wsdlPath = asset("TrackService_v19.wsdl");
        $endPoint = "https://ws.fedex.com:443/web-services"; //You will get it when requesting to FedEx key. It might change based on the API Environments

        $client = new \SoapClient($wsdlPath, array('trace' => true));
        $client->__setLocation($endPoint);

        $apiResponse = $client->track($request);
        if($apiResponse->HighestSeverity == 'SUCCESS'){
            $td=json_encode($apiResponse->CompletedTrackDetails->TrackDetails);
        }else{
            $td=json_encode($apiResponse);
        }
        return ($td);
    }

/*    public function printp($arr){
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

    function printTable($response,$client){
        if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){
            if($response->HighestSeverity != 'SUCCESS'){
                echo '<table border="1">';
                echo '<tr><th>Track Reply</th><th>&nbsp;</th></tr>';
                $this->trackDetails($response->Notifications, '');
                echo '</table>';
            }else{
                if ($response->CompletedTrackDetails->HighestSeverity != 'SUCCESS'){
                    echo '<table border="1">';
                    echo '<tr><th>Shipment Level Tracking Details</th><th>&nbsp;</th></tr>';
                    $this->trackDetails($response->CompletedTrackDetails, '');
                    echo '</table>';
                }else{
                    echo '<table border="1">';
                    echo '<tr><th>Package Level Tracking Details</th><th>&nbsp;</th></tr>';
                    $this->trackDetails($response->CompletedTrackDetails->TrackDetails, '');
                    echo '</table>';
                }
            }
//            printSuccess($client, $response);
        }else{
//            printError($client, $response);
        }
    }

    function trackDetails($details, $spacer){
        foreach($details as $key => $value){
            if(is_array($value) || is_object($value)){
                $newSpacer = $spacer. '&nbsp;&nbsp;&nbsp;&nbsp;';
                echo '<tr><td>'. $spacer . $key.'</td><td>&nbsp;</td></tr>';
                $this->trackDetails($value, $newSpacer);
            }elseif(empty($value)){
                echo '<tr><td>'.$spacer. $key .'</td><td>'.$value.'</td></tr>';
            }else{
                echo '<tr><td>'.$spacer. $key .'</td><td>'.$value.'</td></tr>';
            }
        }
    }*/
}
