@extends('layouts.app')

@section('content')
    <section class="bg-gradient-to-br from-rose-50 via-white to-pink-50 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-2xl bg-green-100 px-5 py-4 font-semibold text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-8 rounded-[32px] bg-gradient-to-r from-slate-900 via-slate-800 to-pink-600 p-8 text-white shadow-xl shadow-pink-100">
                <p class="text-sm font-black uppercase tracking-[0.3em] text-pink-100">
                    Panel Administrator
                </p>

                <h1 class="mt-3 text-4xl font-black">
                    Dashboard Admin UniMart
                </h1>

                <p class="mt-3 max-w-3xl text-pink-50">
                    Admin bertugas memantau data user, produk, status produk, dan menghapus produk yang tidak sesuai.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-[28px] bg-white p-6 shadow-xl shadow-rose-100">
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-slate-400">
                        Total User
                    </p>
                    <h2 class="mt-4 text-4xl font-black text-slate-900">
                        {{ $totalUser }}
                    </h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Semua akun terdaftar
                    </p>
                </div>

                <div class="rounded-[28px] bg-white p-6 shadow-xl shadow-rose-100">
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-pink-500">
                        User Biasa
                    </p>
                    <h2 class="mt-4 text-4xl font-black text-pink-600">
                        {{ $totalUserBiasa }}
                    </h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Akun pembeli / penjual
                    </p>
                </div>

                <div class="rounded-[28px] bg-white p-6 shadow-xl shadow-rose-100">
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-slate-500">
                        Admin
                    </p>
                    <h2 class="mt-4 text-4xl font-black text-slate-900">
                        {{ $totalAdmin }}
                    </h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Akun administrator
                    </p>
                </div>

                <div class="rounded-[28px] bg-white p-6 shadow-xl shadow-rose-100">
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-slate-400">
                        Total Produk
                    </p>
                    <h2 class="mt-4 text-4xl font-black text-slate-900">
                        {{ $totalProduk }}
                    </h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Produk di marketplace
                    </p>
                </div>
            </div>

            <div class="mt-6 grid gap-6 md:grid-cols-2">
                <div class="rounded-[28px] bg-white p-6 shadow-xl shadow-rose-100">
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-green-500">
                        Produk Tersedia
                    </p>
                    <h2 class="mt-4 text-4xl font-black text-green-600">
                        {{ $produkTersedia }}
                    </h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Produk yang masih bisa dibeli
                    </p>
                </div>

                <div class="rounded-[28px] bg-white p-6 shadow-xl shadow-rose-100">
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-red-500">
                        Produk Terjual
                    </p>
                    <h2 class="mt-4 text-4xl font-black text-red-500">
                        {{ $produkTerjual }}
                    </h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Produk yang sudah ditandai terjual
                    </p>
                </div>
            </div>

            <div class="mt-8 rounded-[32px] bg-white p-6 shadow-xl shadow-rose-100">
                <div class="mb-5 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">
                            Monitoring Produk Terbaru
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Admin dapat melihat dan menghapus produk jika diperlukan.
                        </p>
                    </div>

                    <a href="{{ route('produk.index') }}" class="rounded-2xl bg-slate-900 px-5 py-3 text-center text-sm font-bold text-white transition hover:bg-pink-600">
                        Lihat Halaman Produk
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-500">
                                <th class="py-3 pr-4 font-black">Produk</th>
                                <th class="py-3 pr-4 font-black">Penjual</th>
                                <th class="py-3 pr-4 font-black">Kategori</th>
                                <th class="py-3 pr-4 font-black">Harga</th>
                                <th class="py-3 pr-4 font-black">Status</th>
                                <th class="py-3 pr-4 font-black">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($produkTerbaru as $produk)
                                <tr class="border-b border-slate-100">
                                    <td class="py-4 pr-4 font-bold text-slate-900">
                                        {{ $produk->nama }}
                                    </td>

                                    <td class="py-4 pr-4 text-slate-600">
                                        {{ $produk->user->name ?? '-' }}
                                    </td>

                                    <td class="py-4 pr-4 text-slate-600">
                                        {{ $produk->kategori }}
                                    </td>

                                    <td class="py-4 pr-4 text-slate-600">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </td>

                                    <td class="py-4 pr-4">
                                        @if ($produk->aktif)
                                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-black text-green-700">
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-black text-red-700">
                                                Terjual
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-4 pr-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('produk.show', $produk) }}" class="rounded-xl bg-slate-100 px-3 py-2 text-xs font-bold text-slate-700 transition hover:bg-slate-200">
                                                Detail
                                            </a>

                                            <form method="POST" action="{{ route('admin.produk.destroy', $produk) }}" onsubmit="return confirm('Yakin admin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="rounded-xl bg-red-500 px-3 py-2 text-xs font-bold text-white transition hover:bg-red-600">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center font-semibold text-slate-500">
                                        Belum ada produk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection