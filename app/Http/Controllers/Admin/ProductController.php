<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use App\Models\MasterProduct; // Import model MasterProduct
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan form tambah produk
    public function create()
    {
        $categories = Category::all();
        $units = Unit::all();
        $masterProducts = MasterProduct::all(); // Ambil semua master produk

        return view('pages.products.create', compact('categories', 'units', 'masterProducts'));
    }

    // Menyimpan produk baru ke database
    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
        ]);

        // Cek apakah produk dengan nama, jenis, dan ukuran yang sama sudah ada
        $product = Product::where('nama', $request->nama)
                  ->where('ukuran', $request->ukuran)
                  ->where('merek', $request->merek) // <- Perbaikan di sini
                  ->first();


        if ($product) {
            // Jika produk ditemukan, tambahkan stok
            $product->stok += $request->stok;
            $product->harga = $request->harga; // Perbarui harga jika diinginkan
            $product->save();
        } else {
            // Jika produk tidak ditemukan, buat produk baru
            Product::create([
                'nama' => $request->nama,
                'merek' => $request->merek,
                'ukuran' => $request->ukuran,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'category_id' => $request->category_id,
                'unit_id' => $request->unit_id,
            ]);
        }

        return redirect()->route('pages.products.index')->with('success', 'Produk berhasil ditambahkan atau diperbarui.');
    }

    // Menampilkan form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); 
        $units = Unit::all(); 
        $masterProducts = MasterProduct::all(); 

        return view('pages.products.edit', compact('product', 'categories', 'units', 'masterProducts'));
    }

    // Mengupdate produk di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'merek' => 'required|string|max:255', 
            'ukuran' => 'required|string|max:255', 
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'nama' => $request->nama,
            'merek' => $request->merek, 
            'ukuran' => $request->ukuran,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
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
        $products = Product::with(['category', 'unit'])->paginate(10); // Ambil 10 data per halaman
        return view('pages.products.index', compact('products'));
    }
}
