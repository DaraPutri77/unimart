<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProdukController extends Controller
{
    private array $kategoriList = [
        'Elektronik',
        'Aksesori',
        'Buku',
        'Fashion',
        'Lainnya',
    ];

    public function index(Request $request): View
    {
        $search = $request->query('search');
        $kategori = $request->query('kategori');

        $produks = Produk::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('kategori', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%');
                });
            })
            ->when($kategori, function ($query) use ($kategori) {
                $query->where('kategori', $kategori);
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $kategoriList = $this->kategoriList;

        return view('produk.index', compact('produks', 'kategoriList', 'search', 'kategori'));
    }

    public function create(): View
    {
        $kategoriList = $this->kategoriList;

        return view('produk.create', compact('kategoriList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'kategori' => ['required', 'string', 'in:Elektronik,Aksesori,Buku,Fashion,Lainnya'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['aktif'] = true;

        Produk::create($validated);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Produk $produk): View
    {
        $produk->load('user');

        return view('produk.show', compact('produk'));
    }

    public function edit(Produk $produk): View
    {
        $this->authorizeOwner($produk);

        $kategoriList = $this->kategoriList;

        return view('produk.edit', compact('produk', 'kategoriList'));
    }

    public function update(Request $request, Produk $produk): RedirectResponse
    {
        $this->authorizeOwner($produk);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'kategori' => ['required', 'string', 'in:Elektronik,Aksesori,Buku,Fashion,Lainnya'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $produk->update($validated);

        return redirect()
            ->route('produk.show', $produk)
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk): RedirectResponse
    {
        $this->authorizeOwner($produk);

        $produk->delete();

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function tandaiTerjual(Produk $produk): RedirectResponse
    {
        $this->authorizeOwner($produk);

        $produk->update([
            'aktif' => false,
        ]);

        return redirect()
            ->route('produk.show', $produk)
            ->with('success', 'Produk berhasil ditandai terjual.');
    }

    public function tandaiTersedia(Produk $produk): RedirectResponse
    {
        $this->authorizeOwner($produk);

        $produk->update([
            'aktif' => true,
        ]);

        return redirect()
            ->route('produk.show', $produk)
            ->with('success', 'Produk berhasil ditandai tersedia.');
    }

    private function authorizeOwner(Produk $produk): void
    {
        if (! Auth::check() || $produk->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki akses untuk mengelola produk ini.');
        }
    }
}