<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LokasiToko extends Model
{
    protected $table = 'lokasi_toko';
    protected $primaryKey = 'barcode';
    public $incrementing = true; 
    public $timestamps = false;
    protected $fillable = [
        'nama_toko',
        'latitude',
        'longitude',
        'accuracy',
    ];
}