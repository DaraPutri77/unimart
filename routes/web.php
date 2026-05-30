<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');

Route::get('/produk/{produk}', [ProdukController::class, 'show'])
    ->whereNumber('produk')
    ->name('produk.show');

Route::middleware('auth')->group(function () {
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');

    Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])
        ->whereNumber('produk')
        ->name('produk.edit');

    Route::put('/produk/{produk}', [ProdukController::class, 'update'])
        ->whereNumber('produk')
        ->name('produk.update');

    Route::patch('/produk/{produk}', [ProdukController::class, 'update'])
        ->whereNumber('produk')
        ->name('produk.update');

    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])
        ->whereNumber('produk')
        ->name('produk.destroy');

    Route::patch('/produk/{produk}/terjual', [ProdukController::class, 'tandaiTerjual'])
        ->whereNumber('produk')
        ->name('produk.terjual');

    Route::patch('/produk/{produk}/tersedia', [ProdukController::class, 'tandaiTersedia'])
        ->whereNumber('produk')
        ->name('produk.tersedia');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';