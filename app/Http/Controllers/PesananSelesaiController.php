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
        $user = $request->user();

        $kolomPembeli = null;

        foreach (['pembeli_id', 'buyer_id', 'user_id'] as $kolom) {
            if (Schema::hasColumn('pesanans', $kolom)) {
                $kolomPembeli = $kolom;
                break;
            }
        }

        if ($kolomPembeli && (int) $pesanan->{$kolomPembeli} !== (int) $user->id) {
            abort(403);
        }

        $statusSaatIni = strtolower((string) ($pesanan->status ?? 'pending'));

        $bolehDiselesaikan = in_array($statusSaatIni, [
            'accepted',
            'diterima',
            'approved',
            'disetujui',
        ]);

        if (! $bolehDiselesaikan) {
            return back()->with('error', 'Pesanan belum bisa diselesaikan karena belum diterima penjual.');
        }

        $pesanan->status = 'completed';
        $pesanan->save();

        return back()->with('success', 'Pesanan berhasil dikonfirmasi selesai.');
    }
}
