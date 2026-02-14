<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User; // Menggunakan model yang tersedia

class LoginController extends Controller
{
    public function __construct()
    {
        // Hanya guest yang bisa buka login, logout harus sudah login
        $this->middleware('guest')->except('logout');
    }

    // 1. Menampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Proses Login Manual (Versi Tanpa Role)
    public function login(Request $request)
    {
        // Validasi input email dan password
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah user ada dan passwordnya cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['login_error' => 'Email atau Password salah!'])
                ->withInput();
        }

        // Login user ke sistem Auth Laravel
        Auth::login($user);

        // Simpan data user ke session (Gunakan iduser dan nama sesuai tabelmu)
        $request->session()->put([
            'user_id'    => $user->iduser,
            'user_name'  => $user->nama,
            'user_email' => $user->email,
            // Bagian role dihapus karena modelnya belum ada
        ]);

        return redirect()->intended('/admin/dashboard')->with('success', 'Login berhasil!');
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Logout berhasil!');
    }
}