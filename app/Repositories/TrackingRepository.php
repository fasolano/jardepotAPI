<?php


namespace App\Repositories;
use Illuminate\Support\Facades\DB;

class TrackingRepository
{

    public function getGuia($user){

        $guias = DB::connection('digicom')
            ->table('guias_jardepot')
            ->join('pedidos_jardepot', 'pedidos_jardepot.idPedidos', '=', 'guias_jardepot.idPedidos')
            ->join('clientes_jardepot', 'clientes_jardepot.idClientes', '=', 'pedidos_jardepot.idClientes')
            ->join('paqueterias', 'paqueterias.idPaqueterias', '=', 'guias_jardepot.paqueteria')
            ->select('guias_jardepot.guia','paqueterias.nombre')
            ->where('guias_jardepot.idPedidos',  $user->pedido)
            ->whereRaw("REPLACE(clientes_jardepot.correo,' ','') = ? " ,[$user->email])
            ->orWhere([
                ['clientes_jardepot.telefono', '=', $user->telefono],
                ['clientes_jardepot.celular', '=', $user->telefono],
            ])
            ->get();

//        $guias = DB::connection('digicom')
//            ->table('clientes_jardepot')
//            ->select('*')
//            ->whereRaw("REPLACE(correo,' ','') = ? " ,[$user->email])
//            ->orWhere([
//                ['clientes_jardepot.telefono', '=', $user->telefono],
//                ['clientes_jardepot.celular', '=', $user->telefono],
//            ])
//            ->first();
        return $guias;
    }

}
