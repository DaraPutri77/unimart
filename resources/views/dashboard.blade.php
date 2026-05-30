@extends('layouts.app')

@section('content')
    <section class="bg-gradient-to-br from-rose-50 via-white to-pink-50 py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-[32px] bg-white p-8 shadow-xl shadow-rose-100">
                <p class="text-sm font-black uppercase tracking-[0.3em] text-pink-500">
                    Dashboard
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900">
                    Selamat datang, {{ auth()->user()->name }}!
                </h1>

                <p class="mt-3 max-w-2xl text-slate-600">
                    Kelola profil, nomor WhatsApp, dan produk jualanmu di UniMart.
                </p>

                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    <a href="{{ route('produk.index') }}" class="rounded-3xl border border-rose-100 bg-rose-50 p-6 transition hover:-translate-y-1 hover:shadow-lg">
                        <h2 class="text-xl font-black text-slate-900">Lihat Produk</h2>
                        <p class="mt-2 text-sm text-slate-600">Cek semua barang yang tersedia.</p>
                    </a>

                    <a href="{{ route('produk.create') }}" class="rounded-3xl border border-pink-100 bg-pink-50 p-6 transition hover:-translate-y-1 hover:shadow-lg">
                        <h2 class="text-xl font-black text-slate-900">Jual Barang</h2>
                        <p class="mt-2 text-sm text-slate-600">Tambahkan produk baru untuk dijual.</p>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="rounded-3xl border border-slate-100 bg-slate-50 p-6 transition hover:-translate-y-1 hover:shadow-lg">
                        <h2 class="text-xl font-black text-slate-900">Profil</h2>
                        <p class="mt-2 text-sm text-slate-600">Lengkapi nomor WhatsApp penjual.</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection