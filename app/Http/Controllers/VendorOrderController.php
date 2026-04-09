<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class VendorOrderController extends Controller
{
    public function paidOrders()
    {
        $orders = DB::table('pesanan')
            ->where('status_bayar', 1)
            ->orderByDesc('idpesanan')
            ->get();

        return view('vendor.pesanan-lunas', compact('orders'));
    }
}