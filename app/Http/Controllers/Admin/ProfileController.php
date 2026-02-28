<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() {
        return view('admin.profile.index');
    }

    public function edit() {
        return view('admin.profile.edit');
    }

    public function update(Request $request) {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::user()->iduser . ',iduser',
        ]);

        DB::table('users')
            ->where('iduser', Auth::user()->iduser)
            ->update([
                'nama'       => $request->nama,
                'email'      => $request->email,
                'updated_at' => now(), 
            ]);
        
        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}