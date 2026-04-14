<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function create() {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'image' => 'required'
        ]);

        $img = $request->image; 
        $folderPath = "public/uploads/customers/";
        $image_parts = explode(";base64,", $img);
        $image_base64 = base64_decode($image_parts[1]);
        
        $fileName = Str::random(10) . '.png';
        $file = $folderPath . $fileName;
        
        Storage::put($file, $image_base64);

        DB::table('customers')->insert([
            'nama' => $request->nama,
            'foto_blob' => $img,      
            'foto_path' => $fileName, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => 'Customer Berhasil Ditambah! Foto tersimpan.']);
    }
}