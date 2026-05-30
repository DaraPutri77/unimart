@extends('layouts.app')

@section('content')
    <section class="bg-gradient-to-br from-rose-50 via-white to-pink-50 py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-[30px] bg-white p-8 shadow-xl shadow-rose-100">
                <p class="text-sm font-black uppercase tracking-[0.3em] text-pink-500">
                    Jual Barang
                </p>

                <h1 class="mt-2 text-3xl font-black text-slate-900">
                    Tambah Produk
                </h1>

                <form method="POST" action="{{ route('produk.store') }}" class="mt-8 space-y-5">
                    @csrf

                    @include('produk.partials.form', ['produk' => null, 'kategoriList' => $kategoriList])

                    <div class="flex gap-3">
                        <a href="{{ route('produk.index') }}" class="rounded-2xl bg-slate-100 px-5 py-3 font-bold text-slate-700">
                            Batal
                        </a>

                        <button class="rounded-2xl bg-gradient-to-r from-slate-900 to-pink-500 px-5 py-3 font-bold text-white">
                            Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection