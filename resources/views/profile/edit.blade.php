<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 style="font-size:28px; font-weight:900; color:#0f172a; margin:0;">
                Profil Akun
            </h2>
            <p style="margin:6px 0 0; color:#64748b; font-size:15px;">
                Kelola identitas akun agar pembeli dan penjual lebih mudah saling mengenal.
            </p>
        </div>
    </x-slot>

    <div style="padding:32px 24px; background:#fff7fb; min-height:calc(100vh - 120px);">
        <div style="max-width:1120px; margin:0 auto; display:grid; gap:24px;">
            @if (session('status') === 'profile-updated')
                <div style="padding:14px 18px; border-radius:16px; background:#ecfdf5; color:#047857; border:1px solid #a7f3d0; font-weight:800;">
                    Profil berhasil diperbarui.
                </div>
            @endif

            @if (session('status') === 'password-updated')
                <div style="padding:14px 18px; border-radius:16px; background:#ecfdf5; color:#047857; border:1px solid #a7f3d0; font-weight:800;">
                    Password berhasil diperbarui.
                </div>
            @endif

            <div style="display:grid; grid-template-columns:340px 1fr; gap:24px; align-items:start;">
                <div style="background:white; border-radius:28px; padding:26px; box-shadow:0 14px 35px rgba(15,23,42,0.06); border:1px solid #f3e8ef; text-align:center;">
                    <div style="width:170px; height:170px; margin:0 auto 18px; border-radius:999px; overflow:hidden; background:linear-gradient(135deg,#111827,#db2777); display:flex; align-items:center; justify-content:center; color:white; font-size:54px; font-weight:900; border:6px solid #fff1f7; box-shadow:0 18px 40px rgba(219,39,119,0.18);">
                        @if ($user->foto_profil)
                            <img
                                src="{{ asset('storage/' . $user->foto_profil) }}"
                                alt="{{ $user->name }}"
                                style="width:100%; height:100%; object-fit:cover;"
                            >
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>

                    <h3 style="margin:0 0 6px; font-size:24px; font-weight:900; color:#0f172a;">
                        {{ $user->name }}
                    </h3>

                    <p style="margin:0 0 10px; color:#64748b; font-size:14px; font-weight:700;">
                        {{ $user->email }}
                    </p>

                    <div style="display:inline-flex; align-items:center; justify-content:center; padding:8px 14px; border-radius:999px; background:#fce7f3; color:#be185d; font-size:13px; font-weight:900;">
                        {{ $user->is_admin ? 'Admin UniMart' : 'User UniMart' }}
                    </div>

                    <div style="margin-top:22px; text-align:left; display:grid; gap:10px; color:#334155; font-size:14px;">
                        <div style="padding:12px 14px; border-radius:16px; background:#f8fafc;">
                            <strong style="display:block; color:#0f172a; margin-bottom:4px;">WhatsApp</strong>
                            {{ $user->whatsapp ?: 'Belum diisi' }}
                        </div>

                        <div style="padding:12px 14px; border-radius:16px; background:#f8fafc;">
                            <strong style="display:block; color:#0f172a; margin-bottom:4px;">Bio Penjual</strong>
                            {{ $user->bio ?: 'Belum ada bio. Tulis bio singkat agar pembeli lebih mengenalmu.' }}
                        </div>
                    </div>
                </div>

                <div style="display:grid; gap:24px;">
                    <div style="background:white; border-radius:28px; padding:26px; box-shadow:0 14px 35px rgba(15,23,42,0.06); border:1px solid #f3e8ef;">
                        <h3 style="margin:0 0 8px; font-size:24px; font-weight:900; color:#0f172a;">
                            Informasi Profil
                        </h3>

                        <p style="margin:0 0 22px; color:#64748b; font-size:15px;">
                            Perbarui nama, email, nomor WhatsApp, foto profil, dan bio akunmu.
                        </p>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" style="display:grid; gap:18px;">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label for="name" style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                                    Nama Lengkap
                                </label>

                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    style="width:100%; height:50px; border:1px solid #e2e8f0; border-radius:14px; padding:0 14px; outline:none;"
                                >

                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="email" style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                                    Email
                                </label>

                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                    autocomplete="username"
                                    style="width:100%; height:50px; border:1px solid #e2e8f0; border-radius:14px; padding:0 14px; outline:none;"
                                >

                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <label for="whatsapp" style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                                    Nomor WhatsApp
                                </label>

                                <input
                                    id="whatsapp"
                                    name="whatsapp"
                                    type="text"
                                    value="{{ old('whatsapp', $user->whatsapp) }}"
                                    placeholder="Contoh: 6281234567890"
                                    style="width:100%; height:50px; border:1px solid #e2e8f0; border-radius:14px; padding:0 14px; outline:none;"
                                >

                                <p style="margin:8px 0 0; color:#64748b; font-size:13px;">
                                    Gunakan format 62 agar tombol WhatsApp lebih mudah dipakai.
                                </p>

                                <x-input-error :messages="$errors->get('whatsapp')" class="mt-2" />
                            </div>

                            <div>
                                <label for="bio" style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                                    Bio Penjual
                                </label>

                                <textarea
                                    id="bio"
                                    name="bio"
                                    rows="4"
                                    placeholder="Contoh: Mahasiswa SAINTEK. Sering jual buku kuliah, barang elektronik, dan kebutuhan kampus. Bisa COD di area kampus."
                                    style="width:100%; border:1px solid #e2e8f0; border-radius:14px; padding:14px; outline:none; resize:vertical;"
                                >{{ old('bio', $user->bio) }}</textarea>

                                <p style="margin:8px 0 0; color:#64748b; font-size:13px;">
                                    Maksimal 500 karakter. Bio ini akan tampil di detail produk sebagai info penjual.
                                </p>

                                <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                            </div>

                            <div>
                                <label for="foto_profil" style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                                    Foto Profil
                                </label>

                                <input
                                    id="foto_profil"
                                    name="foto_profil"
                                    type="file"
                                    accept="image/jpeg,image/png,image/jpg,image/webp"
                                    style="width:100%; border:1px dashed #f9a8d4; border-radius:16px; padding:15px; background:#fff7fb;"
                                >

                                <p style="margin:8px 0 0; color:#64748b; font-size:13px;">
                                    Pilih foto profil JPG, PNG, atau WEBP. Maksimal 4 MB.
                                </p>

                                <x-input-error :messages="$errors->get('foto_profil')" class="mt-2" />
                            </div>

                            <div>
                                <button
                                    type="submit"
                                    style="height:48px; padding:0 22px; border:0; border-radius:14px; background:linear-gradient(135deg,#111827,#db2777); color:white; font-weight:900; cursor:pointer;"
                                >
                                    Simpan Profil
                                </button>
                            </div>
                        </form>
                    </div>

                    <div style="background:white; border-radius:28px; padding:26px; box-shadow:0 14px 35px rgba(15,23,42,0.06); border:1px solid #f3e8ef;">
                        <h3 style="margin:0 0 8px; font-size:24px; font-weight:900; color:#0f172a;">
                            Update Password
                        </h3>

                        <p style="margin:0 0 22px; color:#64748b; font-size:15px;">
                            Ubah password akun jika diperlukan.
                        </p>

                        <form method="POST" action="{{ route('password.update') }}" style="display:grid; gap:18px;">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="current_password" style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                                    Password Saat Ini
                                </label>

                                <input
                                    id="current_password"
                                    name="current_password"
                                    type="password"
                                    autocomplete="current-password"
                                    style="width:100%; height:50px; border:1px solid #e2e8f0; border-radius:14px; padding:0 14px; outline:none;"
                                >

                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="password" style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                                    Password Baru
                                </label>

                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="new-password"
                                    style="width:100%; height:50px; border:1px solid #e2e8f0; border-radius:14px; padding:0 14px; outline:none;"
                                >

                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="password_confirmation" style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                                    Konfirmasi Password Baru
                                </label>

                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    autocomplete="new-password"
                                    style="width:100%; height:50px; border:1px solid #e2e8f0; border-radius:14px; padding:0 14px; outline:none;"
                                >

                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div>
                                <button
                                    type="submit"
                                    style="height:48px; padding:0 22px; border:0; border-radius:14px; background:#111827; color:white; font-weight:900; cursor:pointer;"
                                >
                                    Simpan Password
                                </button>
                            </div>
                        </form>
                    </div>

                    <div style="background:white; border-radius:28px; padding:26px; box-shadow:0 14px 35px rgba(15,23,42,0.06); border:1px solid #fee2e2;">
                        <h3 style="margin:0 0 8px; font-size:24px; font-weight:900; color:#0f172a;">
                            Hapus Akun
                        </h3>

                        <p style="margin:0 0 20px; color:#64748b; font-size:15px;">
                            Gunakan hanya jika akun benar-benar ingin dihapus.
                        </p>

                        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Yakin ingin menghapus akun ini? Semua data akun akan dihapus.')">
                            @csrf
                            @method('DELETE')

                            <div style="margin-bottom:14px;">
                                <label for="delete_password" style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                                    Masukkan Password
                                </label>

                                <input
                                    id="delete_password"
                                    name="password"
                                    type="password"
                                    style="width:100%; height:50px; border:1px solid #e2e8f0; border-radius:14px; padding:0 14px; outline:none;"
                                >

                                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                            </div>

                            <button
                                type="submit"
                                style="height:48px; padding:0 22px; border:0; border-radius:14px; background:#ef4444; color:white; font-weight:900; cursor:pointer;"
                            >
                                Hapus Akun
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>