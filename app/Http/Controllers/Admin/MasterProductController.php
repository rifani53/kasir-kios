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

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:master_products,nama_produk', // Pastikan nama unik
        ]);

        MasterProduct::create([
            'nama_produk' => $request->nama_produk,
        ]);

        return redirect()->route('master_products.index')->with('success', 'Nama produk berhasil ditambahkan ke master produk.');
    }
}
