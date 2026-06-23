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
                        <h2 style="margin:0; font-size:20px; font-weight:900; color:#111827;">
                            UniMart
                        </h2>
                        <p style="margin:4px 0 0; color:#6b7280; font-size:12px; font-weight:600;">
                            Campus Marketplace
                        </p>
                    </div>
                </div>

                <p class="auth-kicker">Login Akun</p>

                <h1 class="auth-heading">Masuk ke UniMart</h1>

                <p class="auth-subheading">
                    Masuk untuk mulai mengelola produkmu.
                </p>

                @if (session('status'))
                    <div style="margin-bottom:16px; padding:12px 14px; border-radius:14px; background:#ecfdf5; color:#047857; font-size:13px; font-weight:700; border:1px solid #a7f3d0;">
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
                        <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:6px;">
                            <label for="password" class="auth-label" style="margin-bottom:0;">
                                Password
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="auth-link" style="font-size:13px; font-weight:800;">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <div style="position:relative;">
                            <input
                                id="password"
                                class="auth-input"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                                style="padding-right:48px;"
                            >

                            <button
                                type="button"
                                id="togglePassword"
                                aria-label="Lihat password"
                                title="Lihat password"
                                style="
                                    position:absolute;
                                    right:14px;
                                    top:50%;
                                    transform:translateY(-50%);
                                    width:28px;
                                    height:28px;
                                    border:0;
                                    background:transparent;
                                    color:#475569;
                                    cursor:pointer;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    padding:0;
                                "
                            >
                                <svg
                                    id="eyeIcon"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    style="width:21px; height:21px;"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 15.25A3.25 3.25 0 1 0 12 8.75a3.25 3.25 0 0 0 0 6.5z"
                                    />
                                </svg>

                                <svg
                                    id="eyeOffIcon"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    style="width:21px; height:21px; display:none;"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 3l18 18"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M10.58 10.58A2 2 0 0 0 12 14a2 2 0 0 0 1.42-.58"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9.88 5.32A9.88 9.88 0 0 1 12 5.09C18 5.09 21.75 12 21.75 12a18.34 18.34 0 0 1-3.21 4.16"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6.61 6.61C3.84 8.46 2.25 12 2.25 12S6 18.91 12 18.91a9.8 9.8 0 0 0 4.03-.85"
                                    />
                                </svg>
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                        <label
                            for="remember_me"
                            style="display:flex; align-items:center; gap:8px; color:#4b5563; font-size:14px; font-weight:700; cursor:pointer;"
                        >
                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                style="width:16px; height:16px; accent-color:#db2777;"
                            >

                            <span>Ingat saya</span>
                        </label>
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
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeOffIcon = document.getElementById('eyeOffIcon');

        togglePassword.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';

            passwordInput.type = isHidden ? 'text' : 'password';
            eyeIcon.style.display = isHidden ? 'none' : 'block';
            eyeOffIcon.style.display = isHidden ? 'block' : 'none';

            togglePassword.setAttribute(
                'aria-label',
                isHidden ? 'Sembunyikan password' : 'Lihat password'
            );

            togglePassword.setAttribute(
                'title',
                isHidden ? 'Sembunyikan password' : 'Lihat password'
            );
        });
    </script>
</x-guest-layout>