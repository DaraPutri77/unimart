<x-app-layout>
    @php
        $kategoriOptions = $kategoriOptions ?? ['Buku', 'Elektronik', 'Fashion', 'Alat Tulis', 'Aksesoris', 'Lainnya'];
        $kondisiOptions = $kondisiOptions ?? ['baru', 'bekas'];
    @endphp

    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-black uppercase tracking-[0.3em] text-pink-500">
                        Produk Saya
                    </p>

                    <h1 class="mt-3 text-4xl font-black text-slate-900">
                        Kelola Produk Jualan
                    </h1>

                    <p class="mt-3 max-w-3xl text-slate-600">
                        Produk yang kamu tambahkan akan tampil di halaman Produk milik user lain.
                    </p>
                </div>

                <a href="{{ route('produk.create') }}"
                   class="inline-flex rounded-2xl bg-pink-700 px-6 py-4 font-extrabold text-white shadow-lg shadow-pink-100 hover:bg-slate-900">
                    + Tambah Produk
                </a>
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

            <form method="GET" action="{{ route('produk.saya') }}"
                  class="mb-8 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-pink-100">
                <div class="grid gap-4 lg:grid-cols-[1.4fr_0.8fr_0.8fr_0.8fr_auto]">
                    <div>
                        <label class="mb-2 block font-extrabold text-slate-900">Cari Produk</label>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari nama, kategori, fakultas..."
                               class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                    </div>

                    <div>
                        <label class="mb-2 block font-extrabold text-slate-900">Kategori</label>
                        <select name="kategori"
                                class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                            <option value="">Semua</option>

                            @foreach ($kategoriOptions as $kategori)
                                <option value="{{ $kategori }}" @selected(request('kategori') === $kategori)>
                                    {{ $kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block font-extrabold text-slate-900">Kondisi</label>
                        <select name="kondisi"
                                class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                            <option value="">Semua</option>

                            @foreach ($kondisiOptions as $kondisi)
                                <option value="{{ $kondisi }}" @selected(request('kondisi') === $kondisi)>
                                    {{ $kondisi === 'baru' ? 'Barang Baru' : 'Barang Bekas' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block font-extrabold text-slate-900">Status</label>
                        <select name="status"
                                class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                            <option value="">Semua</option>
                            <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full rounded-2xl bg-slate-900 px-7 py-4 font-extrabold text-white hover:bg-pink-700">
                            Filter
                        </button>
                    </div>
                </div>
            </form>

            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                <p class="font-bold text-slate-600">
                    Total: {{ $produks->count() }} produk
                </p>

                <div class="rounded-2xl bg-white px-5 py-3 text-sm font-bold text-slate-600 shadow-sm ring-1 ring-pink-100">
                    Catatan: Produk sendiri hanya tampil di halaman ini, bukan di marketplace milik akun kamu.
                </div>
            </div>

            @if ($produks->count() > 0)
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($produks as $produk)
                        <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-pink-100 transition hover:-translate-y-1 hover:shadow-xl">
                            <div class="flex h-52 items-center justify-center bg-slate-50 p-5">
                                @if ($produk->gambar_url)
                                    <img src="{{ $produk->gambar_url }}"
                                         alt="{{ $produk->nama }}"
                                         class="h-full w-full object-contain">
                                @else
                                    <div class="flex h-full w-full items-center justify-center rounded-2xl bg-pink-50 text-6xl">
                                        🛍️
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <div class="mb-4 flex flex-wrap items-center gap-2">
                                    <span class="rounded-full bg-pink-100 px-4 py-2 text-xs font-extrabold text-pink-700">
                                        {{ $produk->kategori }}
                                    </span>

                                    <span class="rounded-full bg-blue-100 px-4 py-2 text-xs font-extrabold text-blue-700">
                                        {{ $produk->kondisi_label ?? ($produk->kondisi === 'baru' ? 'Barang Baru' : 'Barang Bekas') }}
                                    </span>

                                    <span class="rounded-full bg-slate-100 px-4 py-2 text-xs font-extrabold text-slate-700">
                                        {{ $produk->fakultas }}
                                    </span>

                                    <span class="rounded-full px-4 py-2 text-xs font-extrabold {{ $produk->aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $produk->aktif ? 'Tersedia' : 'Nonaktif' }}
                                    </span>
                                </div>

                                <h2 class="line-clamp-2 text-2xl font-black text-slate-900">
                                    {{ $produk->nama }}
                                </h2>

                                <p class="mt-4 text-3xl font-black text-pink-700">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </p>

                                <div class="mt-5 space-y-2 text-sm text-slate-600">
                                    <p>
                                        Stok:
                                        <span class="font-extrabold text-slate-900">{{ $produk->stok }}</span>
                                    </p>

                                    <p>
                                        Fakultas:
                                        <span class="font-extrabold text-slate-900">{{ $produk->fakultas }}</span>
                                    </p>

                                    <p>
                                        Status:
                                        <span class="font-extrabold {{ $produk->aktif ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $produk->aktif ? 'Produk tampil untuk pembeli' : 'Produk tidak tampil untuk pembeli' }}
                                        </span>
                                    </p>
                                </div>

                                <div class="mt-6 grid grid-cols-3 gap-3">
                                    <a href="{{ route('produk.show', $produk) }}"
                                       class="rounded-2xl bg-slate-900 px-4 py-3 text-center text-sm font-extrabold text-white hover:bg-pink-700">
                                        Detail
                                    </a>

                                    <a href="{{ route('produk.edit', $produk) }}"
                                       class="rounded-2xl bg-yellow-400 px-4 py-3 text-center text-sm font-extrabold text-white hover:bg-yellow-500">
                                        Edit
                                    </a>

                                    <form action="{{ route('produk.destroy', $produk) }}" method="POST"
                                          onsubmit="return confirm('Hapus produk ini? Produk yang dihapus tidak tampil lagi di marketplace.')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="w-full rounded-2xl bg-red-500 px-4 py-3 text-sm font-extrabold text-white hover:bg-red-600">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-3xl bg-white p-10 text-center shadow-sm ring-1 ring-pink-100">
                    <div class="text-6xl">📦</div>
                    <h2 class="mt-4 text-2xl font-extrabold text-slate-900">Belum ada produk</h2>
                    <p class="mt-2 text-slate-600">
                        Tambahkan produk pertama kamu agar bisa tampil di marketplace user lain.
                    </p>

                    <a href="{{ route('produk.create') }}"
                       class="mt-6 inline-flex rounded-2xl bg-pink-700 px-6 py-3 font-bold text-white hover:bg-slate-900">
                        Tambah Produk
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>