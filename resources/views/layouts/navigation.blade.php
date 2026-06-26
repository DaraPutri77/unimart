<nav class="sticky top-0 z-50 border-b border-pink-100 bg-white/95 shadow-sm backdrop-blur">
    @php
        $user = auth()->user();
        $isAdmin = (bool) ($user->is_admin ?? false);
    @endphp

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-[86px] items-center justify-between gap-6">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-4">
                <x-application-logo />

                <div>
                    <h1 class="text-2xl font-black leading-none tracking-tight text-slate-900">
                        UniMart
                    </h1>
                    <p class="mt-1 text-sm font-bold text-slate-500">
                        Campus Marketplace
                    </p>
                </div>
            </a>

            <div class="hidden items-center gap-2 lg:flex">
                <a href="{{ route('dashboard') }}"
                   class="rounded-2xl px-5 py-3 text-sm font-black transition
                   {{ request()->routeIs('dashboard') ? 'bg-pink-100 text-pink-700' : 'text-slate-700 hover:bg-pink-50 hover:text-pink-700' }}">
                    Dashboard
                </a>

                @if (! $isAdmin)
                    @if (\Illuminate\Support\Facades\Route::has('produk.index'))
                        <a href="{{ route('produk.index') }}"
                           class="rounded-2xl px-5 py-3 text-sm font-black transition
                           {{ request()->routeIs('produk.index') || request()->routeIs('produk.show') ? 'bg-pink-100 text-pink-700' : 'text-slate-700 hover:bg-pink-50 hover:text-pink-700' }}">
                            Produk
                        </a>
                    @endif

                    @if (\Illuminate\Support\Facades\Route::has('produk.saya'))
                        <a href="{{ route('produk.saya') }}"
                           class="rounded-2xl px-5 py-3 text-sm font-black transition
                           {{ request()->routeIs('produk.saya') || request()->routeIs('produk.create') || request()->routeIs('produk.edit') ? 'bg-pink-100 text-pink-700' : 'text-slate-700 hover:bg-pink-50 hover:text-pink-700' }}">
                            Produk Saya
                        </a>
                    @endif

                    @if (\Illuminate\Support\Facades\Route::has('keranjang.index'))
                        <a href="{{ route('keranjang.index') }}"
                           class="rounded-2xl px-5 py-3 text-sm font-black transition
                           {{ request()->routeIs('keranjang.*') ? 'bg-pink-100 text-pink-700' : 'text-slate-700 hover:bg-pink-50 hover:text-pink-700' }}">
                            Keranjang
                        </a>
                    @endif

                    @if (\Illuminate\Support\Facades\Route::has('pesanan.saya'))
                        <a href="{{ route('pesanan.saya') }}"
                           class="rounded-2xl px-5 py-3 text-sm font-black transition
                           {{ request()->routeIs('pesanan.saya') ? 'bg-pink-100 text-pink-700' : 'text-slate-700 hover:bg-pink-50 hover:text-pink-700' }}">
                            Pesanan Saya
                        </a>
                    @endif

                    @if (\Illuminate\Support\Facades\Route::has('pesanan.masuk'))
                        <a href="{{ route('pesanan.masuk') }}"
                           class="rounded-2xl px-5 py-3 text-sm font-black transition
                           {{ request()->routeIs('pesanan.masuk') ? 'bg-pink-100 text-pink-700' : 'text-slate-700 hover:bg-pink-50 hover:text-pink-700' }}">
                            Pesanan Masuk
                        </a>
                    @endif

                    @if (\Illuminate\Support\Facades\Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}"
                           class="rounded-2xl px-5 py-3 text-sm font-black transition
                           {{ request()->routeIs('profile.edit') ? 'bg-pink-100 text-pink-700' : 'text-slate-700 hover:bg-pink-50 hover:text-pink-700' }}">
                            Profil
                        </a>
                    @endif
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden text-right sm:block">
                    <p class="text-sm font-black text-slate-900">
                        Halo, {{ $isAdmin ? 'Admin' : $user->name }}
                    </p>

                    @if ($isAdmin)
                        <p class="text-xs font-bold text-pink-600">
                            Pemantau Statistik
                        </p>
                    @endif
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-black text-white shadow-sm transition hover:bg-pink-700">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="flex flex-wrap gap-2 pb-4 lg:hidden">
            <a href="{{ route('dashboard') }}"
               class="rounded-2xl px-4 py-2 text-sm font-black
               {{ request()->routeIs('dashboard') ? 'bg-pink-100 text-pink-700' : 'bg-white text-slate-700 ring-1 ring-pink-100' }}">
                Dashboard
            </a>

            @if (! $isAdmin)
                @if (\Illuminate\Support\Facades\Route::has('produk.index'))
                    <a href="{{ route('produk.index') }}" class="rounded-2xl bg-white px-4 py-2 text-sm font-black text-slate-700 ring-1 ring-pink-100">
                        Produk
                    </a>
                @endif

                @if (\Illuminate\Support\Facades\Route::has('produk.saya'))
                    <a href="{{ route('produk.saya') }}" class="rounded-2xl bg-white px-4 py-2 text-sm font-black text-slate-700 ring-1 ring-pink-100">
                        Produk Saya
                    </a>
                @endif

                @if (\Illuminate\Support\Facades\Route::has('keranjang.index'))
                    <a href="{{ route('keranjang.index') }}" class="rounded-2xl bg-white px-4 py-2 text-sm font-black text-slate-700 ring-1 ring-pink-100">
                        Keranjang
                    </a>
                @endif

                @if (\Illuminate\Support\Facades\Route::has('pesanan.saya'))
                    <a href="{{ route('pesanan.saya') }}" class="rounded-2xl bg-white px-4 py-2 text-sm font-black text-slate-700 ring-1 ring-pink-100">
                        Pesanan Saya
                    </a>
                @endif

                @if (\Illuminate\Support\Facades\Route::has('pesanan.masuk'))
                    <a href="{{ route('pesanan.masuk') }}" class="rounded-2xl bg-white px-4 py-2 text-sm font-black text-slate-700 ring-1 ring-pink-100">
                        Pesanan Masuk
                    </a>
                @endif
            @endif
        </div>
    </div>
</nav>