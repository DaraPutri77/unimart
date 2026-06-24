<x-app-layout>
    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('pesanan.masuk') }}" class="mb-5 inline-block font-bold text-pink-700 hover:text-slate-900">
                ← Kembali ke Pesanan Masuk
            </a>

            @if (session('success'))
                <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 font-semibold text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-pink-100">
                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900">{{ $pesanan->kode_pesanan }}</h1>
                        <p class="mt-2 text-slate-600">Metode pembayaran: <b>{{ $pesanan->metode_pembayaran }}</b></p>
                        <p class="mt-1 text-slate-600">Lokasi COD: <b>{{ $pesanan->lokasi_cod ?: '-' }}</b></p>
                        <p class="mt-1 text-slate-600">Catatan buyer: <b>{{ $pesanan->catatan ?: '-' }}</b></p>
                    </div>

                    <span class="rounded-full border px-4 py-2 text-sm font-bold {{ $pesanan->status_badge }}">
                        {{ $pesanan->status_label }}
                    </span>
                </div>

                <div class="mt-8 rounded-2xl bg-slate-50 p-5">
                    <h2 class="text-xl font-extrabold text-slate-900">Pembeli</h2>
                    <p class="mt-2 text-slate-700">{{ $pesanan->buyer->name ?? '-' }}</p>
                    <p class="text-slate-600">{{ $pesanan->buyer->email ?? '-' }}</p>

                    @if (! empty($pesanan->buyer->whatsapp))
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesanan->buyer->whatsapp) }}"
                           target="_blank"
                           class="mt-4 inline-flex rounded-2xl bg-green-600 px-5 py-3 font-bold text-white hover:bg-green-700">
                            Hubungi Pembeli via WhatsApp
                        </a>
                    @endif
                </div>

                <div class="mt-8">
                    <h2 class="mb-4 text-xl font-extrabold text-slate-900">Item Pesanan</h2>

                    <div class="overflow-hidden rounded-2xl border border-slate-100">
                        <table class="w-full text-left">
                            <thead class="bg-slate-900 text-white">
                                <tr>
                                    <th class="px-4 py-3">Produk</th>
                                    <th class="px-4 py-3">Harga</th>
                                    <th class="px-4 py-3">Jumlah</th>
                                    <th class="px-4 py-3">Subtotal</th>
                                    <th class="px-4 py-3">Stok Saat Ini</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @foreach ($pesanan->items as $item)
                                    <tr>
                                        <td class="px-4 py-3 font-bold text-slate-900">{{ $item->nama_produk }}</td>
                                        <td class="px-4 py-3">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3">{{ $item->jumlah }}</td>
                                        <td class="px-4 py-3 font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3">{{ $item->produk->stok ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5 text-right">
                        <p class="text-sm text-slate-500">Total Pesanan</p>
                        <p class="text-3xl font-extrabold text-pink-700">
                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                @if ($pesanan->canBeRespondedBySeller())
                    <div class="mt-8 flex flex-col gap-3 md:flex-row">
                        <form action="{{ route('pesanan.accept', $pesanan) }}" method="POST"
                              onsubmit="return confirm('Setujui pesanan ini? Stok produk akan berkurang.')">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="rounded-2xl bg-green-600 px-6 py-3 font-bold text-white hover:bg-green-700">
                                Setujui Pesanan
                            </button>
                        </form>

                        <form action="{{ route('pesanan.reject', $pesanan) }}" method="POST"
                              onsubmit="return confirm('Tolak pesanan ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="rounded-2xl bg-red-600 px-6 py-3 font-bold text-white hover:bg-red-700">
                                Tolak Pesanan
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>