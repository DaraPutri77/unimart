<div>
    <label class="mb-2 block font-bold text-slate-700">Nama Produk</label>
    <input
        type="text"
        name="nama"
        value="{{ old('nama', $produk->nama ?? '') }}"
        class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-pink-500 focus:ring-pink-500"
        placeholder="Contoh: Laptop ASUS ROG"
        required
    >
    @error('nama')
        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block font-bold text-slate-700">Harga</label>
        <input
            type="number"
            name="harga"
            value="{{ old('harga', $produk->harga ?? '') }}"
            class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-pink-500 focus:ring-pink-500"
            placeholder="75000"
            min="0"
            required
        >
        @error('harga')
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block font-bold text-slate-700">Stok</label>
        <input
            type="number"
            name="stok"
            value="{{ old('stok', $produk->stok ?? '') }}"
            class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-pink-500 focus:ring-pink-500"
            placeholder="1"
            min="0"
            required
        >
        @error('stok')
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block font-bold text-slate-700">Kategori</label>
        <select
            name="kategori"
            class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-pink-500 focus:ring-pink-500"
            required
        >
            @foreach ($kategoriList as $item)
                <option value="{{ $item }}" @selected(old('kategori', $produk->kategori ?? '') === $item)>
                    {{ $item }}
                </option>
            @endforeach
        </select>
        @error('kategori')
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block font-bold text-slate-700">Fakultas</label>
        <select
            name="fakultas"
            class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-pink-500 focus:ring-pink-500"
            required
        >
            @foreach ($fakultasList as $item)
                <option value="{{ $item }}" @selected(old('fakultas', $produk->fakultas ?? 'SAINTEK') === $item)>
                    {{ $item }}
                </option>
            @endforeach
        </select>
        @error('fakultas')
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>
</div>

<div>
    <label class="mb-2 block font-bold text-slate-700">Deskripsi</label>
    <textarea
        name="deskripsi"
        rows="5"
        class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-pink-500 focus:ring-pink-500"
        placeholder="Tulis kondisi, kelengkapan, atau informasi produk..."
    >{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
    @error('deskripsi')
        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>