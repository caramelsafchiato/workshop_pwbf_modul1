<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Wajib untuk Query Builder

class KategoriController extends Controller
{
    // 1. Menampilkan Tabel
    public function index()
    {
        // Pengganti Kategori::all()
        $kategori = DB::table('kategori')->get(); 
        return view('admin.kategori.index', compact('kategori'));
    }

    // 2. Menampilkan Form Tambah
    public function create()
    {
        return view('admin.kategori.create');
    }

    // 3. Menyimpan Data Baru ke Database
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100'
        ]);

        // Hapus bagian created_at dan updated_at
        DB::table('kategori')->insert([
            'nama_kategori' => $request->nama_kategori
            // Tidak perlu now() karena kolomnya tidak ada di DB
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    // 4. Menampilkan Form Edit
    public function edit($id)
    {
        // Mencari data berdasarkan primary key 'idkategori'
        $kategori = DB::table('kategori')->where('idkategori', $id)->first();
        
        if (!$kategori) {
            abort(404); // Pengganti findOrFail
        }

        return view('admin.kategori.edit', compact('kategori'));
    }

    // 5. Memproses Perubahan Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100'
        ]);

        // Update data berdasarkan idkategori
        DB::table('kategori')->where('idkategori', $id)->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // 6. Menghapus Data
    public function destroy($id)
    {
        // Menghapus data langsung dari tabel
        DB::table('kategori')->where('idkategori', $id)->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}