<nav class="border-b border-pink-100 bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @auth
            @php
                $isAdmin = (bool) auth()->user()->is_admin;
                $displayName = explode(' ', trim(auth()->user()->name))[0] ?? auth()->user()->name;

                $keranjangCount = 0;
                $pesananSayaCount = 0;
                $pesananMasukCount = 0;

                if (! $isAdmin) {
                    $keranjangCount = \App\Models\Keranjang::where('user_id', auth()->id())->count();

                    $pesananSayaCount = \App\Models\Pesanan::where('buyer_id', auth()->id())
                        ->whereIn('status', ['pending', 'accepted'])
                        ->count();

                    $pesananMasukCount = \App\Models\Pesanan::where('seller_id', auth()->id())
                        ->where('status', 'pending')
                        ->count();
                }

                $linkClass = function ($active = false) {
                    return $active
                        ? 'relative rounded-2xl bg-pink-100 px-4 py-3 text-sm font-extrabold text-pink-700'
                        : 'relative rounded-2xl px-4 py-3 text-sm font-extrabold text-slate-600 hover:bg-pink-50 hover:text-pink-700';
                };

                $mobileLinkClass = 'relative shrink-0 rounded-xl bg-pink-50 px-4 py-2 text-sm font-bold text-slate-700';
            @endphp
        @endauth

        <div class="flex min-h-20 items-center justify-between gap-4">
            <a href="{{ url('/') }}" class="flex shrink-0 items-center gap-3">
                <div class="flex h-14 w-14 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-pink-700 to-slate-900 shadow-lg shadow-pink-200">
                    <x-application-logo class="h-10 w-10" />
                </div>

                <div class="hidden sm:block">
                    <div class="text-2xl font-extrabold text-slate-900">UniMart</div>
                    <div class="text-sm font-semibold text-slate-500">Campus Marketplace</div>
                </div>
            </a>

            @auth
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

                            @if ($keranjangCount > 0)
                                <span class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-slate-900 px-1 text-[11px] font-extrabold text-white">
                                    {{ $keranjangCount }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('pesanan.saya') }}" class="{{ $linkClass(request()->routeIs('pesanan.saya') || request()->routeIs('pesanan.saya.show')) }}">
                            Pesanan Saya

                            @if ($pesananSayaCount > 0)
                                <span class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-blue-600 px-1 text-[11px] font-extrabold text-white">
                                    {{ $pesananSayaCount }}
                                </span>
                            @endif
                        </a>

                        <a href="{{ route('pesanan.masuk') }}" class="{{ $linkClass(request()->routeIs('pesanan.masuk') || request()->routeIs('pesanan.masuk.show')) }}">
                            Pesanan Masuk

                            @if ($pesananMasukCount > 0)
                                <span class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-red-600 px-1 text-[11px] font-extrabold text-white">
                                    {{ $pesananMasukCount }}
                                </span>
                            @endif
                        </a>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="{{ $linkClass(request()->routeIs('profile.edit')) }}">
                        Profil
                    </a>
                </div>

                <div class="flex shrink-0 items-center gap-3">
                    <div class="hidden text-right xl:block">
                        <div class="text-sm font-black text-slate-900">Halo, {{ $displayName }}</div>
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
                    <a href="{{ route('dashboard') }}" class="{{ $mobileLinkClass }}">Dashboard</a>
                    <a href="{{ route('produk.index') }}" class="{{ $mobileLinkClass }}">Produk</a>
                    <a href="{{ route('produk.saya') }}" class="{{ $mobileLinkClass }}">Produk Saya</a>

                    <a href="{{ route('keranjang.index') }}" class="{{ $mobileLinkClass }}">
                        Keranjang

                        @if ($keranjangCount > 0)
                            <span class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-slate-900 px-1 text-[11px] font-extrabold text-white">
                                {{ $keranjangCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('pesanan.saya') }}" class="{{ $mobileLinkClass }}">
                        Pesanan Saya

                        @if ($pesananSayaCount > 0)
                            <span class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-blue-600 px-1 text-[11px] font-extrabold text-white">
                                {{ $pesananSayaCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('pesanan.masuk') }}" class="{{ $mobileLinkClass }}">
                        Pesanan Masuk

                        @if ($pesananMasukCount > 0)
                            <span class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-red-600 px-1 text-[11px] font-extrabold text-white">
                                {{ $pesananMasukCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('profile.edit') }}" class="{{ $mobileLinkClass }}">Profil</a>
                </div>
            @endif
        @endauth
    </div>
</nav>