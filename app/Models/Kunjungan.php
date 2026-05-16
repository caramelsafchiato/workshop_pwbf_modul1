<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';
    protected $primaryKey = 'id'; 
    public $incrementing = true; 
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'toko_id',
        'lat',
        'lng',
        'accuracy',
        'distance',
        'accepted'
    ];
}