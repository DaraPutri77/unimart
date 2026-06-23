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

        Produk::query()->delete();

        Produk::create([
            'user_id' => $dara->id,
            'nama' => 'Buku Pemrograman Web 2 Laravel',
            'harga' => 80000,
            'stok' => 1,
            'kategori' => 'Buku',
            'fakultas' => 'SAINTEK',
            'deskripsi' => 'Buku mata kuliah pemrograman web untuk belajar Laravel.',
            'gambar' => 'demo-products/buku-laravel.jpg',
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
            'gambar' => 'demo-products/laptop-lenovo.jpg',
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
            'gambar' => 'demo-products/buku-ekonomi.jpg',
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
}