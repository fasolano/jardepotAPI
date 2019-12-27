<?php


namespace App\Repositories;
use Illuminate\Support\Facades\DB;


class CheckoutRepository {

    public function insertClient($cliente){
        $client = DB::connection('digicom')
            ->table('clientes_jardepot')
            ->insertGetId([
                'nombre' => $cliente['nombre']." ".$cliente['apellido'],
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
                'fecha' => $date,
                'total' => $cart->total,
                'estado' => 1,
                'idusuario' => 2
            ]);

        return $order;
    }

    public function insertProductsOrder($order, $products){
        $date = date('Y-m-d H:i:s');
        foreach ($products as $product) {
            $order = DB::connection('digicom')
                ->table('productosPedidos_jardepot')
                ->insertGetId([
                    'idClientes' => $client,
                    'fecha' => $date,
                    'total' => $cart->total,
                    'estado' => 1,
                    'idusuario' => 2
                ]);
            return $order;
        }

    }

}
