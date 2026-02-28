<?php

namespace App\Http\Controllers\Admin; 
use App\Http\Controllers\Controller; 
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('admin.barang.index', compact('barang'));
    }

    public function cetak(Request $request)
    {
        $barang = \App\Models\Barang::whereIn('id_barang', $request->ids)->get(); 

        $skip = (($request->y - 1) * 5) + ($request->x - 1);

        $customPaper = [0, 0, 595.28, 467.72]; 

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.tag_harga', compact('barang', 'skip'))
                ->setPaper($customPaper, 'portrait');

        return $pdf->stream('Tag_Harga_TnJ_108.pdf');
    }
    public function create()
    {
        return view('admin.barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'harga' => 'required|numeric',
        ]);

        Barang::create($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambah!');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'harga' => 'required|numeric',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate!');
    }

    public function destroy($id)
    {
        Barang::findOrFail($id)->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }
}