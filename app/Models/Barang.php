<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['nama', 'harga'];

    protected static function booted()
    {
        static::creating(function ($barang) {
            $today = Carbon::now()->format('ymd'); 
            
            $count = static::whereDate('timestamp', Carbon::today())->count();
            
            $barang->id_barang = $today . str_pad($count + 1, 2, '0', STR_PAD_LEFT);
            $barang->timestamp = Carbon::now();
        });
    }
}