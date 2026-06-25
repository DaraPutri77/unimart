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
        'kondisi',
        'fakultas',
        'deskripsi',
        'gambar',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'harga' => 'integer',
        'stok' => 'integer',
    ];

    protected $appends = [
        'gambar_url',
        'kondisi_label',
    ];

    public function getGambarUrlAttribute(): ?string
    {
        if (! $this->gambar) {
            return null;
        }

        if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://')) {
            return $this->gambar;
        }

        if (str_starts_with($this->gambar, 'demo-products/')) {
            return asset($this->gambar);
        }

        return asset('storage/' . $this->gambar);
    }

    public function getKondisiLabelAttribute(): string
    {
        return match ($this->kondisi) {
            'baru' => 'Barang Baru',
            'bekas' => 'Barang Bekas',
            default => 'Barang Bekas',
        };
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