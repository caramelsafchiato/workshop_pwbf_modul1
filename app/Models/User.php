<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'iduser'; 

    protected $fillable = [
        'nama', 
        'email', 
        'password', 
        'role', 
        'id_google', 
        'otp',       
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];
}