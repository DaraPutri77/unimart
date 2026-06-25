<x-app-layout>
    @php
        $seller = $produk->user;

        $cleanPhone = $seller && $seller->whatsapp
            ? preg_replace('/[^0-9]/', '', $seller->whatsapp)
            : null;

        $productUrl = route('produk.show', $produk);
        $productImageUrl = $produk->gambar_url;

        $waText = "Halo kak " . ($seller->name ?? '') . ", saya tertarik dengan produk " . $produk->nama . " di UniMart.\n\n";
        $waText .= "Detail produk:\n" . $productUrl . "\n\n";

        if ($productImageUrl) {
            $waText .= "Gambar produk:\n" . $productImageUrl . "\n\n";
        }

        $waText .= "Apakah produk ini masih tersedia untuk COD?";

        $waMessage = rawurlencode($waText);

        $waUrl = $cleanPhone
            ? "https://wa.me/{$cleanPhone}?text={$waMessage}"
            : null;

        $sellerPhoto = null;

        if ($seller && ! empty($seller->foto_profil)) {
            $sellerPhoto = asset('storage/' . $seller->foto_profil);
        }
    @endphp

    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('produk.index') }}"
               class="mb-6 inline-flex rounded-2xl bg-white px-5 py-3 font-extrabold text-pink-700 shadow-sm ring-1 ring-pink-100 hover:bg-pink-700 hover:text-white">
                ← Kembali ke Produk
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

            <div class="grid gap-8 lg:grid-cols-2">
                <div class="space-y-6">
                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-pink-100">
                        <div class="flex min-h-[420px] items-center justify-center overflow-hidden rounded-3xl bg-slate-50">
                            @if ($produk->gambar_url)
                                <img src="{{ $produk->gambar_url }}"
                                     alt="{{ $produk->nama }}"
                                     class="max-h-[520px] w-full object-contain">
                            @else
                                <div class="flex h-[420px] w-full items-center justify-center text-8xl">
                                    🛍️
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-pink-100">
                        <h2 class="text-2xl font-black text-slate-900">Profil Penjual</h2>

                        <div class="mt-6 flex flex-col gap-5 sm:flex-row sm:items-center">
                            <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-pink-700 to-slate-900 text-4xl font-black text-white">
                                @if ($sellerPhoto)
                                    <img src="{{ $sellerPhoto }}"
                                         alt="{{ $seller->name }}"
                                         class="h-full w-full object-cover">
                                @else
                                    {{ strtoupper(substr($seller->name ?? 'U', 0, 1)) }}
                                @endif
                            </div>

                            <div class="flex-1">
                                <h3 class="text-2xl font-black text-slate-900">
                                    {{ $seller->name ?? '-' }}
                                </h3>

                                <p class="mt-1 text-sm font-semibold text-slate-500">
                                    {{ $seller->email ?? '-' }}
                                </p>

                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="rounded-full bg-pink-100 px-4 py-2 text-xs font-extrabold text-pink-700">
                                        Penjual UniMart
                                    </span>

                                    @if ($cleanPhone)
                                        <span class="rounded-full bg-green-100 px-4 py-2 text-xs font-extrabold text-green-700">
                                            WhatsApp tersedia
                                        </span>
                                    @else
                                        <span class="rounded-full bg-red-100 px-4 py-2 text-xs font-extrabold text-red-700">
                                            WhatsApp belum tersedia
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 rounded-2xl bg-slate-50 p-5">
                            <h4 class="font-extrabold text-slate-900">Bio Penjual</h4>
                            <p class="mt-2 leading-7 text-slate-600">
                                {{ $seller->bio ?: 'Penjual belum menambahkan bio.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="h-fit rounded-3xl bg-white p-6 shadow-sm ring-1 ring-pink-100 lg:sticky lg:top-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-full bg-pink-100 px-4 py-2 text-xs font-extrabold text-pink-700">
                            {{ $produk->kategori }}
                        </span>

                        <span class="rounded-full bg-blue-100 px-4 py-2 text-xs font-extrabold text-blue-700">
                            {{ $produk->kondisi_label ?? ($produk->kondisi === 'baru' ? 'Barang Baru' : 'Barang Bekas') }}
                        </span>

                        <span class="rounded-full bg-slate-100 px-4 py-2 text-xs font-extrabold text-slate-700">
                            {{ $produk->fakultas }}
                        </span>

                        <span class="ml-auto rounded-full px-4 py-2 text-xs font-extrabold {{ $produk->aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $produk->aktif ? 'Tersedia' : 'Tidak Aktif' }}
                        </span>
                    </div>

                    <h1 class="mt-8 text-4xl font-black leading-tight text-slate-900">
                        {{ $produk->nama }}
                    </h1>

                    <p class="mt-6 text-5xl font-black text-pink-700">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </p>

                    <div class="mt-8 grid gap-4 rounded-3xl bg-slate-50 p-5">
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-slate-600">Stok</span>
                            <span class="font-black text-slate-900">{{ $produk->stok }}</span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-slate-600">Kondisi</span>
                            <span class="font-black text-slate-900">
                                {{ $produk->kondisi_label ?? ($produk->kondisi === 'baru' ? 'Barang Baru' : 'Barang Bekas') }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-slate-600">Fakultas</span>
                            <span class="font-black text-slate-900">{{ $produk->fakultas }}</span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-slate-600">Penjual</span>
                            <span class="text-right font-black text-slate-900">{{ $seller->name ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h2 class="text-2xl font-black text-slate-900">Deskripsi Produk</h2>
                        <p class="mt-4 leading-8 text-slate-600">
                            {{ $produk->deskripsi ?: 'Produk ini belum memiliki deskripsi.' }}
                        </p>
                    </div>

                    <div class="mt-8 space-y-3">
                        @if ((int) $produk->user_id === (int) auth()->id())
                            <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-4 font-semibold text-yellow-700">
                                Ini adalah produk milik kamu. Produk sendiri tidak bisa dimasukkan ke keranjang.
                            </div>

                            <div class="grid gap-3 sm:grid-cols-2">
                                <a href="{{ route('produk.edit', $produk) }}"
                                   class="rounded-2xl bg-yellow-500 px-6 py-4 text-center font-extrabold text-white hover:bg-yellow-600">
                                    Edit Produk
                                </a>

                                <form action="{{ route('produk.destroy', $produk) }}" method="POST"
                                      onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="w-full rounded-2xl bg-red-600 px-6 py-4 font-extrabold text-white hover:bg-red-700">
                                        Hapus Produk
                                    </button>
                                </form>
                            </div>
                        @else
                            @if ($produk->aktif && (int) $produk->stok > 0)
                                <form action="{{ route('keranjang.tambah', $produk) }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="mb-2 block font-extrabold text-slate-900">Jumlah</label>
                                        <input type="number"
                                               name="jumlah"
                                               value="1"
                                               min="1"
                                               max="{{ $produk->stok }}"
                                               class="w-28 rounded-2xl border-slate-200 text-center focus:border-pink-500 focus:ring-pink-500">
                                    </div>

                                    <button type="submit"
                                            class="w-full rounded-2xl bg-gradient-to-r from-slate-900 to-pink-700 px-6 py-4 font-extrabold text-white hover:from-pink-700 hover:to-slate-900">
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <div class="rounded-2xl border border-red-200 bg-red-50 p-4 font-semibold text-red-700">
                                    Produk sedang tidak tersedia atau stok habis.
                                </div>
                            @endif

                            @if ($waUrl)
                                <a href="{{ $waUrl }}"
                                   target="_blank"
                                   class="block w-full rounded-2xl bg-green-600 px-6 py-4 text-center font-extrabold text-white hover:bg-green-700">
                                    Hubungi Penjual via WhatsApp
                                </a>
                            @else
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-center font-semibold text-slate-500">
                                    Penjual belum menambahkan nomor WhatsApp.
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="mt-6 rounded-2xl bg-pink-50 p-4 text-sm font-semibold leading-6 text-slate-600">
                        Tips: Simpan produk ke keranjang dulu jika belum ingin langsung checkout. Saat checkout, kamu bisa memilih produk mana saja yang ingin dibeli.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>