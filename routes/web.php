<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BuyerPesananController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerPesananController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | PRODUK
    |--------------------------------------------------------------------------
    */

    Route::get('/produk', [ProdukController::class, 'index'])
        ->name('produk.index');

    Route::get('/produk-saya', [ProdukController::class, 'produkSaya'])
        ->name('produk.saya');

    Route::get('/produk/tambah', [ProdukController::class, 'create'])
        ->name('produk.create');

    Route::post('/produk', [ProdukController::class, 'store'])
        ->name('produk.store');

    Route::get('/produk/{produk}', [ProdukController::class, 'show'])
        ->whereNumber('produk')
        ->name('produk.show');

    Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])
        ->whereNumber('produk')
        ->name('produk.edit');

    Route::put('/produk/{produk}', [ProdukController::class, 'update'])
        ->whereNumber('produk')
        ->name('produk.update');

    Route::patch('/produk/{produk}', [ProdukController::class, 'update'])
        ->whereNumber('produk')
        ->name('produk.patch');

    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])
        ->whereNumber('produk')
        ->name('produk.destroy');


    /*
    |--------------------------------------------------------------------------
    | KERANJANG
    |--------------------------------------------------------------------------
    */

    Route::get('/keranjang', [KeranjangController::class, 'index'])
        ->name('keranjang.index');

    Route::post('/keranjang/tambah/{produk}', [KeranjangController::class, 'store'])
        ->whereNumber('produk')
        ->name('keranjang.tambah');

    Route::post('/keranjang/{produk}', [KeranjangController::class, 'store'])
        ->whereNumber('produk')
        ->name('keranjang.store');

    Route::patch('/keranjang/{keranjang}', [KeranjangController::class, 'update'])
        ->whereNumber('keranjang')
        ->name('keranjang.update');

    Route::delete('/keranjang/{keranjang}', [KeranjangController::class, 'destroy'])
        ->whereNumber('keranjang')
        ->name('keranjang.destroy');

    Route::delete('/keranjang', [KeranjangController::class, 'clear'])
        ->name('keranjang.clear');


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT COD
    |--------------------------------------------------------------------------
    */

    Route::post('/checkout', [BuyerPesananController::class, 'checkout'])
        ->name('checkout.store');


    /*
    |--------------------------------------------------------------------------
    | PESANAN SAYA - BUYER
    |--------------------------------------------------------------------------
    */

    Route::get('/pesanan-saya', [BuyerPesananController::class, 'index'])
        ->name('pesanan.saya');

    Route::get('/pesanan-saya/{pesanan}', [BuyerPesananController::class, 'show'])
        ->whereNumber('pesanan')
        ->name('pesanan.saya.show');

    Route::patch('/pesanan-saya/{pesanan}/batalkan', [BuyerPesananController::class, 'cancel'])
        ->whereNumber('pesanan')
        ->name('pesanan.cancel');

    Route::patch('/pesanan-saya/{pesanan}/selesai', [BuyerPesananController::class, 'complete'])
        ->whereNumber('pesanan')
        ->name('pesanan.complete');


    /*
    |--------------------------------------------------------------------------
    | PESANAN MASUK - SELLER
    |--------------------------------------------------------------------------
    */

    Route::get('/pesanan-masuk', [SellerPesananController::class, 'index'])
        ->name('pesanan.masuk');

    Route::get('/pesanan-masuk/{pesanan}', [SellerPesananController::class, 'show'])
        ->whereNumber('pesanan')
        ->name('pesanan.masuk.show');

    Route::patch('/pesanan-masuk/{pesanan}/setujui', [SellerPesananController::class, 'accept'])
        ->whereNumber('pesanan')
        ->name('pesanan.accept');

    Route::patch('/pesanan-masuk/{pesanan}/tolak', [SellerPesananController::class, 'reject'])
        ->whereNumber('pesanan')
        ->name('pesanan.reject');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    Route::delete('/admin/produk/{produk}', [AdminController::class, 'destroyProduk'])
        ->whereNumber('produk')
        ->name('admin.produk.destroy');
});

require __DIR__.'/auth.php';
Route::patch('/pesanan-masuk/{pesanan}/terima-final', function (\Illuminate\Http\Request $request, \App\Models\Pesanan $pesanan) {
    $user = $request->user();

    if (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'penjual_id') && (int) $pesanan->penjual_id !== (int) $user->id) {
        abort(403);
    }

    if (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'seller_id') && (int) $pesanan->seller_id !== (int) $user->id) {
        abort(403);
    }

    $pesanan->status = 'accepted';
    $pesanan->save();

    return back()->with('success', 'Pesanan berhasil diterima.');
})->middleware('auth')->name('pesanan.masuk.terima.final');

Route::patch('/pesanan-masuk/{pesanan}/tolak-final', function (\Illuminate\Http\Request $request, \App\Models\Pesanan $pesanan) {
    $user = $request->user();

    if (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'penjual_id') && (int) $pesanan->penjual_id !== (int) $user->id) {
        abort(403);
    }

    if (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'seller_id') && (int) $pesanan->seller_id !== (int) $user->id) {
        abort(403);
    }

    $pesanan->status = 'rejected';
    $pesanan->save();

    return back()->with('success', 'Pesanan berhasil ditolak.');
})->middleware('auth')->name('pesanan.masuk.tolak.final');

Route::patch('/pesanan-masuk/{pesanan}/selesai-final', function (\Illuminate\Http\Request $request, \App\Models\Pesanan $pesanan) {
    $user = $request->user();

    if (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'penjual_id') && (int) $pesanan->penjual_id !== (int) $user->id) {
        abort(403);
    }

    if (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'seller_id') && (int) $pesanan->seller_id !== (int) $user->id) {
        abort(403);
    }

    $statusSaatIni = strtolower((string) ($pesanan->status ?? 'pending'));

    if (! in_array($statusSaatIni, ['accepted', 'diterima', 'approved', 'disetujui'])) {
        return back()->with('error', 'Pesanan belum bisa diselesaikan karena belum diterima.');
    }

    $pesanan->status = 'completed';
    $pesanan->save();

    return back()->with('success', 'Pesanan berhasil dikonfirmasi selesai.');
})->middleware('auth')->name('pesanan.masuk.selesai.final');
