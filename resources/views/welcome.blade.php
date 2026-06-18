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
                radial-gradient(circle at top left, rgba(236, 72, 153, 0.22), transparent 35%),
                radial-gradient(circle at bottom right, rgba(190, 24, 93, 0.20), transparent 35%),
                #050505;
            color: #ffffff;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: min(1120px, 92%);
            margin: 0 auto;
        }

        .navbar {
            padding: 24px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 24px;
            letter-spacing: 0.5px;
        }

        .brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, #ec4899, #be185d);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 30px rgba(236, 72, 153, 0.45);
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
            padding: 12px 18px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 14px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            transition: 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ec4899, #be185d);
            color: white;
            box-shadow: 0 12px 35px rgba(236, 72, 153, 0.28);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 45px rgba(236, 72, 153, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.07);
            color: white;
            backdrop-filter: blur(12px);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        .hero {
            padding: 78px 0 64px;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 48px;
            align-items: center;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border-radius: 999px;
            color: #f9a8d4;
            background: rgba(236, 72, 153, 0.12);
            border: 1px solid rgba(236, 72, 153, 0.28);
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 22px;
        }

        .hero h1 {
            font-size: clamp(42px, 7vw, 76px);
            line-height: 1.02;
            letter-spacing: -2px;
            margin-bottom: 22px;
        }

        .hero h1 span {
            background: linear-gradient(135deg, #f9a8d4, #ec4899, #be185d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            color: #d4d4d8;
            font-size: 18px;
            line-height: 1.8;
            max-width: 620px;
            margin-bottom: 28px;
        }

        .hero-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .preview-card {
            background: rgba(20, 20, 20, 0.78);
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: 32px;
            padding: 24px;
            box-shadow: 0 28px 90px rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(18px);
        }

        .product-card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.09), rgba(255, 255, 255, 0.04));
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: 26px;
            overflow: hidden;
        }

        .product-image {
            height: 210px;
            background:
                linear-gradient(135deg, rgba(236, 72, 153, 0.75), rgba(15, 15, 15, 0.9)),
                repeating-linear-gradient(45deg, rgba(255,255,255,0.12) 0 10px, transparent 10px 20px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 64px;
        }

        .product-body {
            padding: 22px;
        }

        .product-body h3 {
            font-size: 22px;
            margin-bottom: 8px;
        }

        .product-body p {
            color: #d4d4d8;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .pill {
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            background: rgba(236, 72, 153, 0.15);
            color: #f9a8d4;
            border: 1px solid rgba(236, 72, 153, 0.25);
        }

        .price {
            font-size: 26px;
            font-weight: 900;
            color: #ffffff;
            margin-bottom: 16px;
        }

        .features {
            padding: 42px 0 84px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 34px;
        }

        .section-title h2 {
            font-size: clamp(30px, 4vw, 46px);
            margin-bottom: 12px;
        }

        .section-title p {
            color: #d4d4d8;
            line-height: 1.7;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .feature {
            padding: 24px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.10);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: rgba(236, 72, 153, 0.15);
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
        }

        .feature p {
            color: #d4d4d8;
            line-height: 1.7;
            font-size: 15px;
        }

        .flow {
            padding: 48px 0 88px;
        }

        .flow-box {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.16), rgba(255, 255, 255, 0.05));
            border: 1px solid rgba(236, 72, 153, 0.20);
            border-radius: 32px;
            padding: 34px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .step {
            padding: 18px;
            border-radius: 22px;
            background: rgba(0, 0, 0, 0.22);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .step-number {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: #ec4899;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            margin-bottom: 12px;
        }

        .step h3 {
            margin-bottom: 8px;
            font-size: 17px;
        }

        .step p {
            color: #d4d4d8;
            line-height: 1.6;
            font-size: 14px;
        }

        .footer {
            padding: 28px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.10);
            color: #a1a1aa;
            text-align: center;
            font-size: 14px;
        }

        @media (max-width: 900px) {
            .hero {
                grid-template-columns: 1fr;
                padding-top: 44px;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .flow-box {
                grid-template-columns: 1fr;
            }

            .navbar {
                align-items: flex-start;
                gap: 16px;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <header class="container navbar">
        <a href="{{ url('/') }}" class="brand">
            <div class="brand-logo">U</div>
            <div>UniMart</div>
        </a>

        <nav class="nav-actions">
            <a href="{{ url('/produk') }}" class="btn btn-secondary">Lihat Produk</a>

            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ url('/admin') }}" class="btn btn-primary">Dashboard Admin</a>
                @else
                    <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Dashboard</a>
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
                <div class="badge">Marketplace kampus berbasis COD</div>

                <h1>
                    Jual beli barang mahasiswa jadi lebih <span>mudah</span>.
                </h1>

                <p>
                    UniMart adalah campus marketplace untuk mahasiswa yang ingin menjual,
                    mencari, menyimpan, dan membeli barang bekas atau baru di lingkungan kampus.
                    Transaksi dilakukan dengan sistem COD, lalu pembeli dapat langsung
                    menghubungi penjual melalui WhatsApp.
                </p>

                <div class="hero-actions">
                    <a href="{{ url('/produk') }}" class="btn btn-primary">Cari Produk Sekarang</a>

                    @auth
                        @if(!auth()->user()->is_admin)
                            <a href="{{ url('/produk/create') }}" class="btn btn-secondary">Mulai Jual Barang</a>
                        @else
                            <a href="{{ url('/admin') }}" class="btn btn-secondary">Kelola Admin</a>
                        @endif
                    @else
                        <a href="{{ url('/register') }}" class="btn btn-secondary">Buat Akun Gratis</a>
                    @endauth
                </div>
            </div>

            <div class="preview-card">
                <div class="product-card">
                    <div class="product-image">📚</div>

                    <div class="product-body">
                        <div class="meta">
                            <span class="pill">Buku</span>
                            <span class="pill">SAINTEK</span>
                            <span class="pill">Tersedia</span>
                        </div>

                        <h3>Buku Pemrograman Web 2 Laravel</h3>

                        <p>
                            Contoh produk UniMart. Pembeli bisa melihat detail produk,
                            menyimpan ke keranjang, lalu menghubungi penjual.
                        </p>

                        <div class="price">Rp80.000</div>

                        <a href="{{ url('/produk') }}" class="btn btn-primary" style="width: 100%;">
                            Lihat Detail Produk
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="container features">
            <div class="section-title">
                <h2>Fitur utama UniMart</h2>
                <p>
                    Fitur dibuat sesuai kebutuhan marketplace kampus sederhana:
                    jual barang, cari produk, simpan minat, dan hubungi penjual.
                </p>
            </div>

            <div class="feature-grid">
                <div class="feature">
                    <div class="feature-icon">🛍️</div>
                    <h3>Jual Barang</h3>
                    <p>
                        User biasa dapat menambahkan produk, mengedit detail produk,
                        menghapus produk, dan menandai produk tersedia atau terjual.
                    </p>
                </div>

                <div class="feature">
                    <div class="feature-icon">🔎</div>
                    <h3>Search & Filter</h3>
                    <p>
                        Produk dapat dicari berdasarkan kata kunci, kategori,
                        dan fakultas seperti SAINTEK, FAI, FBBP, dan Fakultas Kesehatan.
                    </p>
                </div>

                <div class="feature">
                    <div class="feature-icon">🛒</div>
                    <h3>Keranjang Minat</h3>
                    <p>
                        Keranjang digunakan untuk menyimpan produk yang diminati sebelum
                        pembeli menghubungi penjual. Tidak ada pembayaran online.
                    </p>
                </div>

                <div class="feature">
                    <div class="feature-icon">💬</div>
                    <h3>WhatsApp Penjual</h3>
                    <p>
                        Pembeli dapat langsung menghubungi penjual melalui WhatsApp
                        untuk menanyakan produk dan membuat janji COD.
                    </p>
                </div>

                <div class="feature">
                    <div class="feature-icon">🤝</div>
                    <h3>COD Kampus</h3>
                    <p>
                        Sistem transaksi UniMart menggunakan COD di lingkungan kampus,
                        sehingga proses jual beli lebih sederhana dan aman untuk demo.
                    </p>
                </div>

                <div class="feature">
                    <div class="feature-icon">🛡️</div>
                    <h3>Panel Admin</h3>
                    <p>
                        Admin memiliki dashboard untuk monitoring user, produk,
                        produk tersedia, produk terjual, dan dapat menghapus produk.
                    </p>
                </div>
            </div>
        </section>

        <section class="container flow">
            <div class="section-title">
                <h2>Alur penggunaan</h2>
                <p>
                    UniMart dibuat agar alur demo UAS mudah dijelaskan dari sisi user biasa dan admin.
                </p>
            </div>

            <div class="flow-box">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Register/Login</h3>
                    <p>
                        Mahasiswa membuat akun atau login menggunakan fitur authentication Laravel Breeze.
                    </p>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Upload Produk</h3>
                    <p>
                        Penjual mengisi nama produk, kategori, fakultas, harga, deskripsi, dan status.
                    </p>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Cari Produk</h3>
                    <p>
                        Pembeli mencari produk berdasarkan search, kategori, dan fakultas.
                    </p>
                </div>

                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Hubungi & COD</h3>
                    <p>
                        Pembeli menghubungi penjual melalui WhatsApp lalu transaksi dilakukan secara COD.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        UniMart © {{ date('Y') }} — Campus Marketplace COD antar mahasiswa.
    </footer>
</body>
</html>