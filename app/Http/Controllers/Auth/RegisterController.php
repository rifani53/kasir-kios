<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna; // Gunakan model Pengguna
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('auths.index'); // Pastikan file auths.index ada di folder views
    }

    // Menyimpan data registrasi
    public function register(Request $request)
    {
        // Validasi data
        $this->validator($request->all())->validate();

        // Buat pengguna baru dengan posisi "kasir"
        $pengguna = Pengguna::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'posisi' => 'kasir', // Tetapkan posisi kasir
        ]);

        // Redirect ke halaman login setelah registrasi
        return redirect()->route('auths.login')->with('success', 'Registrasi berhasil! Silakan login untuk melanjutkan.');
    }

    // Validator untuk validasi data registrasi
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:penggunas', // Validasi unik di tabel pengguna
            'password' => 'required|string|min:8|confirmed', // Pastikan ada konfirmasi password
        ]);
    }
}
