<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // WAJIB ADA

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil angka total
        $totalBuku = DB::table('buku')->count(); 
        $totalKategori = DB::table('kategori')->count();
        $totalPenulis = DB::table('buku')->distinct('pengarang')->count('pengarang');

        // 2. Ambil data terbaru dengan JOIN
        // Ingat: Query Builder tidak punya relasi 'kategori', jadi harus JOIN manual
        $bukuTerbaru = DB::table('buku')
            ->join('kategori', 'buku.idkategori', '=', 'kategori.idkategori')
            ->select('buku.*', 'kategori.nama_kategori') // Menarik nama_kategori ke dalam objek buku
            ->orderBy('idbuku', 'desc')
            ->limit(5)
            ->get();

        // 3. Kirim ke View
        return view('admin.dashboard.index', compact(
            'totalBuku', 
            'totalKategori', 
            'totalPenulis', 
            'bukuTerbaru'
        ));
    }
}