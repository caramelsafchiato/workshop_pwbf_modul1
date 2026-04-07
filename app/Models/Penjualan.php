<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $fillable = ['tgl_penjualan', 'total_harga'];

    // Relasi ke detail (opsional, tapi berguna untuk laporan nanti)
    public function detail()
    {
        return $this->hasMany(PenjualanDetail::class, 'id_penjualan', 'id_penjualan');
    }
}