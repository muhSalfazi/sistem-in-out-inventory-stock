<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLogin() // Pastikan ini konsisten dengan route
    {
        return view('login'); // Pastikan file view 'login.blade.php' ada di folder 'resources/views'
    }

    /**
     * Handle the login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input form
        $request->validate([
            'email' => 'required|min:3|max:50',
            'password' => 'required|max:255',
        ]);

        // Ambil data user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah user ditemukan dan password benar
        if ($user && Hash::check($request->password, $user->password)) {
            // Login user
            Auth::loginUsingId($user->id);

            // Update waktu login terakhir
            DB::table('users')->where('id', $user->id)->update(['last_login' => now()]);

            // Cek role pengguna dan arahkan sesuai role
            if ($user->hasRole('admin')) {
                return redirect()->route('dashboard'); // Redirect ke rute admin
            } elseif ($user->hasRole('user')) {
                return redirect()->route('user.stock.index'); // Redirect ke rute user
            } else {
                // Jika user tidak punya peran yang cocok, logout dan beri pesan error
                Auth::logout();
                return redirect()->route('login')->with('error', 'Peran Anda tidak dikenali.');
            }
        } else {
            // Jika gagal login, kembali ke halaman login dengan pesan error
            return redirect()->route('login')
                ->with('error', 'Password atau kata sandi Anda salah.');
        }
    }


    /**
     * Handle the logout request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Logout successful.')
            ->with('error', false);
    }
}
