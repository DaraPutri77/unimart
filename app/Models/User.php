<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'whatsapp',
        'fakultas',
        'foto_profil',
        'bio',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
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
        if (empty($this->foto_profil)) {
            return null;
        }

        if (str_starts_with($this->foto_profil, 'http://') || str_starts_with($this->foto_profil, 'https://')) {
            return $this->foto_profil;
        }

        return asset('storage/' . $this->foto_profil);
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->foto_profil_url;
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->foto_profil_url;
    }

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }
}
