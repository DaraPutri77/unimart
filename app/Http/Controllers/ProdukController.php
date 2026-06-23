<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

    private array $fakultasList = [
        'SAINTEK',
        'FAI',
        'FBBP',
        'Fakultas Kesehatan',
    ];

    public function index(Request $request): View
    {
        $search = $request->query('search');
        $kategori = $request->query('kategori');
        $fakultas = $request->query('fakultas');

        $produks = Produk::with('user')
            ->where('aktif', true)
            ->where('user_id', '!=', Auth::id())
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('kategori', 'like', '%' . $search . '%')
                        ->orWhere('fakultas', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%');
                });
            })
            ->when($kategori, function ($query) use ($kategori) {
                $query->where('kategori', $kategori);
            })
            ->when($fakultas, function ($query) use ($fakultas) {
                $query->where('fakultas', $fakultas);
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $kategoriList = $this->kategoriList;
        $fakultasList = $this->fakultasList;

        return view('produk.index', compact(
            'produks',
            'kategoriList',
            'fakultasList',
            'search',
            'kategori',
            'fakultas'
        ));
    }

    public function produkSaya(Request $request): View
    {
        $search = $request->query('search');
        $kategori = $request->query('kategori');
        $fakultas = $request->query('fakultas');

        $produks = Produk::with('user')
            ->where('user_id', Auth::id())
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('kategori', 'like', '%' . $search . '%')
                        ->orWhere('fakultas', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%');
                });
            })
            ->when($kategori, function ($query) use ($kategori) {
                $query->where('kategori', $kategori);
            })
            ->when($fakultas, function ($query) use ($fakultas) {
                $query->where('fakultas', $fakultas);
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $kategoriList = $this->kategoriList;
        $fakultasList = $this->fakultasList;

        return view('produk.saya', compact(
            'produks',
            'kategoriList',
            'fakultasList',
            'search',
            'kategori',
            'fakultas'
        ));
    }

    public function create(): View
    {
        $kategoriList = $this->kategoriList;
        $fakultasList = $this->fakultasList;

        return view('produk.create', compact('kategoriList', 'fakultasList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'kategori' => ['required', 'string', 'in:Elektronik,Aksesori,Buku,Fashion,Lainnya'],
            'fakultas' => ['required', 'string', 'in:SAINTEK,FAI,FBBP,Fakultas Kesehatan'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['nullable', 'file', 'max:4096'],
        ]);

        $gambarPath = null;

        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create([
            'user_id' => Auth::id(),
            'nama' => $validated['nama'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'kategori' => $validated['kategori'],
            'fakultas' => $validated['fakultas'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'gambar' => $gambarPath,
            'aktif' => true,
        ]);

        return redirect()
            ->route('produk.saya')
            ->with('success', 'Produk berhasil ditambahkan dan masuk ke Produk Saya.');
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
        $fakultasList = $this->fakultasList;

        return view('produk.edit', compact('produk', 'kategoriList', 'fakultasList'));
    }

    public function update(Request $request, Produk $produk): RedirectResponse
    {
        $this->authorizeOwner($produk);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'kategori' => ['required', 'string', 'in:Elektronik,Aksesori,Buku,Fashion,Lainnya'],
            'fakultas' => ['required', 'string', 'in:SAINTEK,FAI,FBBP,Fakultas Kesehatan'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['nullable', 'file', 'max:4096'],
        ]);

        $gambarPath = $produk->gambar;

        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update([
            'nama' => $validated['nama'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'kategori' => $validated['kategori'],
            'fakultas' => $validated['fakultas'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'gambar' => $gambarPath,
        ]);

        return redirect()
            ->route('produk.show', $produk)
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk): RedirectResponse
    {
        $this->authorizeOwner($produk);

        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()
            ->route('produk.saya')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function tandaiTerjual(Produk $produk): RedirectResponse
    {
        $this->authorizeOwner($produk);

        $produk->update([
            'aktif' => false,
        ]);

        return redirect()
            ->route('produk.saya')
            ->with('success', 'Produk berhasil ditandai terjual.');
    }

    public function tandaiTersedia(Produk $produk): RedirectResponse
    {
        $this->authorizeOwner($produk);

        $produk->update([
            'aktif' => true,
        ]);

        return redirect()
            ->route('produk.saya')
            ->with('success', 'Produk berhasil ditandai tersedia.');
    }

    private function authorizeOwner(Produk $produk): void
    {
        if (! Auth::check() || $produk->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki akses untuk mengelola produk ini.');
        }
    }
}