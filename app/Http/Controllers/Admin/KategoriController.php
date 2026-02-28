<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = DB::table('kategori')->get(); 
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100'
        ]);

        DB::table('kategori')->insert([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = DB::table('kategori')->where('idkategori', $id)->first();
        
        if (!$kategori) {
            abort(404);
        }

        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100'
        ]);

        DB::table('kategori')->where('idkategori', $id)->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::table('kategori')->where('idkategori', $id)->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}