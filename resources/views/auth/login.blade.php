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

                <div class="auth-badge">Masuk Akun</div>

                <h1 class="auth-title">
                    Lanjutkan jual beli barang kampus dengan mudah.
                </h1>

                <p class="auth-desc">
                    Login untuk membeli produk, menambahkan barang jualan, mengelola keranjang, checkout COD, dan memantau status pesananmu.
                </p>

                <div class="auth-list">
                    <div class="auth-list-item">🛍️ Cari dan beli produk kampus</div>
                    <div class="auth-list-item">🤝 Pantau transaksi COD dengan rapi</div>
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

                <p class="auth-kicker">Selamat Datang</p>
                <h1 class="auth-heading">Login ke UniMart</h1>
                <p class="auth-subheading">
                    Masukkan email dan password untuk melanjutkan.
                </p>

                @if (session('status'))
                    <div style="margin-top:16px; padding:14px 16px; border-radius:18px; background:#ecfdf5; color:#047857; font-weight:700; border:1px solid #bbf7d0;">
                        {{ session('status') }}
                    </div>
                @endif

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
                        <label for="password" class="auth-label">Password</label>

                        <div style="position: relative;">
                            <input
                                id="password"
                                class="auth-input"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                                style="padding-right:58px;"
                            >

                            <button
                                type="button"
                                onclick="togglePassword()"
                                aria-label="Tampilkan password"
                                style="
                                    position:absolute;
                                    right:14px;
                                    top:50%;
                                    transform:translateY(-50%);
                                    width:36px;
                                    height:36px;
                                    border:0;
                                    border-radius:999px;
                                    background:transparent;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    cursor:pointer;
                                    color:#6b7280;
                                "
                            >
                                <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>

                                <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                    <path d="M3 3l18 18"/>
                                    <path d="M10.6 10.6a3 3 0 0 0 4.2 4.2"/>
                                    <path d="M9.5 5.3A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a18.5 18.5 0 0 1-3.1 4.1"/>
                                    <path d="M6.5 6.5C3.8 8.2 2 12 2 12s3.5 7 10 7a10.7 10.7 0 0 0 4.1-.8"/>
                                </svg>
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
                        <label style="display:flex; align-items:center; gap:8px; color:#4b5563; font-size:14px; font-weight:700;">
                            <input
                                type="checkbox"
                                name="remember"
                                style="border-radius:6px; border-color:#d1d5db; color:#db2777;"
                            >
                            Ingat saya
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-link" style="font-size:14px;">
                                Lupa password?
                            </a>
                        @endif
                    </div>

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

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            const isHidden = passwordInput.type === 'password';

            passwordInput.type = isHidden ? 'text' : 'password';
            eyeOpen.style.display = isHidden ? 'none' : 'block';
            eyeClosed.style.display = isHidden ? 'block' : 'none';
        }
    </script>
</x-guest-layout>