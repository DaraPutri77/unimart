<x-guest-layout>
    <div class="auth-card">
        <section class="auth-left">
            <div class="auth-left-content">
                <div class="auth-brand">
                    <x-application-logo />
                    <div class="auth-brand-text">
                        <h2>UniMart</h2>
                        <p>Campus Marketplace</p>
                    </div>
                </div>

                <div class="auth-badge">Login Akun</div>

                <h1 class="auth-title">
                    Marketplace kampus untuk semua barangmu.
                </h1>

                <p class="auth-desc">
                    Masuk untuk mengelola produk, menemukan pembeli, dan melakukan transaksi COD di lingkungan kampus.
                </p>

                <div class="auth-list">
                    <div class="auth-list-item">✦ Kelola produk jualanmu</div>
                    <div class="auth-list-item">💬 Hubungi pembeli dengan mudah</div>
                </div>
            </div>
        </section>

        <section class="auth-right">
            <div class="auth-form-wrap">
                <div class="auth-mobile-brand">
                    <x-application-logo />
                    <div>
                        <h2 style="margin:0; font-size:20px; font-weight:900; color:#111827;">UniMart</h2>
                        <p style="margin:4px 0 0; color:#6b7280; font-size:12px; font-weight:600;">Campus Marketplace</p>
                    </div>
                </div>

                <p class="auth-kicker">Login Akun</p>
                <h1 class="auth-heading">Masuk ke UniMart</h1>
                <p class="auth-subheading">
                    Masuk untuk mulai mengelola produkmu.
                </p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf

                    <div>
                        <label for="email" class="auth-label">Email</label>
                        <input
                            id="email"
                            class="auth-input"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="nama@email.com"
                        >
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <div class="auth-row" style="margin-bottom: 7px;">
                            <label for="password" class="auth-label" style="margin-bottom:0;">Password</label>

                            @if (Route::has('password.request'))
                                <a class="auth-link" href="{{ route('password.request') }}">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <input
                            id="password"
                            class="auth-input"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                        >
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <label for="remember_me" class="auth-check">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Ingat saya</span>
                    </label>

                    <button type="submit" class="auth-button">
                        Login
                    </button>
                </form>

                <p class="auth-footer">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
                </p>
            </div>
        </section>
    </div>
</x-guest-layout>