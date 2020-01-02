<?php


namespace App\Repositories;
use Illuminate\Support\Facades\DB;


class CheckoutRepository {

    public function insertClient($cliente){
        $client = DB::connection('digicom')
            ->table('clientes_jardepot')
            ->insertGetId([
                'nombre' => $cliente['nombre']." ".$cliente['apellidos'],
                'correo' => $cliente['email'],
                'telefono' => $cliente['telefono'],
                'estado' => $cliente['estado'],
                'ciudad' => $cliente['ciudad'],
                'tipo' => 1,
                'comentarios' => "Se registro a través de un pedido en la página web",
                'idUsuarios' => 2
            ]);

        return $client;
    }

    public function insertOrder($client, $cart){
        $date = date('Y-m-d H:i:s');

        $order = DB::connection('digicom')
            ->table('pedidos_jardepot')
            ->insertGetId([
                'idClientes' => $client,
                'descuento' => 0,
                'fecha' => $date,
                'total' => $cart->total,
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
        $idPedidos=$order->idPedidos;
        foreach ($products as $product) {
            if($product->offer == 'si'){
                $precio = $product->oferta;
            }else{
                $precio = $product->priceweb;
            }
            $precio = $product->cantidad * $precio;
            $order = DB::connection('digicom')
                ->table('productosPedidos_jardepot')
                ->insertGetId([
                    'idPedidos' => $idPedidos,
                    'cantidad' => $product->cantidad,
                    'nombre' => $product->producto,
                    'precio' => $precio
                ]);
        }
    }

}
