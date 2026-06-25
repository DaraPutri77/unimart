<x-app-layout>
    @php
        $kategoriOptions = $kategoriOptions ?? ['Buku', 'Elektronik', 'Fashion', 'Alat Tulis', 'Aksesoris', 'Lainnya'];
        $fakultasOptions = $fakultasOptions ?? ['SAINTEK', 'FAI', 'FBBP', 'Fakultas Kesehatan'];
        $kondisiOptions = $kondisiOptions ?? ['baru', 'bekas'];
    @endphp

    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('produk.saya') }}"
               class="mb-6 inline-flex rounded-2xl bg-white px-5 py-3 font-extrabold text-pink-700 shadow-sm ring-1 ring-pink-100 hover:bg-pink-700 hover:text-white">
                ← Kembali ke Produk Saya
            </a>

            <div class="mb-8">
                <p class="text-sm font-black uppercase tracking-[0.3em] text-pink-500">
                    Edit Produk
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900">
                    Perbarui Produk
                </h1>

                <p class="mt-3 max-w-3xl text-slate-600">
                    Ubah informasi produk jika ada perubahan harga, stok, kondisi, gambar, atau status produk.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                    <p class="font-black">Data produk belum lengkap.</p>

                    <ul class="mt-2 list-inside list-disc text-sm font-semibold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid gap-8 lg:grid-cols-[0.8fr_1.4fr]">
                <div class="h-fit rounded-3xl bg-white p-6 shadow-sm ring-1 ring-pink-100">
                    <h2 class="text-2xl font-black text-slate-900">Preview Produk</h2>

                    <div class="mt-5 flex h-64 items-center justify-center overflow-hidden rounded-3xl bg-slate-50 p-4">
                        @if ($produk->gambar_url)
                            <img src="{{ $produk->gambar_url }}"
                                 alt="{{ $produk->nama }}"
                                 class="h-full w-full object-contain">
                        @else
                            <div class="text-7xl">🛍️</div>
                        @endif
                    </div>

                    <h3 class="mt-5 text-2xl font-black text-slate-900">
                        {{ $produk->nama }}
                    </h3>

                    <p class="mt-3 text-3xl font-black text-pink-700">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </p>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="rounded-full bg-pink-100 px-4 py-2 text-xs font-extrabold text-pink-700">
                            {{ $produk->kategori }}
                        </span>

                        <span class="rounded-full bg-blue-100 px-4 py-2 text-xs font-extrabold text-blue-700">
                            {{ $produk->kondisi_label ?? ($produk->kondisi === 'baru' ? 'Barang Baru' : 'Barang Bekas') }}
                        </span>

                        <span class="rounded-full bg-slate-100 px-4 py-2 text-xs font-extrabold text-slate-700">
                            {{ $produk->fakultas }}
                        </span>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-pink-100 md:p-8">
                    <form action="{{ route('produk.update', $produk) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="nama" class="mb-2 block font-extrabold text-slate-900">
                                Nama Produk
                            </label>

                            <input type="text"
                                   id="nama"
                                   name="nama"
                                   value="{{ old('nama', $produk->nama) }}"
                                   required
                                   class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">

                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="harga" class="mb-2 block font-extrabold text-slate-900">
                                    Harga
                                </label>

                                <input type="number"
                                       id="harga"
                                       name="harga"
                                       value="{{ old('harga', $produk->harga) }}"
                                       min="0"
                                       required
                                       class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">

                                <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                            </div>

                            <div>
                                <label for="stok" class="mb-2 block font-extrabold text-slate-900">
                                    Stok
                                </label>

                                <input type="number"
                                       id="stok"
                                       name="stok"
                                       value="{{ old('stok', $produk->stok) }}"
                                       min="0"
                                       required
                                       class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">

                                <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-3">
                            <div>
                                <label for="kategori" class="mb-2 block font-extrabold text-slate-900">
                                    Kategori
                                </label>

                                <select id="kategori"
                                        name="kategori"
                                        required
                                        class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                                    <option value="">Pilih kategori</option>

                                    @foreach ($kategoriOptions as $kategori)
                                        <option value="{{ $kategori }}" @selected(old('kategori', $produk->kategori) === $kategori)>
                                            {{ $kategori }}
                                        </option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                            </div>

                            <div>
                                <label for="kondisi" class="mb-2 block font-extrabold text-slate-900">
                                    Kondisi Barang
                                </label>

                                <select id="kondisi"
                                        name="kondisi"
                                        required
                                        class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                                    <option value="">Pilih kondisi</option>

                                    @foreach ($kondisiOptions as $kondisi)
                                        <option value="{{ $kondisi }}" @selected(old('kondisi', $produk->kondisi ?? 'bekas') === $kondisi)>
                                            {{ $kondisi === 'baru' ? 'Barang Baru' : 'Barang Bekas' }}
                                        </option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('kondisi')" class="mt-2" />
                            </div>

                            <div>
                                <label for="fakultas" class="mb-2 block font-extrabold text-slate-900">
                                    Fakultas
                                </label>

                                <select id="fakultas"
                                        name="fakultas"
                                        required
                                        class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">
                                    <option value="">Pilih fakultas</option>

                                    @foreach ($fakultasOptions as $fakultas)
                                        <option value="{{ $fakultas }}" @selected(old('fakultas', $produk->fakultas) === $fakultas)>
                                            {{ $fakultas }}
                                        </option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('fakultas')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <label for="deskripsi" class="mb-2 block font-extrabold text-slate-900">
                                Deskripsi Produk
                            </label>

                            <textarea id="deskripsi"
                                      name="deskripsi"
                                      rows="6"
                                      class="w-full rounded-2xl border-slate-200 px-5 py-4 focus:border-pink-500 focus:ring-pink-500">{{ old('deskripsi', $produk->deskripsi) }}</textarea>

                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <div>
                            <label class="mb-2 block font-extrabold text-slate-900">
                                Ganti Gambar Produk
                            </label>

                            <label for="gambar"
                                   class="flex cursor-pointer flex-col items-center justify-center rounded-3xl border-2 border-dashed border-pink-200 bg-pink-50/50 px-6 py-8 text-center transition hover:bg-pink-50">
                                <div class="text-5xl">🖼️</div>
                                <p class="mt-3 text-lg font-black text-slate-900">
                                    Pilih Gambar Baru
                                </p>
                                <p id="fileName" class="mt-1 text-sm font-semibold text-slate-500">
                                    Kosongkan jika tidak ingin mengganti gambar.
                                </p>

                                <input type="file"
                                       id="gambar"
                                       name="gambar"
                                       accept="image/jpeg,image/png,image/webp"
                                       class="hidden"
                                       onchange="showSelectedFileName(event)">
                            </label>

                            <x-input-error :messages="$errors->get('gambar')" class="mt-2" />
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-5">
                            <label class="flex cursor-pointer items-start gap-3">
                                <input type="checkbox"
                                       name="aktif"
                                       value="1"
                                       class="mt-1 rounded border-slate-300 text-pink-700 focus:ring-pink-500"
                                       @checked(old('aktif', $produk->aktif))>

                                <span>
                                    <span class="block font-extrabold text-slate-900">Produk Aktif</span>
                                    <span class="mt-1 block text-sm font-semibold text-slate-500">
                                        Jika tidak dicentang, produk tidak tampil untuk pembeli.
                                    </span>
                                </span>
                            </label>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                            <a href="{{ route('produk.saya') }}"
                               class="rounded-2xl bg-slate-100 px-8 py-4 text-center font-extrabold text-slate-700 hover:bg-slate-200">
                                Batal
                            </a>

                            <button type="submit"
                                    class="rounded-2xl bg-gradient-to-r from-slate-900 to-pink-700 px-8 py-4 font-extrabold text-white shadow-lg shadow-pink-100 hover:from-pink-700 hover:to-slate-900">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
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
                fileName.textContent = 'Kosongkan jika tidak ingin mengganti gambar.';
            }
        }
    </script>
</x-app-layout>