<nav class="sticky top-0 z-50 border-b border-pink-100 bg-white/95 shadow-sm backdrop-blur">
    @php
        $user = auth()->user();
        $isAdmin = (bool) ($user->is_admin ?? false);

        $dashboardRoute = $isAdmin && \Illuminate\Support\Facades\Route::has('admin.dashboard')
            ? 'admin.dashboard'
            : 'dashboard';

        $dashboardLabel = $isAdmin ? 'Admin Panel' : 'Dashboard';

        $isDashboardAktif = $isAdmin
            ? request()->routeIs('admin.*')
            : request()->routeIs('dashboard');

        $namaLengkap = trim($user->name ?? 'User');
        $namaParts = preg_split('/\s+/', $namaLengkap);
        $namaDepan = $isAdmin ? 'Admin' : ($namaParts[0] ?? 'User');

        $inisialProfil = strtoupper(substr($namaDepan ?: 'U', 0, 1));

        $fotoProfilUrl = null;

        if ($user) {
            if (! empty($user->foto_profil_url)) {
                $fotoProfilUrl = $user->foto_profil_url;
            } elseif (! empty($user->foto_profil)) {
                if (
                    str_starts_with($user->foto_profil, 'http://') ||
                    str_starts_with($user->foto_profil, 'https://')
                ) {
                    $fotoProfilUrl = $user->foto_profil;
                } else {
                    $publicStorageUrl = rtrim((string) env('SUPABASE_PUBLIC_STORAGE_URL'), '/');

                    if ($publicStorageUrl !== '') {
                        $fotoProfilUrl = $publicStorageUrl . '/' . ltrim($user->foto_profil, '/');
                    } else {
                        $fotoProfilUrl = asset('storage/' . ltrim($user->foto_profil, '/'));
                    }
                }
            }
        }

        $jumlahKeranjang = 0;
        $jumlahPesananMasuk = 0;

        if ($user) {
            if (
                \Illuminate\Support\Facades\Schema::hasTable('keranjangs') &&
                \Illuminate\Support\Facades\Schema::hasColumn('keranjangs', 'user_id')
            ) {
                $jumlahKeranjang = \App\Models\Keranjang::where('user_id', $user->id)->count();
            }

            if (
                \Illuminate\Support\Facades\Schema::hasTable('pesanans') &&
                \Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'penjual_id')
            ) {
                $queryPesananMasuk = \App\Models\Pesanan::where('penjual_id', $user->id);

                if (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'status')) {
                    $queryPesananMasuk->where('status', 'pending');
                }

                $jumlahPesananMasuk = $queryPesananMasuk->count();
            } elseif (
                \Illuminate\Support\Facades\Schema::hasTable('pesanans') &&
                \Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'seller_id')
            ) {
                $queryPesananMasuk = \App\Models\Pesanan::where('seller_id', $user->id);

                if (\Illuminate\Support\Facades\Schema::hasColumn('pesanans', 'status')) {
                    $queryPesananMasuk->where('status', 'pending');
                }

                $jumlahPesananMasuk = $queryPesananMasuk->count();
            }
        }
    @endphp

    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-[86px] items-center justify-between gap-4">
            <a href="{{ route($dashboardRoute) }}" class="flex shrink-0 items-center gap-3">
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

            <div class="hidden items-center gap-1 lg:flex">
                <a href="{{ route($dashboardRoute) }}"
                   class="inline-flex items-center justify-center rounded-2xl px-4 py-3 text-sm font-black transition
                   {{ $isDashboardAktif ? 'bg-pink-100 text-pink-700' : 'text-slate-700 hover:bg-pink-50 hover:text-pink-700' }}">
                    {{ $dashboardLabel }}
                </a>

                @if (! $isAdmin)
                    @if (\Illuminate\Support\Facades\Route::has('produk.index'))
                        <a href="{{ route('produk.index') }}"
                           class="inline-flex items-center justify-center rounded-2xl px-4 py-3 text-sm font-black transition
                           {{ request()->routeIs('produk.index') || request()->routeIs('produk.show') ? 'bg-pink-100 text-pink-700' : 'text-slate-700 hover:bg-pink-50 hover:text-pink-700' }}">
                            Produk
                        </a>
                    @endif

                    @if (\Illuminate\Support\Facades\Route::has('produk.saya'))
                        <a href="{{ route('produk.saya') }}"
                           class="inline-flex items-center justify-center rounded-2xl px-4 py-3 text-sm font-black transition
                           {{ request()->routeIs('produk.saya') || request()->routeIs('produk.create') || request()->routeIs('produk.edit') ? 'bg-pink-100 text-pink-700' : 'text-slate-700 hover:bg-pink-50 hover:text-pink-700' }}">
                            <span class="leading-tight">
                                Produk<br>Saya
                            </span>
                        </a>
                    @endif

                    @if (\Illuminate\Support\Facades\Route::has('keranjang.index'))
                        <a href="{{ route('keranjang.index') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-2xl px-4 py-3 text-sm font-black transition
                           {{ request()->routeIs('keranjang.*') ? 'bg-pink-100 text-pink-700' : 'text-slate-700 hover:bg-pink-50 hover:text-pink-700' }}">
                            <span>Keranjang</span>

                            @if ($jumlahKeranjang > 0)
                                <span class="-translate-y-1 inline-flex h-6 min-w-6 items-center justify-center rounded-full bg-pink-600 px-2 text-xs font-black leading-none text-white shadow-md">
                                    {{ $jumlahKeranjang > 99 ? '99+' : $jumlahKeranjang }}
                                </span>
                            @endif
                        </a>
                    @endif

                    @if (\Illuminate\Support\Facades\Route::has('pesanan.saya'))
                        <a href="{{ route('pesanan.saya') }}"
                           class="inline-flex items-center justify-center rounded-2xl px-4 py-3 text-sm font-black transition
                           {{ request()->routeIs('pesanan.saya') ? 'bg-pink-100 text-pink-700' : 'text-slate-700 hover:bg-pink-50 hover:text-pink-700' }}">
                            <span class="leading-tight">
                                Pesanan<br>Saya
                            </span>
                        </a>
                    @endif

                    @if (\Illuminate\Support\Facades\Route::has('pesanan.masuk'))
                        <a href="{{ route('pesanan.masuk') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-2xl px-4 py-3 text-sm font-black transition
                           {{ request()->routeIs('pesanan.masuk') ? 'bg-pink-100 text-pink-700' : 'text-slate-700 hover:bg-pink-50 hover:text-pink-700' }}">
                            <span class="leading-tight">
                                Pesanan<br>Masuk
                            </span>

                            @if ($jumlahPesananMasuk > 0)
                                <span class="-translate-y-1 inline-flex h-6 min-w-6 items-center justify-center rounded-full bg-red-500 px-2 text-xs font-black leading-none text-white shadow-md">
                                    {{ $jumlahPesananMasuk > 99 ? '99+' : $jumlahPesananMasuk }}
                                </span>
                            @endif
                        </a>
                    @endif

                    @if (\Illuminate\Support\Facades\Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}"
                           class="inline-flex items-center justify-center rounded-2xl px-4 py-3 text-sm font-black transition
                           {{ request()->routeIs('profile.edit') ? 'bg-pink-100 text-pink-700' : 'text-slate-700 hover:bg-pink-50 hover:text-pink-700' }}">
                            Profil
                        </a>
                    @endif
                @endif
            </div>

            <div class="flex shrink-0 items-center gap-3">
                @if ($fotoProfilUrl)
                    <img
                        src="{{ $fotoProfilUrl }}"
                        alt="{{ $namaLengkap }}"
                        class="h-11 w-11 rounded-full border-2 border-pink-100 object-cover shadow-sm"
                    >
                @else
                    <div class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-pink-100 bg-pink-100 text-sm font-black text-pink-700 shadow-sm">
                        {{ $inisialProfil }}
                    </div>
                @endif

                <div class="hidden text-right sm:block">
                    <p class="whitespace-nowrap text-sm font-black leading-snug text-slate-900">
                        Halo, {{ $namaDepan }}
                    </p>

                    @if (! $isAdmin && \Illuminate\Support\Facades\Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}"
                           class="text-xs font-bold text-slate-500 hover:text-pink-700">
                            Lihat Profil
                        </a>
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
            <a href="{{ route($dashboardRoute) }}"
               class="rounded-2xl px-4 py-2 text-sm font-black
               {{ $isDashboardAktif ? 'bg-pink-100 text-pink-700' : 'bg-white text-slate-700 ring-1 ring-pink-100' }}">
                {{ $dashboardLabel }}
            </a>

            @if (! $isAdmin)
                @if (\Illuminate\Support\Facades\Route::has('produk.index'))
                    <a href="{{ route('produk.index') }}"
                       class="rounded-2xl bg-white px-4 py-2 text-sm font-black text-slate-700 ring-1 ring-pink-100">
                        Produk
                    </a>
                @endif

                @if (\Illuminate\Support\Facades\Route::has('produk.saya'))
                    <a href="{{ route('produk.saya') }}"
                       class="rounded-2xl bg-white px-4 py-2 text-sm font-black text-slate-700 ring-1 ring-pink-100">
                        Produk Saya
                    </a>
                @endif

                @if (\Illuminate\Support\Facades\Route::has('keranjang.index'))
                    <a href="{{ route('keranjang.index') }}"
                       class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2 text-sm font-black text-slate-700 ring-1 ring-pink-100">
                        Keranjang

                        @if ($jumlahKeranjang > 0)
                            <span class="-translate-y-0.5 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-pink-600 px-2 text-xs font-black text-white">
                                {{ $jumlahKeranjang > 99 ? '99+' : $jumlahKeranjang }}
                            </span>
                        @endif
                    </a>
                @endif

                @if (\Illuminate\Support\Facades\Route::has('pesanan.saya'))
                    <a href="{{ route('pesanan.saya') }}"
                       class="rounded-2xl bg-white px-4 py-2 text-sm font-black text-slate-700 ring-1 ring-pink-100">
                        Pesanan Saya
                    </a>
                @endif

                @if (\Illuminate\Support\Facades\Route::has('pesanan.masuk'))
                    <a href="{{ route('pesanan.masuk') }}"
                       class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2 text-sm font-black text-slate-700 ring-1 ring-pink-100">
                        Pesanan Masuk

                        @if ($jumlahPesananMasuk > 0)
                            <span class="-translate-y-0.5 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-red-500 px-2 text-xs font-black text-white">
                                {{ $jumlahPesananMasuk > 99 ? '99+' : $jumlahPesananMasuk }}
                            </span>
                        @endif
                    </a>
                @endif

                @if (\Illuminate\Support\Facades\Route::has('profile.edit'))
                    <a href="{{ route('profile.edit') }}"
                       class="rounded-2xl bg-white px-4 py-2 text-sm font-black text-slate-700 ring-1 ring-pink-100">
                        Profil
                    </a>
                @endif
            @endif
        </div>
    </div>
</nav>