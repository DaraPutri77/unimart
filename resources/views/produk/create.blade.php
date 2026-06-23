<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size:28px; font-weight:900; color:#0f172a; margin:0;">
            Jual Barang
        </h2>
        <p style="margin:6px 0 0; color:#64748b;">
            Tambahkan produk yang ingin kamu jual di UniMart.
        </p>
    </x-slot>

    <div style="padding:36px 24px; background:#fff7fb; min-height:calc(100vh - 120px);">
        <div style="max-width:900px; margin:0 auto; background:white; border-radius:28px; padding:28px; box-shadow:0 18px 45px rgba(15,23,42,0.06);">
            <form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data" style="display:grid; gap:18px;">
                @csrf

                <div>
                    <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">Nama Produk</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Buku Pemrograman Web"
                        style="width:100%; height:52px; border:1px solid #e2e8f0; border-radius:16px; padding:0 16px;">
                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">Harga</label>
                        <input type="number" name="harga" value="{{ old('harga') }}" required min="0" placeholder="80000"
                            style="width:100%; height:52px; border:1px solid #e2e8f0; border-radius:16px; padding:0 16px;">
                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                    </div>

                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok') }}" required min="0" placeholder="1"
                            style="width:100%; height:52px; border:1px solid #e2e8f0; border-radius:16px; padding:0 16px;">
                        <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">Kategori</label>
                        <select name="kategori" required style="width:100%; height:52px; border:1px solid #e2e8f0; border-radius:16px; padding:0 16px;">
                            <option value="">Pilih kategori</option>
                            @foreach ($kategoriList as $item)
                                <option value="{{ $item }}" @selected(old('kategori') === $item)>{{ $item }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                    </div>

                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">Fakultas</label>
                        <select name="fakultas" required style="width:100%; height:52px; border:1px solid #e2e8f0; border-radius:16px; padding:0 16px;">
                            <option value="">Pilih fakultas</option>
                            @foreach ($fakultasList as $item)
                                <option value="{{ $item }}" @selected(old('fakultas') === $item)>{{ $item }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('fakultas')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">Gambar Produk</label>
                    <input type="file" name="gambar" accept="image/*"
                        style="width:100%; border:1px dashed #f9a8d4; border-radius:18px; padding:16px; background:#fff7fb;">
                    <p style="margin:8px 0 0; color:#64748b; font-size:13px;">
                        Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                    </p>
                    <x-input-error :messages="$errors->get('gambar')" class="mt-2" />
                </div>

                <div>
                    <label style="display:block; margin-bottom:8px; font-weight:900; color:#0f172a;">Deskripsi</label>
                    <textarea name="deskripsi" rows="5" placeholder="Tulis kondisi produk, kelengkapan, dan catatan penting..."
                        style="width:100%; border:1px solid #e2e8f0; border-radius:16px; padding:16px;">{{ old('deskripsi') }}</textarea>
                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                </div>

                <div style="display:flex; gap:12px; justify-content:flex-end;">
                    <a href="{{ route('produk.saya') }}"
                        style="display:inline-flex; align-items:center; justify-content:center; height:48px; padding:0 20px; border-radius:14px; background:#f1f5f9; color:#334155; font-weight:900; text-decoration:none;">
                        Batal
                    </a>

                    <button type="submit"
                        style="height:48px; padding:0 24px; border:0; border-radius:14px; background:linear-gradient(135deg,#111827,#db2777); color:white; font-weight:900; cursor:pointer;">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>