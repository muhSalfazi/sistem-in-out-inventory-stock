<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $timeout = config('session.lifetime') * 60; // Hitung dalam detik

            if (session()->has('lastActivity') && (time() - session('lastActivity') > $timeout)) {
                Auth::logout(); // Log out pengguna

                // Redirect ke halaman login
                return redirect()->route('login')->with('gagal', 'Sesi Anda telah kadaluarsa. Silakan login kembali.');
            }

            session(['lastActivity' => time()]); // Perbarui timestamp aktivitas terakhir
        }

        return $next($request);
    }
}
