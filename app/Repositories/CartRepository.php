<?php


namespace App\Repositories;
use Illuminate\Support\Facades\DB;


class CartRepository{

    public function addCart($user){
        $date = date('Y-m-d H:i:s');
        $cart = DB::table('carrito')
            ->insertGetId([
                'fk_user' => $user->id,
                'alta' => $date
                ]);
        return $cart;
    }

    public function verifyCart($user, $cart){
        $twoDaysBefore = date('Y-m-d H:i:s', strtotime("-2 days"));

        DB::table('users')
            ->leftJoin('carrito', 'carrito.fk_user', '=', 'users.id')
            ->where([
                ['fk_user', '=', $user->id],
                ['api_token', '=', $user->api_token],
                ['alta', '<=', $twoDaysBefore]
            ])
            ->update([
                'estado' => 'Vencido'
            ]);

        $cart = DB::table('users')
            ->leftJoin('carrito', 'carrito.fk_user', '=', 'users.id')
            ->select('id_carrito')
            ->where([
                'fk_user' => $user->id,
                'api_token' => $user->api_token,
                'id_carrito' => $cart,
            ])
            ->orWhere('estado', 'Activo')
            ->orWhere('estado', 'Pendiente')
            ->get();

        return count($cart);
    }

    public function getProductsFromCart($cart){
        $products = DB::table('producto_carrito as pc')
            ->join('productos', function($join){
                $join->on("pc.producto", DB::raw("binary CONCAT(productos.productType,' ',productos.brand,' ',productos.mpn)"));
            })
            ->join("XML", function($join){
                $join->on("productos.productType","=","XML.productType")
                    ->on("productos.brand","=","XML.brand")
                    ->on("productos.mpn","=","XML.mpn");
            })
            ->leftJoin("inventario",function($join){
                $join->on("productos.productType","=","inventario.productType")
                    ->on("productos.brand","=","inventario.brand")
                    ->on("productos.mpn","=","inventario.mpn");
            })
            ->select('pc.producto',
                'pc.cantidad',
                'productos.id',
                'productos.productType',
                'productos.brand',
                'productos.mpn',
                'productos.description',
                'productos.availability',
                'productos.price',
                'productos.oferta',
                'productos.PrecioDeLista',
                'productos.offer',
                'productos.iva',
                'productos.video',
                'productos.volada',
                'productos.visible',
                'XML.keywords',
                'XML.metadesc',
                'XML.descriptionweb',
                'XML.resenia',
                DB::raw('SUM(inventario.cantidad) as cantidadInventario')
            )
            ->where([
                'pc.fk_carrito' => $cart,
                'pc.estado' => 'Activo'
            ])
            ->groupBy(
                'productos.productType',
                'productos.brand','productos.mpn'
            )->get();

        return $products;
    }

    public function getProductsFromCartFinal($cart){
        $products = DB::table('producto_carrito as pc')
            ->join('productos', function($join){
                $join->on("pc.producto", DB::raw("binary CONCAT(productos.productType,' ',productos.brand,' ',productos.mpn)"));
            })
            ->join("XML", function($join){
                $join->on("productos.productType","=","XML.productType")
                    ->on("productos.brand","=","XML.brand")
                    ->on("productos.mpn","=","XML.mpn");
            })
            ->leftJoin("inventario",function($join){
                $join->on("productos.productType","=","inventario.productType")
                    ->on("productos.brand","=","inventario.brand")
                    ->on("productos.mpn","=","inventario.mpn");
            })
            ->select('pc.producto',
                'pc.cantidad',
                'productos.id',
                'productos.productType',
                'productos.brand',
                'productos.mpn',
                'productos.description',
                'productos.availability',
                'productos.price',
                'productos.oferta',
                'productos.PrecioDeLista',
                'productos.offer',
                'productos.iva',
                'productos.video',
                'productos.volada',
                'productos.visible',
                'XML.keywords',
                'XML.metadesc',
                'XML.descriptionweb',
                'XML.resenia',
                DB::raw('SUM(inventario.cantidad) as cantidadInventario')
            )
            ->where([
                'pc.fk_carrito' => $cart
            ])
            ->groupBy(
                'productos.productType',
                'productos.brand','productos.mpn'
            )->get();

        return $products;
    }

    public function addProductCart($cart, $product, $quantity){
        $date = date('Y-m-d H:i:s');
        DB::table('producto_carrito')
            ->updateOrInsert(
                ['fk_carrito' => $cart, 'producto' => $product],
                ['alta' => $date, 'cantidad' => $quantity, 'estado' => 'Activo']
            );

        $productAdded = DB::table('producto_carrito')
            ->select('id_producto_carrito')
            ->where([
                'fk_carrito' => $cart,
                'producto' => $product
            ])->first();

        return $productAdded->id_producto_carrito;
    }

    public function calculateTotalProducts($cart){
        $products = DB::table('producto_carrito')->where(['fk_carrito' => $cart, 'estado' => 'Activo'])->sum('cantidad');
        return $products;
    }

    public function updateCart($cart){
        $products = DB::table('producto_carrito')
            ->select('producto', 'cantidad')
            ->where(['fk_carrito'=> $cart, 'estado' => 'Activo'])
            ->get();
        $totalPrice = 0;
        $totalQuantity = 0;
        foreach ($products as $productCart) {
            $product = DB::table('productos')
                ->select(DB::raw("IF(offer = 'si', (oferta * ".$productCart->cantidad."),
                (price * ".$productCart->cantidad.")) precio"))
                ->whereRaw("concat(productType, ' ', brand, ' ', mpn) = '".$productCart->producto."'")
                ->first();
            $totalPrice += $product->precio;
            $totalQuantity += $productCart->cantidad;
        }

        DB::table('carrito')
            ->where('id_carrito', $cart)
            ->update([
                'total' => $totalPrice,
                'cantidad' => $totalQuantity
            ]);
    }

    /*public function calculateTotalPriceProducts($cart){
        $products = DB::table('producto_carrito')->where(['fk_carrito'=> $cart, 'estado' => 'Activo'])->sum('cantidad');
        return $products;
    }*/

    public function removeProduct($cart, $product){
        DB::table('producto_carrito')
            ->where([
                'fk_carrito' => $cart,
                'producto' => $product
            ])
            ->update(['estado' => 'Eliminado']);
    }

    public function getCart($cart){
        $cart = DB::table('carrito')
            ->select('*')
            ->where(['id_carrito' => $cart])
            ->orWhere([['estado', 'Pendiente'], ['estado','Activo']])
            ->first();
        return $cart;
    }

    public function closeCart($cart){
        DB::table('carrito')
            ->where([
                ['id_carrito', '=', $cart->id_carrito]
            ])
            ->update([
                'estado' => 'Comprado'
            ]);
    }

    public function setSellerToCart($cart){
        $mails = array("ventas@jardepot.com","ventas1@jardepot.com", "ventas2@jardepot.com", "ventas4@jardepot.com");
        $mailsSent = DB::table('carrito')
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

        DB::table('carrito')
            ->where(['id_carrito' => $cart, 'estado' => 'Activo'])
            ->update(['fk_vendedor' => $mailMin]);

        $mailMin = $mails[$mailMin];
        return $mailMin;
    }


}
