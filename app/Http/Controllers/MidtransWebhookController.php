<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        $required = ['order_id', 'status_code', 'gross_amount', 'signature_key', 'transaction_status'];
        foreach ($required as $field) {
            if (!array_key_exists($field, $payload)) {
                return response()->json(['message' => 'Payload tidak lengkap.'], 422);
            }
        }

        $serverKey = (string) config('services.midtrans.server_key');
        $signature = hash('sha512', $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . $serverKey);

        if (!hash_equals($signature, (string) $payload['signature_key'])) {
            return response()->json(['message' => 'Signature tidak valid.'], 403);
        }

        if (!preg_match('/^POS-(\d+)$/', (string) $payload['order_id'], $matches)) {
            return response()->json(['message' => 'order_id tidak dikenal.'], 422);
        }

        $pesanan = Pesanan::find((int) $matches[1]);
        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);
        }

        if (in_array((string) $payload['transaction_status'], ['settlement', 'capture'], true)) {
            $pesanan->update(['status_bayar' => 1]);
        }

        return response()->json(['status' => 'ok']);
    }
}