<x-app-layout>
    <style>
        .produk-saya-page {
            min-height: 100vh;
            background: rgba(253, 242, 248, 0.55);
            padding: 36px 0;
        }

        .produk-saya-container {
            width: min(1280px, calc(100% - 48px));
            margin: 0 auto;
        }

        .produk-saya-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 26px;
        }

        .produk-saya-kicker {
            margin: 0;
            color: #ec4899;
            font-size: 13px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.28em;
        }

        .produk-saya-heading {
            margin: 10px 0 0;
            color: #0f172a;
            font-size: 36px;
            line-height: 1.1;
            font-weight: 900;
            letter-spacing: -0.04em;
        }

        .produk-saya-subheading {
            max-width: 760px;
            margin: 10px 0 0;
            color: #64748b;
            font-size: 16px;
            line-height: 1.65;
            font-weight: 600;
        }

        .produk-saya-add {
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 52px;
            padding: 0 24px;
            border-radius: 18px;
            background: #be185d;
            color: #ffffff;
            font-size: 15px;
            font-weight: 900;
            text-decoration: none;
            box-shadow: 0 14px 28px rgba(190, 24, 93, 0.18);
            transition: 0.2s ease;
        }

        .produk-saya-add:hover {
            background: #0f172a;
            transform: translateY(-1px);
        }

        .produk-saya-alert {
            margin-bottom: 20px;
            border-radius: 18px;
            padding: 16px 18px;
            font-weight: 800;
        }

        .produk-saya-alert-success {
            border: 1px solid #bbf7d0;
            background: #f0fdf4;
            color: #15803d;
        }

        .produk-saya-alert-error {
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #b91c1c;
        }

        .produk-saya-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 26px;
            align-items: start;
        }

        .produk-saya-card {
            height: 560px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border-radius: 28px;
            background: #ffffff;
            border: 1px solid #fbcfe8;
            box-shadow: 0 18px 45px rgba(190, 24, 93, 0.08);
            transition: 0.2s ease;
        }

        .produk-saya-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 24px 55px rgba(190, 24, 93, 0.13);
        }

        .produk-saya-image-box {
            height: 160px;
            flex: 0 0 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 14px;
            background: #f8fafc;
        }

        .produk-saya-image {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: contain;
        }

        .produk-saya-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border-radius: 20px;
            background: #fdf2f8;
            color: #be185d;
            text-align: center;
            font-weight: 900;
        }

        .produk-saya-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 18px 22px 20px;
        }

        .produk-saya-badges {
            height: 76px;
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
            gap: 8px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .produk-saya-badge {
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0 14px;
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .produk-saya-badge-pink {
            background: #fce7f3;
            color: #be185d;
        }

        .produk-saya-badge-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .produk-saya-badge-gray {
            background: #f1f5f9;
            color: #0f172a;
        }

        .produk-saya-badge-green {
            background: #dcfce7;
            color: #15803d;
        }

        .produk-saya-title {
            height: 64px;
            margin: 0;
            color: #0f172a;
            font-size: 23px;
            line-height: 1.25;
            font-weight: 900;
            letter-spacing: -0.045em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .produk-saya-price {
            height: 44px;
            margin: 10px 0 0;
            color: #be185d;
            font-size: 31px;
            line-height: 1.1;
            font-weight: 900;
            letter-spacing: -0.045em;
            display: flex;
            align-items: center;
        }

        .produk-saya-meta {
            height: 88px;
            margin-top: 12px;
            display: grid;
            align-content: start;
            gap: 7px;
            color: #475569;
            font-size: 15px;
            line-height: 1.35;
            overflow: hidden;
        }

        .produk-saya-meta p {
            margin: 0;
        }

        .produk-saya-meta strong {
            color: #0f172a;
            font-weight: 900;
        }

        .produk-saya-status {
            color: #16a34a;
            font-weight: 900;
        }

        .produk-saya-actions {
            margin-top: 14px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .produk-saya-button {
            width: 100%;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 17px;
            color: #ffffff;
            font-size: 15px;
            font-weight: 900;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .produk-saya-button-detail {
            background: #0f172a;
        }

        .produk-saya-button-edit {
            background: #facc15;
        }

        .produk-saya-button-delete {
            background: #ef4444;
        }

        .produk-saya-button-detail:hover,
        .produk-saya-button-edit:hover,
        .produk-saya-button-delete:hover {
            transform: translateY(-1px);
            filter: brightness(0.95);
        }

        .produk-saya-empty {
            border-radius: 28px;
            background: #ffffff;
            padding: 48px 28px;
            text-align: center;
            border: 1px solid #fbcfe8;
            box-shadow: 0 18px 45px rgba(190, 24, 93, 0.08);
        }

        .produk-saya-empty-icon {
            font-size: 58px;
        }

        .produk-saya-empty-title {
            margin: 16px 0 0;
            color: #0f172a;
            font-size: 24px;
            font-weight: 900;
        }

        .produk-saya-empty-text {
            margin: 8px 0 0;
            color: #64748b;
            font-weight: 600;
        }

        @media (max-width: 1180px) {
            .produk-saya-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 760px) {
            .produk-saya-container {
                width: min(100% - 28px, 520px);
            }

            .produk-saya-header {
                flex-direction: column;
            }

            .produk-saya-grid {
                grid-template-columns: 1fr;
            }

            .produk-saya-card {
                height: auto;
                min-height: 560px;
            }

            .produk-saya-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="produk-saya-page">
        <div class="produk-saya-container">
            <div class="produk-saya-header">
                <div>
                    <p class="produk-saya-kicker">
                        Produk Saya
                    </p>

                    <h1 class="produk-saya-heading">
                        Kelola Produk Jualanmu
                    </h1>

                    <p class="produk-saya-subheading">
                        Halaman ini menampilkan produk milik akun yang sedang login. Produk yang kamu tambahkan di sini akan tampil di halaman Produk untuk pengguna lain.
                    </p>
                </div>

                <a href="{{ route('produk.create') }}" class="produk-saya-add">
                    + Tambah Produk
                </a>
            </div>

            @if (session('success'))
                <div class="produk-saya-alert produk-saya-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="produk-saya-alert produk-saya-alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if ($produks->count() > 0)
                <div class="produk-saya-grid">
                    @foreach ($produks as $produk)
                        <article class="produk-saya-card">
                            <div class="produk-saya-image-box">
                                @if ($produk->gambar_url)
                                    <img src="{{ $produk->gambar_url }}"
                                         alt="{{ $produk->nama }}"
                                         class="produk-saya-image">
                                @else
                                    <div class="produk-saya-placeholder">
                                        <div style="font-size: 40px;">🛍️</div>
                                        <div style="margin-top: 8px; font-size: 12px;">
                                            Gambar belum tersedia
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="produk-saya-body">
                                <div class="produk-saya-badges">
                                    <span class="produk-saya-badge produk-saya-badge-pink">
                                        {{ $produk->kategori }}
                                    </span>

                                    <span class="produk-saya-badge produk-saya-badge-blue">
                                        {{ $produk->kondisi_label ?? (($produk->kondisi ?? 'bekas') === 'baru' ? 'Barang Baru' : 'Barang Bekas') }}
                                    </span>

                                    <span class="produk-saya-badge produk-saya-badge-gray">
                                        {{ $produk->fakultas }}
                                    </span>

                                    <span class="produk-saya-badge produk-saya-badge-green">
                                        {{ $produk->stok > 0 ? 'Tersedia' : 'Stok Habis' }}
                                    </span>
                                </div>

                                <h2 class="produk-saya-title">
                                    {{ $produk->nama }}
                                </h2>

                                <p class="produk-saya-price">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </p>

                                <div class="produk-saya-meta">
                                    <p>
                                        Stok:
                                        <strong>{{ $produk->stok }}</strong>
                                    </p>

                                    <p>
                                        Fakultas:
                                        <strong>{{ $produk->fakultas }}</strong>
                                    </p>

                                    <p>
                                        Status:
                                        <span class="produk-saya-status">
                                            {{ $produk->stok > 0 ? 'Produk tampil untuk pembeli' : 'Produk tidak tersedia sementara' }}
                                        </span>
                                    </p>
                                </div>

                                <div class="produk-saya-actions">
                                    <a href="{{ route('produk.show', $produk) }}"
                                       class="produk-saya-button produk-saya-button-detail">
                                        Detail
                                    </a>

                                    <a href="{{ route('produk.edit', $produk) }}"
                                       class="produk-saya-button produk-saya-button-edit">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('produk.destroy', $produk) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="produk-saya-button produk-saya-button-delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="produk-saya-empty">
                    <div class="produk-saya-empty-icon">📦</div>

                    <h2 class="produk-saya-empty-title">
                        Belum ada produk
                    </h2>

                    <p class="produk-saya-empty-text">
                        Tambahkan produk pertamamu agar bisa tampil di marketplace.
                    </p>

                    <a href="{{ route('produk.create') }}"
                       class="produk-saya-add"
                       style="margin-top: 22px;">
                        Tambah Produk
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>