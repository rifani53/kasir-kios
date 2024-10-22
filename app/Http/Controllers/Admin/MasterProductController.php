<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterProduct;
use Illuminate\Http\Request;

class MasterProductController extends Controller
{
    public function create()
    {
        return view('pages.master_products.create');
    }
    public function index()
    {
        $masterProducts = MasterProduct::all(); // Ambil semua data dari tabel master_products
        return view('pages.master_products.index', compact('masterProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:master_products,nama_produk', // Pastikan nama unik
        ]);

        MasterProduct::create([
            'nama_produk' => $request->nama_produk,
        ]);

        return redirect()->route('pages.master_products.index')->with('success', 'Nama produk berhasil ditambahkan ke master produk.');
    }
    public function edit($id)
    {
        $masterProduct = MasterProduct::findOrFail($id);
        return view('pages.master_products.edit', compact('masterProduct'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:master_products,nama_produk,' . $id,
        ]);

        $masterProduct = MasterProduct::findOrFail($id);
        $masterProduct->update([
            'nama_produk' => $request->nama_produk,
        ]);

        return redirect()->route('pages.master_products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $masterProduct = MasterProduct::findOrFail($id);
        $masterProduct->delete();

        return redirect()->route('pages.master_products.index')->with('success', 'Produk berhasil dihapus.');
    }
}

