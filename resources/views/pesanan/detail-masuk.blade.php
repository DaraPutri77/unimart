<x-app-layout>
    @php
        $statusAsli = strtolower((string) ($pesanan->status ?? 'pending'));

        $statusLabel = match ($statusAsli) {
            'pending' => 'Menunggu Konfirmasi Penjual',
            'accepted', 'diterima', 'approved', 'disetujui' => 'Disetujui, Menunggu COD',
            'rejected', 'ditolak' => 'Ditolak Penjual',
            'completed', 'selesai' => 'Pesanan Selesai',
            'canceled', 'cancelled', 'dibatalkan' => 'Dibatalkan Pembeli',
            default => ucfirst((string) ($pesanan->status ?? 'Pending')),
        };

        $statusClass = match ($statusAsli) {
            'pending' => 'border-yellow-300 bg-yellow-50 text-yellow-700',
            'accepted', 'diterima', 'approved', 'disetujui' => 'border-blue-300 bg-blue-50 text-blue-700',
            'rejected', 'ditolak' => 'border-red-300 bg-red-50 text-red-700',
            'completed', 'selesai' => 'border-green-300 bg-green-50 text-green-700',
            'canceled', 'cancelled', 'dibatalkan' => 'border-slate-300 bg-slate-50 text-slate-700',
            default => 'border-slate-300 bg-slate-50 text-slate-700',
        };

        $masihPending = $statusAsli === 'pending';

        $sudahDiterima = in_array($statusAsli, [
            'accepted',
            'diterima',
            'approved',
            'disetujui',
        ]);

        $sudahSelesai = in_array($statusAsli, [
            'completed',
            'selesai',
        ]);

        $items = collect();

        if (isset($pesanan->items)) {
            $items = collect($pesanan->items);
        } elseif (isset($pesanan->detailPesanans)) {
            $items = collect($pesanan->detailPesanans);
        } elseif (isset($pesanan->details)) {
            $items = collect($pesanan->details);
        } elseif (isset($pesanan->produk)) {
            $items = collect([$pesanan]);
        }

        $pembeli = $pesanan->pembeli
            ?? $pesanan->buyer
            ?? $pesanan->user
            ?? null;

        $namaPembeli = $pembeli->name ?? 'Pembeli';
        $whatsappPembeli = $pembeli->whatsapp ?? '';

        $nomorWa = preg_replace('/[^0-9]/', '', $whatsappPembeli);

        if (str_starts_with($nomorWa, '0')) {
            $nomorWa = '62' . substr($nomorWa, 1);
        }

        if (str_starts_with($nomorWa, '8')) {
            $nomorWa = '62' . $nomorWa;
        }

        $kodePesanan = $pesanan->kode_pesanan
            ?? $pesanan->kode
            ?? ('UM-' . str_pad((string) $pesanan->id, 6, '0', STR_PAD_LEFT));

        $metodePembayaran = $pesanan->metode_pembayaran
            ?? $pesanan->payment_method
            ?? 'COD';

        $lokasiCod = $pesanan->lokasi_cod
            ?? $pesanan->lokasi
            ?? $pesanan->alamat
            ?? '-';

        $catatan = $pesanan->catatan
            ?? $pesanan->note
            ?? $pesanan->notes
            ?? '-';

        $tanggalPesanan = $pesanan->created_at
            ? $pesanan->created_at->format('d M Y H:i')
            : '-';

        $totalPesanan = $pesanan->total_harga
            ?? $pesanan->total
            ?? $pesanan->subtotal
            ?? 0;

        if (! $totalPesanan && $items->count() > 0) {
            $totalPesanan = $items->sum(function ($item) {
                $produk = $item->produk ?? $item;

                $harga = $item->harga
                    ?? $item->harga_satuan
                    ?? $produk->harga
                    ?? 0;

                $jumlah = $item->jumlah
                    ?? $item->qty
                    ?? $item->quantity
                    ?? 1;

                return $harga * $jumlah;
            });
        }

        $pesanWa = "Halo Kak {$namaPembeli}, pesanan kamu di UniMart sudah saya terima.\n\n";
        $pesanWa .= "Kode Pesanan: {$kodePesanan}\n";
        $pesanWa .= "Total: Rp " . number_format($totalPesanan, 0, ',', '.') . "\n";
        $pesanWa .= "Metode Pembayaran: {$metodePembayaran}\n";
        $pesanWa .= "Lokasi COD: {$lokasiCod}\n\n";
        $pesanWa .= "Mari kita lanjutkan proses COD. Terima kasih.";

        $linkWa = $nomorWa
            ? 'https://web.whatsapp.com/send?phone=' . $nomorWa . '&text=' . urlencode($pesanWa)
            : '#';
    @endphp

    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6">
                @if (\Illuminate\Support\Facades\Route::has('pesanan.masuk'))
                    <a href="{{ route('pesanan.masuk') }}"
                       class="inline-flex items-center text-base font-black text-pink-700 hover:text-pink-900">
                        ? Kembali ke Pesanan Masuk
                    </a>
                @endif
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-3xl border border-green-200 bg-green-50 px-6 py-5 text-base font-black text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-6 py-5 text-base font-black text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <section class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-pink-100 lg:p-10">
                <div class="flex flex-wrap items-start justify-between gap-6">
                    <div>
                        <h1 class="text-4xl font-black tracking-tight text-slate-900">
                            {{ $kodePesanan }}
                        </h1>

                        <div class="mt-5 space-y-2 text-lg text-slate-600">
                            <p>
                                Metode pembayaran:
                                <span class="font-black text-slate-900">
                                    {{ $metodePembayaran }}
                                </span>
                            </p>

                            <p>
                                Lokasi COD:
                                <span class="font-black text-slate-900">
                                    {{ $lokasiCod }}
                                </span>
                            </p>

                            <p>
                                Catatan buyer:
                                <span class="font-black text-slate-900">
                                    {{ $catatan }}
                                </span>
                            </p>

                            <p>
                                Tanggal:
                                <span class="font-black text-slate-900">
                                    {{ $tanggalPesanan }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <span class="inline-flex rounded-full border px-6 py-3 text-sm font-black {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>
                </div>

                <div class="mt-10 rounded-3xl bg-slate-50 p-7">
                    <h2 class="text-2xl font-black text-slate-900">
                        Pembeli
                    </h2>

                    <div class="mt-5">
                        <p class="text-lg font-bold text-slate-700">
                            {{ $namaPembeli }}
                        </p>
                    </div>

                    <div class="mt-6">
                        @if ($masihPending)
                            <div class="flex flex-wrap gap-4">
                                <form method="POST"
                                      action="{{ route('pesanan.masuk.terima.final', $pesanan) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="inline-flex items-center justify-center rounded-3xl bg-green-600 px-7 py-4 text-base font-black text-white shadow-sm transition hover:bg-green-700">
                                        Terima Pesanan
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('pesanan.masuk.tolak.final', $pesanan) }}"
                                      onsubmit="return confirm('Yakin ingin menolak pesanan ini?')">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="inline-flex items-center justify-center rounded-3xl bg-red-600 px-7 py-4 text-base font-black text-white shadow-sm transition hover:bg-red-700">
                                        Tolak Pesanan
                                    </button>
                                </form>
                            </div>
                        @elseif ($sudahDiterima)
                            <div class="flex flex-wrap gap-4">
                                @if ($nomorWa)
                                    <a href="{{ $linkWa }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       onclick="navigator.clipboard && navigator.clipboard.writeText(@js($pesanWa));"
                                       class="inline-flex items-center justify-center rounded-3xl bg-green-600 px-7 py-4 text-base font-black text-white shadow-sm transition hover:bg-green-700">
                                        Hubungi Pembeli via WhatsApp
                                    </a>
                                @endif

                                <form method="POST"
                                      action="{{ route('pesanan.masuk.selesai.final', $pesanan) }}"
                                      onsubmit="return confirm('Yakin pesanan ini sudah selesai?')">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="inline-flex items-center justify-center rounded-3xl bg-slate-950 px-7 py-4 text-base font-black text-white shadow-sm transition hover:bg-pink-700">
                                        Konfirmasi Pesanan Selesai
                                    </button>
                                </form>
                            </div>

                            <div class="mt-5 rounded-3xl border border-blue-200 bg-blue-50 px-6 py-5">
                                <p class="text-base font-black text-blue-700">
                                    Pesanan sudah disetujui.
                                </p>

                                <p class="mt-2 text-sm font-semibold leading-6 text-blue-700">
                                    Lanjutkan proses COD. Setelah transaksi selesai, klik tombol Konfirmasi Pesanan Selesai.
                                </p>
                            </div>
                        @elseif ($sudahSelesai)
                            <div class="rounded-3xl border border-green-200 bg-green-50 px-6 py-5">
                                <p class="text-base font-black text-green-700">
                                    Pesanan selesai.
                                </p>

                                <p class="mt-2 text-sm font-semibold leading-6 text-green-700">
                                    Transaksi ini sudah dikonfirmasi selesai.
                                </p>
                            </div>
                        @else
                            <div class="rounded-3xl border border-slate-200 bg-white px-6 py-5">
                                <p class="text-base font-black text-slate-700">
                                    Tidak ada aksi lanjutan untuk status pesanan ini.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-10">
                    <h2 class="text-2xl font-black text-slate-900">
                        Item Pesanan
                    </h2>

                    <div class="mt-5 overflow-hidden rounded-3xl border border-pink-100 bg-white">
                        <div class="hidden grid-cols-[1fr_160px_120px_160px] gap-4 bg-slate-950 px-6 py-4 text-sm font-black uppercase tracking-wider text-white md:grid">
                            <div>Produk</div>
                            <div class="text-right">Harga</div>
                            <div class="text-center">Jumlah</div>
                            <div class="text-right">Subtotal</div>
                        </div>

                        <div class="divide-y divide-pink-100">
                            @forelse ($items as $item)
                                @php
                                    $produk = $item->produk ?? $item;

                                    $namaItem = $produk->nama
                                        ?? $produk->title
                                        ?? 'Produk';

                                    $hargaItem = $item->harga
                                        ?? $item->harga_satuan
                                        ?? $produk->harga
                                        ?? 0;

                                    $jumlahItem = $item->jumlah
                                        ?? $item->qty
                                        ?? $item->quantity
                                        ?? 1;

                                    $subtotalItem = $hargaItem * $jumlahItem;
                                @endphp

                                <div class="grid gap-4 px-6 py-5 md:grid-cols-[1fr_160px_120px_160px] md:items-center">
                                    <div>
                                        <p class="text-lg font-black text-slate-900">
                                            {{ $namaItem }}
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-slate-500">
                                            {{ $produk->kategori ?? '-' }}
                                        </p>
                                    </div>

                                    <div class="text-left font-black text-slate-900 md:text-right">
                                        <span class="md:hidden text-slate-500">Harga: </span>
                                        Rp {{ number_format($hargaItem, 0, ',', '.') }}
                                    </div>

                                    <div class="text-left font-black text-slate-900 md:text-center">
                                        <span class="md:hidden text-slate-500">Jumlah: </span>
                                        {{ $jumlahItem }}
                                    </div>

                                    <div class="text-left text-xl font-black text-pink-700 md:text-right">
                                        <span class="md:hidden text-slate-500">Subtotal: </span>
                                        Rp {{ number_format($subtotalItem, 0, ',', '.') }}
                                    </div>
                                </div>
                            @empty
                                <div class="px-6 py-8 text-center font-bold text-slate-500">
                                    Item pesanan tidak ditemukan.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <div class="w-full max-w-sm rounded-3xl bg-pink-50 p-6">
                            <p class="text-sm font-black text-slate-500">
                                Total Pesanan
                            </p>

                            <p class="mt-2 text-4xl font-black text-pink-700">
                                Rp {{ number_format($totalPesanan, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

                    @if(!empty($pesanan->rating))
                        <div class="mt-5 rounded-2xl border border-yellow-200 bg-yellow-50 p-4">
                            <p class="text-sm font-bold text-slate-900">Rating dari Pembeli</p>
                            <p class="mt-1 text-lg font-bold text-yellow-600">
                                {!! str_repeat('&#9733;', (int) $pesanan->rating) !!}{!! str_repeat('&#9734;', max(0, 5 - (int) $pesanan->rating)) !!}
                                <span class="ml-2 text-sm text-slate-600">({{ $pesanan->rating }}/5)</span>
                            </p>

                            @if(!empty($pesanan->ulasan))
                                <p class="mt-2 text-sm text-slate-700">"{{ $pesanan->ulasan }}"</p>
                            @endif
                        </div>
                    @endif
</x-app-layout>


