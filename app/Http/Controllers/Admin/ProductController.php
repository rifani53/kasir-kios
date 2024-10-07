<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function edit($id)
{
    $product = Product::findOrFail($id);
    $categories = Category::all(); // Mengambil semua kategori untuk dropdown
    return view('pages.products.edit', compact('product', 'categories'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'stok' => 'required|integer',
        'category_id' => 'required|exists:categories,id',
    ]);

    $product = Product::findOrFail($id);
    $product->update($request->all());

    return redirect()->route('pages.products.index')->with('success', 'Produk berhasil diupdate.');
}

public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect()->route('pages.products.index')->with('success', 'Produk berhasil dihapus.');
}

    // Menampilkan daftar produk
    public function index()
    {
        $products = Product::with('category')->get();
        return view('pages.products.index', compact('products'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        $categories = Category::all();
        return view('pages.products.create', compact('categories'));
    }

    // Menyimpan produk baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'category_id' => $request->category_id,
        ]);

        return redirect('/products')->with('success', 'Produk berhasil ditambahkan.');
    }
}
