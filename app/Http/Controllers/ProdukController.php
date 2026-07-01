<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
            'gambar' => ['nullable', 'image', 'max:4096'],
            'aktif' => ['nullable'],
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadProdukImage($request->file('gambar'));
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
            'gambar' => ['nullable', 'image', 'max:4096'],
            'aktif' => ['nullable'],
        ]);

        if ($request->hasFile('gambar')) {
            $this->deleteProdukImage($produk->gambar);

            $validated['gambar'] = $this->uploadProdukImage($request->file('gambar'));
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

        $this->deleteProdukImage($produk->gambar);

        $produk->delete();

        return redirect()
            ->route('produk.saya')
            ->with('success', 'Produk berhasil dihapus.');
    }

    private function uploadProdukImage(UploadedFile $file): string
    {
        $supabaseUrl = $this->supabaseUrl();
        $serviceRoleKey = $this->supabaseServiceRoleKey();
        $bucket = $this->supabaseBucket();

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $extension = preg_replace('/[^a-z0-9]/', '', $extension) ?: 'jpg';

        $path = 'produk/' . now()->format('Y/m') . '/' . Str::uuid()->toString() . '.' . $extension;

        $mimeType = $file->getMimeType() ?: 'application/octet-stream';
        $filePath = $file->getRealPath() ?: $file->getPathname();

        if (! is_readable($filePath)) {
            throw ValidationException::withMessages([
                'gambar' => 'File gambar tidak bisa dibaca.',
            ]);
        }

        $uploadUrl = $supabaseUrl . '/storage/v1/object/' . $bucket . '/' . $path;

        $response = Http::withHeaders([
            'apikey' => $serviceRoleKey,
            'Authorization' => 'Bearer ' . $serviceRoleKey,
            'Content-Type' => $mimeType,
            'cache-control' => '3600',
            'x-upsert' => 'false',
        ])->withBody(
            file_get_contents($filePath),
            $mimeType
        )->post($uploadUrl);

        if (! $response->successful()) {
            throw ValidationException::withMessages([
                'gambar' => 'Upload gambar gagal ke Supabase Storage. Detail: ' . $response->body(),
            ]);
        }

        return $this->supabasePublicStorageUrl() . '/' . $path;
    }

    private function deleteProdukImage(?string $gambar): void
    {
        if (! $gambar) {
            return;
        }

        if (str_starts_with($gambar, 'demo-products/')) {
            return;
        }

        $path = $this->extractSupabasePath($gambar);

        if (! $path) {
            return;
        }

        $supabaseUrl = $this->supabaseUrl();
        $serviceRoleKey = $this->supabaseServiceRoleKey();
        $bucket = $this->supabaseBucket();

        Http::withHeaders([
            'apikey' => $serviceRoleKey,
            'Authorization' => 'Bearer ' . $serviceRoleKey,
            'Content-Type' => 'application/json',
        ])->delete($supabaseUrl . '/storage/v1/object/' . $bucket, [
            'prefixes' => [$path],
        ]);
    }

    private function extractSupabasePath(string $gambar): ?string
    {
        $gambar = trim($gambar);

        if ($gambar === '') {
            return null;
        }

        $publicBaseUrl = $this->supabasePublicStorageUrl() . '/';

        if (str_starts_with($gambar, $publicBaseUrl)) {
            $path = substr($gambar, strlen($publicBaseUrl));
            $path = strtok($path, '?') ?: $path;

            return ltrim($path, '/');
        }

        if (str_starts_with($gambar, 'http://') || str_starts_with($gambar, 'https://')) {
            return null;
        }

        return ltrim($gambar, '/');
    }

    private function supabaseUrl(): string
    {
        $url = rtrim((string) env('SUPABASE_URL'), '/');

        if ($url === '') {
            throw ValidationException::withMessages([
                'gambar' => 'SUPABASE_URL belum diisi di Environment Variables.',
            ]);
        }

        return $url;
    }

    private function supabaseServiceRoleKey(): string
    {
        $key = (string) env('SUPABASE_SERVICE_ROLE_KEY');

        if ($key === '') {
            throw ValidationException::withMessages([
                'gambar' => 'SUPABASE_SERVICE_ROLE_KEY belum diisi di Environment Variables.',
            ]);
        }

        return $key;
    }

    private function supabaseBucket(): string
    {
        return trim((string) env('SUPABASE_STORAGE_BUCKET', 'unimart'));
    }

    private function supabasePublicStorageUrl(): string
    {
        $publicUrl = rtrim((string) env('SUPABASE_PUBLIC_STORAGE_URL'), '/');

        if ($publicUrl !== '') {
            return $publicUrl;
        }

        return $this->supabaseUrl()
            . '/storage/v1/object/public/'
            . $this->supabaseBucket();
    }

    private function authorizeOwner(Produk $produk): void
    {
        if ((int) $produk->user_id !== (int) Auth::id()) {
            abort(403);
        }
    }
}