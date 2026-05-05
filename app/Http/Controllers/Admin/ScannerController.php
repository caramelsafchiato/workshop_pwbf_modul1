<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ScannerController extends Controller
{
    public function scanBarang() {

    if (Auth::user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Cuma Admin yang bisa scan!');
        }
        return view('admin.scanner.barang');
    }

    public function scanPesanan() {

    if (!Auth::check() || (strtolower(Auth::user()->role) !== 'vendor' && !Auth::user()->idvendor)) {
            return redirect('/')->with('error', 'Cuma Vendor yang bisa scan pesanan!');
        }
        return view('vendor.scanner.pesanan');
    }

    public function getBarangDetail($id) {

        $barangId = trim($id);
        $barang = DB::table('barang')->where('id_barang', $barangId)->first();
        
        if ($barang) {
            return response()->json(['success' => true, 'data' => $barang]);
        }
        return response()->json(['success' => false, 'message' => 'Barang nggak ketemu!']);
    }

    public function getPesananDetail($id) {
        $pesanan = DB::table('pesanan')->where('idpesanan', $id)->first();
        
        if (!$pesanan) {
            return response()->json(['success' => false, 'message' => 'Pesanan nggak ketemu!']);
        }

        $query = DB::table('detail_pesanan')
            ->join('menu', 'detail_pesanan.idmenu', '=', 'menu.idmenu')
            ->where('detail_pesanan.idpesanan', $id)
            ->select('menu.idmenu', 'menu.nama_menu', 'menu.idvendor', 'detail_pesanan.jumlah', 'detail_pesanan.harga', 'detail_pesanan.subtotal');

        if (Auth::check() && Auth::user()->idvendor) {
            $vendorId = Auth::user()->idvendor;
            $query->where('menu.idvendor', $vendorId);
        }

        $items = $query->get();

        $data = [ 
            'idpesanan' => $pesanan->idpesanan,
            'status' => $pesanan->status_bayar ?? $pesanan->status,
            'total' => $pesanan->total,
            'items' => $items,
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }
}