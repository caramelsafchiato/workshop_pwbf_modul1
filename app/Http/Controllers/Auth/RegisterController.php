<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi: Pastikan key 'nama' sesuai dengan name="nama" di Blade
        $validator = Validator::make($request->all(), [
            'nama'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 2. Simpan User Baru dengan insertGetId
        // Kita gunakan idkategori atau iduser sesuai primary key tabel users Anda
        $iduser = DB::table('users')->insertGetId([
            'nama'       => $request->nama,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'admin', 
            'created_at' => now(),   
            'updated_at' => now(),
        ]);

        // 3. Ambil data user yang baru saja dibuat
        $user = DB::table('users')->where('iduser', $iduser)->first();

        // 4. Login Otomatis menggunakan ID
        // Penting: Laravel butuh Model User terkonfigurasi dengan primaryKey = 'iduser'
        Auth::loginUsingId($iduser);

        // 5. Simpan data krusial ke Session
        $request->session()->put([
            'user_id'    => $user->iduser,
            'user_name'  => $user->nama,
            'user_email' => $user->email,
            'user_role'  => $user->role,
        ]);

        return redirect('/admin/dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }
}