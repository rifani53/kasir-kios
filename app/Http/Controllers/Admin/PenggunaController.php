<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Tambahkan ini

class PenggunaController extends Controller
{
    public function index()
    {
        // Mengambil semua data pengguna dari database
        $penggunas = Pengguna::all();
        // Mengirim data pengguna ke view
        return view('pages.penggunas.index', compact('penggunas'));
    }

    public function create()
    {
        // Menampilkan form tambah pengguna
        return view('pages.penggunas.create');
    }

    public function store(Request $request)
    {
        // Validasi data input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:penggunas', // Sesuaikan nama tabel
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Membuat pengguna baru
        Pengguna::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Menggunakan Hash untuk password
        ]);

        // Redirect ke halaman daftar pengguna dengan pesan sukses
        return redirect()->route('pages.penggunas.index')->with('success', 'Pengguna berhasil dibuat.');
    }

    public function edit(Pengguna $pengguna)
    {
        // Menampilkan form edit pengguna dengan data yang akan diedit
        return view('pages.penggunas.edit', compact('pengguna'));
    }

    public function update(Request $request, Pengguna $pengguna)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:penggunas,email,' . $pengguna->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update data pengguna
        $pengguna->name = $request->name;
        $pengguna->email = $request->email;

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }

        // Simpan perubahan ke database
        $pengguna->save();

        // Redirect ke halaman daftar pengguna dengan pesan sukses
        return redirect()->route('pages.penggunas.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(Pengguna $pengguna)
    {
        // Menghapus pengguna
        $pengguna->delete();

        // Redirect ke halaman daftar pengguna dengan pesan sukses
        return redirect()->route('pages.penggunas.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
