@extends('layouts.app')

@section('content')
    <section class="bg-gradient-to-br from-rose-50 via-white to-pink-50 py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-2xl bg-green-100 px-5 py-4 font-semibold text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-8 rounded-[32px] bg-white p-8 shadow-xl shadow-rose-100">
                <p class="text-sm font-black uppercase tracking-[0.3em] text-pink-500">
                    Keranjang Saya
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900">
                    Produk yang Kamu Minati
                </h1>

                <p class="mt-3 max-w-2xl text-slate-600">
                    Simpan produk yang kamu minati, lalu hubungi penjual melalui WhatsApp untuk transaksi COD di area kampus.
                </p>
            </div>

            <div class="space-y-5">
                @forelse ($keranjangs as $item)
                    @php
                        $produk = $item->produk;
                        $penjual = $produk?->user;

                        $wa = preg_replace('/\D/', '', $penjual->whatsapp ?? '');

                        if (str_starts_with($wa, '0')) {
                            $wa = '62' . substr($wa, 1);
                        }

                        $pesan = urlencode('Halo, saya tertarik dengan produk ' . ($produk->nama ?? 'di UniMart') . ' yang saya simpan di keranjang UniMart.');
                    @endphp

                    <div class="grid gap-5 rounded-[28px] bg-white p-6 shadow-xl shadow-rose-100 md:grid-cols-[1fr_auto] md:items-center">
                        <div>
                            <div class="mb-3 flex flex-wrap gap-2">
                                <span class="rounded-full bg-pink-100 px-4 py-2 text-xs font-black text-pink-700">
                                    {{ $produk->kategori ?? '-' }}
                                </span>

                                <span class="rounded-full bg-slate-100 px-4 py-2 text-xs font-black text-slate-700">
                                    {{ $produk->fakultas ?? '-' }}
                                </span>

                                @if ($produk && $produk->aktif)
                                    <span class="rounded-full bg-green-100 px-4 py-2 text-xs font-black text-green-700">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="rounded-full bg-red-100 px-4 py-2 text-xs font-black text-red-700">
                                        Terjual
                                    </span>
                                @endif
                            </div>

                            <h2 class="text-2xl font-black text-slate-900">
                                {{ $produk->nama ?? 'Produk tidak ditemukan' }}
                            </h2>

                            <p class="mt-2 text-2xl font-black text-pink-600">
                                Rp {{ number_format($produk->harga ?? 0, 0, ',', '.') }}
                            </p>

                            <div class="mt-3 space-y-1 text-sm text-slate-600">
                                <p>Penjual: <span class="font-bold text-slate-900">{{ $penjual->name ?? '-' }}</span></p>
                                <p>WhatsApp: <span class="font-bold text-slate-900">{{ $penjual->whatsapp ?? 'Belum diisi' }}</span></p>
                            </div>
                        </div>

                        <div class="grid gap-3 md:min-w-[210px]">
                            @if ($produk)
                                <a href="{{ route('produk.show', $produk) }}" class="rounded-2xl bg-slate-900 px-5 py-3 text-center text-sm font-bold text-white transition hover:bg-pink-600">
                                    Detail Produk
                                </a>
                            @endif

                            @if ($produk && $produk->aktif && $wa)
                                <a
                                    href="https://wa.me/{{ $wa }}?text={{ $pesan }}"
                                    target="_blank"
                                    class="rounded-2xl bg-green-600 px-5 py-3 text-center text-sm font-bold text-white transition hover:bg-green-700"
                                >
                                    Hubungi Penjual
                                </a>
                            @endif

                            <form method="POST" action="{{ route('keranjang.destroy', $item) }}" onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                @csrf
                                @method('DELETE')

                                <button class="w-full rounded-2xl bg-red-500 px-5 py-3 text-sm font-bold text-white transition hover:bg-red-600">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="rounded-[28px] bg-white p-10 text-center shadow-xl shadow-rose-100">
                        <h2 class="text-2xl font-black text-slate-900">
                            Keranjang masih kosong.
                        </h2>

                        <p class="mt-2 text-slate-600">
                            Cari produk yang kamu minati lalu tambahkan ke keranjang.
                        </p>

                        <a href="{{ route('produk.index') }}" class="mt-6 inline-block rounded-2xl bg-gradient-to-r from-slate-900 to-pink-500 px-6 py-3 font-bold text-white">
                            Lihat Produk
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection