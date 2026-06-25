<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\PesananItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BuyerPesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with(['seller', 'items'])
            ->where('buyer_id', Auth::id())
            ->latest()
            ->get();

        return view('pesanan.saya', compact('pesanans'));
    }

    public function show(Pesanan $pesanan)
    {
        if ((int) $pesanan->buyer_id !== (int) Auth::id()) {
            abort(403);
        }

        $pesanan->load(['seller', 'items.produk']);

        return view('pesanan.detail-saya', compact('pesanan'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'keranjang_ids' => ['required', 'array', 'min:1'],
            'keranjang_ids.*' => ['required', 'integer'],
            'lokasi_cod' => ['nullable', 'string', 'max:255'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], [
            'keranjang_ids.required' => 'Pilih minimal satu produk yang ingin di-checkout.',
            'keranjang_ids.array' => 'Format produk checkout tidak valid.',
            'keranjang_ids.min' => 'Pilih minimal satu produk yang ingin di-checkout.',
        ]);

        $keranjangIds = collect($request->keranjang_ids)
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();

        $keranjangs = Keranjang::with(['produk.user'])
            ->where('user_id', Auth::id())
            ->whereIn('id', $keranjangIds)
            ->get();

        if ($keranjangs->isEmpty()) {
            return back()->with('error', 'Pilih minimal satu produk yang ingin di-checkout.');
        }

        if ($keranjangs->count() !== $keranjangIds->count()) {
            return back()->with('error', 'Ada produk pilihan yang tidak valid atau bukan milik keranjang kamu.');
        }

        foreach ($keranjangs as $keranjang) {
            if (! $keranjang->produk) {
                return back()->with('error', 'Ada produk di keranjang yang sudah tidak tersedia.');
            }

            if ((int) $keranjang->produk->user_id === (int) Auth::id()) {
                return back()->with('error', 'Kamu tidak bisa checkout produk milik sendiri.');
            }

            if (! $keranjang->produk->aktif) {
                return back()->with('error', 'Produk ' . $keranjang->produk->nama . ' sedang tidak aktif.');
            }

            if ((int) $keranjang->produk->stok < (int) $keranjang->jumlah) {
                return back()->with('error', 'Stok produk ' . $keranjang->produk->nama . ' tidak mencukupi.');
            }
        }

        DB::transaction(function () use ($keranjangs, $request) {
            $groupedBySeller = $keranjangs->groupBy(function ($keranjang) {
                return $keranjang->produk->user_id;
            });

            foreach ($groupedBySeller as $sellerId => $items) {
                $totalHarga = $items->sum(function ($keranjang) {
                    return (int) $keranjang->produk->harga * (int) $keranjang->jumlah;
                });

                $pesanan = Pesanan::create([
                    'kode_pesanan' => 'UM-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
                    'buyer_id' => Auth::id(),
                    'seller_id' => $sellerId,
                    'status' => Pesanan::STATUS_PENDING,
                    'total_harga' => $totalHarga,
                    'metode_pembayaran' => 'COD',
                    'lokasi_cod' => $request->lokasi_cod,
                    'catatan' => $request->catatan,
                    'alasan_penolakan' => null,
                ]);

                foreach ($items as $keranjang) {
                    PesananItem::create([
                        'pesanan_id' => $pesanan->id,
                        'produk_id' => $keranjang->produk_id,
                        'nama_produk' => $keranjang->produk->nama,
                        'harga' => $keranjang->produk->harga,
                        'jumlah' => $keranjang->jumlah,
                        'subtotal' => (int) $keranjang->produk->harga * (int) $keranjang->jumlah,
                    ]);
                }
            }

            Keranjang::where('user_id', Auth::id())
                ->whereIn('id', $keranjangs->pluck('id'))
                ->delete();
        });

        return redirect()
            ->route('pesanan.saya')
            ->with('success', 'Checkout berhasil. Produk yang dipilih sudah dibuat menjadi pesanan COD.');
    }

    public function cancel(Pesanan $pesanan)
    {
        if ((int) $pesanan->buyer_id !== (int) Auth::id()) {
            abort(403);
        }

        if (! $pesanan->canBeCancelledByBuyer()) {
            return back()->with('error', 'Pesanan ini tidak bisa dibatalkan.');
        }

        $pesanan->update([
            'status' => Pesanan::STATUS_CANCELLED,
            'cancelled_at' => now(),
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function complete(Pesanan $pesanan)
    {
        if ((int) $pesanan->buyer_id !== (int) Auth::id()) {
            abort(403);
        }

        if (! $pesanan->canBeCompletedByBuyer()) {
            return back()->with('error', 'Pesanan hanya bisa diselesaikan setelah disetujui penjual.');
        }

        $pesanan->update([
            'status' => Pesanan::STATUS_COMPLETED,
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Pesanan berhasil ditandai selesai.');
    }
}