<x-app-layout>
    @php
        $user = auth()->user();

        $fotoProfil = null;

        if (! empty($user->foto_profil)) {
            $fotoProfil = asset('storage/' . $user->foto_profil);
        }
    @endphp

    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <p class="text-sm font-black uppercase tracking-[0.3em] text-pink-500">Profil Akun</p>
                <h1 class="mt-3 text-4xl font-black text-slate-900">Kelola Profil</h1>
                <p class="mt-3 max-w-3xl text-slate-600">
                    Lengkapi profil agar pembeli dan penjual lebih mudah saling mengenal saat transaksi COD.
                </p>
            </div>

            @if (session('status') === 'profile-updated')
                <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">
                    Profil berhasil diperbarui.
                </div>
            @endif

            @if (session('status') === 'password-updated')
                <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">
                    Password berhasil diperbarui.
                </div>
            @endif

            <div class="grid gap-8 lg:grid-cols-[0.9fr_1.7fr]">
                <div class="h-fit rounded-3xl bg-white p-8 text-center shadow-sm ring-1 ring-pink-100">
                    <div class="mx-auto flex h-40 w-40 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-pink-700 to-slate-900 text-6xl font-black text-white ring-8 ring-pink-50">
                        @if ($fotoProfil)
                            <img src="{{ $fotoProfil }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>

                    <h2 class="mt-6 text-3xl font-black text-slate-900">
                        {{ $user->name }}
                    </h2>

                    <p class="mt-2 break-words text-sm font-semibold text-slate-500">
                        {{ $user->email }}
                    </p>

                    <span class="mt-4 inline-flex rounded-full bg-pink-100 px-5 py-2 text-sm font-extrabold text-pink-700">
                        {{ $user->is_admin ? 'Admin UniMart' : 'User UniMart' }}
                    </span>

                    <div class="mt-8 space-y-4 text-left">
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="text-sm font-black text-slate-900">WhatsApp</p>
                            <p class="mt-2 text-slate-600">
                                {{ $user->whatsapp ?: 'Belum diisi' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="text-sm font-black text-slate-900">Bio Penjual</p>
                            <p class="mt-2 leading-7 text-slate-600">
                                {{ $user->bio ?: 'Belum ada bio.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-pink-100">
                        <h2 class="text-3xl font-black text-slate-900">Informasi Profil</h2>
                        <p class="mt-2 text-slate-600">
                            Perbarui nama, email, nomor WhatsApp, foto profil, dan bio akunmu.
                        </p>

                        <form method="POST"
                              action="{{ route('profile.update') }}"
                              enctype="multipart/form-data"
                              class="mt-8 space-y-6">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label for="name" class="mb-2 block font-extrabold text-slate-900">Nama Lengkap</label>
                                <input id="name"
                                       name="name"
                                       type="text"
                                       value="{{ old('name', $user->name) }}"
                                       required
                                       autofocus
                                       autocomplete="name"
                                       class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="email" class="mb-2 block font-extrabold text-slate-900">Email</label>
                                <input id="email"
                                       name="email"
                                       type="email"
                                       value="{{ old('email', $user->email) }}"
                                       required
                                       autocomplete="username"
                                       class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <label for="whatsapp" class="mb-2 block font-extrabold text-slate-900">Nomor WhatsApp</label>
                                <input id="whatsapp"
                                       name="whatsapp"
                                       type="text"
                                       value="{{ old('whatsapp', $user->whatsapp) }}"
                                       placeholder="Contoh: 6281234567890"
                                       class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                                <p class="mt-2 text-sm font-semibold text-slate-500">
                                    Gunakan format 62 agar tombol WhatsApp dapat langsung digunakan.
                                </p>
                                <x-input-error :messages="$errors->get('whatsapp')" class="mt-2" />
                            </div>

                            <div>
                                <label for="bio" class="mb-2 block font-extrabold text-slate-900">Bio Penjual</label>
                                <textarea id="bio"
                                          name="bio"
                                          rows="5"
                                          placeholder="Contoh: Mahasiswa SAINTEK yang menjual perlengkapan kuliah dan barang layak pakai."
                                          class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">{{ old('bio', $user->bio) }}</textarea>
                                <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                            </div>

                            <div>
                                <label class="mb-2 block font-extrabold text-slate-900">Foto Profil</label>

                                <label for="foto_profil"
                                       class="flex cursor-pointer flex-col items-center justify-center rounded-3xl border-2 border-dashed border-pink-200 bg-pink-50/50 px-6 py-8 text-center transition hover:bg-pink-50">
                                    <div class="text-5xl">📷</div>
                                    <p class="mt-3 text-lg font-black text-slate-900">Pilih Foto Profil</p>
                                    <p id="fileName" class="mt-1 text-sm font-semibold text-slate-500">
                                        JPG, PNG, atau WEBP. Maksimal 4 MB.
                                    </p>

                                    <input id="foto_profil"
                                           name="foto_profil"
                                           type="file"
                                           accept="image/jpeg,image/png,image/webp"
                                           class="hidden"
                                           onchange="showSelectedFileName(event)">
                                </label>

                                <x-input-error :messages="$errors->get('foto_profil')" class="mt-2" />
                            </div>

                            <button type="submit"
                                    class="rounded-2xl bg-gradient-to-r from-slate-900 to-pink-700 px-8 py-4 font-extrabold text-white shadow-lg shadow-pink-100 hover:from-pink-700 hover:to-slate-900">
                                Simpan Profil
                            </button>
                        </form>
                    </div>

                    <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-pink-100">
                        <h2 class="text-3xl font-black text-slate-900">Update Password</h2>
                        <p class="mt-2 text-slate-600">
                            Ubah password akun jika diperlukan.
                        </p>

                        <form method="POST" action="{{ route('password.update') }}" class="mt-8 space-y-6">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="current_password" class="mb-2 block font-extrabold text-slate-900">Password Saat Ini</label>
                                <input id="current_password"
                                       name="current_password"
                                       type="password"
                                       autocomplete="current-password"
                                       class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="password" class="mb-2 block font-extrabold text-slate-900">Password Baru</label>
                                <input id="password"
                                       name="password"
                                       type="password"
                                       autocomplete="new-password"
                                       class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="password_confirmation" class="mb-2 block font-extrabold text-slate-900">Konfirmasi Password Baru</label>
                                <input id="password_confirmation"
                                       name="password_confirmation"
                                       type="password"
                                       autocomplete="new-password"
                                       class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>

                            <button type="submit"
                                    class="rounded-2xl bg-slate-900 px-8 py-4 font-extrabold text-white hover:bg-pink-700">
                                Simpan Password
                            </button>
                        </form>
                    </div>

                    <div class="rounded-3xl border border-yellow-200 bg-yellow-50 p-6">
                        <h2 class="text-xl font-black text-yellow-800">Catatan Demo</h2>
                        <p class="mt-2 leading-7 text-yellow-700">
                            Fitur hapus akun tidak ditampilkan di halaman ini agar data produk dan riwayat pesanan demo tetap aman.
                            Untuk aplikasi marketplace, penghapusan akun sebaiknya diganti dengan status nonaktif agar histori transaksi tidak hilang.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showSelectedFileName(event) {
            const fileName = document.getElementById('fileName');

            if (event.target.files && event.target.files.length > 0) {
                fileName.textContent = 'File dipilih: ' + event.target.files[0].name;
            } else {
                fileName.textContent = 'JPG, PNG, atau WEBP. Maksimal 4 MB.';
            }
        }
    </script>
</x-app-layout>