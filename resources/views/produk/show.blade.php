<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
            <div>
                <h2 style="font-size:28px; font-weight:900; color:#0f172a; margin:0;">
                    Detail Produk
                </h2>
                <p style="margin:6px 0 0; color:#64748b; font-size:15px;">
                    Informasi lengkap produk di UniMart.
                </p>
            </div>

            <a
                href="{{ auth()->id() === $produk->user_id ? route('produk.saya') : route('produk.index') }}"
                style="display:inline-flex; align-items:center; justify-content:center; padding:13px 20px; border-radius:16px; background:#f1f5f9; color:#334155; font-weight:900; text-decoration:none;"
            >
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div style="padding:36px 24px; background:#fff7fb; min-height:calc(100vh - 120px);">
        <div style="max-width:1100px; margin:0 auto;">
            @if (session('success'))
                <div style="margin-bottom:20px; padding:14px 18px; border-radius:16px; background:#ecfdf5; color:#047857; border:1px solid #a7f3d0; font-weight:800;">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div style="margin-bottom:20px; padding:14px 18px; border-radius:16px; background:#fff1f2; color:#be123c; border:1px solid #fecdd3; font-weight:800;">
                    {{ session('error') }}
                </div>
            @endif

            <div style="display:grid; grid-template-columns:0.95fr 1.05fr; gap:28px; align-items:start;">
                <div style="background:white; border-radius:28px; padding:22px; box-shadow:0 18px 45px rgba(15,23,42,0.06);">
                    @if ($produk->gambar)
                        <img
                            src="{{ asset('storage/' . $produk->gambar) }}"
                            alt="{{ $produk->nama }}"
                            style="width:100%; height:380px; object-fit:cover; border-radius:22px; border:1px solid #e2e8f0;"
                        >
                    @else
                        <div style="width:100%; height:380px; border-radius:22px; background:linear-gradient(135deg,#111827,#db2777); display:flex; align-items:center; justify-content:center; color:white; font-size:72px; font-weight:900;">
                            🛍️
                        </div>
                    @endif
                </div>

                <div style="background:white; border-radius:28px; padding:28px; box-shadow:0 18px 45px rgba(15,23,42,0.06);">
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:22px; flex-wrap:wrap;">
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

                    <h1 style="margin:0 0 16px; font-size:34px; line-height:1.25; font-weight:900; color:#0f172a;">
                        {{ $produk->nama }}
                    </h1>

                    <div style="margin-bottom:24px; font-size:42px; font-weight:900; color:#db2777;">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </div>

                    <div style="display:grid; gap:10px; margin-bottom:24px; color:#334155; font-size:16px;">
                        <div>Stok: <strong style="color:#0f172a;">{{ $produk->stok }}</strong></div>
                        <div>Fakultas: <strong style="color:#0f172a;">{{ $produk->fakultas }}</strong></div>
                        <div>Penjual: <strong style="color:#0f172a;">{{ $produk->user->name ?? '-' }}</strong></div>
                        <div>WhatsApp: <strong style="color:#0f172a;">{{ $produk->user->whatsapp ?? '-' }}</strong></div>
                    </div>

                    <div style="margin-bottom:28px;">
                        <h3 style="margin:0 0 10px; font-size:18px; font-weight:900; color:#0f172a;">
                            Deskripsi Produk
                        </h3>

                        <p style="margin:0; color:#475569; line-height:1.8; font-size:15px;">
                            {{ $produk->deskripsi ?: 'Belum ada deskripsi produk.' }}
                        </p>
                    </div>

                    @if (auth()->id() === $produk->user_id)
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                            <a
                                href="{{ route('produk.edit', $produk) }}"
                                style="display:flex; align-items:center; justify-content:center; height:50px; border-radius:15px; background:#fbbf24; color:white; font-weight:900; text-decoration:none;"
                            >
                                Edit Produk
                            </a>

                            <form method="POST" action="{{ route('produk.destroy', $produk) }}" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    style="width:100%; height:50px; border:0; border-radius:15px; background:#ef4444; color:white; font-weight:900; cursor:pointer;"
                                >
                                    Hapus Produk
                                </button>
                            </form>
                        </div>

                        @if ($produk->aktif)
                            <form method="POST" action="{{ route('produk.tandai-terjual', $produk) }}">
                                @csrf

                                <button
                                    type="submit"
                                    style="width:100%; height:50px; border:0; border-radius:15px; background:#111827; color:white; font-weight:900; cursor:pointer;"
                                >
                                    Tandai Terjual
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('produk.tandai-tersedia', $produk) }}">
                                @csrf

                                <button
                                    type="submit"
                                    style="width:100%; height:50px; border:0; border-radius:15px; background:#16a34a; color:white; font-weight:900; cursor:pointer;"
                                >
                                    Tandai Tersedia
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>