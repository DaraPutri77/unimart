<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PesananSelesaiController extends Controller
{
    public function __invoke(Request $request, Pesanan $pesanan): RedirectResponse
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'ulasan' => ['nullable', 'string', 'max:500'],
        ], [
            'rating.required' => 'Rating wajib dipilih sebelum menyelesaikan pesanan.',
        ]);

        $userId = $request->user()->id;

        $isPembeli = false;

        foreach (['pembeli_id', 'buyer_id', 'user_id'] as $column) {
            if (Schema::hasColumn('pesanans', $column) && (int) $pesanan->{$column} === (int) $userId) {
                $isPembeli = true;
                break;
            }
        }

        abort_if(! $isPembeli, 403);

        $status = strtolower((string) $pesanan->status);

        if (! in_array($status, ['accepted', 'diterima', 'approved', 'disetujui'], true)) {
            return back()->with('error', 'Pesanan hanya bisa diselesaikan setelah diterima penjual.');
        }

        if (Schema::hasColumn('pesanans', 'rating')) {
            $pesanan->rating = $request->integer('rating');
        }

        if (Schema::hasColumn('pesanans', 'ulasan')) {
            $pesanan->ulasan = $request->input('ulasan');
        }

        $pesanan->status = 'completed';
        $pesanan->save();

        return redirect()
            ->route('pesanan.saya')
            ->with('success', 'Pesanan selesai. Terima kasih sudah memberikan rating.');
    }
}
