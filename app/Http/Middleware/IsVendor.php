<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsVendor
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login DAN role-nya vendor
        if (Auth::check() && (strtolower(Auth::user()->role) == 'vendor' || Auth::user()->idvendor != null)) {
            return $next($request);
        }

        // Kalau bukan vendor, lempar ke halaman netral (misal: /pos) 
        // JANGAN ke '/' biar gak looping!
        return redirect('/pos')->with('error', 'Hanya untuk Vendor!');
    }
}