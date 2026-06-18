<nav class="unimart-navbar">
    <div class="unimart-nav-container">
        <div class="unimart-brand-area">
            <a href="{{ route('home') }}" class="unimart-brand">
                <x-application-logo />

                <div>
                    <div class="unimart-brand-title">UniMart</div>
                    <div class="unimart-brand-subtitle">Campus Marketplace</div>
                </div>
            </a>
        </div>

        <div class="unimart-menu">
            <a
                href="{{ route('home') }}"
                class="unimart-link {{ request()->routeIs('home') ? 'active' : '' }}"
            >
                Home
            </a>

            @auth
                @if(auth()->user()->is_admin)
                    <a
                        href="{{ route('admin.index') }}"
                        class="unimart-link {{ request()->routeIs('admin.index') ? 'active' : '' }}"
                    >
                        Dashboard Admin
                    </a>

                    <a
                        href="{{ route('produk.index') }}"
                        class="unimart-link {{ request()->routeIs('produk.index') || request()->routeIs('produk.show') ? 'active' : '' }}"
                    >
                        Produk
                    </a>

                    <a
                        href="{{ route('profile.edit') }}"
                        class="unimart-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                    >
                        Profil
                    </a>
                @else
                    <a
                        href="{{ route('dashboard') }}"
                        class="unimart-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ route('produk.index') }}"
                        class="unimart-link {{ request()->routeIs('produk.index') || request()->routeIs('produk.show') ? 'active' : '' }}"
                    >
                        Produk
                    </a>

                    <a
                        href="{{ route('produk.create') }}"
                        class="unimart-link {{ request()->routeIs('produk.create') ? 'active' : '' }}"
                    >
                        Jual Barang
                    </a>

                    <a
                        href="{{ route('produk.saya') }}"
                        class="unimart-link {{ request()->routeIs('produk.saya') || request()->routeIs('produk.edit') ? 'active' : '' }}"
                    >
                        Produk Saya
                    </a>

                    <a
                        href="{{ route('keranjang.index') }}"
                        class="unimart-link {{ request()->routeIs('keranjang.index') ? 'active' : '' }}"
                    >
                        Keranjang
                    </a>

                    <a
                        href="{{ route('profile.edit') }}"
                        class="unimart-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                    >
                        Profil
                    </a>
                @endif

                <span class="unimart-user-name">
                    Halo, {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="unimart-logout">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="unimart-link">
                    Login
                </a>

                <a href="{{ route('register') }}" class="unimart-register">
                    Daftar
                </a>
            @endauth
        </div>
    </div>

    <style>
        .unimart-navbar {
            background: rgba(255, 255, 255, 0.94);
            border-bottom: 1px solid #f1dbe7;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(14px);
        }

        .unimart-nav-container {
            width: 100%;
            min-height: 98px;
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .unimart-brand-area {
            flex-shrink: 0;
        }

        .unimart-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: inherit;
        }

        .unimart-brand svg,
        .unimart-brand img {
            width: 66px;
            height: 66px;
        }

        .unimart-brand-title {
            font-size: 28px;
            line-height: 1;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.8px;
        }

        .unimart-brand-subtitle {
            margin-top: 8px;
            font-size: 15px;
            font-weight: 700;
            color: #64748b;
        }

        .unimart-menu {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 22px;
            flex-wrap: wrap;
        }

        .unimart-link {
            color: #475569;
            font-size: 16px;
            font-weight: 900;
            text-decoration: none;
            transition: 0.2s ease;
            white-space: nowrap;
        }

        .unimart-link:hover,
        .unimart-link.active {
            color: #db2777;
        }

        .unimart-user-name {
            color: #64748b;
            font-size: 16px;
            font-weight: 800;
            white-space: nowrap;
        }

        .unimart-logout {
            border: 0;
            border-radius: 18px;
            padding: 18px 28px;
            background: #0f172a;
            color: white;
            font-size: 16px;
            font-weight: 900;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .unimart-logout:hover {
            background: #db2777;
            transform: translateY(-1px);
        }

        .unimart-register {
            border-radius: 18px;
            padding: 16px 24px;
            background: linear-gradient(135deg, #111827, #db2777);
            color: white;
            font-size: 16px;
            font-weight: 900;
            text-decoration: none;
            white-space: nowrap;
        }

        @media (max-width: 1100px) {
            .unimart-nav-container {
                align-items: flex-start;
                flex-direction: column;
            }

            .unimart-menu {
                justify-content: flex-start;
                gap: 16px;
            }
        }

        @media (max-width: 640px) {
            .unimart-nav-container {
                padding: 14px 18px;
            }

            .unimart-brand svg,
            .unimart-brand img {
                width: 54px;
                height: 54px;
            }

            .unimart-brand-title {
                font-size: 24px;
            }

            .unimart-brand-subtitle {
                font-size: 13px;
            }

            .unimart-link,
            .unimart-user-name {
                font-size: 14px;
            }

            .unimart-logout,
            .unimart-register {
                padding: 14px 20px;
                font-size: 14px;
            }
        }
    </style>
</nav>