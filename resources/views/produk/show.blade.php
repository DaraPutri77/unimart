@extends('layouts.app')

@section('content')
    <section class="bg-gradient-to-br from-rose-50 via-white to-pink-50 py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-2xl bg-green-100 px-5 py-4 font-semibold text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('produk.index') }}" class="font-bold text-pink-600">
                ← Kembali ke Daftar Produk
            </a>

            <div class="mt-6 grid gap-8 rounded-[32px] bg-white p-8 shadow-xl shadow-rose-100 lg:grid-cols-[0.9fr_1.1fr]">
                <div class="flex min-h-[360px] items-center justify-center rounded-[28px] bg-gradient-to-br from-rose-100 to-pink-50">
                    <div class="text-center">
                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-slate-900 to-pink-500 text-4xl font-black text-white">
                            U
                        </div>
                        <p class="mt-4 font-bold text-pink-700">
                            Foto produk belum tersedia
                        </p>
                    </div>
                </div>

                <div>
                    <div class="flex flex-wrap gap-3">
                        <span class="rounded-full bg-pink-100 px-4 py-2 text-xs font-black text-pink-700">
                            {{ $produk->kategori }}
                        </span>

                        <span class="rounded-full bg-slate-100 px-4 py-2 text-xs font-black text-slate-700">
                            {{ $produk->fakultas }}
                        </span>

                        @if ($produk->aktif)
                            <span class="rounded-full bg-green-100 px-4 py-2 text-xs font-black text-green-700">
                                Tersedia
                            </span>
                        @else
                            <span class="rounded-full bg-red-100 px-4 py-2 text-xs font-black text-red-700">
                                Terjual
                            </span>
                        @endif
                    </div>

                    <h1 class="mt-5 text-4xl font-black text-slate-900">
                        {{ $produk->nama }}
                    </h1>

                    <p class="mt-4 text-4xl font-black text-pink-600">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </p>

                    <div class="mt-6 space-y-3 text-slate-600">
                        <p><span class="font-bold text-slate-900">Stok:</span> {{ $produk->stok }}</p>
                        <p><span class="font-bold text-slate-900">Fakultas:</span> {{ $produk->fakultas }}</p>
                        <p><span class="font-bold text-slate-900">Penjual:</span> {{ $produk->user->name ?? '-' }}</p>
                        <p><span class="font-bold text-slate-900">WhatsApp:</span> {{ $produk->user->whatsapp ?? 'Belum diisi' }}</p>
                        <p><span class="font-bold text-slate-900">Tanggal ditambahkan:</span> {{ $produk->created_at->format('d M Y') }}</p>
                    </div>

                    <div class="mt-8">
                        <h2 class="text-xl font-black text-slate-900">Deskripsi Produk</h2>
                        <p class="mt-3 leading-7 text-slate-600">
                            {{ $produk->deskripsi ?: 'Belum ada deskripsi produk.' }}
                        </p>
                    </div>

                    <div class="mt-8 space-y-3">
                        @auth
                            @if (auth()->id() === $produk->user_id)
                                <div class="grid gap-3 md:grid-cols-2">
                                    <a href="{{ route('produk.edit', $produk) }}" class="rounded-2xl bg-amber-400 px-5 py-3 text-center font-bold text-white">
                                        Edit Produk
                                    </a>

                                    <form method="POST" action="{{ route('produk.destroy', $produk) }}" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="w-full rounded-2xl bg-red-500 px-5 py-3 font-bold text-white">
                                            Hapus Produk
                                        </button>
                                    </form>
                                </div>

                                @if ($produk->aktif)
                                    <form method="POST" action="{{ route('produk.terjual', $produk) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button class="w-full rounded-2xl bg-slate-900 px-5 py-3 font-bold text-white">
                                            Tandai Terjual
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('produk.tersedia', $produk) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button class="w-full rounded-2xl bg-green-600 px-5 py-3 font-bold text-white">
                                            Tandai Tersedia
                                        </button>
                                    </form>
                                @endif

                                <div class="rounded-2xl bg-pink-50 px-5 py-4 font-semibold text-pink-700">
                                    Ini adalah produk milikmu. Kamu bisa mengedit, menghapus, atau mengubah status produk ini.
                                </div>
                            @else
                                @php
                                    $wa = preg_replace('/\D/', '', $produk->user->whatsapp ?? '');

                                    if (str_starts_with($wa, '0')) {
                                        $wa = '62' . substr($wa, 1);
                                    }

                                    $pesan = urlencode('Halo, saya tertarik dengan produk ' . $produk->nama . ' di UniMart.');
                                @endphp

                                @if ($produk->aktif && $wa)
                                    <a
                                        href="https://wa.me/{{ $wa }}?text={{ $pesan }}"
                                        target="_blank"
                                        class="block rounded-2xl bg-green-600 px-5 py-3 text-center font-bold text-white"
                                    >
                                        Hubungi Penjual via WhatsApp
                                    </a>
                                @elseif (! $produk->aktif)
                                    <div class="rounded-2xl bg-red-50 px-5 py-4 font-semibold text-red-700">
                                        Produk ini sudah terjual.
                                    </div>
                                @else
                                    <div class="rounded-2xl bg-slate-100 px-5 py-4 font-semibold text-slate-600">
                                        Penjual belum mengisi nomor WhatsApp.
                                    </div>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block rounded-2xl bg-gradient-to-r from-slate-900 to-pink-500 px-5 py-3 text-center font-bold text-white">
                                Login untuk Menghubungi Penjual
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection