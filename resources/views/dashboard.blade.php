<x-app-layout>
    @php
        $user = auth()->user();
        $isAdmin = (bool) ($user->is_admin ?? false);

        $usersTableAda = \Illuminate\Support\Facades\Schema::hasTable('users');
        $produkTableAda = \Illuminate\Support\Facades\Schema::hasTable('produks');
        $keranjangTableAda = \Illuminate\Support\Facades\Schema::hasTable('keranjangs');
        $pesananTableAda = \Illuminate\Support\Facades\Schema::hasTable('pesanans');

        $usersHasIsAdmin = $usersTableAda && \Illuminate\Support\Facades\Schema::hasColumn('users', 'is_admin');

        $totalPengguna = $usersTableAda
            ? ($usersHasIsAdmin
                ? \App\Models\User::where('is_admin', false)->count()
                : \App\Models\User::count())
            : 0;

        $totalAdmin = $usersTableAda && $usersHasIsAdmin
            ? \App\Models\User::where('is_admin', true)->count()
            : 0;

        $totalProduk = $produkTableAda ? \App\Models\Produk::count() : 0;
        $totalKeranjang = $keranjangTableAda ? \App\Models\Keranjang::count() : 0;
        $totalPesanan = $pesananTableAda ? \App\Models\Pesanan::count() : 0;

        $pesananHasStatus = $pesananTableAda && \Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'status');

        $pesananPending = $pesananHasStatus ? \App\Models\Pesanan::where('status', 'pending')->count() : 0;
        $pesananDiterima = $pesananHasStatus ? \App\Models\Pesanan::where('status', 'accepted')->count() : 0;
        $pesananDitolak = $pesananHasStatus ? \App\Models\Pesanan::where('status', 'rejected')->count() : 0;
        $pesananSelesai = $pesananHasStatus ? \App\Models\Pesanan::where('status', 'completed')->count() : 0;
        $pesananDibatalkan = $pesananHasStatus ? \App\Models\Pesanan::where('status', 'canceled')->count() : 0;

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
                $pesananMasuk = \App\Models\Pesanan::where('penjual_id', $user->id)->where('status', 'pending')->count();
            } elseif (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'seller_id')) {
                $pesananMasuk = \App\Models\Pesanan::where('seller_id', $user->id)->where('status', 'pending')->count();
            }
        }

        $routeProduk = \Illuminate\Support\Facades\Route::has('produk.index') ? route('produk.index') : '#';
        $routeProdukSaya = \Illuminate\Support\Facades\Route::has('produk.saya') ? route('produk.saya') : '#';
        $routeKeranjang = \Illuminate\Support\Facades\Route::has('keranjang.index') ? route('keranjang.index') : '#';
        $routePesananMasuk = \Illuminate\Support\Facades\Route::has('pesanan.masuk') ? route('pesanan.masuk') : '#';
    @endphp

    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if ($isAdmin)
                <section class="mb-8 rounded-[2rem] bg-white p-10 shadow-sm ring-1 ring-pink-100">
                    <p class="text-sm font-black uppercase tracking-[0.35em] text-pink-500">
                        Dashboard Admin
                    </p>

                    <h1 class="mt-5 text-4xl font-black tracking-tight text-slate-900">
                        Statistik UniMart
                    </h1>

                    <p class="mt-5 max-w-4xl text-lg leading-8 text-slate-600">
                        Admin berperan sebagai pemantau sistem. Pada halaman ini admin dapat melihat ringkasan aktivitas UniMart,
                        seperti jumlah pengguna, produk, keranjang, dan status pesanan. Admin tidak masuk ke alur jual beli sebagai pembeli maupun penjual.
                    </p>
                </section>

                <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                        <p class="font-extrabold text-slate-500">Total Pengguna</p>
                        <h2 class="mt-4 text-5xl font-black text-slate-900">{{ $totalPengguna }}</h2>
                        <p class="mt-2 font-bold text-green-600">Mahasiswa/User</p>
                    </div>

                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                        <p class="font-extrabold text-slate-500">Total Admin</p>
                        <h2 class="mt-4 text-5xl font-black text-pink-700">{{ $totalAdmin }}</h2>
                        <p class="mt-2 font-bold text-slate-500">Akun pemantau</p>
                    </div>

                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                        <p class="font-extrabold text-slate-500">Total Produk</p>
                        <h2 class="mt-4 text-5xl font-black text-blue-600">{{ $totalProduk }}</h2>
                        <p class="mt-2 font-bold text-slate-500">Produk di marketplace</p>
                    </div>

                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                        <p class="font-extrabold text-slate-500">Total Keranjang</p>
                        <h2 class="mt-4 text-5xl font-black text-purple-600">{{ $totalKeranjang }}</h2>
                        <p class="mt-2 font-bold text-slate-500">Item tersimpan</p>
                    </div>
                </section>

                <section class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-5">
                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                        <p class="font-extrabold text-slate-500">Total Pesanan</p>
                        <h2 class="mt-4 text-4xl font-black text-slate-900">{{ $totalPesanan }}</h2>
                        <p class="mt-2 font-bold text-slate-500">Semua transaksi</p>
                    </div>

                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                        <p class="font-extrabold text-slate-500">Pending</p>
                        <h2 class="mt-4 text-4xl font-black text-yellow-600">{{ $pesananPending }}</h2>
                        <p class="mt-2 font-bold text-slate-500">Menunggu konfirmasi</p>
                    </div>

                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                        <p class="font-extrabold text-slate-500">Diterima</p>
                        <h2 class="mt-4 text-4xl font-black text-blue-600">{{ $pesananDiterima }}</h2>
                        <p class="mt-2 font-bold text-slate-500">Disetujui penjual</p>
                    </div>

                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                        <p class="font-extrabold text-slate-500">Ditolak</p>
                        <h2 class="mt-4 text-4xl font-black text-red-600">{{ $pesananDitolak }}</h2>
                        <p class="mt-2 font-bold text-slate-500">Ditolak penjual</p>
                    </div>

                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                        <p class="font-extrabold text-slate-500">Selesai</p>
                        <h2 class="mt-4 text-4xl font-black text-green-600">{{ $pesananSelesai }}</h2>
                        <p class="mt-2 font-bold text-slate-500">Transaksi selesai</p>
                    </div>
                </section>

                <section class="mt-10 rounded-[2rem] bg-slate-950 p-10 text-white">
                    <h2 class="text-3xl font-black">
                        Peran Admin
                    </h2>

                    <div class="mt-8 grid gap-5 md:grid-cols-3">
                        <div class="rounded-3xl bg-slate-800 p-6">
                            <h3 class="text-xl font-black text-pink-300">1. Memantau Statistik</h3>
                            <p class="mt-3 leading-7 text-slate-200">
                                Admin melihat jumlah pengguna, produk, keranjang, dan pesanan dalam sistem.
                            </p>
                        </div>

                        <div class="rounded-3xl bg-slate-800 p-6">
                            <h3 class="text-xl font-black text-pink-300">2. Mengevaluasi Aktivitas</h3>
                            <p class="mt-3 leading-7 text-slate-200">
                                Admin dapat mengetahui aktivitas marketplace berdasarkan data yang tercatat.
                            </p>
                        </div>

                        <div class="rounded-3xl bg-slate-800 p-6">
                            <h3 class="text-xl font-black text-pink-300">3. Tidak Bertransaksi</h3>
                            <p class="mt-3 leading-7 text-slate-200">
                                Admin tidak digunakan untuk membeli, menjual, checkout, atau memproses pesanan.
                            </p>
                        </div>
                    </div>
                </section>
            @else
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

                <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-5">
                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                        <p class="font-extrabold text-slate-500">Produk Saya</p>
                        <h2 class="mt-4 text-5xl font-black text-slate-900">{{ $produkSaya }}</h2>
                        <p class="mt-2 font-bold text-green-600">{{ $produkSayaAktif }} aktif</p>
                    </div>

                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                        <p class="font-extrabold text-slate-500">Keranjang</p>
                        <h2 class="mt-4 text-5xl font-black text-pink-700">{{ $keranjangSaya }}</h2>
                        <p class="mt-2 font-bold text-slate-500">Item tersimpan</p>
                    </div>

                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                        <p class="font-extrabold text-slate-500">Pesanan Saya</p>
                        <h2 class="mt-4 text-5xl font-black text-blue-600">{{ $pesananSaya }}</h2>
                        <p class="mt-2 font-bold text-slate-500">Pesanan sebagai pembeli</p>
                    </div>

                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                        <p class="font-extrabold text-slate-500">Pesanan Masuk</p>
                        <h2 class="mt-4 text-5xl font-black text-red-600">{{ $pesananMasuk }}</h2>
                        <p class="mt-2 font-bold text-slate-500">Menunggu konfirmasi</p>
                    </div>

                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-pink-100">
                        <p class="font-extrabold text-slate-500">WhatsApp</p>
                        <h2 class="mt-4 text-3xl font-black text-slate-900">
                            {{ $user->whatsapp ?: '-' }}
                        </h2>
                        <p class="mt-2 font-bold text-slate-500">Kontak penjual</p>
                    </div>
                </section>

                <section class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                    <a href="{{ $routeProduk }}" class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1 hover:shadow-xl">
                        <h2 class="text-2xl font-black text-slate-900">Lihat Produk</h2>
                        <p class="mt-4 leading-7 text-slate-600">Cari produk milik user lain di marketplace.</p>
                    </a>

                    <a href="{{ $routeProdukSaya }}" class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1 hover:shadow-xl">
                        <h2 class="text-2xl font-black text-slate-900">Produk Saya</h2>
                        <p class="mt-4 leading-7 text-slate-600">Tambah dan kelola produk jualanmu.</p>
                    </a>

                    <a href="{{ $routeKeranjang }}" class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1 hover:shadow-xl">
                        <h2 class="text-2xl font-black text-slate-900">Keranjang</h2>
                        <p class="mt-4 leading-7 text-slate-600">Lanjutkan checkout produk yang kamu minati.</p>
                    </a>

                    <a href="{{ $routePesananMasuk }}" class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1 hover:shadow-xl">
                        <h2 class="text-2xl font-black text-slate-900">Pesanan Masuk</h2>
                        <p class="mt-4 leading-7 text-slate-600">Konfirmasi pesanan dari pembeli.</p>
                    </a>
                </section>
            @endif
        </div>
    </div>
</x-app-layout>