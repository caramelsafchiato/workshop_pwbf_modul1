<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    // Nama tabel di PostgreSQL tadi [cite: 13]
    protected $table = 'vendor';

    // Primary Key manual [cite: 14, 15]
    protected $primaryKey = 'idvendor';

    // Kolom yang boleh diisi [cite: 16]
    protected $fillable = ['nama_vendor'];

    // Relasi ke Menu (Satu Vendor punya banyak Menu)
    public function menus()
    {
        return $this->hasMany(Menu::class, 'idvendor', 'idvendor');
    }
}