<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessUser extends Model
{
    protected $table = 'business_users';
    protected $connection = 'digicom';
    protected $fillable = [
        'name', 'email', 'password',
        'phone', 'active', 'created_at',
        'updated_at'
    ];
}
