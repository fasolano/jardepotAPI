<?php


namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CheckoutRepository {

    public function insertClient($cliente){
        $clientRegistered = DB::connection('digicom')
            ->table('clientes_jardepot')
            ->select('*')
            ->where([
                'correo' => $cliente['email'],
                // 'telefono' => $cliente['telefono']
            ])
            ->first();

        if(!is_object($clientRegistered)){
            $date = date('Y-m-d H:i:s');
            $clientRegistered = DB::connection('digicom')
                ->table('clientes_jardepot')
                ->insertGetId([
                    'nombre' => $cliente['nombre']." ".$cliente['apellidos'],
                    'correo' => $cliente['email'],
                    'telefono' => $cliente['telefono'],
                    'estado' => $cliente['estado'],
                    'ciudad' => $cliente['ciudad'],
                    'tipo' => 1,
                    'comentarios' => "Se registro a través de un pedido en la página web",
                    'origen' => 2,
                    'idUsuarios' => 2,
                    'fecha' => $date
                ]);
        }else{
//            echo 'entro a else object:'.$clientRegistered->idClientes;
            $clientRegistered = $clientRegistered->idClientes;
        }
        return $clientRegistered;
    }

    public function insertOrder($client, $cart, $deliveryMethod){
        $date = date('Y-m-d H:i:s');
        $total = $cart->total;
        if($cart->total < $deliveryMethod->deliveryMethod->min){
            $total = $deliveryMethod->deliveryMethod->cost + $cart->total;
        }
        // $total *= 1.04;
        $total = round($total, 2);
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

    public function insertWebOrder($order, $cart, $payment){
        $token = hash('sha256', Str::random(60));
        $order = DB::connection('digicom')
            ->table('pedidos_web')
            ->insertGetId([
                'idPedidos' => $order->idPedidos,
                'fk_carrito' => $cart->id_carrito,
                'medio_pago' => $payment,
                'token' => $token
            ]);

        $order = DB::connection('digicom')
            ->table('pedidos_web')
            ->select('*')
            ->where('id_pedidos_web', $order)
            ->first();

        return $order;
    }

    public function setSellerToOrder($order){
        // $mails = array("ventas10@jardepot.com","ventas@jardepot.com","ventas1@jardepot.com", "ventas2@jardepot.com", "ventas4@jardepot.com");
        $mails = ["ventas10@jardepot.com"];
        $mailsSent = DB::connection('digicom')
            ->table('pedidos_web')
            ->select(DB::raw('count(fk_vendedor) as cant'), 'fk_vendedor')
            ->whereNotNull('fk_vendedor')
            ->groupBy('fk_vendedor')
            ->get();
        $min = 100000000;
        $mailMin = 0;
        foreach ($mailsSent as $item) {
            if($item->cant < $min){
                $min = $item->cant;
                $mailMin = $item->fk_vendedor;
            }
        }
        DB::connection('digicom')
            ->table('pedidos_web')
            ->where(['idPedidos' => $order])
            ->update(['fk_vendedor' => $mailMin]);
        $mailMin = $mails[$mailMin];
        return $mailMin;
    }

    public function insertProductsOrder($order, $products, $deliveryMethod){
        $idPedidos = $order->idPedidos;
        foreach ($products as $product) {
            if($product->offer == 'si'){
                $precio = $product->oferta;
            }else{
                $precio = $product->price;
            }
//            $precio = $product->cantidad * $precio;
            // $precio *= 1.04;
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
            // $precioEnvio = $deliveryMethod->deliveryMethod->cost * 1.04;
            $precioEnvio = $deliveryMethod->deliveryMethod->cost;
            $orderProductInserted = DB::connection('digicom')
                ->table('productosPedidos_jardepot')
                ->insertGetId([
                    'idPedidos' => $idPedidos,
                    'cantidad' => 1,
                    'nombre' => 'Manejo de Mercancía Envío paquetería',
                    'precio' => $precioEnvio
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
                $precio = $product->price;
            }

            $rowInserted = DB::connection('digicom')
                ->table('productosCotizados_jardepot')
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
                ->table('productosCotizados_jardepot')
                ->insertGetId([
                    'idCotizaciones' => $quotation->idCotizaciones,
                    'cantidad' => 1,
                    'nombre' => 'Manejo de Mercancía Envío paquetería',
                    'precio' => $deliveryMethod->deliveryMethod->cost *1.04,
                    'marca' => '',
                    'iva' => 'no'
                ]);
        }
        return $rowInserted;
    }
    public function checkQuotation($client, $total,$id_carrito, $deliveryMethod){
        if($total < $deliveryMethod->deliveryMethod->min){
            $total = $total + $deliveryMethod->deliveryMethod->cost;
        }
        $quotationRegistered = DB::connection('digicom')
        ->table('cotizaciones_jardepot') ->select('*')
        ->where([
            'idClientes' => $client,
            'total'=>$total
        ])->first();

        if(!is_object($quotationRegistered)){
            return array('exist'=>'false');
        }else{
            $cartRepository = new CartRepository();
            $products = $cartRepository->getProductsFromCart($id_carrito);

            $productsRegistered = DB::connection('digicom')
                ->table('productosCotizados_jardepot')->select('*')
                ->where('idCotizaciones', $quotationRegistered->idCotizaciones)
                ->get();
            $countRegistered=count($productsRegistered);
            $count=0;
            foreach ($products as $product){
                foreach ($productsRegistered as $registered){
                    if($registered->nombre =='Manejo de Mercancía Envío paquetería'){
                        $count++;
                    }
                    if ($product->producto == $registered->nombre){
                        $count++;
                    }
                }
            }
            if ($countRegistered == $count){
                return array('exist'=>'true','quotation'=>$quotationRegistered);
            }else{
                return array('exist'=>'false');
            }
        }
    }

    public function insertDeliveryBilling($data){
        $rowInserted = DB::connection('digicom')
            ->table('datosEnvioYFacturacion_jardepot')
            ->insertGetId($data);
        return $rowInserted;
    }

}
