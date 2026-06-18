<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
            <div>
                <h2 style="font-size:28px; font-weight:900; color:#0f172a; margin:0;">
                    Produk Saya
                </h2>
                <p style="margin:6px 0 0; color:#64748b; font-size:15px;">
                    Kelola produk yang kamu jual di UniMart.
                </p>
            </div>

            <a
                href="{{ route('produk.create') }}"
                style="display:inline-flex; align-items:center; justify-content:center; padding:13px 20px; border-radius:16px; background:linear-gradient(135deg,#111827,#db2777); color:white; font-weight:900; text-decoration:none;"
            >
                + Tambah Produk
            </a>
        </div>
    </x-slot>

    <div style="padding:36px 24px; background:#fff7fb; min-height:calc(100vh - 120px);">
        <div style="max-width:1200px; margin:0 auto;">
            @if (session('success'))
                <div style="margin-bottom:20px; padding:14px 18px; border-radius:16px; background:#ecfdf5; color:#047857; border:1px solid #a7f3d0; font-weight:800;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" action="{{ route('produk.saya') }}" style="margin-bottom:28px; background:white; padding:20px; border-radius:24px; box-shadow:0 18px 45px rgba(15,23,42,0.06);">
                <div style="display:grid; grid-template-columns:2fr 1fr 1fr auto; gap:14px; align-items:end;">
                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                            Cari Produk
                        </label>
                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Cari nama, kategori, fakultas..."
                            style="width:100%; height:48px; border:1px solid #e2e8f0; border-radius:14px; padding:0 14px; outline:none;"
                        >
                    </div>

                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                            Kategori
                        </label>
                        <select
                            name="kategori"
                            style="width:100%; height:48px; border:1px solid #e2e8f0; border-radius:14px; padding:0 14px; outline:none;"
                        >
                            <option value="">Semua</option>
                            @foreach ($kategoriList as $item)
                                <option value="{{ $item }}" @selected($kategori === $item)>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                            Fakultas
                        </label>
                        <select
                            name="fakultas"
                            style="width:100%; height:48px; border:1px solid #e2e8f0; border-radius:14px; padding:0 14px; outline:none;"
                        >
                            <option value="">Semua</option>
                            @foreach ($fakultasList as $item)
                                <option value="{{ $item }}" @selected($fakultas === $item)>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button
                        type="submit"
                        style="height:48px; padding:0 22px; border:0; border-radius:14px; background:#111827; color:white; font-weight:900; cursor:pointer;"
                    >
                        Filter
                    </button>
                </div>
            </form>

            @if ($produks->count())
                <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:24px;">
                    @foreach ($produks as $produk)
                        <div style="background:white; border-radius:28px; padding:24px; box-shadow:0 18px 45px rgba(15,23,42,0.06);">
                            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:22px;">
                                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                                    <span style="padding:8px 14px; border-radius:999px; background:#fce7f3; color:#be185d; font-size:13px; font-weight:900;">
                                        {{ $produk->kategori }}
                                    </span>

                                    <span style="padding:8px 14px; border-radius:999px; background:#f1f5f9; color:#334155; font-size:13px; font-weight:900;">
                                        {{ $produk->fakultas }}
                                    </span>
                                </div>

                                @if ($produk->aktif)
                                    <span style="padding:8px 14px; border-radius:999px; background:#dcfce7; color:#15803d; font-size:13px; font-weight:900;">
                                        Tersedia
                                    </span>
                                @else
                                    <span style="padding:8px 14px; border-radius:999px; background:#fee2e2; color:#b91c1c; font-size:13px; font-weight:900;">
                                        Terjual
                                    </span>
                                @endif
                            </div>

                            <h3 style="margin:0 0 14px; font-size:24px; font-weight:900; color:#0f172a;">
                                {{ $produk->nama }}
                            </h3>

                            <div style="margin-bottom:18px; font-size:34px; font-weight:900; color:#db2777;">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </div>

                            <div style="display:grid; gap:8px; margin-bottom:24px; color:#334155; font-size:15px;">
                                <div>Stok: <strong style="color:#0f172a;">{{ $produk->stok }}</strong></div>
                                <div>Fakultas: <strong style="color:#0f172a;">{{ $produk->fakultas }}</strong></div>
                                <div>Status:
                                    <strong style="color:#0f172a;">
                                        {{ $produk->aktif ? 'Tersedia' : 'Terjual' }}
                                    </strong>
                                </div>
                            </div>

                            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                                <a
                                    href="{{ route('produk.show', $produk) }}"
                                    style="display:flex; align-items:center; justify-content:center; height:48px; border-radius:14px; background:#111827; color:white; font-weight:900; text-decoration:none;"
                                >
                                    Detail
                                </a>

                                <a
                                    href="{{ route('produk.edit', $produk) }}"
                                    style="display:flex; align-items:center; justify-content:center; height:48px; border-radius:14px; background:#fbbf24; color:white; font-weight:900; text-decoration:none;"
                                >
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('produk.destroy', $produk) }}" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        style="width:100%; height:48px; border:0; border-radius:14px; background:#ef4444; color:white; font-weight:900; cursor:pointer;"
                                    >
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top:28px;">
                    {{ $produks->links() }}
                </div>
            @else
                <div style="background:white; border-radius:28px; padding:42px; text-align:center; box-shadow:0 18px 45px rgba(15,23,42,0.06);">
                    <h3 style="margin:0 0 12px; font-size:26px; font-weight:900; color:#0f172a;">
                        Belum ada produk milikmu.
                    </h3>

                    <p style="margin:0 0 22px; color:#64748b;">
                        Tambahkan produk pertama agar bisa dijual di UniMart.
                    </p>

                    <a
                        href="{{ route('produk.create') }}"
                        style="display:inline-flex; align-items:center; justify-content:center; padding:13px 20px; border-radius:16px; background:linear-gradient(135deg,#111827,#db2777); color:white; font-weight:900; text-decoration:none;"
                    >
                        Tambah Produk
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>