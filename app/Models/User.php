<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users'; // Nama tabelmu
    protected $primaryKey = 'iduser'; // INI WAJIB ADA

    protected $fillable = [
        'nama', 
        'email', 
        'password', 
        'role', // Tambahkan ini agar tidak error saat create
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];
}