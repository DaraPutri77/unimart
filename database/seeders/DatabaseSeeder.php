<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->buatGambarDemo();

        $admin = $this->saveUser(
            name: 'Admin UniMart',
            email: 'admin@unimart.test',
            password: 'password123',
            whatsapp: '6281111111111',
            isAdmin: true
        );

        $dara = $this->saveUser(
            name: 'Dara Putri Nata Sukma',
            email: 'daraputrinatasukma@gmail.com',
            password: '12345678',
            whatsapp: '6285766806932',
            isAdmin: false,
            bio: 'Mahasiswa SAINTEK. Menjual barang kebutuhan kuliah seperti buku, laptop, dan perlengkapan akademik. Bisa COD di area kampus.'
        );

        $nela = $this->saveUser(
            name: 'Nela Ulivatul Zahro Maulana',
            email: 'nelaulivatulzahromaulana@gmail.com',
            password: '87654321',
            whatsapp: '6282141644491',
            isAdmin: false,
            bio: 'Mahasiswa FBBP. Menjual buku dan barang kebutuhan kuliah yang masih layak pakai. Bisa COD di lingkungan kampus.'
        );

        $this->saveUser(
            name: 'Mirza Fahmi',
            email: 'mirzafahmi727@gmail.com',
            password: 'harusbisa',
            whatsapp: '6281234567890',
            isAdmin: false,
            bio: 'Mahasiswa FAI. Akun ini digunakan untuk membeli dan menjual barang kebutuhan kampus di UniMart.'
        );

        Produk::where(function ($query) {
            $query->where('nama', 'like', '%Pemrograman%')
                ->orWhere('nama', 'like', '%Laravel%')
                ->orWhere('nama', 'like', '%ThinkPad%')
                ->orWhere('nama', 'like', '%Ekonomi%')
                ->orWhere('nama', 'like', '%Bisinis%');
        })->delete();

        Produk::create([
            'user_id' => $dara->id,
            'nama' => 'Buku Pemrograman Web 2 Laravel',
            'harga' => 80000,
            'stok' => 1,
            'kategori' => 'Buku',
            'fakultas' => 'SAINTEK',
            'deskripsi' => 'Buku mata kuliah pemrograman web untuk belajar Laravel.',
            'gambar' => 'demo-products/buku-laravel.svg',
            'aktif' => true,
        ]);

        Produk::create([
            'user_id' => $dara->id,
            'nama' => 'Laptop Lenovo ThinkPad L14',
            'harga' => 5000000,
            'stok' => 1,
            'kategori' => 'Elektronik',
            'fakultas' => 'SAINTEK',
            'deskripsi' => 'Laptop bekas masih layak pakai untuk kebutuhan kuliah dan tugas.',
            'gambar' => 'demo-products/laptop-lenovo.svg',
            'aktif' => true,
        ]);

        Produk::create([
            'user_id' => $nela->id,
            'nama' => 'Buku Ekonomi Bisnis',
            'harga' => 120000,
            'stok' => 2,
            'kategori' => 'Buku',
            'fakultas' => 'FBBP',
            'deskripsi' => 'Buku ekonomi bisnis untuk mahasiswa FBBP, kondisi masih bagus dan lengkap.',
            'gambar' => 'demo-products/buku-ekonomi.svg',
            'aktif' => true,
        ]);
    }

    private function saveUser(
        string $name,
        string $email,
        string $password,
        string $whatsapp,
        bool $isAdmin,
        ?string $bio = null
    ): User {
        $user = User::firstOrNew([
            'email' => $email,
        ]);

        $user->forceFill([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'whatsapp' => $whatsapp,
            'bio' => $bio,
            'is_admin' => $isAdmin,
            'email_verified_at' => now(),
        ]);

        $user->save();

        return $user;
    }

    private function buatGambarDemo(): void
    {
        $folder = public_path('demo-products');

        if (! is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        file_put_contents(
            public_path('demo-products/buku-laravel.svg'),
            $this->svgProduk('Buku Laravel', 'Pemrograman Web 2', '📘', '#111827', '#db2777')
        );

        file_put_contents(
            public_path('demo-products/laptop-lenovo.svg'),
            $this->svgProduk('Laptop Lenovo', 'ThinkPad L14', '💻', '#111827', '#2563eb')
        );

        file_put_contents(
            public_path('demo-products/buku-ekonomi.svg'),
            $this->svgProduk('Buku Ekonomi', 'Bisnis FBBP', '📗', '#111827', '#16a34a')
        );
    }

    private function svgProduk(string $judul, string $subjudul, string $ikon, string $warna1, string $warna2): string
    {
        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="900" height="520" viewBox="0 0 900 520">
    <defs>
        <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="{$warna1}"/>
            <stop offset="100%" stop-color="{$warna2}"/>
        </linearGradient>
    </defs>
    <rect width="900" height="520" rx="42" fill="#f8fafc"/>
    <rect x="40" y="40" width="820" height="440" rx="36" fill="url(#g)"/>
    <circle cx="735" cy="135" r="92" fill="rgba(255,255,255,0.12)"/>
    <circle cx="165" cy="395" r="115" fill="rgba(255,255,255,0.10)"/>
    <text x="450" y="210" text-anchor="middle" font-size="88" font-family="Arial, sans-serif">{$ikon}</text>
    <text x="450" y="305" text-anchor="middle" fill="#ffffff" font-size="46" font-weight="800" font-family="Arial, sans-serif">{$judul}</text>
    <text x="450" y="360" text-anchor="middle" fill="#fce7f3" font-size="28" font-weight="700" font-family="Arial, sans-serif">{$subjudul}</text>
</svg>
SVG;
    }
}