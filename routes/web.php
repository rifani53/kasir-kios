]<?php
use App\Http\Controllers\UnitController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController; // Pastikan menggunakan backslash (\) bukan titik (.)
use App\Http\Controllers\Admin\PenggunaController;
use Illuminate\Support\Facades\Route;
// Rute untuk pengguna


// Rute untuk satuan
Route::get('/units', [UnitController::class, 'index'])->name('pages.units.index'); // Menampilkan daftar satuan
Route::get('/units/create', [UnitController::class, 'create'])->name('pages.units.create'); // Menampilkan form tambah satuan
Route::post('/units', [UnitController::class, 'store'])->name('pages.units.store'); // Menyimpan satuan baru
Route::get('/units/{unit}/edit', [UnitController::class, 'edit'])->name('pages.units.edit'); // Menampilkan form edit satuan
Route::put('/units/{unit}', [UnitController::class, 'update'])->name('pages.units.update'); // Mengupdate satuan
Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('pages.units.destroy'); // Menghapus satuan

Route::get('/penggunas', [PenggunaController::class, 'index'])->name('pages.penggunas.index');
Route::get('/penggunas/create', [PenggunaController::class, 'create'])->name('pages.penggunas.create');
Route::post('/penggunas', [PenggunaController::class, 'store'])->name('pages.penggunas.store');
Route::get('/penggunas/{id}/edit', [PenggunaController::class, 'edit'])->name('pages.penggunas.edit');
Route::put('/penggunas/{id}', [PenggunaController::class, 'update'])->name('pages.penggunas.update');
Route::delete('/penggunas/{id}', [PenggunaController::class, 'destroy'])->name('pages.penggunas.destroy');

// Rute untuk kategori
Route::get('/categories', [CategoryController::class, 'index'])->name('pages.categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('pages.categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('pages.categories.store');

// Rute untuk produk
Route::get('/products', [ProductController::class, 'index'])->name('pages.products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('pages.products.create');
Route::post('/products', [ProductController::class, 'store'])->name('pages.products.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('pages.products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('pages.products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('pages.products.destroy');
