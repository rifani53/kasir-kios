<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit; // Jangan lupa import model Unit
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan form tambah produk
    public function create()
    {
        $categories = Category::all();
        $units = Unit::all(); // Ambil semua satuan

        return view('pages.products.create', compact('categories', 'units'));
    }

    // Menyimpan produk baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id', // Validasi satuan
        ]);

        Product::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id, // Simpan unit_id
        ]);

        return redirect()->route('pages.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Menampilkan form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); // Mengambil semua kategori untuk dropdown
        $units = Unit::all(); // Ambil semua satuan untuk dropdown
        return view('pages.products.edit', compact('product', 'categories', 'units'));
    }

    // Mengupdate produk di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id', // Validasi satuan
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id, // Update unit_id
        ]);

        return redirect()->route('pages.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Menghapus produk dari database
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('pages.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    // Menampilkan daftar produk
    public function index()
    {
        $products = Product::with('category', 'unit')->get(); // Pastikan relasi 'unit' di-load
        return view('pages.products.index', compact('products'));
    }
}
