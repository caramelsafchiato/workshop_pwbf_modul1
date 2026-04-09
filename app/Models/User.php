<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // 1. Kasih tahu Laravel kalau Primary Key-nya iduser
    protected $primaryKey = 'iduser';

    // 2. Daftarkan kolom agar bisa diisi (Mass Assignment)
    protected $fillable = [
        'nama', 
        'email', 
        'password', 
        'role', 
        'idvendor'
    ];
    
    // Jangan lupa ini kalau kamu nggak pakai id (standard)
    public $incrementing = true;
}