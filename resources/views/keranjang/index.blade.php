<x-app-layout>
    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900">Keranjang</h1>
                <p class="mt-2 text-slate-600">Cek produk pilihan kamu sebelum checkout COD.</p>
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

            @php
                $dataKeranjang = $keranjangs ?? collect();
                $totalHarga = $dataKeranjang->sum(fn ($item) => $item->subtotal);
            @endphp

            @if ($dataKeranjang->count() > 0)
                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="space-y-4 lg:col-span-2">
                        @foreach ($dataKeranjang as $item)
                            @if ($item->produk)
                                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-pink-100">
                                    <div class="flex flex-col gap-4 md:flex-row">
                                        <div class="flex h-32 w-full shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-slate-100 md:w-32">
                                            @if ($item->produk->gambar_url)
                                                <img src="{{ $item->produk->gambar_url }}"
                                                     alt="{{ $item->produk->nama }}"
                                                     class="h-full w-full object-contain">
                                            @else
                                                <span class="text-4xl">🛍️</span>
                                            @endif
                                        </div>

                                        <div class="flex-1">
                                            <h2 class="text-xl font-extrabold text-slate-900">{{ $item->produk->nama }}</h2>

                                            <p class="mt-1 text-sm text-slate-600">
                                                Penjual:
                                                <span class="font-bold">{{ $item->produk->user->name ?? '-' }}</span>
                                            </p>

                                            <p class="mt-1 text-sm text-slate-600">
                                                Fakultas:
                                                <span class="font-bold">{{ $item->produk->fakultas }}</span>
                                            </p>

                                            <p class="mt-3 text-lg font-extrabold text-pink-700">
                                                Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                            </p>

                                            <div class="mt-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                                <form action="{{ route('keranjang.update', $item) }}" method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')

                                                    <label class="text-sm font-bold text-slate-700">Jumlah</label>
                                                    <input type="number"
                                                           name="jumlah"
                                                           min="1"
                                                           max="{{ $item->produk->stok }}"
                                                           value="{{ $item->jumlah }}"
                                                           class="w-20 rounded-xl border-slate-200 text-center focus:border-pink-500 focus:ring-pink-500">

                                                    <button type="submit"
                                                            class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-bold text-white hover:bg-pink-700">
                                                        Update
                                                    </button>
                                                </form>

                                                <form action="{{ route('keranjang.destroy', $item) }}" method="POST"
                                                      onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="rounded-xl bg-red-600 px-4 py-2 text-sm font-bold text-white hover:bg-red-700">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>

                                            <p class="mt-3 text-sm text-slate-600">
                                                Subtotal:
                                                <b>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</b>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="h-fit rounded-3xl bg-white p-6 shadow-sm ring-1 ring-pink-100">
                        <h2 class="text-2xl font-extrabold text-slate-900">Checkout COD</h2>
                        <p class="mt-2 text-slate-600">Isi lokasi dan catatan untuk penjual.</p>

                        <div class="mt-6 rounded-2xl bg-pink-50 p-4">
                            <p class="text-sm text-slate-500">Total Keranjang</p>
                            <p class="text-3xl font-extrabold text-pink-700">
                                Rp {{ number_format($totalHarga, 0, ',', '.') }}
                            </p>
                        </div>

                        <form action="{{ route('checkout.store') }}" method="POST" class="mt-6 space-y-4">
                            @csrf

                            <div>
                                <label class="mb-2 block font-bold text-slate-900">Lokasi COD</label>
                                <input type="text"
                                       name="lokasi_cod"
                                       value="{{ old('lokasi_cod') }}"
                                       placeholder="Contoh: Kantin kampus / depan fakultas"
                                       class="w-full rounded-2xl border-slate-200 focus:border-pink-500 focus:ring-pink-500">
                                @error('lokasi_cod')
                                    <p class="mt-1 text-sm font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block font-bold text-slate-900">Catatan</label>
                                <textarea name="catatan"
                                          rows="4"
                                          placeholder="Contoh: COD jam 12 siang ya kak"
                                          class="w-full rounded-2xl border-slate-200 focus:border-pink-500 focus:ring-pink-500">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <p class="mt-1 text-sm font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="w-full rounded-2xl bg-pink-700 px-6 py-4 font-extrabold text-white hover:bg-slate-900">
                                Checkout COD
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="rounded-3xl bg-white p-10 text-center shadow-sm ring-1 ring-pink-100">
                    <div class="text-6xl">🛒</div>
                    <h2 class="mt-4 text-2xl font-extrabold text-slate-900">Keranjang masih kosong</h2>
                    <p class="mt-2 text-slate-600">Pilih produk dari marketplace lalu tambahkan ke keranjang.</p>
                    <a href="{{ route('produk.index') }}"
                       class="mt-6 inline-flex rounded-2xl bg-pink-700 px-6 py-3 font-bold text-white hover:bg-slate-900">
                        Lihat Produk
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>