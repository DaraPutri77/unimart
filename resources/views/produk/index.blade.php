<x-app-layout>
    @php
        $kategoriOptions = $kategoriOptions ?? ['Buku', 'Elektronik', 'Fashion', 'Alat Tulis', 'Aksesoris', 'Lainnya'];
        $fakultasOptions = $fakultasOptions ?? ['SAINTEK', 'FAI', 'FBBP', 'Fakultas Kesehatan'];
        $kondisiOptions = $kondisiOptions ?? ['baru', 'bekas'];
    @endphp

    <style>
        .produk-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 28px;
            align-items: stretch;
        }

        .produk-card {
            min-height: 640px;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border-radius: 28px;
            background: #ffffff;
            border: 1px solid #fbcfe8;
            box-shadow: 0 18px 40px rgba(219, 39, 119, 0.08);
            transition: 0.2s ease;
        }

        .produk-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 55px rgba(219, 39, 119, 0.14);
        }

        .produk-image-box {
            height: 220px;
            flex: 0 0 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            padding: 18px;
        }

        .produk-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .produk-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 20px;
            background: #fdf2f8;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #be185d;
            font-weight: 900;
            text-align: center;
        }

        .produk-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 22px;
        }

        .produk-badges {
            min-height: 78px;
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
            gap: 8px;
            margin-bottom: 10px;
        }

        .produk-badge {
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0 16px;
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .produk-badge-pink {
            background: #fce7f3;
            color: #be185d;
        }

        .produk-badge-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .produk-badge-gray {
            background: #f1f5f9;
            color: #0f172a;
        }

        .produk-title {
            height: 70px;
            margin: 0;
            color: #0f172a;
            font-size: 24px;
            line-height: 1.25;
            font-weight: 900;
            letter-spacing: -0.04em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .produk-price {
            margin-top: 12px;
            margin-bottom: 0;
            color: #be185d;
            font-size: 32px;
            line-height: 1.1;
            font-weight: 900;
            letter-spacing: -0.04em;
        }

        .produk-meta {
            margin-top: 16px;
            display: grid;
            gap: 8px;
            color: #475569;
            font-size: 15px;
            line-height: 1.4;
        }

        .produk-meta p {
            margin: 0;
        }

        .produk-meta strong {
            color: #0f172a;
            font-weight: 900;
        }

        .produk-meta .wa-ok {
            color: #16a34a;
            font-weight: 900;
        }

        .produk-meta .wa-no {
            color: #dc2626;
            font-weight: 900;
        }

        .produk-action {
            margin-top: auto;
            padding-top: 20px;
        }

        .produk-button {
            width: 100%;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: #0f172a;
            color: #ffffff;
            font-size: 16px;
            font-weight: 900;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .produk-button:hover {
            background: #be185d;
        }

        @media (max-width: 1180px) {
            .produk-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .produk-grid {
                grid-template-columns: 1fr;
            }

            .produk-card {
                min-height: 620px;
            }
        }
    </style>

    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <p class="text-sm font-black uppercase tracking-[0.3em] text-pink-500">
                    Marketplace
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900">
                    Produk Mahasiswa
                </h1>

                <p class="mt-3 max-w-3xl text-slate-600">
                    Temukan produk milik mahasiswa lain. Produk milik kamu sendiri tidak tampil di halaman ini agar alur pembeli dan penjual tetap jelas.
                </p>
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

            <form method="GET" action="{{ route('produk.index') }}"
                  class="mb-8 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-pink-100">
                <div class="grid gap-4 lg:grid-cols-[1.4fr_0.8fr_0.8fr_0.8fr_auto]">
                    <div>
                        <label class="mb-2 block font-extrabold text-slate-900">
                            Cari Produk
                        </label>

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari nama produk..."
                               class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                    </div>

                    <div>
                        <label class="mb-2 block font-extrabold text-slate-900">
                            Kategori
                        </label>

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
                        <label class="mb-2 block font-extrabold text-slate-900">
                            Kondisi
                        </label>

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
                        <label class="mb-2 block font-extrabold text-slate-900">
                            Fakultas
                        </label>

                        <select name="fakultas"
                                class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                            <option value="">Semua</option>

                            @foreach ($fakultasOptions as $fakultas)
                                <option value="{{ $fakultas }}" @selected(request('fakultas') === $fakultas)>
                                    {{ $fakultas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full rounded-2xl bg-slate-900 px-7 py-4 font-extrabold text-white hover:bg-pink-700">
                            Cari
                        </button>
                    </div>
                </div>
            </form>

            <div class="mb-5 flex flex-wrap items-center justify-between gap-4">
                <p class="font-bold text-slate-600">
                    Total: {{ $produks->count() }} produk
                </p>

                <a href="{{ route('produk.saya') }}"
                   class="rounded-2xl bg-white px-5 py-3 text-sm font-extrabold text-pink-700 shadow-sm ring-1 ring-pink-100 hover:bg-pink-700 hover:text-white">
                    Kelola Produk Saya
                </a>
            </div>

            @if ($produks->count() > 0)
                <div class="produk-grid">
                    @foreach ($produks as $produk)
                        <article class="produk-card">
                            <div class="produk-image-box">
                                @if ($produk->gambar_url)
                                    <img src="{{ $produk->gambar_url }}"
                                         alt="{{ $produk->nama }}"
                                         class="produk-image">
                                @else
                                    <div class="produk-placeholder">
                                        <div style="font-size: 44px;">🛍️</div>
                                        <div style="margin-top: 8px; font-size: 12px;">
                                            Gambar belum tersedia
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="produk-body">
                                <div class="produk-badges">
                                    <span class="produk-badge produk-badge-pink">
                                        {{ $produk->kategori }}
                                    </span>

                                    <span class="produk-badge produk-badge-blue">
                                        {{ $produk->kondisi_label ?? (($produk->kondisi ?? 'bekas') === 'baru' ? 'Barang Baru' : 'Barang Bekas') }}
                                    </span>

                                    <span class="produk-badge produk-badge-gray">
                                        {{ $produk->fakultas }}
                                    </span>
                                </div>

                                <h2 class="produk-title">
                                    {{ $produk->nama }}
                                </h2>

                                <p class="produk-price">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </p>

                                <div class="produk-meta">
                                    <p>
                                        Stok:
                                        <strong>{{ $produk->stok }}</strong>
                                    </p>

                                    <p>
                                        Penjual:
                                        <strong>{{ $produk->user->name ?? '-' }}</strong>
                                    </p>

                                    <p>
                                        Status kontak:
                                        @if (! empty($produk->user?->whatsapp))
                                            <span class="wa-ok">WhatsApp tersedia</span>
                                        @else
                                            <span class="wa-no">WhatsApp belum tersedia</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="produk-action">
                                    <a href="{{ route('produk.show', $produk) }}" class="produk-button">
                                        Detail Produk
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="rounded-3xl bg-white p-10 text-center shadow-sm ring-1 ring-pink-100">
                    <div class="text-6xl">🔎</div>

                    <h2 class="mt-4 text-2xl font-extrabold text-slate-900">
                        Produk tidak ditemukan
                    </h2>

                    <p class="mt-2 text-slate-600">
                        Coba ubah kata kunci, kategori, kondisi, atau fakultas pencarian.
                    </p>

                    <a href="{{ route('produk.index') }}"
                       class="mt-6 inline-flex rounded-2xl bg-pink-700 px-6 py-3 font-bold text-white hover:bg-slate-900">
                        Reset Filter
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>