<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProdukController extends Controller
{
    private array $kategoriOptions = [
    'Buku',
    'Elektronik',
    'Fashion',
    'Alat Tulis',
    'Aksesoris',
    'Lainnya',
];

    private array $fakultasOptions = [
        'SAINTEK',
        'FAI',
        'FBBP',
        'Fakultas Kesehatan',
    ];

    private array $kondisiOptions = [
        'baru',
        'bekas',
    ];

    public function index(Request $request)
    {
        $produks = Produk::with('user')
            ->where('aktif', true)
            ->where('user_id', '!=', Auth::id())
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%')
                        ->orWhere('kategori', 'like', '%' . $search . '%')
                        ->orWhere('fakultas', 'like', '%' . $search . '%');
                });
            })
            ->when($request->filled('kategori'), function ($query) use ($request) {
                $query->where('kategori', $request->kategori);
            })
            ->when($request->filled('kondisi'), function ($query) use ($request) {
                $query->where('kondisi', $request->kondisi);
            })
            ->when($request->filled('fakultas'), function ($query) use ($request) {
                $query->where('fakultas', $request->fakultas);
            })
            ->latest()
            ->get();

        return view('produk.index', [
            'produks' => $produks,
            'kategoriOptions' => $this->kategoriOptions,
            'fakultasOptions' => $this->fakultasOptions,
            'kondisiOptions' => $this->kondisiOptions,
        ]);
    }

    public function produkSaya(Request $request)
    {
        $produks = Produk::with('user')
            ->where('user_id', Auth::id())
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%')
                        ->orWhere('kategori', 'like', '%' . $search . '%')
                        ->orWhere('fakultas', 'like', '%' . $search . '%');
                });
            })
            ->when($request->filled('kategori'), function ($query) use ($request) {
                $query->where('kategori', $request->kategori);
            })
            ->when($request->filled('kondisi'), function ($query) use ($request) {
                $query->where('kondisi', $request->kondisi);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                if ($request->status === 'aktif') {
                    $query->where('aktif', true);
                }

                if ($request->status === 'nonaktif') {
                    $query->where('aktif', false);
                }
            })
            ->latest()
            ->get();

        return view('produk.saya', [
            'produks' => $produks,
            'kategoriOptions' => $this->kategoriOptions,
            'fakultasOptions' => $this->fakultasOptions,
            'kondisiOptions' => $this->kondisiOptions,
        ]);
    }

    public function create()
    {
        return view('produk.create', [
            'kategoriOptions' => $this->kategoriOptions,
            'fakultasOptions' => $this->fakultasOptions,
            'kondisiOptions' => $this->kondisiOptions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'kategori' => ['required', 'string', Rule::in($this->kategoriOptions)],
            'kondisi' => ['required', 'string', Rule::in($this->kondisiOptions)],
            'fakultas' => ['required', 'string', Rule::in($this->fakultasOptions)],
            'deskripsi' => ['nullable', 'string', 'max:3000'],
            'gambar' => ['nullable', 'file', 'max:4096'],
            'aktif' => ['nullable'],
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['aktif'] = $request->boolean('aktif', true);

        Produk::create($validated);

        return redirect()
            ->route('produk.saya')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Produk $produk)
    {
        $produk->load('user');

        return view('produk.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        $this->authorizeOwner($produk);

        return view('produk.edit', [
            'produk' => $produk,
            'kategoriOptions' => $this->kategoriOptions,
            'fakultasOptions' => $this->fakultasOptions,
            'kondisiOptions' => $this->kondisiOptions,
        ]);
    }

    public function update(Request $request, Produk $produk)
    {
        $this->authorizeOwner($produk);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'kategori' => ['required', 'string', Rule::in($this->kategoriOptions)],
            'kondisi' => ['required', 'string', Rule::in($this->kondisiOptions)],
            'fakultas' => ['required', 'string', Rule::in($this->fakultasOptions)],
            'deskripsi' => ['nullable', 'string', 'max:3000'],
            'gambar' => ['nullable', 'file', 'max:4096'],
            'aktif' => ['nullable'],
        ]);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && ! str_starts_with($produk->gambar, 'demo-products/') && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $validated['aktif'] = $request->boolean('aktif');

        $produk->update($validated);

        return redirect()
            ->route('produk.saya')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $this->authorizeOwner($produk);

        if ($produk->gambar && ! str_starts_with($produk->gambar, 'demo-products/') && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()
            ->route('produk.saya')
            ->with('success', 'Produk berhasil dihapus.');
    }

    private function authorizeOwner(Produk $produk): void
    {
        if ((int) $produk->user_id !== (int) Auth::id()) {
            abort(403);
        }
    }
}