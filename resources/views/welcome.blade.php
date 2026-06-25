<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UniMart - Campus Marketplace</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
    </style>
</head>

<body class="bg-slate-950 text-white antialiased">
    <main class="min-h-screen overflow-hidden bg-[radial-gradient(circle_at_top_left,_rgba(219,39,119,0.35),_transparent_35%),linear-gradient(135deg,#09090f_0%,#020617_45%,#2a0618_100%)]">
        <header class="mx-auto flex max-w-7xl items-center justify-between px-6 py-8 lg:px-8">
            <a href="{{ url('/') }}" class="flex items-center gap-4">
                <div class="flex h-16 w-16 items-center justify-center overflow-hidden rounded-3xl bg-gradient-to-br from-pink-700 to-slate-950 shadow-2xl shadow-pink-900/40">
                    <x-application-logo class="h-11 w-11" />
                </div>

                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight">UniMart</h1>
                    <p class="mt-1 text-sm font-semibold text-slate-300">Campus Marketplace</p>
                </div>
            </a>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="rounded-2xl bg-white/10 px-6 py-3 text-sm font-extrabold text-white ring-1 ring-white/15 transition hover:bg-pink-700">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="rounded-2xl bg-white/10 px-6 py-3 text-sm font-extrabold text-white ring-1 ring-white/15 transition hover:bg-white/20">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="rounded-2xl bg-pink-700 px-6 py-3 text-sm font-extrabold text-white shadow-xl shadow-pink-900/40 transition hover:bg-pink-600">
                        Daftar
                    </a>
                @endauth
            </div>
        </header>

        <section class="mx-auto grid max-w-7xl items-center gap-12 px-6 pb-20 pt-10 lg:grid-cols-2 lg:px-8 lg:pb-28">
            <div>
                <div class="inline-flex rounded-full border border-pink-500/40 bg-pink-500/15 px-5 py-3 text-sm font-extrabold uppercase tracking-[0.25em] text-pink-200">
                    Marketplace Kampus Berbasis COD
                </div>

                <h2 class="mt-8 max-w-3xl text-6xl font-black leading-[0.95] tracking-tight lg:text-8xl">
                    Jual beli barang kampus jadi lebih <span class="text-pink-500">rapi.</span>
                </h2>

                <p class="mt-8 max-w-2xl text-xl leading-9 text-slate-300">
                    UniMart membantu mahasiswa menjual produk, mencari barang, menyimpan produk ke keranjang,
                    melakukan checkout COD, dan memantau status pesanan dalam satu sistem.
                </p>

                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="{{ auth()->check() ? route('produk.index') : route('login') }}"
                       class="rounded-2xl bg-pink-700 px-8 py-4 text-base font-extrabold text-white shadow-2xl shadow-pink-900/40 transition hover:bg-pink-600">
                        Lihat Produk
                    </a>

                    <a href="{{ auth()->check() ? route('produk.saya') : route('register') }}"
                       class="rounded-2xl bg-white/10 px-8 py-4 text-base font-extrabold text-white ring-1 ring-white/15 transition hover:bg-white/20">
                        {{ auth()->check() ? 'Tambah Produk' : 'Buat Akun' }}
                    </a>
                </div>
            </div>

            <div class="rounded-[2rem] border border-white/10 bg-white/10 p-6 shadow-2xl backdrop-blur-xl">
                <div class="rounded-[1.5rem] bg-slate-950/70 p-8 ring-1 ring-white/10">
                    <h3 class="text-3xl font-black">Alur UniMart</h3>
                    <p class="mt-4 text-lg leading-8 text-slate-300">
                        Alur dibuat sesuai proses transaksi marketplace kampus: pembeli dan penjual tetap bertemu
                        secara COD, tetapi status transaksi tercatat di sistem.
                    </p>

                    <div class="mt-8 space-y-4">
                        <div class="flex gap-4 rounded-3xl bg-white/5 p-5 ring-1 ring-white/10">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-pink-600 text-lg font-black">1</div>
                            <div>
                                <h4 class="text-xl font-extrabold">Penjual Tambah Produk</h4>
                                <p class="mt-1 text-slate-300">Produk ditambahkan melalui menu Produk Saya.</p>
                            </div>
                        </div>

                        <div class="flex gap-4 rounded-3xl bg-white/5 p-5 ring-1 ring-white/10">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-pink-600 text-lg font-black">2</div>
                            <div>
                                <h4 class="text-xl font-extrabold">Pembeli Melihat Produk</h4>
                                <p class="mt-1 text-slate-300">Pembeli melihat produk milik user lain di halaman Produk.</p>
                            </div>
                        </div>

                        <div class="flex gap-4 rounded-3xl bg-white/5 p-5 ring-1 ring-white/10">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-pink-600 text-lg font-black">3</div>
                            <div>
                                <h4 class="text-xl font-extrabold">Checkout COD</h4>
                                <p class="mt-1 text-slate-300">Produk dari keranjang diproses menjadi pesanan COD.</p>
                            </div>
                        </div>

                        <div class="flex gap-4 rounded-3xl bg-white/5 p-5 ring-1 ring-white/10">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-pink-600 text-lg font-black">4</div>
                            <div>
                                <h4 class="text-xl font-extrabold">Pesanan Dikonfirmasi</h4>
                                <p class="mt-1 text-slate-300">Penjual menyetujui atau menolak pesanan masuk.</p>
                            </div>
                        </div>

                        <div class="flex gap-4 rounded-3xl bg-white/5 p-5 ring-1 ring-white/10">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-pink-600 text-lg font-black">5</div>
                            <div>
                                <h4 class="text-xl font-extrabold">Pesanan Selesai</h4>
                                <p class="mt-1 text-slate-300">Setelah COD, pembeli menandai pesanan sebagai selesai.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <h2 class="text-5xl font-black tracking-tight lg:text-6xl">Fitur utama UniMart</h2>
                <p class="mt-6 text-xl leading-9 text-slate-300">
                    Fitur difokuskan pada kebutuhan marketplace kampus agar mudah dijelaskan saat demo UAS.
                </p>
            </div>

            <div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-[2rem] border border-white/10 bg-white/10 p-8">
                    <div class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-pink-700/30 text-3xl">📦</div>
                    <h3 class="text-2xl font-black">Produk Saya</h3>
                    <p class="mt-4 text-lg leading-8 text-slate-300">Penjual dapat menambah, mengedit, menghapus, dan mengatur stok produk.</p>
                </div>

                <div class="rounded-[2rem] border border-white/10 bg-white/10 p-8">
                    <div class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-pink-700/30 text-3xl">🔎</div>
                    <h3 class="text-2xl font-black">Marketplace Produk</h3>
                    <p class="mt-4 text-lg leading-8 text-slate-300">Pembeli melihat produk milik user lain dan dapat mencari berdasarkan kategori atau fakultas.</p>
                </div>

                <div class="rounded-[2rem] border border-white/10 bg-white/10 p-8">
                    <div class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-pink-700/30 text-3xl">🛒</div>
                    <h3 class="text-2xl font-black">Keranjang</h3>
                    <p class="mt-4 text-lg leading-8 text-slate-300">Pembeli menyimpan produk sebelum melanjutkan checkout COD.</p>
                </div>

                <div class="rounded-[2rem] border border-white/10 bg-white/10 p-8">
                    <div class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-pink-700/30 text-3xl">🤝</div>
                    <h3 class="text-2xl font-black">Checkout COD</h3>
                    <p class="mt-4 text-lg leading-8 text-slate-300">Pembeli mengisi lokasi dan catatan COD agar transaksi lebih jelas.</p>
                </div>

                <div class="rounded-[2rem] border border-white/10 bg-white/10 p-8">
                    <div class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-pink-700/30 text-3xl">🧾</div>
                    <h3 class="text-2xl font-black">Pesanan Saya</h3>
                    <p class="mt-4 text-lg leading-8 text-slate-300">Pembeli dapat memantau status pesanan dan menyelesaikan pesanan setelah COD.</p>
                </div>

                <div class="rounded-[2rem] border border-white/10 bg-white/10 p-8">
                    <div class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-pink-700/30 text-3xl">📥</div>
                    <h3 class="text-2xl font-black">Pesanan Masuk</h3>
                    <p class="mt-4 text-lg leading-8 text-slate-300">Penjual dapat menyetujui atau menolak pesanan dari pembeli.</p>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-6 pb-20 lg:px-8">
            <div class="flex flex-col gap-8 rounded-[2rem] border border-pink-500/30 bg-pink-700/15 p-10 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-4xl font-black">Mulai gunakan UniMart</h2>
                    <p class="mt-4 max-w-3xl text-lg leading-8 text-slate-300">
                        Login untuk mengelola produk, melihat marketplace, menyimpan produk ke keranjang, dan memproses transaksi COD.
                    </p>
                </div>

                <div class="flex shrink-0 gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="rounded-2xl bg-pink-700 px-8 py-4 font-extrabold text-white hover:bg-pink-600">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="rounded-2xl bg-white/10 px-8 py-4 font-extrabold text-white ring-1 ring-white/15 hover:bg-white/20">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="rounded-2xl bg-pink-700 px-8 py-4 font-extrabold text-white hover:bg-pink-600">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <footer class="border-t border-white/10 py-8 text-center text-sm font-semibold text-slate-400">
            UniMart © 2026 — Campus Marketplace COD antar mahasiswa.
        </footer>
    </main>
</body>
</html>