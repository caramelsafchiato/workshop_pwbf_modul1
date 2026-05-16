<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsSales
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Cek apakah sudah login DAN rolenya 'sales'
        // Kita pakai strtolower biar aman kalau di DB tulisannya 'Sales' atau 'SALES'
        if (Auth::check() && strtolower(Auth::user()->role) == 'sales') {
            return $next($request);
        }

        // 2. Kalau bukan sales, lempar ke halaman dashboard utama atau POS
        return redirect('/dashboard')->with('error', 'Waduh Sya, akses ini cuma buat Sales!');
    }
}