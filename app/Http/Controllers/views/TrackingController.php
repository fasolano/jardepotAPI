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
        if (isset($_POST['form'])){
            $guias = $this->trackingRepository->getGuia(json_decode($_POST['form']));
            if(isset($guia)){
                return ['status'=>'success','data'=>$guias];
            }else{
                return ['status'=>'notfound','data'=>$guias];
            }
        }else{
            return ['status'=>'error'];
        }
    }
}
