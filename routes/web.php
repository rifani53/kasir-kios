<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController; // Pastikan menggunakan backslash (\) bukan titik (.)
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\MasterProductController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Admin\UserController;





use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('pages.Authorization.login1');
})->name('login');

// Route untuk proses login dan register
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');

// Route untuk logout
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Route untuk halaman dashboard setelah login atau register berhasil
Route::middleware('auth')->group(function () {
    // Route untuk halaman dashboard, hanya bisa diakses jika login
    Route::view('/dashboard', 'pages.dashboard.index')->name('pages.dashboard.index');
});



Route::post('/generate-invoice', [PDFController::class, 'generateInvoice'])->name('generate.invoice');
// rute untuk masterproductk

Route::get('/master-products/create', [MasterProductController::class, 'create'])->name('pages.master_products.create');
Route::post('/master-products/store', [MasterProductController::class, 'store'])->name('master_products.store');
Route::get('/master-products', [MasterProductController::class, 'index'])->name('pages.master_products.index');
Route::get('/master-products/{id}/edit', [MasterProductController::class, 'edit'])->name('pages.master_products.edit');
Route::put('/master-products/{id}', [MasterProductController::class, 'update'])->name('master_products.update');
Route::delete('/master-products/{id}', [MasterProductController::class, 'destroy'])->name('master_products.destroy');

// Rute untuk dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('pages.dashboard.index');

Route::get('/transactions', [TransactionController::class, 'index'])->name('pages.transactions.index');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::delete('/transactions/{id}', [TransactionController::class, 'cancel'])->name('transactions.cancel');
Route::post('/transactions/{id}/complete', [TransactionController::class, 'complete'])->name('transactions.complete');
Route::get('/transactions/{id}/print', [TransactionController::class, 'printReceipt'])->name('transactions.print');
Route::get('/transactions/history', [TransactionController::class, 'history'])->name('pages.transactions.history');
Route::post('/transactions/complete', [TransactionController::class, 'complete'])->name('transactions.complete');

// Rute untuk satuan
Route::get('/units', [UnitController::class, 'index'])->name('pages.units.index'); // Menampilkan daftar satuan
Route::get('/units/create', [UnitController::class, 'create'])->name('pages.units.create'); // Menampilkan form tambah satuan
Route::post('/units', [UnitController::class, 'store'])->name('pages.units.store'); // Menyimpan satuan baru
Route::get('/units/{unit}/edit', [UnitController::class, 'edit'])->name('pages.units.edit'); // Menampilkan form edit satuan
Route::put('/units/{unit}', [UnitController::class, 'update'])->name('pages.units.update'); // Mengupdate satuan
Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('pages.units.destroy'); // Menghapus satuan

//route untuk pengguna
Route::get('/penggunas', [PenggunaController::class, 'index'])->name('pages.penggunas.index');
Route::get('/penggunas/create', [PenggunaController::class, 'create'])->name('pages.penggunas.create');
Route::post('/penggunas', [PenggunaController::class, 'store'])->name('pages.penggunas.store');
Route::get('/penggunas/{pengguna}/edit', [PenggunaController::class, 'edit'])->name('pages.penggunas.edit');
Route::put('/penggunas/{id}', [PenggunaController::class, 'update'])->name('pages.penggunas.update');
Route::delete('/penggunas/{id}', [PenggunaController::class, 'destroy'])->name('pages.penggunas.destroy');

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
Route::get('/penggunas/{pengguna}/edit', [PenggunaController::class, 'edit'])->name('pages.penggunas.edit');
Route::put('/penggunas/{id}', [PenggunaController::class, 'update'])->name('pages.penggunas.update');
Route::delete('/penggunas/{id}', [PenggunaController::class, 'destroy'])->name('pages.penggunas.destroy');

// Rute untuk kategori
Route::get('/categories', [CategoryController::class, 'index'])->name('pages.categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('pages.categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('pages.categories.store');
Route::get('categories/{category}', [CategoryController::class, 'edit'])->name('pages.categories.edit');
Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::get('products/categories', [CategoryController::class, 'index']);



// Rute untuk produk
Route::get('/products', [ProductController::class, 'index'])->name('pages.products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('pages.products.create');
Route::post('/products', [ProductController::class, 'store'])->name('pages.products.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('pages.products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('pages.products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('pages.products.destroy');
