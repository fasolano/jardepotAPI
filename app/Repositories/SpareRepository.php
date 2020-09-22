<?php


namespace App\Repositories;


use Illuminate\Support\Facades\DB;

class SpareRepository {

    public function getIpls($productType, $brand, $mpn){
        $data = DB::table('ipl')
            ->select('*')
            ->where([
                'productType' => $productType,
                'brand' => $brand,
                'mpn' => $mpn
            ])->get();

        return $data;
    }

    public function getMarcadores($ipl){
        $data = DB::table('ipl_ubicacion')
            ->join('pieza', 'ipl_ubicacion.fk_pieza', '=', 'pieza.id_pieza')
            ->select('ipl_ubicacion.indice_ipl',
                'ipl_ubicacion.latitud',
                'ipl_ubicacion.longitud',
                'ipl_ubicacion.comentario as coment',
                'pieza.id_pieza as pieza',
                'pieza.nombre',
                'pieza.precio',
                'pieza.codigo',
                'pieza.comentario')
            ->where([
                'ipl_ubicacion.fk_ipl' => $ipl
            ])
            ->orderBy('ipl_ubicacion.indice_ipl', 'asc')
            ->get();
        return $data;
    }

    public function addPieza($pieza, $cantidad, $modelo){
        $carrito = session('carrito', null);
        if ($carrito !== null) {
            if (isset($carrito[$pieza])) {
                $carrito[$pieza]['cantidad'] += $cantidad;
                $carrito[$pieza]['modelo'] = $modelo;
            }elseif ($cantidad > 0) {
                $carrito[$pieza]['cantidad'] = $cantidad;
                $carrito[$pieza]['modelo'] = $modelo;
            }else{
                return 0;
            }
            session(['carrito'=>$carrito]);
            return  $carrito[$pieza]['cantidad'];
        }elseif ($cantidad > 0) {
            $carrito[$pieza]['cantidad'] = $cantidad;
            $carrito[$pieza]['modelo'] = $modelo;
            session(['carrito'=>$carrito]);
            return $carrito[$pieza]['cantidad'];
        }else{
            return 0;
        }

    }

    public function getCarrito($carrito){
        $refacciones = array();
        foreach($carrito as $key => $item){
            array_push($refacciones, $key);
        }
        $data = DB::table('pieza')
            ->select('pieza.id_pieza as pieza',
                'pieza.nombre',
                'pieza.brand',
                'pieza.precio',
                'pieza.codigo',
                'pieza.comentario')
            ->whereIn('id_pieza', $refacciones)
            ->get();
        foreach ($data as $key => $item) {
            $data[$key]->cantidad = '<div class="quantity">
                                      <input type="number" min="1" step="1" value="'.$carrito[$item->pieza]['cantidad'].'" data-pieza="'.$item->pieza.'" readonly>
                                      <div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>
                                    </div>';
            $data[$key]->subtotal = "$ ".number_format(($carrito[$item->pieza]['cantidad'] * $item->precio), 2, '.', ',');
            $carrito[$item->pieza]['subtotal'] = $item->precio * $carrito[$item->pieza]['cantidad'];
            $data[$key]->opcion = '<button class="btn btn-xs btn-danger borrarRefaccion" data-pieza="'.$item->pieza.'"><i class="fa fa-trash"></i></button>';
            unset($data[$key]->pieza);
        }
        return $data;
    }

    public function getRefaccion($id, $cantidad){
        $carrito = session('carrito', null);
        $data = DB::table('pieza')
            ->select('pieza.id_pieza as pieza',
                'pieza.nombre',
                'pieza.brand',
                'pieza.precio',
                'pieza.codigo',
                'pieza.comentario')
            ->where(['id_pieza' => $id])
            ->get();
        foreach ($data as $key => $item) {
            $data[$key]->cantidad = '<div class="quantity">
                                      <input type="number" min="1" step="1" value="'.$cantidad.'" data-pieza="'.$item->pieza.'" readonly>
                                      <div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>
                                    </div>';

            $carrito[$item->pieza]['subtotal'] = $cantidad * $item->precio;

            $data[$key]->subtotal = "$ ".number_format(($cantidad * $item->precio), 2, '.', ',');
            $data[$key]->precio = "$ ".$item->precio;
            $data[$key]->opcion = '<button class="btn btn-xs btn-danger borrarRefaccion" data-pieza="'.$item->pieza.'"><i class="fa fa-trash"></i></button>';

            unset($data[$key]->pieza);
        }
        session(['carrito'=>$carrito]);
        return $data[0];
    }

    public function deleteRefaccion($id){
        $carrito = session('carrito', null);
        if ($carrito !== null) {
            if (isset($carrito[$id])){
                unset($carrito[$id]);
                session(['carrito'=>$carrito]);
                $total = $this->actualizarTotal();
                $total = number_format($total, 2, '.', ',');
                return json_encode(['numero' => count($carrito)-1, 'status' => 1, 'total' => $total]);
            }else{
                return json_encode(['numero' => count($carrito)-1, 'status' => 0]);
            }
        }else{
            return json_encode(['numero' => count($carrito)-1, 'status' => 0]);
        }
    }

    public function actualizarTotal(){
        $carrito = session('carrito');
        $total = 0;
        foreach ($carrito as $key => $item) {
            $total += $item['subtotal'];
        }
        $carrito['total'] = $total;
        session(['carrito'=>$carrito]);
        return $total;
    }

    public function enviarCotizacion($nombre, $telefono, $mail, $comentarios){
        $carritoViejo = session('carrito', null);
        $total = $carritoViejo['total'];
        $total = number_format($total, 2, '.', ',');
        unset($carritoViejo['total']);
        $carrito = array();
        foreach ($carritoViejo as $key => $item) {
            $refaccion = DB::table('pieza')->select('*')->where(['id_pieza' => $key])->get()[0];
            $refaccion->subtotal = number_format($item['subtotal'], 2, '.', ',');
            $refaccion->cantidad = $item['cantidad'];
            $refaccion->modelo = $item['modelo'];
            array_push($carrito, $refaccion);
        }

        $destino = "fasolanof@gmail.com";
        //        $destino = "ventas4@jardepot.com";

        $data = [
            'nombre' => $nombre,
            'telefono' => $telefono,
            'mail' => $mail,
            'comentario' => $comentarios,
            'carrito' => $carrito,
            'total' => $total
        ];
        Mail::send('mailRefacciones', $data, function ($message) use ($destino) {
            $message->to($destino)->subject
            ('Consulta de refacciones en Jardepot');
            $message->from('sistemas1@jardepot.com', 'Sitemas Jardepot');
        });
    }

}
