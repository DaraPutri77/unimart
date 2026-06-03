<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KeranjangController extends Controller
{
    public function index(): View
    {
        $keranjangs = Keranjang::with(['produk.user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('keranjang.index', compact('keranjangs'));
    }

    public function store(Produk $produk): RedirectResponse
    {
        $produk->load('user');

        if (! $produk->aktif) {
            return redirect()
                ->route('produk.show', $produk)
                ->with('success', 'Produk ini sudah terjual dan tidak bisa dimasukkan ke keranjang.');
        }

        if ($produk->user_id === Auth::id()) {
            return redirect()
                ->route('produk.show', $produk)
                ->with('success', 'Produk milik sendiri tidak perlu dimasukkan ke keranjang.');
        }

        Keranjang::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'produk_id' => $produk->id,
            ],
            [
                'jumlah' => 1,
            ]
        );

        return redirect()
            ->route('keranjang.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function destroy(Keranjang $keranjang): RedirectResponse
    {
        if ($keranjang->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki akses untuk menghapus item keranjang ini.');
        }

        $keranjang->delete();

        return redirect()
            ->route('keranjang.index')
            ->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}