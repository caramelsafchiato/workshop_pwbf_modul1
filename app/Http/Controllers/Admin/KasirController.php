<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;

class KasirController extends Controller
{
    public function indexAjax() {
        $barang = DB::table('barang')->get();
        return view('admin.kasir.ajax', compact('barang'));
    }

    public function indexAxios() {
        $barang = DB::table('barang')->get();
        return view('admin.kasir.axios', compact('barang'));
    }

    public function cekBarang(Request $request) {
        $barang = DB::table('barang')->where('id_barang', $request->id_barang)->first();
        if ($barang) {
            return response()->json(['status' => 'success', 'data' => $barang]); 
        }
        return response()->json(['status' => 'error'], 404);
    }

    public function bayar(Request $request) {
        DB::beginTransaction();
        try {
            $penjualan = Penjualan::create([
                'tgl_penjualan' => now(),
                'total_harga' => $request->total
            ]);

            foreach ($request->cart as $item) {
                PenjualanDetail::create([
                    'id_penjualan' => $penjualan->id_penjualan,
                    'id_barang' => $item['id_barang'],
                    'qty' => $item['qty'],
                    'harga_jual' => $item['harga']
                ]);
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Berhasil']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}