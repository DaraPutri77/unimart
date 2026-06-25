<x-app-layout>
    <div class="min-h-screen bg-pink-50/40 py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900">Keranjang</h1>
                <p class="mt-2 text-slate-600">
                    Simpan produk yang kamu minati. Pilih produk tertentu saat ingin checkout COD.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 font-semibold text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 font-semibold text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            @php
                $dataKeranjang = $keranjangs ?? collect();
                $totalSemua = $dataKeranjang->sum(fn ($item) => $item->subtotal);
            @endphp

            @if ($dataKeranjang->count() > 0)
                <div class="mb-5 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-pink-100">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-xl font-extrabold text-slate-900">Pilih Produk untuk Checkout</h2>
                            <p class="mt-1 text-sm text-slate-600">
                                Produk yang tidak dicentang tetap tersimpan di keranjang.
                            </p>
                        </div>

                        <label class="inline-flex cursor-pointer items-center gap-3 rounded-2xl bg-pink-50 px-4 py-3 font-bold text-slate-700">
                            <input type="checkbox"
                                   id="checkAll"
                                   class="rounded border-slate-300 text-pink-700 focus:ring-pink-600">
                            Pilih Semua
                        </label>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="space-y-4 lg:col-span-2">
                        @foreach ($dataKeranjang as $item)
                            @if ($item->produk)
                                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-pink-100">
                                    <div class="flex flex-col gap-4 md:flex-row">
                                        <div class="flex items-start pt-2">
                                            <input type="checkbox"
                                                   name="keranjang_ids[]"
                                                   value="{{ $item->id }}"
                                                   data-subtotal="{{ $item->subtotal }}"
                                                   form="checkoutForm"
                                                   class="checkout-item mt-1 h-5 w-5 rounded border-slate-300 text-pink-700 focus:ring-pink-600">
                                        </div>

                                        <div class="flex h-32 w-full shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-slate-100 md:w-32">
                                            @if ($item->produk->gambar_url)
                                                <img src="{{ $item->produk->gambar_url }}"
                                                     alt="{{ $item->produk->nama }}"
                                                     class="h-full w-full object-contain">
                                            @else
                                                <span class="text-4xl">🛍️</span>
                                            @endif
                                        </div>

                                        <div class="flex-1">
                                            <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                                <div>
                                                    <h2 class="text-xl font-extrabold text-slate-900">
                                                        {{ $item->produk->nama }}
                                                    </h2>

                                                    <p class="mt-1 text-sm text-slate-600">
                                                        Penjual:
                                                        <span class="font-bold">{{ $item->produk->user->name ?? '-' }}</span>
                                                    </p>

                                                    <p class="mt-1 text-sm text-slate-600">
                                                        Fakultas:
                                                        <span class="font-bold">{{ $item->produk->fakultas }}</span>
                                                    </p>

                                                    <p class="mt-3 text-lg font-extrabold text-pink-700">
                                                        Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                                    </p>
                                                </div>

                                                <form action="{{ route('keranjang.destroy', $item) }}" method="POST"
                                                      onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="rounded-xl bg-red-600 px-4 py-2 text-sm font-bold text-white hover:bg-red-700">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>

                                            <div class="mt-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                                <form action="{{ route('keranjang.update', $item) }}" method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')

                                                    <label class="text-sm font-bold text-slate-700">Jumlah</label>
                                                    <input type="number"
                                                           name="jumlah"
                                                           min="1"
                                                           max="{{ $item->produk->stok }}"
                                                           value="{{ $item->jumlah }}"
                                                           class="w-20 rounded-xl border-slate-200 text-center focus:border-pink-500 focus:ring-pink-500">

                                                    <button type="submit"
                                                            class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-bold text-white hover:bg-pink-700">
                                                        Update
                                                    </button>
                                                </form>

                                                <p class="text-sm text-slate-600">
                                                    Subtotal:
                                                    <b>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</b>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="h-fit rounded-3xl bg-white p-6 shadow-sm ring-1 ring-pink-100">
                        <h2 class="text-2xl font-extrabold text-slate-900">Checkout COD</h2>
                        <p class="mt-2 text-slate-600">
                            Checkout hanya untuk produk yang kamu centang.
                        </p>

                        <div class="mt-6 rounded-2xl bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">Total Semua Keranjang</p>
                            <p class="text-2xl font-extrabold text-slate-900">
                                Rp {{ number_format($totalSemua, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="mt-4 rounded-2xl bg-pink-50 p-4">
                            <p class="text-sm text-slate-500">Total Produk Terpilih</p>
                            <p id="selectedTotalText" class="text-3xl font-extrabold text-pink-700">
                                Rp 0
                            </p>
                        </div>

                        <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST" class="mt-6 space-y-4">
                            @csrf

                            <div>
                                <label class="mb-2 block font-bold text-slate-900">Lokasi COD</label>
                                <input type="text"
                                       name="lokasi_cod"
                                       value="{{ old('lokasi_cod') }}"
                                       placeholder="Contoh: Kantin kampus / depan fakultas"
                                       class="w-full rounded-2xl border-slate-200 focus:border-pink-500 focus:ring-pink-500">
                                @error('lokasi_cod')
                                    <p class="mt-1 text-sm font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block font-bold text-slate-900">Catatan</label>
                                <textarea name="catatan"
                                          rows="4"
                                          placeholder="Contoh: COD jam 12 siang ya kak"
                                          class="w-full rounded-2xl border-slate-200 focus:border-pink-500 focus:ring-pink-500">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <p class="mt-1 text-sm font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button id="checkoutButton"
                                    type="submit"
                                    disabled
                                    class="w-full rounded-2xl bg-pink-700 px-6 py-4 font-extrabold text-white opacity-50 hover:bg-slate-900 disabled:cursor-not-allowed">
                                Checkout Produk Terpilih
                            </button>

                            <p id="checkoutHint" class="text-center text-sm font-semibold text-slate-500">
                                Centang minimal satu produk untuk checkout.
                            </p>
                        </form>
                    </div>
                </div>
            @else
                <div class="rounded-3xl bg-white p-10 text-center shadow-sm ring-1 ring-pink-100">
                    <div class="text-6xl">🛒</div>
                    <h2 class="mt-4 text-2xl font-extrabold text-slate-900">Keranjang masih kosong</h2>
                    <p class="mt-2 text-slate-600">Pilih produk dari marketplace lalu tambahkan ke keranjang.</p>
                    <a href="{{ route('produk.index') }}"
                       class="mt-6 inline-flex rounded-2xl bg-pink-700 px-6 py-3 font-bold text-white hover:bg-slate-900">
                        Lihat Produk
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        const checkAll = document.getElementById('checkAll');
        const checkoutItems = document.querySelectorAll('.checkout-item');
        const selectedTotalText = document.getElementById('selectedTotalText');
        const checkoutButton = document.getElementById('checkoutButton');
        const checkoutHint = document.getElementById('checkoutHint');

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }

        function updateSelectedTotal() {
            let total = 0;
            let checkedCount = 0;

            checkoutItems.forEach((item) => {
                if (item.checked) {
                    total += parseInt(item.dataset.subtotal || 0);
                    checkedCount++;
                }
            });

            selectedTotalText.textContent = 'Rp ' + formatRupiah(total);

            if (checkedCount > 0) {
                checkoutButton.disabled = false;
                checkoutButton.classList.remove('opacity-50');
                checkoutHint.textContent = checkedCount + ' produk dipilih untuk checkout.';
            } else {
                checkoutButton.disabled = true;
                checkoutButton.classList.add('opacity-50');
                checkoutHint.textContent = 'Centang minimal satu produk untuk checkout.';
            }

            if (checkAll) {
                checkAll.checked = checkedCount > 0 && checkedCount === checkoutItems.length;
            }
        }

        if (checkAll) {
            checkAll.addEventListener('change', function () {
                checkoutItems.forEach((item) => {
                    item.checked = checkAll.checked;
                });

                updateSelectedTotal();
            });
        }

        checkoutItems.forEach((item) => {
            item.addEventListener('change', updateSelectedTotal);
        });

        updateSelectedTotal();
    </script>
</x-app-layout>