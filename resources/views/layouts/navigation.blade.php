<nav class="border-b border-pink-100 bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-20 items-center justify-between gap-6">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-pink-700 to-slate-900 text-2xl font-extrabold text-white shadow-lg shadow-pink-200">
                    U
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-slate-900">UniMart</div>
                    <div class="text-sm font-semibold text-slate-500">Campus Marketplace</div>
                </div>
            </a>

            @auth
                @php
                    $isAdmin = (bool) auth()->user()->is_admin;

                    $linkClass = function ($active = false) {
                        return $active
                            ? 'rounded-2xl bg-pink-100 px-4 py-3 text-sm font-extrabold text-pink-700'
                            : 'rounded-2xl px-4 py-3 text-sm font-extrabold text-slate-600 hover:bg-pink-50 hover:text-pink-700';
                    };
                @endphp

                <div class="hidden items-center gap-1 lg:flex">
                    <a href="{{ route('dashboard') }}" class="{{ $linkClass(request()->routeIs('dashboard')) }}">
                        Dashboard
                    </a>

                    @if ($isAdmin)
                        @if (Route::has('admin.dashboard'))
                            <a href="{{ route('admin.dashboard') }}" class="{{ $linkClass(request()->routeIs('admin.*')) }}">
                                Admin
                            </a>
                        @endif

                        <a href="{{ route('produk.index') }}" class="{{ $linkClass(request()->routeIs('produk.index') || request()->routeIs('produk.show')) }}">
                            Produk
                        </a>
                    @else
                        <a href="{{ route('produk.index') }}" class="{{ $linkClass(request()->routeIs('produk.index') || request()->routeIs('produk.show')) }}">
                            Produk
                        </a>

                        <a href="{{ route('produk.saya') }}" class="{{ $linkClass(request()->routeIs('produk.saya') || request()->routeIs('produk.create') || request()->routeIs('produk.edit')) }}">
                            Produk Saya
                        </a>

                        <a href="{{ route('keranjang.index') }}" class="{{ $linkClass(request()->routeIs('keranjang.*')) }}">
                            Keranjang
                        </a>

                        <a href="{{ route('pesanan.saya') }}" class="{{ $linkClass(request()->routeIs('pesanan.saya') || request()->routeIs('pesanan.saya.show')) }}">
                            Pesanan Saya
                        </a>

                        <a href="{{ route('pesanan.masuk') }}" class="{{ $linkClass(request()->routeIs('pesanan.masuk') || request()->routeIs('pesanan.masuk.show')) }}">
                            Pesanan Masuk
                        </a>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="{{ $linkClass(request()->routeIs('profile.edit')) }}">
                        Profil
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden text-right xl:block">
                        <div class="text-sm font-bold text-slate-900">Halo, {{ auth()->user()->name }}</div>
                        <div class="text-xs font-semibold text-slate-500">{{ auth()->user()->email }}</div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-extrabold text-white hover:bg-pink-700">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}"
                       class="rounded-2xl px-5 py-3 text-sm font-extrabold text-slate-700 hover:bg-pink-50 hover:text-pink-700">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="rounded-2xl bg-pink-700 px-5 py-3 text-sm font-extrabold text-white hover:bg-slate-900">
                        Register
                    </a>
                </div>
            @endauth
        </div>

        @auth
            @if (! auth()->user()->is_admin)
                <div class="flex gap-2 overflow-x-auto pb-4 lg:hidden">
                    <a href="{{ route('dashboard') }}" class="shrink-0 rounded-xl bg-pink-50 px-4 py-2 text-sm font-bold text-slate-700">Dashboard</a>
                    <a href="{{ route('produk.index') }}" class="shrink-0 rounded-xl bg-pink-50 px-4 py-2 text-sm font-bold text-slate-700">Produk</a>
                    <a href="{{ route('produk.saya') }}" class="shrink-0 rounded-xl bg-pink-50 px-4 py-2 text-sm font-bold text-slate-700">Produk Saya</a>
                    <a href="{{ route('keranjang.index') }}" class="shrink-0 rounded-xl bg-pink-50 px-4 py-2 text-sm font-bold text-slate-700">Keranjang</a>
                    <a href="{{ route('pesanan.saya') }}" class="shrink-0 rounded-xl bg-pink-50 px-4 py-2 text-sm font-bold text-slate-700">Pesanan Saya</a>
                    <a href="{{ route('pesanan.masuk') }}" class="shrink-0 rounded-xl bg-pink-50 px-4 py-2 text-sm font-bold text-slate-700">Pesanan Masuk</a>
                </div>
            @endif
        @endauth
    </div>
</nav>