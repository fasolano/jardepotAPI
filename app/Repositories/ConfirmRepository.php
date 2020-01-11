<?php


namespace App\Repositories;


use Illuminate\Support\Facades\DB;


class ConfirmRepository {

    public function verifyTokenAndPaymentMethod($payment, $token){
        $webOrder = DB::connection('digicom')
            ->table('pedidos_web as a')
            ->select('*')
            ->where([
                'token' => $token,
                'medio_pago' => $payment
            ])
            ->first();
        return $webOrder;
    }

    public function createDeposit($total, $order, $payment){
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

        return $deposit;
    }

}
