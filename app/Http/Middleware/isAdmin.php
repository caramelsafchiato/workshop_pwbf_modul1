<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib import ini
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek: Apakah user sudah login dan apakah kolom role isinya 'admin'?
        if (auth()->check() && auth()->user()->role == 'admin') {
            return $next($request);
        }

        // Kalau bukan admin, lempar ke dashboard dengan pesan error
        return redirect()->route('dashboard')->with('error', 'Hanya Admin yang boleh masuk!');
    }
}