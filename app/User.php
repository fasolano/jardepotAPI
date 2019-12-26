<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateToken(){
        $token = Str::random(60);
        $this->api_token = hash('sha256', $token);
        $this->save();

        return $this->api_token;
    }

    public function updateMail(){
        $this->email = "guest".$this->id."@jardepot.com";
        $this->save();

        return $this->email;
    }

    public function getUserByTokenAndId($id, $token){
        $user = DB::table('users')
            ->select('*')
            ->where(['api_token' => $token, 'id' => $id])
            ->first();

        return $user;
    }

    public function getSession($carrito){
        return ['api_token'=>$this->api_token, 'user' => $this->id, 'carrito' => $carrito];
    }

}
