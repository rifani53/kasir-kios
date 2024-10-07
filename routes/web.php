<?php
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\PenggunaController; // Pastikan ini sesuai dengan nama controller kamu
use Illuminate\Support\Facades\Route;

// Rute untuk pengguna
Route::get('/penggunas', [ProductController::class, 'index'])->name('pages.penggunas.index'); // Menampilkan daftar produk
Route::get('/penggunas/create', [ProductController::class, 'create'])->name('pages.penggunas.create'); // Menampilkan form tambah produk
Route::post('/penggunas', [ProductController::class, 'store'])->name('pages.penggunas.store'); // Menyimpan produk baru
Route::get('/penggunas/{id}/edit', [ProductController::class, 'edit'])->name('pages.penggunas.edit'); // Menampilkan form edit produk
Route::put('/penggunas/{id}', [ProductController::class, 'update'])->name('pages.penggunas.update'); // Mengupdate produk
Route::delete('/penggunas/{id}', [ProductController::class, 'destroy'])->name('pages.penggunas.destroy'); // Menghapus produk


// Rute untuk kategori
Route::get('/categories', [CategoryController::class, 'index'])->name('pages.categories.index'); // Menampilkan daftar kategori
Route::get('/categories/create', [CategoryController::class, 'create'])->name('pages.categories.create'); // Menampilkan form tambah kategori
Route::post('/categories', [CategoryController::class, 'store'])->name('pages.categories.store'); // Menyimpan kategori baru

// Rute untuk produk
Route::get('/products', [ProductController::class, 'index'])->name('pages.products.index'); // Menampilkan daftar produk
Route::get('/products/create', [ProductController::class, 'create'])->name('pages.products.create'); // Menampilkan form tambah produk
Route::post('/products', [ProductController::class, 'store'])->name('pages.products.store'); // Menyimpan produk baru
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('pages.products.edit'); // Menampilkan form edit produk
Route::put('/products/{id}', [ProductController::class, 'update'])->name('pages.products.update'); // Mengupdate produk
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('pages.products.destroy'); // Menghapus produk
