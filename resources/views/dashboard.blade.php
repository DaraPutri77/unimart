<x-app-layout>
    @php
        $user = auth()->user();

        $produkTableAda = \Illuminate\Support\Facades\Schema::hasTable('produks');
        $keranjangTableAda = \Illuminate\Support\Facades\Schema::hasTable('keranjangs');
        $pesananTableAda = \Illuminate\Support\Facades\Schema::hasTable('pesanans');

        $produkSaya = $produkTableAda && \Illuminate\Support\Facades\Schema::hasColumn('produks', 'user_id')
            ? \App\Models\Produk::where('user_id', $user->id)->count()
            : 0;

        $produkSayaAktif = $produkTableAda && \Illuminate\Support\Facades\Schema::hasColumn('produks', 'user_id')
            ? \App\Models\Produk::where('user_id', $user->id)->where('stok', '>', 0)->count()
            : 0;

        $keranjangSaya = $keranjangTableAda && \Illuminate\Support\Facades\Schema::hasColumn('keranjangs', 'user_id')
            ? \App\Models\Keranjang::where('user_id', $user->id)->count()
            : 0;

        $pesananSaya = 0;
        $pesananMasuk = 0;

        if ($pesananTableAda) {
            if (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'pembeli_id')) {
                $pesananSaya = \App\Models\Pesanan::where('pembeli_id', $user->id)->count();
            } elseif (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'buyer_id')) {
                $pesananSaya = \App\Models\Pesanan::where('buyer_id', $user->id)->count();
            } elseif (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'user_id')) {
                $pesananSaya = \App\Models\Pesanan::where('user_id', $user->id)->count();
            }

            if (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'penjual_id')) {
                $queryPesananMasuk = \App\Models\Pesanan::where('penjual_id', $user->id);

                if (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'status')) {
                    $queryPesananMasuk->where('status', 'pending');
                }

                $pesananMasuk = $queryPesananMasuk->count();
            } elseif (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'seller_id')) {
                $queryPesananMasuk = \App\Models\Pesanan::where('seller_id', $user->id);

                if (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'status')) {
                    $queryPesananMasuk->where('status', 'pending');
                }

                $pesananMasuk = $queryPesananMasuk->count();
            }
        }

        $routeProduk = \Illuminate\Support\Facades\Route::has('produk.index') ? route('produk.index') : '#';
        $routeProdukSaya = \Illuminate\Support\Facades\Route::has('produk.saya') ? route('produk.saya') : '#';
        $routeKeranjang = \Illuminate\Support\Facades\Route::has('keranjang.index') ? route('keranjang.index') : '#';
        $routePesananSaya = \Illuminate\Support\Facades\Route::has('pesanan.saya') ? route('pesanan.saya') : '#';
        $routePesananMasuk = \Illuminate\Support\Facades\Route::has('pesanan.masuk') ? route('pesanan.masuk') : '#';
    @endphp

    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <section class="mb-8 rounded-[2rem] bg-white p-10 shadow-sm ring-1 ring-pink-100">
                <p class="text-sm font-black uppercase tracking-[0.35em] text-pink-500">
                    Dashboard
                </p>

                <h1 class="mt-5 text-4xl font-black tracking-tight text-slate-900">
                    Selamat datang, {{ $user->name }}!
                </h1>

                <p class="mt-5 max-w-4xl text-lg leading-8 text-slate-600">
                    Kelola aktivitas jual beli kamu, mulai dari produk, keranjang, pesanan sebagai pembeli,
                    sampai pesanan masuk sebagai penjual.
                </p>
            </section>

            <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                    <p class="font-extrabold text-slate-500">
                        Produk Saya
                    </p>

                    <h2 class="mt-4 text-5xl font-black text-slate-900">
                        {{ $produkSaya }}
                    </h2>

                    <p class="mt-2 font-bold text-green-600">
                        {{ $produkSayaAktif }} aktif
                    </p>
                </div>

                <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                    <p class="font-extrabold text-slate-500">
                        Keranjang
                    </p>

                    <h2 class="mt-4 text-5xl font-black text-pink-700">
                        {{ $keranjangSaya }}
                    </h2>

                    <p class="mt-2 font-bold text-slate-500">
                        Item tersimpan
                    </p>
                </div>

                <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                    <p class="font-extrabold text-slate-500">
                        Pesanan Saya
                    </p>

                    <h2 class="mt-4 text-5xl font-black text-blue-600">
                        {{ $pesananSaya }}
                    </h2>

                    <p class="mt-2 font-bold text-slate-500">
                        Pesanan sebagai pembeli
                    </p>
                </div>

                <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                    <p class="font-extrabold text-slate-500">
                        Pesanan Masuk
                    </p>

                    <h2 class="mt-4 text-5xl font-black text-red-600">
                        {{ $pesananMasuk }}
                    </h2>

                    <p class="mt-2 font-bold text-slate-500">
                        Menunggu konfirmasi
                    </p>
                </div>
            </section>

            <section class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                <a href="{{ $routeProduk }}"
                   class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1 hover:shadow-xl">
                    <h2 class="text-2xl font-black text-slate-900">
                        Lihat Produk
                    </h2>

                    <p class="mt-4 leading-7 text-slate-600">
                        Cari produk milik user lain di marketplace.
                    </p>
                </a>

                <a href="{{ $routeProdukSaya }}"
                   class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1 hover:shadow-xl">
                    <h2 class="text-2xl font-black text-slate-900">
                        Produk Saya
                    </h2>

                    <p class="mt-4 leading-7 text-slate-600">
                        Tambah dan kelola produk jualanmu.
                    </p>
                </a>

                <a href="{{ $routeKeranjang }}"
                   class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1 hover:shadow-xl">
                    <h2 class="text-2xl font-black text-slate-900">
                        Keranjang
                    </h2>

                    <p class="mt-4 leading-7 text-slate-600">
                        Lanjutkan checkout produk yang kamu minati.
                    </p>
                </a>

                <a href="{{ $routePesananSaya }}"
                   class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1 hover:shadow-xl">
                    <h2 class="text-2xl font-black text-slate-900">
                        Pesanan Saya
                    </h2>

                    <p class="mt-4 leading-7 text-slate-600">
                        Lihat riwayat pesanan sebagai pembeli.
                    </p>
                </a>
            </section>

            <section class="mt-5 grid gap-5 md:grid-cols-2 xl:grid-cols-1">
                <a href="{{ $routePesananMasuk }}"
                   class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1 hover:shadow-xl">
                    <h2 class="text-2xl font-black text-slate-900">
                        Pesanan Masuk
                    </h2>

                    <p class="mt-4 leading-7 text-slate-600">
                        Konfirmasi pesanan dari pembeli terhadap produk yang kamu jual.
                    </p>
                </a>
            </section>
        </div>
    </div>
</x-app-layout>