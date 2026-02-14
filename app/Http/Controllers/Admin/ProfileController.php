<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Wajib import Facade DB
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() {
        // Kita tetap bisa menggunakan view karena data user diambil lewat auth() di Blade
        return view('admin.profile.index');
    }

    public function edit() {
        return view('admin.profile.edit');
    }

    public function update(Request $request) {
        // 1. Validasi input agar data nama dan email aman
        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::user()->iduser . ',iduser',
        ]);

        // 2. Update data menggunakan Query Builder
        // Kita gunakan iduser sebagai primary key sesuai struktur tabelmu
        DB::table('users')
            ->where('iduser', Auth::user()->iduser)
            ->update([
                'nama'       => $request->nama,
                'email'      => $request->email,
                'updated_at' => now(), // Manual mengisi timestamp karena Query Builder
            ]);
        
        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}