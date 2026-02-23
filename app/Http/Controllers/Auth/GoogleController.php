<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; // WAJIB TAMBAH INI
use App\Mail\OtpMail;               // WAJIB TAMBAH INI
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::updateOrCreate(['email' => $googleUser->email], [
                'nama' => $googleUser->name,
                'id_google' => $googleUser->id,
                'password' => Hash::make('google-auth-'.rand(1,1000)), 
                'role' => 'admin' 
            ]);

            // 3. Generate OTP 6 Karakter (Poin d.ii)
            $otpCode = rand(100000, 999999);
            $user->update(['otp' => $otpCode]);

            // --- BARIS YANG KURANG: KIRIM EMAIL SEKARANG ---
            Mail::to($user->email)->send(new OtpMail($otpCode)); 
            // -----------------------------------------------

            session()->put('temp_user_id', $user->iduser);

            return redirect()->route('otp.view')->with('success', 'Kode OTP telah dikirim ke email kamu!');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login menggunakan Google.');
        }
    }

    public function showOtpForm()
    {
        if (!session()->has('temp_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_input' => 'required|digits:6',
        ]);

        $user = User::find(session('temp_user_id'));

        if ($user && $user->otp == $request->otp_input) {
            Auth::login($user);
            
            $user->update(['otp' => null]);
            session()->forget('temp_user_id');

            return redirect()->route('dashboard')->with('success', 'Login Berhasil!');
        }

        return redirect()->back()->withErrors(['otp_error' => 'Kode OTP yang kamu masukkan salah!']);
    }
}