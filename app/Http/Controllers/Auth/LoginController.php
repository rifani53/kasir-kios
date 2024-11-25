<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Logout pengguna
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auths.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Cek kredensial dan login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user(); // Dapatkan data pengguna yang login

            // Redirect berdasarkan peran pengguna
            if ($user->posisi === 'admin') {
                return redirect()->route('pages.dashboard.index')->with('success', 'Selamat datang, Admin!');
            } elseif ($user->posisi === 'kasir') {
                return redirect()->route('pages.dashboard.index')->with('success', 'Selamat datang, Kasir!');
            } else {
                // Default redirect jika peran tidak dikenali
                Auth::logout();
                return redirect()->route('login')->with('error', 'Peran tidak dikenali.');
            }
        } else {
            // Login gagal
            return redirect()->back()->with('error', 'Email atau password salah.');
        }
    }
}
