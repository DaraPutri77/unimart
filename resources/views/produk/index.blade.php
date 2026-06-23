<x-app-layout>
    <x-slot name="header">
        <div>
            <p style="margin:0 0 8px; color:#db2777; font-size:13px; font-weight:900; letter-spacing:6px;">
                MARKETPLACE
            </p>

            <h2 style="font-size:28px; font-weight:900; color:#0f172a; margin:0;">
                Daftar Produk
            </h2>

            <p style="margin:6px 0 0; color:#64748b; font-size:15px;">
                Temukan produk yang dijual mahasiswa lain di UniMart.
            </p>
        </div>
    </x-slot>

    <div style="padding:28px 20px; background:#fff7fb; min-height:calc(100vh - 120px);">
        <div style="max-width:1180px; margin:0 auto;">
            @if (session('success'))
                <div style="margin-bottom:18px; padding:13px 16px; border-radius:14px; background:#ecfdf5; color:#047857; border:1px solid #a7f3d0; font-weight:800;">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div style="margin-bottom:18px; padding:13px 16px; border-radius:14px; background:#fff1f2; color:#be123c; border:1px solid #fecdd3; font-weight:800;">
                    {{ session('error') }}
                </div>
            @endif

            <form
                method="GET"
                action="{{ route('produk.index') }}"
                style="margin-bottom:22px; background:white; padding:16px; border-radius:20px; box-shadow:0 10px 26px rgba(15,23,42,0.05);"
            >
                <div style="display:grid; grid-template-columns:2fr 1fr 1fr auto; gap:12px; align-items:end;">
                    <div>
                        <label style="display:block; margin-bottom:7px; font-weight:900; color:#0f172a; font-size:14px;">
                            Cari Produk
                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Cari produk..."
                            style="width:100%; height:44px; border:1px solid #e2e8f0; border-radius:12px; padding:0 13px; outline:none; font-size:14px;"
                        >
                    </div>

                    <div>
                        <label style="display:block; margin-bottom:7px; font-weight:900; color:#0f172a; font-size:14px;">
                            Kategori
                        </label>

                        <select
                            name="kategori"
                            style="width:100%; height:44px; border:1px solid #e2e8f0; border-radius:12px; padding:0 13px; outline:none; font-size:14px;"
                        >
                            <option value="">Semua Kategori</option>

                            @foreach ($kategoriList as $item)
                                <option value="{{ $item }}" @selected($kategori === $item)>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display:block; margin-bottom:7px; font-weight:900; color:#0f172a; font-size:14px;">
                            Fakultas
                        </label>

                        <select
                            name="fakultas"
                            style="width:100%; height:44px; border:1px solid #e2e8f0; border-radius:12px; padding:0 13px; outline:none; font-size:14px;"
                        >
                            <option value="">Semua Fakultas</option>

                            @foreach ($fakultasList as $item)
                                <option value="{{ $item }}" @selected($fakultas === $item)>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button
                        type="submit"
                        style="height:44px; padding:0 20px; border:0; border-radius:12px; background:#111827; color:white; font-weight:900; cursor:pointer; font-size:14px;"
                    >
                        Cari
                    </button>
                </div>
            </form>

            <div style="margin-bottom:18px; color:#64748b; font-size:15px; font-weight:700;">
                Total: {{ $produks->total() }} produk
            </div>

            @if ($produks->count())
                <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:18px;">
                    @foreach ($produks as $produk)
                        <div style="background:white; border-radius:22px; overflow:hidden; box-shadow:0 10px 26px rgba(15,23,42,0.05); border:1px solid #f3e8ef;">
                            <div style="height:145px; background:#f8fafc; display:flex; align-items:center; justify-content:center; padding:12px; border-bottom:1px solid #f1f5f9;">
                                @if ($produk->gambar_url)
                                    <img
                                        src="{{ $produk->gambar_url }}"
                                        alt="{{ $produk->nama }}"
                                        style="max-width:100%; max-height:100%; width:auto; height:auto; object-fit:contain; display:block;"
                                    >
                                @else
                                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#111827,#db2777); border-radius:16px; color:white; font-size:46px;">
                                        🛍️
                                    </div>
                                @endif
                            </div>

                            <div style="padding:16px;">
                                <div style="display:flex; align-items:center; justify-content:space-between; gap:8px; margin-bottom:14px; flex-wrap:wrap;">
                                    <div style="display:flex; gap:7px; flex-wrap:wrap;">
                                        <span style="padding:6px 10px; border-radius:999px; background:#fce7f3; color:#be185d; font-size:11px; font-weight:900;">
                                            {{ $produk->kategori }}
                                        </span>

                                        <span style="padding:6px 10px; border-radius:999px; background:#f1f5f9; color:#334155; font-size:11px; font-weight:900;">
                                            {{ $produk->fakultas }}
                                        </span>
                                    </div>

                                    @if ($produk->aktif)
                                        <span style="padding:6px 10px; border-radius:999px; background:#dcfce7; color:#15803d; font-size:11px; font-weight:900;">
                                            Tersedia
                                        </span>
                                    @else
                                        <span style="padding:6px 10px; border-radius:999px; background:#fee2e2; color:#b91c1c; font-size:11px; font-weight:900;">
                                            Terjual
                                        </span>
                                    @endif
                                </div>

                                <h3 style="margin:0 0 8px; font-size:18px; font-weight:900; color:#0f172a; line-height:1.35;">
                                    {{ $produk->nama }}
                                </h3>

                                <div style="margin-bottom:12px; font-size:24px; font-weight:900; color:#db2777;">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </div>

                                <div style="display:grid; gap:5px; margin-bottom:16px; color:#334155; font-size:13px;">
                                    <div>
                                        Stok:
                                        <strong style="color:#0f172a;">{{ $produk->stok }}</strong>
                                    </div>

                                    <div>
                                        Fakultas:
                                        <strong style="color:#0f172a;">{{ $produk->fakultas }}</strong>
                                    </div>

                                    <div>
                                        Penjual:
                                        <strong style="color:#0f172a;">{{ $produk->user->name ?? '-' }}</strong>
                                    </div>

                                    <div>
                                        WhatsApp:
                                        <strong style="color:#0f172a;">{{ $produk->user->whatsapp ?? '-' }}</strong>
                                    </div>
                                </div>

                                <a
                                    href="{{ route('produk.show', $produk) }}"
                                    style="display:flex; align-items:center; justify-content:center; height:40px; border-radius:11px; background:#111827; color:white; font-weight:900; text-decoration:none; font-size:13px;"
                                >
                                    Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top:24px;">
                    {{ $produks->links() }}
                </div>
            @else
                <div style="background:white; border-radius:22px; padding:34px; text-align:center; box-shadow:0 10px 26px rgba(15,23,42,0.05);">
                    <h3 style="margin:0 0 12px; font-size:23px; font-weight:900; color:#0f172a;">
                        Belum ada produk yang bisa ditampilkan.
                    </h3>

                    <p style="margin:0; color:#64748b; font-size:15px;">
                        Produk milikmu sendiri tidak tampil di halaman Produk. Produkmu ada di menu Produk Saya.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>