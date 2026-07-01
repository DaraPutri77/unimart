<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Informasi Profil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Perbarui nama, email, nomor WhatsApp, dan foto profil agar pembeli bisa mengenalimu.
        </p>
    </header>

    @php
        $fotoProfilUrl = null;

        if (! empty($user->foto_profil_url)) {
            $fotoProfilUrl = $user->foto_profil_url;
        } elseif (! empty($user->foto_profil)) {
            if (str_starts_with($user->foto_profil, 'http://') || str_starts_with($user->foto_profil, 'https://')) {
                $fotoProfilUrl = $user->foto_profil;
            } else {
                $publicStorageUrl = rtrim((string) env('SUPABASE_PUBLIC_STORAGE_URL'), '/');

                if ($publicStorageUrl !== '') {
                    $fotoProfilUrl = $publicStorageUrl . '/' . ltrim($user->foto_profil, '/');
                } else {
                    $fotoProfilUrl = asset('storage/' . ltrim($user->foto_profil, '/'));
                }
            }
        }

        $inisial = strtoupper(mb_substr($user->name ?? 'U', 0, 1));
    @endphp

    <form
        method="post"
        action="{{ route('profile.update') }}"
        enctype="multipart/form-data"
        class="mt-6 space-y-6"
    >
        @csrf
        @method('patch')

        <div>
            <x-input-label for="foto_profil" value="Foto Profil" />

            <div class="mt-3 flex items-center gap-5">
                @if ($fotoProfilUrl)
                    <img
                        src="{{ $fotoProfilUrl }}"
                        alt="{{ $user->name }}"
                        class="h-24 w-24 rounded-full border border-gray-200 object-cover shadow-sm"
                    >
                @else
                    <div class="flex h-24 w-24 items-center justify-center rounded-full bg-pink-100 text-3xl font-black text-pink-700">
                        {{ $inisial }}
                    </div>
                @endif

                <div class="flex-1">
                    <input
                        id="foto_profil"
                        name="foto_profil"
                        type="file"
                        accept="image/*"
                        class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-pink-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-pink-700"
                    >

                    <p class="mt-2 text-sm text-gray-500">
                        Format gambar: JPG, PNG, atau WEBP. Maksimal 4MB.
                    </p>

                    @if ($fotoProfilUrl)
                        <label class="mt-3 flex items-center gap-2 text-sm text-gray-600">
                            <input
                                type="checkbox"
                                name="hapus_foto_profil"
                                value="1"
                                class="rounded border-gray-300 text-pink-600 shadow-sm focus:ring-pink-500"
                            >
                            Hapus foto profil saat ini
                        </label>
                    @endif
                </div>
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('foto_profil')" />
            <x-input-error class="mt-2" :messages="$errors->get('hapus_foto_profil')" />
        </div>

        <div>
            <x-input-label for="name" value="Nama Lengkap" />

            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />

            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />

            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="whatsapp" value="Nomor WhatsApp" />

            <x-text-input
                id="whatsapp"
                name="whatsapp"
                type="text"
                class="mt-1 block w-full"
                :value="old('whatsapp', $user->whatsapp)"
                placeholder="Contoh: 6281234567890"
            />

            <p class="mt-1 text-sm text-gray-500">
                Gunakan format 62 agar tombol WhatsApp lebih mudah dipakai.
            </p>

            <x-input-error class="mt-2" :messages="$errors->get('whatsapp')" />
        </div>

        @if (isset($fakultasOptions))
            <div>
                <x-input-label for="fakultas" value="Fakultas" />

                <select
                    id="fakultas"
                    name="fakultas"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                >
                    <option value="">Pilih Fakultas</option>

                    @foreach ($fakultasOptions as $fakultas)
                        <option
                            value="{{ $fakultas }}"
                            @selected(old('fakultas', $user->fakultas ?? '') === $fakultas)
                        >
                            {{ $fakultas }}
                        </option>
                    @endforeach
                </select>

                <x-input-error class="mt-2" :messages="$errors->get('fakultas')" />
            </div>
        @endif

        <div>
            <x-input-label for="bio" value="Bio" />

            <textarea
                id="bio"
                name="bio"
                rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                placeholder="Ceritakan sedikit tentang kamu..."
            >{{ old('bio', $user->bio ?? '') }}</textarea>

            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="mt-2 text-sm text-gray-800">
                    Email kamu belum diverifikasi.

                    <button
                        form="send-verification"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Klik di sini untuk mengirim ulang email verifikasi.
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm font-medium text-green-600">
                        Link verifikasi baru sudah dikirim ke email kamu.
                    </p>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >
                    Tersimpan.
                </p>
            @endif

            @if (session('success'))
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm text-green-600"
                >
                    {{ session('success') }}
                </p>
            @endif
        </div>
    </form>
</section>