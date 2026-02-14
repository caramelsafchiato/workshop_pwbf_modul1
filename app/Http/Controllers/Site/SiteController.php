<?php

namespace App\Http\Controllers\Site; // Perhatikan folder 'Site'

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Tambahkan ini biar bisa cek DB

class SiteController extends Controller
{
    public function index()
    {
        return view('index'); // Ini buat halaman depan kamu
    }

    public function cekKoneksi()
    {
        try {
            DB::connection()->getPdo();
            return 'Koneksi ke database berhasil!';
        } catch (\Exception $e) {
            return 'Koneksi ke database gagal: ' . $e->getMessage();
        }
    }
}