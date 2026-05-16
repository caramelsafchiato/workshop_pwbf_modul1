<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LokasiToko;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LokasiTokoController extends Controller
{
    public function index()
    {
        $list = LokasiToko::orderBy('barcode')->get();
        return view('admin.lokasi_toko.index', compact('list'));
    }

    public function create()
    {
        return view('admin.lokasi_toko.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:100',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'accuracy' => 'required|numeric',
        ]);

        $toko = LokasiToko::create($request->only(['nama_toko','latitude','longitude','accuracy']));


        return redirect()->route('lokasitoko.index')
            ->with('success', 'Lokasi toko disimpan. ID Toko: ' . $toko->barcode);
    }

    public function scan()
    { 
        return view('admin.lokasi_toko.scan');
    }

    public function getLokasi($barcode)
    {
        $toko = LokasiToko::where('barcode', $barcode)->first();
        
        if (!$toko) return response()->json(['success' => false, 'message' => 'Toko tidak ditemukan']);
        return response()->json(['success' => true, 'data' => $toko]);
    }

    public function validateVisit(Request $request)
    {
        //input
        $data = $request->validate([
            'barcode'   => 'required|string',
            'lat'       => 'required|numeric',
            'lng'       => 'required|numeric',
            'accuracy'  => 'required|numeric',
            'threshold' => 'nullable|numeric'
        ]);

        //cari data toko berdasarkan barcode
        $toko = LokasiToko::where('barcode', $data['barcode'])->first();
        if (!$toko) return response()->json(['success' => false, 'message' => 'Toko tidak ditemukan']);

        //menghitung jarak dengan haversine formula
        $R    = 6371000; 
        $lat1 = deg2rad($toko->latitude);
        $lat2 = deg2rad($data['lat']);
        $dLat = $lat2 - $lat1;
        $dLon = deg2rad($data['lng'] - $toko->longitude);
        
        $a = sin($dLat/2) * sin($dLat/2) + cos($lat1) * cos($lat2) * sin($dLon/2) * sin($dLon/2); // 
        $c = 2 * atan2(sqrt($a), sqrt(1-$a)); 
        $distance = $R * $c; 

        //menentukan thresshold efektif 
        $threshold = $request->input('threshold', 300); 
        $effectiveThreshold = $threshold + ($toko->accuracy ?? 0) + ($data['accuracy'] ?? 0); // [cite: 89]

        //menentukan status diterima atau tidak
        $accepted = ($distance <= $effectiveThreshold); 
 
        //simpan ke tabel kunjungan
        \DB::table('kunjungan')->insert([
            'user_id'    => \Auth::id(), 
            'toko_id'    => $toko->barcode, 
            'lat'        => $data['lat'],
            'lng'        => $data['lng'],
            'accuracy'   => $data['accuracy'],
            'distance'   => $distance, 
            'accepted'   => $accepted, 
            'created_at' => now()
        ]);

        return response()->json([
            'success'            => true,
            'distance'           => round($distance, 2),
            'effective_threshold' => $effectiveThreshold,
            'accepted'           => $accepted
        ]);
    }

    public function history()
    {
        $history = \DB::table('kunjungan')
            ->join('users', 'kunjungan.user_id', '=', 'users.iduser')
            ->join('lokasi_toko', 'kunjungan.toko_id', '=', 'lokasi_toko.barcode')
            ->select(
                'kunjungan.*', 
                'users.nama as nama_sales', 
                'lokasi_toko.nama_toko'
            )
            ->orderBy('kunjungan.created_at', 'desc')
            ->get();

        return view('admin.lokasi_toko.history', compact('history'));
    }

    public function cetakQR($barcode)
    {
        $toko = \App\Models\LokasiToko::where('barcode', $barcode)->firstOrFail();
        return view('admin.lokasi_toko.print', compact('toko'));
    }

    public function salesDashboard()
    {
        $myHistory = \DB::table('kunjungan')
            ->join('lokasi_toko', 'kunjungan.toko_id', '=', 'lokasi_toko.barcode')
            ->where('kunjungan.user_id', \Auth::id())
            ->select('kunjungan.*', 'lokasi_toko.nama_toko')
            ->orderBy('kunjungan.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('sales.dashboard', compact('myHistory'));
    }

    public function scanSales()
    {
        return view('sales.scan');
    }
}
