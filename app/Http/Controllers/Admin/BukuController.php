<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class BukuController extends Controller
{
    public function index()
    {
        $buku = DB::table('buku')
            ->join('kategori', 'buku.idkategori', '=', 'kategori.idkategori')
            ->select('buku.*', 'kategori.nama_kategori')
            ->get(); 
        
        return view('admin.buku.index', compact('buku'));
    }

    public function create() {
        $kategori = DB::table('kategori')->get(); 
        return view('admin.buku.create', compact('kategori'));
    }

    public function store(Request $request) {
        $request->validate([
            'kode' => 'required|unique:buku,kode',
            'judul' => 'required',
            'idkategori' => 'required'
        ]);

        DB::table('buku')->insert([
            'kode'       => $request->kode,
            'judul'      => $request->judul,
            'pengarang'  => $request->pengarang,
            'idkategori' => $request->idkategori,
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambah!');
    }

    public function edit($id) {
        $buku = DB::table('buku')->where('idbuku', $id)->first();
        
        if (!$buku) {
            abort(404);
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

        DB::table('buku')->where('idbuku', $id)->update([
            'kode'       => $request->kode,
            'judul'      => $request->judul,
            'pengarang'  => $request->pengarang,
            'idkategori' => $request->idkategori,
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy($id) {
        DB::table('buku')->where('idbuku', $id)->delete();
        
        return redirect()->route('buku.index')->with('success', 'Buku dihapus!');
    }
}