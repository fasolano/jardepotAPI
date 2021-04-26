<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteJardepot extends Model
{
    protected $table = 'clientes_jardepot';
    protected $connection = 'digicom';
    protected $fillable = [
        'nombre', 'telefono', 'correo',
        'idBusiness', 'fecha',
    ];
    public $timestamps = false;
}
