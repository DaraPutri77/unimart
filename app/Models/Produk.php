<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'harga',
        'stok',
        'kategori',
        'fakultas',
        'deskripsi',
        'gambar',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    protected $appends = [
        'gambar_url',
    ];

    public function getGambarUrlAttribute(): ?string
    {
        if (! $this->gambar) {
            return null;
        }

        if (str_starts_with($this->gambar, 'demo-products/')) {
            return asset($this->gambar);
        }

        return asset('storage/' . $this->gambar);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function keranjangs(): HasMany
    {
        return $this->hasMany(Keranjang::class);
    }
}