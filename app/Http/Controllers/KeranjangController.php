<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjangs = Keranjang::with(['produk.user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('keranjang.index', compact('keranjangs'));
    }

    public function store(Request $request, Produk $produk)
    {
        if ((int) $produk->user_id === (int) Auth::id()) {
            return back()->with('error', 'Kamu tidak bisa memasukkan produk sendiri ke keranjang.');
        }

        if (! $produk->aktif) {
            return back()->with('error', 'Produk ini sedang tidak aktif.');
        }

        if ((int) $produk->stok <= 0) {
            return back()->with('error', 'Stok produk ini sudah habis.');
        }

        $jumlah = (int) $request->input('jumlah', 1);
        $jumlah = max(1, $jumlah);

        $keranjang = Keranjang::firstOrNew([
            'user_id' => Auth::id(),
            'produk_id' => $produk->id,
        ]);

        $jumlahBaru = (int) ($keranjang->jumlah ?? 0) + $jumlah;

        if ($jumlahBaru > (int) $produk->stok) {
            return back()->with('error', 'Jumlah produk di keranjang melebihi stok yang tersedia.');
        }

        $keranjang->jumlah = $jumlahBaru;
        $keranjang->save();

        return redirect()
            ->route('keranjang.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, Keranjang $keranjang)
    {
        if ((int) $keranjang->user_id !== (int) Auth::id()) {
            abort(403);
        }

        $request->validate([
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $keranjang->load('produk');

        if (! $keranjang->produk) {
            $keranjang->delete();

            return redirect()
                ->route('keranjang.index')
                ->with('error', 'Produk sudah tidak tersedia dan dihapus dari keranjang.');
        }

        if ((int) $request->jumlah > (int) $keranjang->produk->stok) {
            return back()->with('error', 'Jumlah melebihi stok produk.');
        }

        $keranjang->update([
            'jumlah' => (int) $request->jumlah,
        ]);

        return back()->with('success', 'Jumlah produk di keranjang berhasil diperbarui.');
    }

    public function destroy(Keranjang $keranjang)
    {
        if ((int) $keranjang->user_id !== (int) Auth::id()) {
            abort(403);
        }

        $keranjang->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function clear()
    {
        Keranjang::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Keranjang berhasil dikosongkan.');
    }
}