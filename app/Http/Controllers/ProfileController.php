<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private array $fakultasOptions = [
        'SAINTEK',
        'FAI',
        'FBBP',
        'Fakultas Kesehatan',
    ];

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'fakultasOptions' => $this->fakultasOptions,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validated();

        unset($validated['foto_profil']);
        unset($validated['hapus_foto_profil']);

        if (array_key_exists('fakultas', $validated) && ! Schema::hasColumn('users', 'fakultas')) {
            unset($validated['fakultas']);
        }

        if (array_key_exists('whatsapp', $validated) && ! Schema::hasColumn('users', 'whatsapp')) {
            unset($validated['whatsapp']);
        }

        if (array_key_exists('bio', $validated) && ! Schema::hasColumn('users', 'bio')) {
            unset($validated['bio']);
        }

        if ($request->boolean('hapus_foto_profil') && Schema::hasColumn('users', 'foto_profil')) {
            $this->deleteProfileImage($user->foto_profil);

            $validated['foto_profil'] = null;
        }

        if ($request->hasFile('foto_profil') && Schema::hasColumn('users', 'foto_profil')) {
            $this->deleteProfileImage($user->foto_profil);

            $validated['foto_profil'] = $this->uploadProfileImage($request->file('foto_profil'));
        }

        if (
            array_key_exists('email', $validated) &&
            $validated['email'] !== $user->email &&
            Schema::hasColumn('users', 'email_verified_at')
        ) {
            $validated['email_verified_at'] = null;
        }

        $user->fill($validated);

        $user->save();

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if (Schema::hasColumn('users', 'foto_profil')) {
            $this->deleteProfileImage($user->foto_profil);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    private function uploadProfileImage(UploadedFile $file): string
    {
        $supabaseUrl = $this->supabaseUrl();
        $serviceRoleKey = $this->supabaseServiceRoleKey();
        $bucket = $this->supabaseBucket();

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $extension = preg_replace('/[^a-z0-9]/', '', $extension) ?: 'jpg';

        $path = 'foto-profil/' . now()->format('Y/m') . '/' . Str::uuid()->toString() . '.' . $extension;

        $mimeType = $file->getMimeType() ?: 'application/octet-stream';
        $filePath = $file->getRealPath() ?: $file->getPathname();

        if (! is_readable($filePath)) {
            throw ValidationException::withMessages([
                'foto_profil' => 'File foto profil tidak bisa dibaca.',
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
                'foto_profil' => 'Upload foto profil gagal ke Supabase Storage. Detail: ' . $response->body(),
            ]);
        }

        return $path;
    }

    private function deleteProfileImage(?string $fotoProfil): void
    {
        if (! $fotoProfil) {
            return;
        }

        $path = $this->extractSupabasePath($fotoProfil);

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

    private function extractSupabasePath(string $fotoProfil): ?string
    {
        $fotoProfil = trim($fotoProfil);

        if ($fotoProfil === '') {
            return null;
        }

        $publicBaseUrl = $this->supabasePublicStorageUrl() . '/';

        if (str_starts_with($fotoProfil, $publicBaseUrl)) {
            $path = substr($fotoProfil, strlen($publicBaseUrl));
            $path = strtok($path, '?') ?: $path;

            return ltrim($path, '/');
        }

        if (str_starts_with($fotoProfil, 'http://') || str_starts_with($fotoProfil, 'https://')) {
            return null;
        }

        return ltrim($fotoProfil, '/');
    }

    private function supabaseUrl(): string
    {
        $url = rtrim((string) env('SUPABASE_URL'), '/');

        if ($url === '') {
            throw ValidationException::withMessages([
                'foto_profil' => 'SUPABASE_URL belum diisi di Environment Variables.',
            ]);
        }

        return $url;
    }

    private function supabaseServiceRoleKey(): string
    {
        $key = (string) env('SUPABASE_SERVICE_ROLE_KEY');

        if ($key === '') {
            throw ValidationException::withMessages([
                'foto_profil' => 'SUPABASE_SERVICE_ROLE_KEY belum diisi di Environment Variables.',
            ]);
        }

        return $key;
    }

    private function supabaseBucket(): string
    {
        $bucket = trim((string) env('SUPABASE_STORAGE_BUCKET', 'unimart'));

        if ($bucket === '') {
            return 'unimart';
        }

        return $bucket;
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
}