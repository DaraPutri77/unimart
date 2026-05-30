@extends('layouts.app')

@section('content')
    <section class="bg-gradient-to-br from-rose-50 via-white to-pink-50 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-2xl bg-green-100 px-5 py-4 font-semibold text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-black uppercase tracking-[0.3em] text-pink-500">
                        Marketplace
                    </p>

                    <h1 class="mt-2 text-4xl font-black text-slate-900">
                        Daftar Produk
                    </h1>

                    <p class="mt-2 text-slate-600">
                        Total: {{ $produks->total() }} produk
                    </p>
                </div>

                <div class="w-full lg:max-w-2xl">
                    <form method="GET" action="{{ route('produk.index') }}" class="grid gap-3 md:grid-cols-[1fr_180px_120px]">
                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Cari produk..."
                            class="rounded-2xl border border-slate-200 px-4 py-3 focus:border-pink-500 focus:ring-pink-500"
                        >

                        <select
                            name="kategori"
                            class="rounded-2xl border border-slate-200 px-4 py-3 focus:border-pink-500 focus:ring-pink-500"
                        >
                            <option value="">Semua Kategori</option>

                            @foreach ($kategoriList as $item)
                                <option value="{{ $item }}" @selected($kategori === $item)>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>

                        <button class="rounded-2xl bg-slate-900 px-5 py-3 font-bold text-white transition hover:bg-pink-600">
                            Cari
                        </button>
                    </form>

                    @auth
                        <a href="{{ route('produk.create') }}" class="mt-3 block rounded-2xl bg-gradient-to-r from-slate-900 to-pink-500 px-5 py-3 text-center font-bold text-white shadow-lg shadow-pink-100">
                            + Tambah Produk
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="mt-3 block rounded-2xl bg-gradient-to-r from-slate-900 to-pink-500 px-5 py-3 text-center font-bold text-white shadow-lg shadow-pink-100">
                            Login untuk Jual Barang
                        </a>
                    @endauth
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($produks as $produk)
                    <article class="flex min-h-[360px] flex-col rounded-[28px] bg-white p-6 shadow-xl shadow-rose-100/70">
                        <div class="mb-5 flex items-center justify-between">
                            <span class="rounded-full bg-pink-100 px-4 py-2 text-xs font-black text-pink-700">
                                {{ $produk->kategori }}
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

                        <h2 class="text-xl font-black text-slate-900">
                            {{ $produk->nama }}
                        </h2>

                        <p class="mt-4 text-3xl font-black text-pink-600">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </p>

                        <div class="mt-4 space-y-1 text-sm text-slate-600">
                            <p>
                                Stok:
                                <span class="font-bold text-slate-800">
                                    {{ $produk->stok }}
                                </span>
                            </p>

                            <p>
                                Penjual:
                                <span class="font-bold text-slate-800">
                                    {{ $produk->user->name ?? '-' }}
                                </span>
                            </p>

                            <p>
                                WhatsApp:
                                <span class="font-bold text-slate-800">
                                    {{ $produk->user->whatsapp ?? 'Belum diisi' }}
                                </span>
                            </p>
                        </div>

                        <div class="mt-auto grid gap-3 pt-6 {{ auth()->id() === $produk->user_id ? 'grid-cols-3' : 'grid-cols-1' }}">
                            <a href="{{ route('produk.show', $produk) }}" class="rounded-2xl bg-slate-900 px-4 py-3 text-center text-sm font-bold text-white transition hover:bg-pink-600">
                                Detail
                            </a>

                            @auth
                                @if (auth()->id() === $produk->user_id)
                                    <a href="{{ route('produk.edit', $produk) }}" class="rounded-2xl bg-amber-400 px-4 py-3 text-center text-sm font-bold text-white transition hover:bg-amber-500">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('produk.destroy', $produk) }}" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="w-full rounded-2xl bg-red-500 px-4 py-3 text-sm font-bold text-white transition hover:bg-red-600">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-[28px] bg-white p-10 text-center shadow-xl shadow-rose-100">
                        <h2 class="text-2xl font-black text-slate-900">
                            Produk belum ada.
                        </h2>

                        <p class="mt-2 text-slate-600">
                            Jadilah penjual pertama di UniMart.
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $produks->links() }}
            </div>
        </div>
    </section>
@endsection