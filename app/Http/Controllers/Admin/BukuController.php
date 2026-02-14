<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Wajib diimport untuk Query Builder

class BukuController extends Controller
{
    public function index()
    {
        // Query Builder dengan Join untuk mengambil nama kategori
        $buku = DB::table('buku')
            ->join('kategori', 'buku.idkategori', '=', 'kategori.idkategori')
            ->select('buku.*', 'kategori.nama_kategori')
            ->get(); 
        
        return view('admin.buku.index', compact('buku'));
    }

    public function create() {
        // Mengambil semua data kategori untuk dropdown
        $kategori = DB::table('kategori')->get(); 
        return view('admin.buku.create', compact('kategori'));
    }

    public function store(Request $request) {
        $request->validate([
            'kode' => 'required|unique:buku,kode',
            'judul' => 'required',
            'idkategori' => 'required'
        ]);

        // Query Builder menggunakan insert (kecuali _token)
        DB::table('buku')->insert([
            'kode'       => $request->kode,
            'judul'      => $request->judul,
            'pengarang'  => $request->pengarang,
            'idkategori' => $request->idkategori,
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambah!');
    }

    public function edit($id) {
        // Mencari satu data buku berdasarkan idkategori (ID primer)
        $buku = DB::table('buku')->where('idbuku', $id)->first();
        
        if (!$buku) {
            abort(404); // Pengganti findOrFail
        }

        $kategori = DB::table('kategori')->get();
        return view('admin.buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'kode' => 'required|unique:buku,kode,'.$id.',idbuku',
            'judul' => 'required',
            'idkategori' => 'required'
        ]);

        // Update data berdasarkan idbuku
        DB::table('buku')->where('idbuku', $id)->update([
            'kode'       => $request->kode,
            'judul'      => $request->judul,
            'pengarang'  => $request->pengarang,
            'idkategori' => $request->idkategori,
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy($id) {
        // Hapus data secara langsung
        DB::table('buku')->where('idbuku', $id)->delete();
        
        return redirect()->route('buku.index')->with('success', 'Buku dihapus!');
    }
}