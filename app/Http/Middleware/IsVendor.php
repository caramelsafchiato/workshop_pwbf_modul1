<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsVendor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'vendor') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Hanya vendor yang boleh mengakses halaman ini.');
    }
}
