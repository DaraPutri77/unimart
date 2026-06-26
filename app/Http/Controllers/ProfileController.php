<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'fakultas' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],

            'foto_profil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if (Schema::hasColumn('users', 'name')) {
            $user->name = $request->input('name');
        }

        if (Schema::hasColumn('users', 'email')) {
            if ($user->email !== $request->input('email') && Schema::hasColumn('users', 'email_verified_at')) {
                $user->email_verified_at = null;
            }

            $user->email = $request->input('email');
        }

        if (Schema::hasColumn('users', 'whatsapp')) {
            $user->whatsapp = $request->input('whatsapp');
        }

        if (Schema::hasColumn('users', 'fakultas')) {
            $user->fakultas = $request->input('fakultas');
        }

        if (Schema::hasColumn('users', 'bio')) {
            $user->bio = $request->input('bio');
        }

        $fileField = null;

        foreach (['foto_profil', 'avatar', 'photo', 'foto', 'profile_photo'] as $field) {
            if ($request->hasFile($field)) {
                $fileField = $field;
                break;
            }
        }

        if ($fileField && Schema::hasColumn('users', 'foto_profil')) {
            if (! empty($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $user->foto_profil = $request->file($fileField)->store('foto-profil', 'public');
        }

        $user->save();

        return Redirect::route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if (Schema::hasColumn('users', 'foto_profil') && ! empty($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Akun berhasil dihapus.');
    }
}
