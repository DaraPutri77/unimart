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

                <div class="auth-badge">Akun Baru</div>

                <h1 class="auth-title">
                    Mulai jual produkmu di lingkungan kampus.
                </h1>

                <p class="auth-desc">
                    Daftar untuk menjual barang baru maupun barang layak pakai, menjangkau pembeli, dan mengelola produkmu dengan mudah.
                </p>

                <div class="auth-list">
                    <div class="auth-list-item">🎓 Daftar sebagai pengguna UniMart</div>
                    <div class="auth-list-item">📦 Tambahkan produk jualanmu</div>
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

                <p class="auth-kicker">Buat Akun</p>
                <h1 class="auth-heading">Daftar ke UniMart</h1>
                <p class="auth-subheading">
                    Isi data di bawah ini untuk membuat akun baru.
                </p>

                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf

                    <div>
                        <label for="name" class="auth-label">Nama Lengkap</label>
                        <input
                            id="name"
                            class="auth-input"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Nama lengkap"
                        >
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="email" class="auth-label">Email</label>
                        <input
                            id="email"
                            class="auth-input"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            placeholder="nama@email.com"
                        >
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="auth-two-cols">
                        <div>
                            <label for="password" class="auth-label">Password</label>
                            <input
                                id="password"
                                class="auth-input"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Minimal 8 karakter"
                            >
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <label for="password_confirmation" class="auth-label">Konfirmasi</label>
                            <input
                                id="password_confirmation"
                                class="auth-input"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Ulangi password"
                            >
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <button type="submit" class="auth-button">
                        Daftar
                    </button>
                </form>

                <p class="auth-footer">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="auth-link">Login sekarang</a>
                </p>
            </div>
        </section>
    </div>
</x-guest-layout>