<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekLogin
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login menggunakan session
        if (! session()->has('user_logged_in')) {
            // Kalau belum login, redirect ke halaman login
            return redirect('/login')->with('error', 'Silakan login dulu!');
        }

        // Kalau sudah login, lanjutkan request
        return $next($request);
    }
}
