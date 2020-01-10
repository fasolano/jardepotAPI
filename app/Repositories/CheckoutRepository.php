<?php


namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


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

    public function insertOrder($client, $cart, $deliveryMethod){
        $date = date('Y-m-d H:i:s');
        if($cart->total < $deliveryMethod->deliveryMethod->min){
            $total = $deliveryMethod->deliveryMethod->cost + $cart->total;
        }
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

    public function insertWebOrder($order, $cart){
        $token = hash('sha256', Str::random(60));
        $order = DB::connection('digicom')
            ->table('pedidos_web')
            ->insertGetId([
                'idPedidos' => $order->idPedidos,
                'fk_carrito' => $cart->id_carrito,
                'token' => $token
            ]);

        $order = DB::connection('digicom')
            ->table('pedidos_web')
            ->select('*')
            ->where('id_pedidos_web', $order)
            ->first();

        return $order;
    }

    public function insertProductsOrder($order, $products, $deliveryMethod){
        $idPedidos = $order->idPedidos;
        foreach ($products as $product) {
            if($product->offer == 'si'){
                $precio = $product->oferta;
            }else{
                $precio = $product->priceweb;
            }
            $precio = $product->cantidad * $precio;
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
        if($order->total < $deliveryMethod->deliveryMethod->min){
            $orderProductInserted = DB::connection('digicom')
                ->table('productosPedidos_jardepot')
                ->insertGetId([
                    'idPedidos' => $idPedidos,
                    'cantidad' => 1,
                    'nombre' => 'Manejo de Mercancía Envío paquetería',
                    'precio' => $deliveryMethod->deliveryMethod->cost
                ]);
        }
    }

    public function insertQuotation($client, $total, $deliveryMethod){
        if($total < $deliveryMethod->deliveryMethod->min){
            $total = $total + $deliveryMethod->deliveryMethod->cost;
        }
        $date = date('Y-m-d H:i:s');
        $rowInserted = DB::connection('digicom')
            ->table('cotizaciones_jardepot')
            ->insertGetId([
                'idClientes' => $client,
                'fecha' => $date,
                'total' => $total,
                'idusuario' => 2
            ]);
        DB::connection('digicom')
            ->table('seguimiento_cotizacion')
            ->insertGetId([
                'fk_cotizacion' => $rowInserted
            ]);

        $bandera = false;
        while(!$bandera){
            //genera la clave
            $clave = substr(str_shuffle(MD5(microtime())), 0, 5);
            while (is_numeric($clave)){
                $clave = substr(str_shuffle(MD5(microtime())), 0, 5);
            }
            $claveSelect = DB::connection('digicom')
                ->table('clavesWebCotizaciones_jardepot')
                ->select('clave')
                ->where('clave', $clave)
                ->get();
            if(count($claveSelect) == 0){
                $bandera = true;
            }

        }

        DB::connection('digicom')
            ->table('clavesWebCotizaciones_jardepot')
            ->insertGetId([
                'idCotizaciones' => $rowInserted,
                'clave' => $clave
            ]);

        $rowInserted = DB::connection('digicom')
            ->table('cotizaciones_jardepot')
            ->select('*')
            ->where('idCotizaciones', $rowInserted)
            ->first();

        $rowInserted->clave = $clave;
        return $rowInserted;
    }

    public function insertProductsQuotation($products, $quotation, $deliveryMethod){
        foreach ($products as $product) {
            if($product->offer == 'si'){
                $precio = $product->oferta;
            }else{
                $precio = $product->priceweb;
            }
            $rowInserted = DB::connection('digicom')
                ->table('productoscotizados_jardepot')
                ->insertGetId([
                    'idCotizaciones' => $quotation->idCotizaciones,
                    'cantidad' => $product->cantidad,
                    'nombre' => $product->producto,
                    'precio' => $precio,
                    'marca' => $product->brand,
                    'iva' => 'no'
                ]);
        }
        if($quotation->total < $deliveryMethod->deliveryMethod->min){
            $rowInserted = DB::connection('digicom')
                ->table('productoscotizados_jardepot')
                ->insertGetId([
                    'idCotizaciones' => $quotation->idCotizaciones,
                    'cantidad' => 1,
                    'nombre' => 'Manejo de Mercancía Envío paquetería',
                    'precio' => $deliveryMethod->deliveryMethod->cost,
                    'marca' => '',
                    'iva' => 'no'
                ]);
        }
        return $rowInserted;
    }

    public function insertDeliveryBilling($data){
        $rowInserted = DB::connection('digicom')
            ->table('datosenvioyfacturacion_jardepot')
            ->insertGetId($data);
        return $rowInserted;
    }

}
