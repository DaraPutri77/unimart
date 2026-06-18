<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Produk Saya
    |--------------------------------------------------------------------------
    | Halaman khusus untuk melihat dan mengelola produk milik user login.
    */
    Route::get('/produk-saya', [ProdukController::class, 'produkSaya'])->name('produk.saya');

    /*
    |--------------------------------------------------------------------------
    | Produk
    |--------------------------------------------------------------------------
    | /produk dipakai sebagai marketplace untuk melihat produk milik orang lain.
    */
    Route::post('/produk/{produk}/tandai-terjual', [ProdukController::class, 'tandaiTerjual'])
        ->name('produk.tandai-terjual');

    Route::post('/produk/{produk}/tandai-tersedia', [ProdukController::class, 'tandaiTersedia'])
        ->name('produk.tandai-tersedia');

    Route::resource('produk', ProdukController::class);

    /*
    |--------------------------------------------------------------------------
    | Keranjang
    |--------------------------------------------------------------------------
    | Keranjang hanya untuk menyimpan produk yang diminati sebelum hubungi WhatsApp.
    */
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/{produk}', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::delete('/keranjang/{keranjang}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::delete('/admin/produk/{produk}', [AdminController::class, 'destroyProduk'])
        ->name('admin.produk.destroy');
});

require __DIR__ . '/auth.php';