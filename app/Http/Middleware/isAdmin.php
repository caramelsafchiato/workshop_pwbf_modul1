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
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }

        // JANGAN ke /login, tapi ke / atau /pos biar gak loop
        return redirect('/')->with('error', 'Halaman ini khusus Admin!');
    }
}