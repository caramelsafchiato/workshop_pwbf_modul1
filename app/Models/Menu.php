<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    // 1. Kasih tahu nama tabelnya (karena bukan 'menus')
    protected $table = 'menu';

    // 2. Kasih tahu Primary Key-nya (karena bukan 'id')
    protected $primaryKey = 'idmenu';

    // 3. INI SOLUSINYA: Matikan fitur pencatatan waktu otomatis
    public $timestamps = false;

    // 4. Pastikan kolom ini bisa diisi (Mass Assignment)
    protected $fillable = [
        'nama_menu', 
        'harga', 
        'idvendor', 
        'path_gambar'
    ];

    // Relasi ke Vendor (Biar gak error pas nampilin nama vendor)
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'idvendor', 'idvendor');
    }
}