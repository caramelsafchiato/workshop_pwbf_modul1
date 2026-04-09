<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Midtrans\Config;
use Midtrans\Snap;

class KantinController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();
        return view('pesanan.pos', compact('vendors'));
    }

    // Jurus Cascading: Ambil menu berdasarkan Vendor yang dipilih
    public function getMenus($idvendor)
    {
        $menus = Menu::where('idvendor', $idvendor)->get();
        return response()->json($menus);
    }

    public function checkout(Request $request)
    {
        // 1. Logika Nama Guest Otomatis (Guest_0000001)
        $lastGuest = Pesanan::where('nama', 'like', 'Guest_%')->orderBy('idpesanan', 'desc')->first();
        $lastNumber = $lastGuest ? (int) substr($lastGuest->nama, 6) : 0;
        $guestName = 'Guest_' . str_pad($lastNumber + 1, 7, '0', STR_PAD_LEFT); 

        // 2. Simpan Kepala Pesanan
        $pesanan = Pesanan::create([
            'nama' => $guestName,
            'total' => $request->total_harga,
            'status_bayar' => 0, // 0 = Pending
        ]);

        // 3. Simpan Detail Pesanan (Looping dari data belanja)
        foreach ($request->items as $item) {
            DetailPesanan::create([
                'idpesanan' => $pesanan->idpesanan,
                'idmenu' => $item['idmenu'],
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga'],
                'subtotal' => $item['jumlah'] * $item['harga'],
            ]);
        }

        // 4. Integrasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $pesanan->idpesanan . '-' . time(),
                'gross_amount' => (int) $request->total_harga,
            ],
            'customer_details' => [
                'first_name' => $guestName,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        $pesanan->update(['snap_token' => $snapToken]);

        return response()->json(['token' => $snapToken]);
    }
}