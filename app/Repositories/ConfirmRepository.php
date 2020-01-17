<?php


namespace App\Repositories;


use Illuminate\Support\Facades\DB;


class ConfirmRepository {

    public function verifyTokenAndPaymentMethod($payment, $token){
        $webOrder = DB::connection('digicom')
            ->table('pedidos_web')
            ->join('pedidos_jardepot', 'pedidos_jardepot.idPedidos', '=', 'pedidos_web.idPedidos')
            ->select('pedidos_jardepot.*', 'pedidos_web.fk_carrito')
            ->where([
                'token' => $token,
                'medio_pago' => $payment
            ])
            ->first();
        $validCart = DB::table('carrito')
            ->select('*')
            ->where([
                'id_carrito' => $webOrder->fk_carrito,
                'estado' => 'Pendiente'
            ])
            ->get();
        return count($validCart)?$webOrder:null;
    }

    public function createDeposit($total, $order, $payment, $carrito){
        $date = date('Y-m-d H:i:s');
        $deposit = DB::connection('digicom')
            ->table('depositos_jardepot')
            ->insertGetId([
                'cantidad' => $total,
                'pedido' => $order,
                'usuario' => 2,
                'fecha' => $date,
                'identificado' => 1,
                'forma' => $payment,
                'pagoTransferenciaElectronicaDepositar' => 1,
                'referencia' => 'Pago en linea desde la página web'
            ]);

        DB::connection('digicom')
            ->table('pedidos_jardepot')
            ->where('idPedidos', $order)
            ->update(['estado' => 2]);

        DB::table('carrito')
            ->where('id_carrito', $carrito)
            ->update(['estado' => 'Comprado']);

        return $deposit;
    }

    public function getClientFromToken($token){
        $client = DB::connection('digicom')
            ->table('pedidos_web')
            ->join('pedidos_jardepot', 'pedidos_web.idPedidos', '=', 'pedidos_jardepot.idPedidos')
            ->join('clientes_jardepot', 'pedidos_jardepot.idClientes', '=','clientes_jardepot.idClientes')
            ->select('clientes_jardepot.*')
            ->where(['token' => $token])
            ->first();
        return $client;
    }

}
