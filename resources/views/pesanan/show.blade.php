<x-app-layout>
    @php
        $statusAsli = strtolower((string) ($pesanan->status ?? 'pending'));

        $statusLabel = match ($statusAsli) {
            'pending' => 'Menunggu Konfirmasi Penjual',
            'accepted', 'diterima', 'approved', 'disetujui' => 'Diterima Penjual',
            'rejected', 'ditolak' => 'Ditolak Penjual',
            'completed', 'selesai' => 'Selesai',
            'canceled', 'cancelled', 'dibatalkan' => 'Dibatalkan Pembeli',
            default => ucfirst((string) ($pesanan->status ?? 'Pending')),
        };

        $statusClass = match ($statusAsli) {
            'pending' => 'border-yellow-300 bg-yellow-50 text-yellow-700',
            'accepted', 'diterima', 'approved', 'disetujui' => 'border-green-300 bg-green-50 text-green-700',
            'rejected', 'ditolak' => 'border-red-300 bg-red-50 text-red-700',
            'completed', 'selesai' => 'border-blue-300 bg-blue-50 text-blue-700',
            'canceled', 'cancelled', 'dibatalkan' => 'border-slate-300 bg-slate-50 text-slate-700',
            default => 'border-slate-300 bg-slate-50 text-slate-700',
        };

        $penjual = $pesanan->penjual
            ?? $pesanan->seller
            ?? $pesanan->produk->user
            ?? null;

        $namaPenjual = $penjual->name ?? 'Penjual';
        $emailPenjual = $penjual->email ?? '-';

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
    @endphp

    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6">
                @if (\Illuminate\Support\Facades\Route::has('pesanan.saya'))
                    <a href="{{ route('pesanan.saya') }}"
                       class="inline-flex items-center text-base font-black text-pink-700 hover:text-pink-900">
                        ? Kembali ke Pesanan Saya
                    </a>
                @endif
            </div>

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
                                Catatan:
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
                        Penjual
                    </h2>

                    <div class="mt-5">
                        <p class="text-lg font-bold text-slate-700">
                            {{ $namaPenjual }}
                        </p>
                    </div>

                    <div class="mt-6 rounded-3xl border border-yellow-200 bg-yellow-50 px-6 py-5">
                        <p class="text-base font-black text-yellow-700">
                            Pesanan masih menunggu konfirmasi penjual.
                        </p>

                        <p class="mt-2 text-sm font-semibold leading-6 text-yellow-700">
                            Kontak WhatsApp tidak ditampilkan pada tahap ini agar alur pesanan tetap melalui proses konfirmasi terlebih dahulu.
                        </p>
                    </div>
                </div>

                <div class="mt-10">
                    <h2 class="text-2xl font-black text-slate-900">
                        Item Pesanan
                    </h2>

                    <div class="mt-5 overflow-hidden rounded-3xl border border-pink-100 bg-white">
                        <div class="hidden grid-cols-[1fr_120px_160px_160px] gap-4 bg-slate-950 px-6 py-4 text-sm font-black uppercase tracking-wider text-white md:grid">
                            <div>Produk</div>
                            <div class="text-center">Jumlah</div>
                            <div class="text-right">Harga</div>
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

                                    $gambarItem = $produk->gambar_url ?? null;

                                    if (! $gambarItem && ! empty($produk->gambar)) {
                                        $gambarItem = asset('storage/' . $produk->gambar);
                                    }
                                @endphp

                                <div class="grid gap-4 px-6 py-5 md:grid-cols-[1fr_120px_160px_160px] md:items-center">
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-pink-50">
                                            @if ($gambarItem)
                                                <img src="{{ $gambarItem }}"
                                                     alt="{{ $namaItem }}"
                                                     class="h-full w-full object-cover">
                                            @else
                                                <span class="text-2xl">
                                                    ???
                                                </span>
                                            @endif
                                        </div>

                                        <div>
                                            <p class="text-lg font-black text-slate-900">
                                                {{ $namaItem }}
                                            </p>

                                            <p class="mt-1 text-sm font-bold text-slate-500">
                                                {{ $produk->kategori ?? '-' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="text-left font-black text-slate-900 md:text-center">
                                        <span class="md:hidden text-slate-500">Jumlah: </span>
                                        {{ $jumlahItem }}
                                    </div>

                                    <div class="text-left font-black text-slate-900 md:text-right">
                                        <span class="md:hidden text-slate-500">Harga: </span>
                                        Rp {{ number_format($hargaItem, 0, ',', '.') }}
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
</x-app-layout>

