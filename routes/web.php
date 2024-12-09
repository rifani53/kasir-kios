<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Laporancontroller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\MasterProductController;


// Rute Login dan Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('auths.login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute Registrasi
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('auths.index');
Route::post('/register', [RegisterController::class, 'register'])->name('auths.register');

// Halaman Awal
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('pages.laporan.index');
    Route::post('/laporan/export', [LaporanController::class, 'export'])->name('pages.laporan.export');
    Route::get('/dropbox/dropbox-files', [LaporanController::class, 'showDropboxFiles'])->name('pages.dropbox.dropbox_files');
    Route::get('/dropbox/dropbox-files/download/{fileName}', [LaporanController::class, 'downloadDropboxFile'])->name('pages.dropbox.download');
    Route::get('/dropbox/temporary-link/{filePath}', [LaporanController::class, 'getTemporaryLink'])->name('pages.dropbox.temporary-link');
    Route::delete('/dropbox/delete/{fileName}', [LaporanController::class, 'deleteDropboxFile'])->name('pages.dropbox.delete');

    // Master Products
    Route::get('/master-products', [MasterProductController::class, 'index'])->name('pages.master_products.index');
    Route::get('/master-products/create', [MasterProductController::class, 'create'])->name('pages.master_products.create');
    Route::post('/master-products', [MasterProductController::class, 'store'])->name('master_products.store');
    Route::get('/master-products/{id}/edit', [MasterProductController::class, 'edit'])->name('pages.master_products.edit');
    Route::put('/master-products/{id}', [MasterProductController::class, 'update'])->name('master_products.update');
    Route::delete('/master-products/{id}', [MasterProductController::class, 'destroy'])->name('master_products.destroy');

    // Units
    Route::get('/units', [UnitController::class, 'index'])->name('pages.units.index');
    Route::get('/units/create', [UnitController::class, 'create'])->name('pages.units.create');
    Route::post('/units', [UnitController::class, 'store'])->name('pages.units.store');
    Route::get('/units/{unit}/edit', [UnitController::class, 'edit'])->name('pages.units.edit');
    Route::put('/units/{unit}', [UnitController::class, 'update'])->name('pages.units.update');
    Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('pages.units.destroy');

    // Pengguna
    Route::get('/penggunas', [PenggunaController::class, 'index'])->name('pages.penggunas.index');
    Route::get('/penggunas/create', [PenggunaController::class, 'create'])->name('pages.penggunas.create');
    Route::post('/penggunas', [PenggunaController::class, 'store'])->name('pages.penggunas.store');
    Route::get('/penggunas/{pengguna}/edit', [PenggunaController::class, 'edit'])->name('pages.penggunas.edit');
    Route::put('/penggunas/{id}', [PenggunaController::class, 'update'])->name('pages.penggunas.update');
    Route::delete('/penggunas/{id}', [PenggunaController::class, 'destroy'])->name('pages.penggunas.destroy');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('pages.categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('pages.categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('pages.categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('pages.categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('pages.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('pages.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('pages.products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('pages.products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('pages.products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('pages.products.destroy');
});
// Rute untuk Admi


// Rute untuk Admin dan Kasir
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('pages.dashboard.index');
});

// Rute untuk Kasir
Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index'])->name('pages.transactions.index');

    Route::get('/history', [TransactionController::class, 'history'])->name('pages.transactions.history');
    Route::post('/cart/add', [TransactionController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [TransactionController::class, 'showCart'])->name('cart.show');
    Route::delete('/cart/remove/{productId}', [TransactionController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/complete', [TransactionController::class, 'completeCart'])->name('cart.complete');
    Route::post('/cart/cancel', [TransactionController::class, 'cancelCart'])->name('cart.cancel');
    Route::get('transactions/success/{transactionId}', [TransactionController::class, 'success'])->name('pages.transactions.success');
    Route::get('transactions/download-receipt/{transactionId}', [TransactionController::class, 'downloadReceipt'])->name('transactions.downloadReceipt');
});
// Rute untuk Kasir

