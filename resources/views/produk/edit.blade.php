<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size:28px; font-weight:900; color:#0f172a; margin:0;">
            Edit Produk
        </h2>
        <p style="margin:6px 0 0; color:#64748b;">
            Perbarui data produk yang kamu jual.
        </p>
    </x-slot>

    <div style="padding:36px 24px; background:#fff7fb; min-height:calc(100vh - 120px);">
        <div style="max-width:900px; margin:0 auto; background:white; border-radius:28px; padding:28px; box-shadow:0 18px 45px rgba(15,23,42,0.06);">
            <form
                method="POST"
                action="{{ route('produk.update', $produk) }}"
                enctype="multipart/form-data"
                style="display:grid; gap:18px;"
            >
                @csrf
                @method('PUT')

                <div>
                    <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                        Nama Produk
                    </label>

                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama', $produk->nama) }}"
                        required
                        style="width:100%; height:52px; border:1px solid #e2e8f0; border-radius:16px; padding:0 16px;"
                    >

                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                            Harga
                        </label>

                        <input
                            type="number"
                            name="harga"
                            value="{{ old('harga', $produk->harga) }}"
                            required
                            min="0"
                            style="width:100%; height:52px; border:1px solid #e2e8f0; border-radius:16px; padding:0 16px;"
                        >

                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                    </div>

                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                            Stok
                        </label>

                        <input
                            type="number"
                            name="stok"
                            value="{{ old('stok', $produk->stok) }}"
                            required
                            min="0"
                            style="width:100%; height:52px; border:1px solid #e2e8f0; border-radius:16px; padding:0 16px;"
                        >

                        <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                            Kategori
                        </label>

                        <select
                            name="kategori"
                            required
                            style="width:100%; height:52px; border:1px solid #e2e8f0; border-radius:16px; padding:0 16px;"
                        >
                            @foreach ($kategoriList as $item)
                                <option value="{{ $item }}" @selected(old('kategori', $produk->kategori) === $item)>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>

                        <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                    </div>

                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                            Fakultas
                        </label>

                        <select
                            name="fakultas"
                            required
                            style="width:100%; height:52px; border:1px solid #e2e8f0; border-radius:16px; padding:0 16px;"
                        >
                            @foreach ($fakultasList as $item)
                                <option value="{{ $item }}" @selected(old('fakultas', $produk->fakultas) === $item)>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>

                        <x-input-error :messages="$errors->get('fakultas')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                        Gambar Produk
                    </label>

                    @if ($produk->gambar)
                        <div style="margin-bottom:12px;">
                            <img
                                src="{{ asset('storage/' . $produk->gambar) }}"
                                alt="{{ $produk->nama }}"
                                style="width:180px; height:130px; object-fit:cover; border-radius:18px; border:1px solid #e2e8f0;"
                            >
                        </div>
                    @else
                        <div style="margin-bottom:12px; padding:14px 16px; border-radius:16px; background:#fff7fb; color:#be185d; font-weight:800;">
                            Produk ini belum memiliki gambar.
                        </div>
                    @endif

                    <input
                        type="file"
                        name="gambar"
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        style="width:100%; border:1px dashed #f9a8d4; border-radius:18px; padding:16px; background:#fff7fb;"
                    >

                    <p style="margin:8px 0 0; color:#64748b; font-size:13px;">
                        Pilih gambar baru jika ingin menambahkan atau mengganti gambar produk. Maksimal 4 MB.
                    </p>

                    <x-input-error :messages="$errors->get('gambar')" class="mt-2" />
                </div>

                <div>
                    <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">
                        Deskripsi
                    </label>

                    <textarea
                        name="deskripsi"
                        rows="5"
                        style="width:100%; border:1px solid #e2e8f0; border-radius:16px; padding:16px;"
                    >{{ old('deskripsi', $produk->deskripsi) }}</textarea>

                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                </div>

                <div style="display:flex; gap:12px; justify-content:flex-end;">
                    <a
                        href="{{ route('produk.show', $produk) }}"
                        style="display:inline-flex; align-items:center; justify-content:center; height:48px; padding:0 20px; border-radius:14px; background:#f1f5f9; color:#334155; font-weight:900; text-decoration:none;"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        style="height:48px; padding:0 24px; border:0; border-radius:14px; background:linear-gradient(135deg,#111827,#db2777); color:white; font-weight:900; cursor:pointer;"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>