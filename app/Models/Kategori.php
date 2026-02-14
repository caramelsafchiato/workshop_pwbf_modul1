<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori'; // Nama tabel di DB
    protected $primaryKey = 'idkategori'; // PK kustom kamu
    public $timestamps = false; // Karena di SQL kamu tidak ada created_at/updated_at

    protected $fillable = ['nama_kategori'];

    // Relasi: Satu kategori punya banyak buku
    public function buku()
    {
        return $this->hasMany(Buku::class, 'idkategori', 'idkategori');
    }
}