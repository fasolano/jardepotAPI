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
                'id_carrito' => $webOrder->fk_carrito
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

    public function insertOrder($client, $cart){
        $date = date('Y-m-d H:i:s');
        $total = $cart->total;
        if($cart->total < 3000){
            $total = 300 + $cart->total;
        }
        $total *= 1.04;
        $order = DB::connection('digicom')
            ->table('pedidos_jardepot')
            ->insertGetId([
                'idClientes' => $client,
                'descuento' => 0,
                'fecha' => $date,
                'total' => $total,
                'estado' => 1,
                'idusuario' => 2
            ]);

        $order = DB::connection('digicom')
            ->table('pedidos_jardepot')
            ->select('*')
            ->where('idPedidos', $order)
            ->first();

        return $order;
    }

    public function insertProductsOrder($order, $products){
        $idPedidos = $order->idPedidos;
        foreach ($products as $product) {
            if($product->offer == 'si'){
                $precio = $product->oferta;
            }else{
                $precio = $product->price;
            }
//            $precio = $product->cantidad * $precio;
            $precio *= 1.04;
            $orderProductInserted = DB::connection('digicom')
                ->table('productosPedidos_jardepot')
                ->insertGetId([
                    'idPedidos' => $idPedidos,
                    'cantidad' => $product->cantidad,
                    'nombre' => $product->producto,
                    'precio' => $precio
                ]);
        }
        // Despues de haber insertado productos evalua si es necesario cobrar envio de ser así se agrega a la orden
        if($order->total < 3000){
            $orderProductInserted = DB::connection('digicom')
                ->table('productosPedidos_jardepot')
                ->insertGetId([
                    'idPedidos' => $idPedidos,
                    'cantidad' => 1,
                    'nombre' => 'Manejo de Mercancía Envío paquetería',
                    'precio' => 300 * 1.04
                ]);
        }
    }

}
