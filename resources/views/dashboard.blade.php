<x-app-layout>
    @php
        $user = auth()->user();
        $isAdmin = (bool) $user->is_admin;

        if ($isAdmin) {
            $totalProduk = \App\Models\Produk::count();
            $produkAktif = \App\Models\Produk::where('aktif', true)->count();
            $totalUser = \App\Models\User::where('is_admin', false)->count();
            $totalPesanan = \App\Models\Pesanan::count();
            $pesananPending = \App\Models\Pesanan::where('status', 'pending')->count();
        } else {
            $produkSaya = \App\Models\Produk::where('user_id', $user->id)->count();
            $produkAktifSaya = \App\Models\Produk::where('user_id', $user->id)->where('aktif', true)->count();
            $keranjang = \App\Models\Keranjang::where('user_id', $user->id)->count();
            $pesananSayaAktif = \App\Models\Pesanan::where('buyer_id', $user->id)->whereIn('status', ['pending', 'accepted'])->count();
            $pesananMasukPending = \App\Models\Pesanan::where('seller_id', $user->id)->where('status', 'pending')->count();
        }
    @endphp

    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-pink-100 lg:p-10">
                <p class="text-sm font-black uppercase tracking-[0.35em] text-pink-500">
                    Dashboard
                </p>

                <h1 class="mt-4 text-4xl font-black tracking-tight text-slate-900">
                    Selamat datang, {{ $user->name }}!
                </h1>

                <p class="mt-4 max-w-3xl text-lg leading-8 text-slate-600">
                    @if ($isAdmin)
                        Pantau data utama UniMart, produk, user, dan pesanan dari dashboard admin.
                    @else
                        Kelola aktivitas jual beli kamu, mulai dari produk, keranjang, pesanan sebagai pembeli, sampai pesanan masuk sebagai penjual.
                    @endif
                </p>
            </div>

            @if ($isAdmin)
                <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-5">
                    <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-pink-100">
                        <p class="text-sm font-bold text-slate-500">Total User</p>
                        <p class="mt-3 text-4xl font-black text-slate-900">{{ $totalUser }}</p>
                    </div>

                    <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-pink-100">
                        <p class="text-sm font-bold text-slate-500">Total Produk</p>
                        <p class="mt-3 text-4xl font-black text-slate-900">{{ $totalProduk }}</p>
                    </div>

                    <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-pink-100">
                        <p class="text-sm font-bold text-slate-500">Produk Aktif</p>
                        <p class="mt-3 text-4xl font-black text-green-600">{{ $produkAktif }}</p>
                    </div>

                    <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-pink-100">
                        <p class="text-sm font-bold text-slate-500">Total Pesanan</p>
                        <p class="mt-3 text-4xl font-black text-pink-700">{{ $totalPesanan }}</p>
                    </div>

                    <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-pink-100">
                        <p class="text-sm font-bold text-slate-500">Pending</p>
                        <p class="mt-3 text-4xl font-black text-yellow-600">{{ $pesananPending }}</p>
                    </div>
                </div>

                <div class="mt-8 grid gap-5 md:grid-cols-3">
                    <a href="{{ route('admin.dashboard') }}" class="rounded-[2rem] bg-slate-900 p-7 text-white shadow-sm transition hover:bg-pink-700">
                        <h2 class="text-2xl font-black">Dashboard Admin</h2>
                        <p class="mt-3 text-slate-200">Kelola dan pantau data utama UniMart.</p>
                    </a>

                    <a href="{{ route('produk.index') }}" class="rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1">
                        <h2 class="text-2xl font-black text-slate-900">Lihat Produk</h2>
                        <p class="mt-3 text-slate-600">Pantau produk yang tampil di marketplace.</p>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1">
                        <h2 class="text-2xl font-black text-slate-900">Profil</h2>
                        <p class="mt-3 text-slate-600">Kelola data akun admin.</p>
                    </a>
                </div>
            @else
                <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-5">
                    <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-pink-100">
                        <p class="text-sm font-bold text-slate-500">Produk Saya</p>
                        <p class="mt-3 text-4xl font-black text-slate-900">{{ $produkSaya }}</p>
                        <p class="mt-2 text-sm font-semibold text-green-600">{{ $produkAktifSaya }} aktif</p>
                    </div>

                    <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-pink-100">
                        <p class="text-sm font-bold text-slate-500">Keranjang</p>
                        <p class="mt-3 text-4xl font-black text-pink-700">{{ $keranjang }}</p>
                        <p class="mt-2 text-sm font-semibold text-slate-500">Item tersimpan</p>
                    </div>

                    <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-pink-100">
                        <p class="text-sm font-bold text-slate-500">Pesanan Saya</p>
                        <p class="mt-3 text-4xl font-black text-blue-600">{{ $pesananSayaAktif }}</p>
                        <p class="mt-2 text-sm font-semibold text-slate-500">Masih aktif</p>
                    </div>

                    <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-pink-100">
                        <p class="text-sm font-bold text-slate-500">Pesanan Masuk</p>
                        <p class="mt-3 text-4xl font-black text-red-600">{{ $pesananMasukPending }}</p>
                        <p class="mt-2 text-sm font-semibold text-slate-500">Menunggu konfirmasi</p>
                    </div>

                    <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-pink-100">
                        <p class="text-sm font-bold text-slate-500">WhatsApp</p>
                        <p class="mt-3 text-xl font-black text-slate-900">{{ $user->whatsapp ?: '-' }}</p>
                        <p class="mt-2 text-sm font-semibold text-slate-500">Kontak penjual</p>
                    </div>
                </div>

                <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                    <a href="{{ route('produk.index') }}" class="rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1">
                        <h2 class="text-2xl font-black text-slate-900">Lihat Produk</h2>
                        <p class="mt-3 text-slate-600">Cari produk milik user lain di marketplace.</p>
                    </a>

                    <a href="{{ route('produk.saya') }}" class="rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1">
                        <h2 class="text-2xl font-black text-slate-900">Produk Saya</h2>
                        <p class="mt-3 text-slate-600">Tambah dan kelola produk jualanmu.</p>
                    </a>

                    <a href="{{ route('keranjang.index') }}" class="rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1">
                        <h2 class="text-2xl font-black text-slate-900">Keranjang</h2>
                        <p class="mt-3 text-slate-600">Lanjutkan checkout produk yang kamu minati.</p>
                    </a>

                    <a href="{{ route('pesanan.masuk') }}" class="rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1">
                        <h2 class="text-2xl font-black text-slate-900">Pesanan Masuk</h2>
                        <p class="mt-3 text-slate-600">Konfirmasi pesanan dari pembeli.</p>
                    </a>
                </div>

                <div class="mt-8 rounded-[2rem] bg-slate-900 p-8 text-white shadow-sm">
                    <h2 class="text-3xl font-black">Alur transaksi yang benar</h2>
                    <div class="mt-6 grid gap-4 md:grid-cols-4">
                        <div class="rounded-2xl bg-white/10 p-5">
                            <p class="font-black text-pink-300">1. Produk</p>
                            <p class="mt-2 text-sm text-slate-200">Pembeli memilih produk milik user lain.</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-5">
                            <p class="font-black text-pink-300">2. Keranjang</p>
                            <p class="mt-2 text-sm text-slate-200">Produk disimpan sebelum checkout.</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-5">
                            <p class="font-black text-pink-300">3. Checkout COD</p>
                            <p class="mt-2 text-sm text-slate-200">Pembeli mengisi lokasi dan catatan COD.</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-5">
                            <p class="font-black text-pink-300">4. Pesanan</p>
                            <p class="mt-2 text-sm text-slate-200">Seller konfirmasi, lalu buyer menyelesaikan pesanan.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>