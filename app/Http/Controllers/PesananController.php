<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Midtrans\Config;
use Midtrans\Snap;

class PesananController extends Controller
{
    public function storePesananSimulasi(Request $request)
    {
        $request->validate([
            'total_harga' => 'required|numeric|min:1',
            'items' => 'required|array|min:1',
            'items.*.idmenu' => 'required|integer|exists:menu,idmenu',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $idPesanan = DB::table('pesanan')->insertGetId([
                    'nama' => 'Guest Customer',
                    'total' => (int) round($request->total_harga),
                    'status_bayar' => 1,
                    'metode_bayar' => 2,
                    'timestamp' => now(),
                    'snap_token' => null,
                ], 'idpesanan');

                foreach ($request->items as $item) {
                    $jumlah = (int) $item['quantity'];
                    $harga = (int) round((float) $item['harga']);

                    DB::table('detail_pesanan')->insert([
                        'idmenu' => (int) $item['idmenu'],
                        'idpesanan' => (int) $idPesanan,
                        'jumlah' => $jumlah,
                        'harga' => $harga,
                        'subtotal' => $harga * $jumlah,
                        'timestamp' => now(),
                        'catatan' => $item['catatan'] ?? null,
                    ]);
                }
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran Berhasil (Simulasi)!',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'total_harga' => 'required|numeric|min:1',
            'items' => 'required|array|min:1',
            'items.*.idmenu' => 'required|integer|exists:menu,idmenu',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $total = (int) round($request->total_harga);

                $idPesanan = DB::table('pesanan')->insertGetId([
                    'nama' => 'Guest Customer',
                    'total' => $total,
                    'status_bayar' => 0,
                    'metode_bayar' => 1,
                    'timestamp' => now(),
                    'snap_token' => null,
                ], 'idpesanan');

                foreach ($request->items as $item) {
                    $jumlah = (int) $item['quantity'];
                    $harga = (int) round((float) $item['harga']);

                    DB::table('detail_pesanan')->insert([
                        'idmenu' => (int) $item['idmenu'],
                        'idpesanan' => (int) $idPesanan,
                        'jumlah' => $jumlah,
                        'harga' => $harga,
                        'subtotal' => $harga * $jumlah,
                        'timestamp' => now(),
                        'catatan' => $item['catatan'] ?? null,
                    ]);
                }

                Config::$serverKey = (string) config('services.midtrans.server_key');
                Config::$isProduction = (bool) config('services.midtrans.is_production', false);
                Config::$isSanitized = true;
                Config::$is3ds = true;

                $params = [
                    'transaction_details' => [
                        'order_id' => 'POS-' . $idPesanan,
                        'gross_amount' => $total,
                    ],
                    'customer_details' => [
                        'first_name' => 'Guest Customer',
                    ],
                ];

                $token = Snap::getSnapToken($params);

                DB::table('pesanan')
                    ->where('idpesanan', $idPesanan)
                    ->update(['snap_token' => $token]);

                return response()->json([
                    'status' => 'success',
                    'token' => $token,
                    'idpesanan' => $idPesanan,
                ]);
            });
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function storePesananGuest(Request $request)
    {
        return $this->checkout($request);
    }

    public function getPesananDetail($idpesanan)
    {
        $pesanan = Pesanan::with(['details.menu'])->find($idpesanan);

        if (!$pesanan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $pesanan,
        ]);
    }

}