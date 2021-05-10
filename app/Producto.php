<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "productos";

    public function getComentariosAttribute(){
        $producto = $this->productType . " " . $this->brand . " " . $this->mpn;
        $comentarios = ComentarioProducto::where('producto', $producto)->get();
        return $comentarios;
    }
}
