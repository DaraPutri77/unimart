<x-app-layout>
    @php
        $penjual = $produk->user ?? null;

        $namaProduk = $produk->nama ?? 'Produk';
        $hargaProduk = $produk->harga ?? 0;
        $stokProduk = $produk->stok ?? 0;
        $kategoriProduk = $produk->kategori ?? '-';
        $kondisiProduk = $produk->kondisi_label ?? (($produk->kondisi ?? 'bekas') === 'baru' ? 'Barang Baru' : 'Barang Bekas');
        $fakultasProduk = $produk->fakultas ?? '-';
        $deskripsiProduk = $produk->deskripsi ?? '-';

        $gambarProduk = $produk->gambar_url ?? null;

        if (! $gambarProduk && ! empty($produk->gambar)) {
            $gambarProduk = asset('storage/' . $produk->gambar);
        }

        $namaPenjual = $penjual->name ?? 'Penjual';
        $emailPenjual = $penjual->email ?? '-';
        $fakultasPenjual = $penjual->fakultas ?? '-';
        $whatsappPenjual = $penjual->whatsapp ?? 'Belum tersedia';

        $isProdukSaya = auth()->check() && $penjual && auth()->id() === $penjual->id;
    @endphp

    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-black uppercase tracking-[0.35em] text-pink-500">
                        Detail Produk
                    </p>

                    <h1 class="mt-4 text-4xl font-black tracking-tight text-slate-900">
                        {{ $namaProduk }}
                    </h1>

                    <p class="mt-3 text-lg font-semibold text-slate-500">
                        Lihat informasi lengkap produk sebelum memasukkan ke keranjang.
                    </p>
                </div>

                @if (\Illuminate\Support\Facades\Route::has('produk.index'))
                    <a href="{{ route('produk.index') }}"
                       class="rounded-2xl bg-white px-6 py-4 text-sm font-black text-slate-700 shadow-sm ring-1 ring-pink-100 transition hover:bg-pink-50 hover:text-pink-700">
                        ← Kembali ke Produk
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

            <div class="grid gap-8 lg:grid-cols-[1fr_460px]">
                <section class="overflow-hidden rounded-[2rem] bg-white shadow-sm ring-1 ring-pink-100">
                    <div class="flex min-h-[420px] items-center justify-center bg-slate-50 p-8">
                        @if ($gambarProduk)
                            <img src="{{ $gambarProduk }}"
                                 alt="{{ $namaProduk }}"
                                 class="max-h-[520px] w-full rounded-[1.5rem] object-contain">
                        @else
                            <div class="flex h-[360px] w-full flex-col items-center justify-center rounded-[1.5rem] bg-pink-50 text-center text-pink-700">
                                <div class="text-7xl">🛍️</div>

                                <p class="mt-4 text-lg font-black">
                                    Gambar belum tersedia
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="p-8 lg:p-10">
                        <div class="flex flex-wrap gap-3">
                            <span class="rounded-full bg-pink-100 px-5 py-2 text-sm font-black text-pink-700">
                                {{ $kategoriProduk }}
                            </span>

                            <span class="rounded-full bg-blue-100 px-5 py-2 text-sm font-black text-blue-700">
                                {{ $kondisiProduk }}
                            </span>

                            <span class="rounded-full bg-slate-100 px-5 py-2 text-sm font-black text-slate-700">
                                {{ $fakultasProduk }}
                            </span>

                            <span class="rounded-full bg-green-100 px-5 py-2 text-sm font-black text-green-700">
                                {{ $stokProduk > 0 ? 'Tersedia' : 'Stok Habis' }}
                            </span>
                        </div>

                        <h2 class="mt-8 text-4xl font-black leading-tight tracking-tight text-slate-900">
                            {{ $namaProduk }}
                        </h2>

                        <p class="mt-5 text-5xl font-black tracking-tight text-pink-700">
                            Rp {{ number_format($hargaProduk, 0, ',', '.') }}
                        </p>

                        <div class="mt-8 grid gap-4 md:grid-cols-3">
                            <div class="rounded-3xl bg-pink-50 p-5">
                                <p class="text-sm font-black text-slate-500">
                                    Stok
                                </p>

                                <p class="mt-2 text-2xl font-black text-slate-900">
                                    {{ $stokProduk }}
                                </p>
                            </div>

                            <div class="rounded-3xl bg-pink-50 p-5">
                                <p class="text-sm font-black text-slate-500">
                                    Kondisi
                                </p>

                                <p class="mt-2 text-2xl font-black text-slate-900">
                                    {{ $kondisiProduk }}
                                </p>
                            </div>

                            <div class="rounded-3xl bg-pink-50 p-5">
                                <p class="text-sm font-black text-slate-500">
                                    Fakultas
                                </p>

                                <p class="mt-2 text-2xl font-black text-slate-900">
                                    {{ $fakultasProduk }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-2xl font-black text-slate-900">
                                Deskripsi Produk
                            </h3>

                            <p class="mt-4 whitespace-pre-line text-lg leading-8 text-slate-600">
                                {{ $deskripsiProduk }}
                            </p>
                        </div>
                    </div>
                </section>

                <aside class="h-fit rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-pink-100">
                    <h2 class="text-3xl font-black tracking-tight text-slate-900">
                        Informasi Penjual
                    </h2>

                    <div class="mt-7 flex items-center gap-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-pink-700 to-slate-950 text-2xl font-black text-white">
                            {{ strtoupper(substr($namaPenjual, 0, 1)) }}
                        </div>

                        <div>
                            <p class="text-xl font-black text-slate-900">
                                {{ $namaPenjual }}
                            </p>

                            <p class="mt-1 text-sm font-bold text-slate-500">
                                {{ $emailPenjual }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-7 space-y-4">
                        <div class="rounded-3xl bg-pink-50 p-5">
                            <p class="text-sm font-black text-slate-500">
                                WhatsApp
                            </p>

                            <p class="mt-2 text-lg font-black text-pink-700">
                                {{ $whatsappPenjual }}
                            </p>
                        </div>

                        <div class="rounded-3xl bg-pink-50 p-5">
                            <p class="text-sm font-black text-slate-500">
                                Fakultas Penjual
                            </p>

                            <p class="mt-2 text-lg font-black text-slate-900">
                                {{ $fakultasPenjual }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        @if (! $isProdukSaya)
                            @if ($stokProduk > 0)
                                @if (\Illuminate\Support\Facades\Route::has('keranjang.store'))
                                    <form method="POST" action="{{ route('keranjang.store', $produk) }}">
                                        @csrf

                                        <button type="submit"
                                                class="flex w-full items-center justify-center rounded-3xl bg-pink-600 px-6 py-4 text-base font-black text-white shadow-sm transition hover:bg-pink-700">
                                            + Masukkan Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button type="button"
                                            disabled
                                            class="flex w-full cursor-not-allowed items-center justify-center rounded-3xl bg-slate-300 px-6 py-4 text-base font-black text-white">
                                        Keranjang Belum Tersedia
                                    </button>
                                @endif
                            @else
                                <button type="button"
                                        disabled
                                        class="flex w-full cursor-not-allowed items-center justify-center rounded-3xl bg-slate-300 px-6 py-4 text-base font-black text-white">
                                    Stok Produk Habis
                                </button>
                            @endif
                        @else
                            @if (\Illuminate\Support\Facades\Route::has('produk.edit'))
                                <a href="{{ route('produk.edit', $produk) }}"
                                   class="flex w-full items-center justify-center rounded-3xl bg-yellow-400 px-6 py-4 text-base font-black text-white shadow-sm transition hover:bg-yellow-500">
                                    Edit Produk
                                </a>
                            @endif

                            @if (\Illuminate\Support\Facades\Route::has('produk.saya'))
                                <a href="{{ route('produk.saya') }}"
                                   class="flex w-full items-center justify-center rounded-3xl bg-slate-950 px-6 py-4 text-base font-black text-white shadow-sm transition hover:bg-pink-700">
                                    Kembali ke Produk Saya
                                </a>
                            @endif
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>