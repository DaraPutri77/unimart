<nav class="sticky top-0 z-50 border-b border-rose-100 bg-white/90 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-[82px] items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-slate-900 to-pink-500 text-xl font-black text-white shadow-lg shadow-pink-200">
                    U
                </div>

                <div>
                    <p class="text-xl font-black leading-none text-slate-900">UniMart</p>
                    <p class="mt-1 text-xs font-semibold text-slate-500">Campus Marketplace</p>
                </div>
            </a>

            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-sm font-bold text-slate-600 transition hover:text-pink-600">
                    Home
                </a>

                @auth
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-slate-600 transition hover:text-pink-600">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-600 transition hover:text-pink-600">
                            Dashboard
                        </a>
                    @endif
                @endauth

                <a href="{{ route('produk.index') }}" class="text-sm font-bold text-slate-600 transition hover:text-pink-600">
                    Produk
                </a>

                @auth
                    @if (! auth()->user()->is_admin)
                        <a href="{{ route('produk.create') }}" class="text-sm font-bold text-slate-600 transition hover:text-pink-600">
                            Jual Barang
                        </a>

                        <a href="{{ route('keranjang.index') }}" class="text-sm font-bold text-slate-600 transition hover:text-pink-600">
                            Keranjang
                        </a>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="text-sm font-bold text-slate-600 transition hover:text-pink-600">
                        Profil
                    </a>

                    <span class="hidden text-sm font-semibold text-slate-500 md:inline">
                        Halo, {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-pink-600">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 transition hover:text-pink-600">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="rounded-2xl bg-gradient-to-r from-slate-900 to-pink-500 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-pink-100 transition hover:opacity-90">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>