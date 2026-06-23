<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UniMart - Campus Marketplace</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(236, 72, 153, 0.24), transparent 34%),
                radial-gradient(circle at bottom right, rgba(219, 39, 119, 0.18), transparent 34%),
                #050510;
            color: #ffffff;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: min(1180px, 92%);
            margin: 0 auto;
        }

        .navbar {
            padding: 28px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-logo {
            width: 54px;
            height: 54px;
            border-radius: 18px;
            background: linear-gradient(135deg, #111827, #db2777);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
            font-weight: 900;
            box-shadow: 0 16px 45px rgba(219, 39, 119, 0.35);
        }

        .brand-title {
            font-size: 28px;
            font-weight: 900;
            line-height: 1;
        }

        .brand-subtitle {
            margin-top: 5px;
            color: #d1d5db;
            font-size: 14px;
            font-weight: 600;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
            padding: 0 20px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 900;
            border: 1px solid rgba(255, 255, 255, 0.14);
            transition: 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #111827, #db2777);
            color: white;
            box-shadow: 0 16px 38px rgba(219, 39, 119, 0.28);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 48px rgba(219, 39, 119, 0.38);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            backdrop-filter: blur(14px);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.13);
        }

        .hero {
            padding: 72px 0 70px;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 46px;
            align-items: center;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 10px 18px;
            border-radius: 999px;
            background: rgba(236, 72, 153, 0.14);
            color: #f9a8d4;
            border: 1px solid rgba(236, 72, 153, 0.30);
            font-size: 14px;
            font-weight: 900;
            letter-spacing: 1px;
            margin-bottom: 22px;
        }

        .hero h1 {
            max-width: 720px;
            font-size: clamp(42px, 6.8vw, 78px);
            line-height: 1.03;
            letter-spacing: -2px;
            margin-bottom: 24px;
            font-weight: 900;
        }

        .hero h1 span {
            background: linear-gradient(135deg, #f9a8d4, #ec4899, #db2777);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            max-width: 660px;
            color: #d1d5db;
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .hero-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .hero-panel {
            padding: 28px;
            border-radius: 34px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 28px 90px rgba(0, 0, 0, 0.46);
            backdrop-filter: blur(18px);
        }

        .panel-title {
            font-size: 26px;
            font-weight: 900;
            margin-bottom: 8px;
        }

        .panel-desc {
            color: #d1d5db;
            line-height: 1.7;
            font-size: 15px;
            margin-bottom: 22px;
        }

        .flow-list {
            display: grid;
            gap: 14px;
        }

        .flow-item {
            display: flex;
            gap: 14px;
            padding: 16px;
            border-radius: 22px;
            background: rgba(0, 0, 0, 0.26);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .flow-number {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: #db2777;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-weight: 900;
        }

        .flow-item h3 {
            font-size: 16px;
            font-weight: 900;
            margin-bottom: 5px;
        }

        .flow-item p {
            color: #d1d5db;
            font-size: 13px;
            line-height: 1.6;
            margin: 0;
        }

        .section {
            padding: 30px 0 78px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 34px;
        }

        .section-title h2 {
            font-size: clamp(30px, 4vw, 46px);
            margin-bottom: 12px;
            font-weight: 900;
        }

        .section-title p {
            max-width: 760px;
            margin: 0 auto;
            color: #d1d5db;
            line-height: 1.8;
            font-size: 16px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .feature {
            padding: 24px;
            border-radius: 26px;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.10);
            min-height: 190px;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: rgba(236, 72, 153, 0.16);
            color: #f9a8d4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 16px;
        }

        .feature h3 {
            font-size: 19px;
            margin-bottom: 10px;
            font-weight: 900;
        }

        .feature p {
            color: #d1d5db;
            font-size: 15px;
            line-height: 1.7;
        }

        .cta {
            padding: 0 0 86px;
        }

        .cta-box {
            padding: 36px;
            border-radius: 34px;
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.20), rgba(255, 255, 255, 0.07));
            border: 1px solid rgba(236, 72, 153, 0.22);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
        }

        .cta-box h2 {
            font-size: 34px;
            font-weight: 900;
            margin-bottom: 10px;
        }

        .cta-box p {
            color: #d1d5db;
            line-height: 1.7;
            max-width: 680px;
        }

        .footer {
            padding: 28px 0;
            text-align: center;
            color: #9ca3af;
            border-top: 1px solid rgba(255, 255, 255, 0.10);
            font-size: 14px;
        }

        @media (max-width: 980px) {
            .navbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .hero {
                grid-template-columns: 1fr;
                padding-top: 42px;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <header class="container navbar">
        <a href="{{ url('/') }}" class="brand">
            <div class="brand-logo">U</div>
            <div>
                <div class="brand-title">UniMart</div>
                <div class="brand-subtitle">Campus Marketplace</div>
            </div>
        </a>

        <nav class="nav-actions">
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ url('/admin') }}" class="btn btn-primary">Dashboard Admin</a>
                @else
                    <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Dashboard</a>
                    <a href="{{ url('/produk') }}" class="btn btn-secondary">Lihat Produk</a>
                    <a href="{{ url('/produk/create') }}" class="btn btn-primary">Jual Barang</a>
                @endif
            @else
                <a href="{{ url('/login') }}" class="btn btn-secondary">Login</a>
                <a href="{{ url('/register') }}" class="btn btn-primary">Daftar</a>
            @endauth
        </nav>
    </header>

    <main>
        <section class="container hero">
            <div>
                <div class="badge">Marketplace Kampus Berbasis COD</div>

                <h1>
                    Jual beli barang antar mahasiswa jadi lebih <span>rapi</span>.
                </h1>

                <p>
                    UniMart adalah aplikasi web marketplace kampus untuk membantu mahasiswa menjual,
                    mencari, dan membeli barang di lingkungan kampus. Sistem transaksi menggunakan COD,
                    sedangkan komunikasi lanjutan dilakukan melalui WhatsApp.
                </p>

                <div class="hero-actions">
                    <a href="{{ url('/produk') }}" class="btn btn-primary">Lihat Produk</a>

                    @auth
                        @if(!auth()->user()->is_admin)
                            <a href="{{ url('/produk/create') }}" class="btn btn-secondary">Mulai Jual Barang</a>
                        @endif
                    @else
                        <a href="{{ url('/register') }}" class="btn btn-secondary">Buat Akun</a>
                    @endauth
                </div>
            </div>

            <div class="hero-panel">
                <h2 class="panel-title">Alur UniMart</h2>
                <p class="panel-desc">
                    Landing page ini hanya menjelaskan konsep aplikasi. Data produk asli dikelola di dalam sistem setelah user login.
                </p>

                <div class="flow-list">
                    <div class="flow-item">
                        <div class="flow-number">1</div>
                        <div>
                            <h3>Penjual Upload Produk</h3>
                            <p>Mahasiswa menambahkan produk melalui menu Jual Barang.</p>
                        </div>
                    </div>

                    <div class="flow-item">
                        <div class="flow-number">2</div>
                        <div>
                            <h3>Pembeli Cari Produk</h3>
                            <p>Pembeli melihat produk milik user lain melalui halaman Produk.</p>
                        </div>
                    </div>

                    <div class="flow-item">
                        <div class="flow-number">3</div>
                        <div>
                            <h3>Simpan ke Keranjang</h3>
                            <p>Produk yang diminati dapat disimpan sebelum pembeli menghubungi penjual.</p>
                        </div>
                    </div>

                    <div class="flow-item">
                        <div class="flow-number">4</div>
                        <div>
                            <h3>COD & WhatsApp</h3>
                            <p>Pembeli dan penjual melakukan koordinasi waktu dan lokasi COD melalui WhatsApp.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container section">
            <div class="section-title">
                <h2>Fitur utama UniMart</h2>
                <p>
                    Fitur dibuat sederhana agar sesuai dengan kebutuhan marketplace kampus dan tetap mudah dijelaskan saat demo UAS.
                </p>
            </div>

            <div class="feature-grid">
                <div class="feature">
                    <div class="feature-icon">🛍️</div>
                    <h3>Jual Barang</h3>
                    <p>
                        User dapat menambahkan produk, mengedit, menghapus, serta menandai produk tersedia atau terjual.
                    </p>
                </div>

                <div class="feature">
                    <div class="feature-icon">🔎</div>
                    <h3>Cari & Filter Produk</h3>
                    <p>
                        Produk dapat dicari berdasarkan kata kunci, kategori, dan fakultas agar pembeli lebih mudah menemukan barang.
                    </p>
                </div>

                <div class="feature">
                    <div class="feature-icon">🛒</div>
                    <h3>Keranjang</h3>
                    <p>
                        Keranjang dipakai untuk menyimpan produk yang diminati sebelum pembeli menghubungi penjual.
                    </p>
                </div>

                <div class="feature">
                    <div class="feature-icon">💬</div>
                    <h3>WhatsApp Penjual</h3>
                    <p>
                        Pembeli dapat menghubungi penjual melalui WhatsApp untuk menanyakan barang dan membuat janji COD.
                    </p>
                </div>

                <div class="feature">
                    <div class="feature-icon">🤝</div>
                    <h3>COD Kampus</h3>
                    <p>
                        Transaksi dilakukan secara COD di lingkungan kampus sehingga alur aplikasi tetap sederhana dan realistis.
                    </p>
                </div>

                <div class="feature">
                    <div class="feature-icon">🛡️</div>
                    <h3>Admin Dashboard</h3>
                    <p>
                        Admin dapat memantau user, produk, status produk, dan menjaga data marketplace tetap terkontrol.
                    </p>
                </div>
            </div>
        </section>

        <section class="container cta">
            <div class="cta-box">
                <div>
                    <h2>Mulai gunakan UniMart</h2>
                    <p>
                        Login untuk mengelola produk, melihat marketplace, menyimpan produk ke keranjang, dan melakukan transaksi COD.
                    </p>
                </div>

                <div class="hero-actions">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Masuk Dashboard</a>
                    @else
                        <a href="{{ url('/login') }}" class="btn btn-secondary">Login</a>
                        <a href="{{ url('/register') }}" class="btn btn-primary">Daftar</a>
                    @endauth
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        UniMart © {{ date('Y') }} — Campus Marketplace COD antar mahasiswa.
    </footer>
</body>
</html>