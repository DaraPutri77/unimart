<x-app-layout>
    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900">Pesanan Saya</h1>
                <p class="mt-2 text-slate-600">Pantau semua pesanan yang kamu buat sebagai pembeli.</p>
            </div>

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

            @forelse ($pesanans as $pesanan)
                <div class="mb-5 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-pink-100">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <div class="mb-2 flex flex-wrap items-center gap-3">
                                <h2 class="text-xl font-extrabold text-slate-900">
                                    {{ $pesanan->kode_pesanan }}
                                </h2>

                                <span class="rounded-full border px-3 py-1 text-sm font-bold {{ $pesanan->status_badge }}">
                                    {{ $pesanan->status_label }}
                                </span>
                            </div>

                            <p class="text-sm text-slate-600">
                                Penjual:
                                <span class="font-bold text-slate-900">
                                    {{ $pesanan->seller->name ?? '-' }}
                                </span>
                            </p>

                            <p class="mt-1 text-sm text-slate-600">
                                Tanggal:
                                <span class="font-semibold">
                                    {{ $pesanan->created_at->format('d M Y H:i') }}
                                </span>
                            </p>

                            <p class="mt-1 text-sm text-slate-600">
                                Jumlah item:
                                <span class="font-semibold">
                                    {{ $pesanan->items->count() }}
                                </span>
                            </p>
                        </div>

                        <div class="text-left md:text-right">
                            <p class="text-sm text-slate-500">Total</p>
                            <p class="text-2xl font-extrabold text-pink-700">
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </p>

                            <a href="{{ route('pesanan.saya.show', $pesanan) }}"
                               class="mt-4 inline-flex rounded-2xl bg-slate-900 px-5 py-3 text-sm font-bold text-white hover:bg-pink-700">
                                Detail Pesanan
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl bg-white p-10 text-center shadow-sm ring-1 ring-pink-100">
                    <div class="text-6xl">🧾</div>
                    <h2 class="mt-4 text-2xl font-extrabold text-slate-900">Belum ada pesanan</h2>
                    <p class="mt-2 text-slate-600">
                        Tambahkan produk ke keranjang lalu checkout COD.
                    </p>

                    <a href="{{ route('produk.index') }}"
                       class="mt-6 inline-flex rounded-2xl bg-pink-700 px-6 py-3 font-bold text-white hover:bg-slate-900">
                        Cari Produk
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>