<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SellerPesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with(['buyer', 'items'])
            ->where('seller_id', Auth::id())
            ->latest()
            ->get();

        return view('pesanan.masuk', compact('pesanans'));
    }

    public function show(Pesanan $pesanan)
    {
        if ((int) $pesanan->seller_id !== (int) Auth::id()) {
            abort(403);
        }

        $pesanan->load(['buyer', 'items.produk']);

        return view('pesanan.detail-masuk', compact('pesanan'));
    }

    public function accept(Pesanan $pesanan)
    {
        if ((int) $pesanan->seller_id !== (int) Auth::id()) {
            abort(403);
        }

        if (! $pesanan->canBeRespondedBySeller()) {
            return back()->with('error', 'Pesanan ini sudah diproses.');
        }

        try {
            DB::transaction(function () use ($pesanan) {
                $pesanan->load('items.produk');

                foreach ($pesanan->items as $item) {
                    if (! $item->produk) {
                        throw ValidationException::withMessages([
                            'produk' => 'Ada produk pada pesanan ini yang sudah terhapus.',
                        ]);
                    }

                    if (! $item->produk->aktif) {
                        throw ValidationException::withMessages([
                            'produk' => 'Produk ' . $item->nama_produk . ' sedang tidak aktif.',
                        ]);
                    }

                    if ((int) $item->produk->stok < (int) $item->jumlah) {
                        throw ValidationException::withMessages([
                            'stok' => 'Stok produk ' . $item->nama_produk . ' tidak mencukupi.',
                        ]);
                    }
                }

                foreach ($pesanan->items as $item) {
                    $produk = $item->produk;
                    $produk->stok = max(0, (int) $produk->stok - (int) $item->jumlah);

                    if ((int) $produk->stok <= 0) {
                        $produk->aktif = false;
                    }

                    $produk->save();
                }

                $pesanan->update([
                    'status' => Pesanan::STATUS_ACCEPTED,
                    'accepted_at' => now(),
                    'alasan_penolakan' => null,
                ]);
            });
        } catch (ValidationException $exception) {
            return back()->with('error', collect($exception->errors())->flatten()->first());
        }

        return back()->with('success', 'Pesanan berhasil disetujui. Pembeli dapat melanjutkan COD.');
    }

    public function reject(Request $request, Pesanan $pesanan)
    {
        if ((int) $pesanan->seller_id !== (int) Auth::id()) {
            abort(403);
        }

        if (! $pesanan->canBeRespondedBySeller()) {
            return back()->with('error', 'Pesanan ini sudah diproses.');
        }

        $request->validate([
            'alasan_penolakan' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.min' => 'Alasan penolakan minimal 5 karakter.',
            'alasan_penolakan.max' => 'Alasan penolakan maksimal 1000 karakter.',
        ]);

        $pesanan->update([
            'status' => Pesanan::STATUS_REJECTED,
            'alasan_penolakan' => $request->alasan_penolakan,
            'rejected_at' => now(),
        ]);

        return back()->with('success', 'Pesanan berhasil ditolak dengan alasan yang jelas.');
    }
}