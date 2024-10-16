<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $penggunas = Pengguna::all(); // Mengambil semua data pengguna
        return view('pages.penggunas.index', compact('penggunas')); // Mengirim data ke view
    }

    // Menampilkan formulir untuk menambah pengguna
    public function create()
    {
        return view('pages.penggunas.create'); // Mengirim tampilan untuk menambah pengguna
    }

    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:penggunas,',
            'password' => 'required|string|min:8',
        ]);

        // Membuat pengguna baru
        Pengguna::create([
            'name' => $request->nama_pengguna,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Meng-hash password
        ]);

        return redirect()->route('pages.penggunas.index')->with('success', 'Pengguna berhasil ditambahkan.'); // Redirect dengan pesan sukses
    }

    // Menampilkan formulir untuk mengedit pengguna
    public function edit($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        return view('pages.penggunas.edit', compact('pengguna')); // Mengirim data pengguna ke view
    }

    // Memperbarui data pengguna
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:penggunas,email,' . $id, // tambahkan ID
        ]);
        

        $pengguna = Pengguna::findOrFail($id); // Mengambil pengguna berdasarkan ID
        $pengguna->update($request->except('password')); // Memperbarui pengguna kecuali password

        // Mengupdate password jika diberikan
        if ($request->filled('password')) {
            $pengguna->update(['password' => bcrypt($request->password)]); // Meng-hash password
        }

        return redirect()->route('pages.penggunas.index')->with('success', 'Pengguna berhasil diperbarui.'); // Redirect dengan pesan sukses
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id); // Mengambil pengguna berdasarkan ID
        $pengguna->delete(); // Menghapus pengguna

        return redirect()->route('pages.penggunas.index')->with('success', 'Pengguna berhasil dihapus.'); // Redirect dengan pesan sukses
    }
}
