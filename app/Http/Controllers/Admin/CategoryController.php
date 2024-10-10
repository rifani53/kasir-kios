<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // Mengambil data kategori
        return view('pages.categories.index', compact('categories')); // Sesuaikan dengan struktur view
    }

    public function create()
    {
        return view('pages.categories.create'); // Pastikan sesuai dengan foldernya
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('pages.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    // Menampilkan form untuk mengedit kategori
    public function edit(Category $category)
    {
        return view('pages.categories.edit', compact('category'));
    }

    // Mengupdate kategori
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('pages.categories.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    // Menghapus kategori
    public function destroy(Category $category)
{
    $category->delete();
    return redirect()->route('pages.categories.index')
                     ->with('success', 'Kategori berhasil dihapus.');
}

}

