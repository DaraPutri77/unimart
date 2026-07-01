<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'whatsapp',
        'is_admin',
        'foto_profil',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'foto_profil_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function getFotoProfilUrlAttribute(): ?string
    {
        if (! $this->foto_profil) {
            return null;
        }

        if (Str::startsWith($this->foto_profil, ['http://', 'https://'])) {
            return $this->foto_profil;
        }

        $publicStorageUrl = rtrim((string) env('SUPABASE_PUBLIC_STORAGE_URL'), '/');

        if ($publicStorageUrl !== '') {
            return $publicStorageUrl . '/' . ltrim($this->foto_profil, '/');
        }

        return asset('storage/' . ltrim($this->foto_profil, '/'));
    }
}