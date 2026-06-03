<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'harga',
        'stok',
        'kategori',
        'fakultas',
        'deskripsi',
        'foto',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}