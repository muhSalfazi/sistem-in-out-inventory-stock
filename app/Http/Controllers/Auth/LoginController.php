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

        // Ambil data user berdasarkan username
        $user = User::where('email', $request->email)->first();

        // Cek apakah user ditemukan dan password benar
        if ($user && Hash::check($request->password, $user->password)) {
            // Login user
            Auth::loginUsingId($user->id);

            // Update waktu login terakhir
            DB::table('users')->where('id', $user->id)->update(['last_login' => now()]);

            return redirect()->route('dashboard'); // Ganti dengan rute dashboard Anda
        } else {
            // Jika gagal login, kembali ke halaman login dengan pesan error
            return redirect()->route('login')
                ->with('msg', 'Password atau kata sandi anda salah.')
                ->with('error', true);
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

        return redirect()->route('welcome')
            ->with('msg', 'Logout successful.')
            ->with('error', false);
    }
}
