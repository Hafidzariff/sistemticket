<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Periksa apakah pengguna terautentikasi dan memiliki role yang benar
        if (Auth::check()) {
            // Cek jika role pengguna sesuai dengan yang diinginkan
            if (Auth::user()->role === $role) {
                return $next($request); // Lanjutkan permintaan jika role cocok
            } else {
                // Jika role tidak cocok, arahkan ke halaman yang sesuai atau kembali dengan error
                return redirect()->route('landing')->with('loginError', 'Akses ditolak. Role tidak sesuai.');
            }
        }

        // Jika pengguna tidak terautentikasi, arahkan ke halaman login
        return redirect()->route('/login');
    }
}
