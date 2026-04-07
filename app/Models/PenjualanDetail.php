<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $table = 'penjualan_detail';
    protected $primaryKey = 'id_detail';
    protected $fillable = ['id_penjualan', 'id_barang', 'qty', 'harga_jual']; // WAJIB ADA INI

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}