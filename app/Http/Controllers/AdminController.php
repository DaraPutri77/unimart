<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $totalUser = User::count();

        $totalAdmin = User::where('is_admin', true)->count();

        $totalUserBiasa = User::where('is_admin', false)->count();

        $totalProduk = Produk::count();

        $produkTersedia = Produk::where('aktif', true)->count();

        $produkTerjual = Produk::where('aktif', false)->count();

        $produkTerbaru = Produk::with('user')
            ->latest()
            ->take(8)
            ->get();

        return view('admin.index', compact(
            'totalUser',
            'totalAdmin',
            'totalUserBiasa',
            'totalProduk',
            'produkTersedia',
            'produkTerjual',
            'produkTerbaru'
        ));
    }

    public function destroyProduk(Produk $produk): RedirectResponse
    {
        $produk->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Produk berhasil dihapus oleh admin.');
    }
}