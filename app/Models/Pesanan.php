<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pesanan extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'kode_pesanan',
        'buyer_id',
        'seller_id',
        'status',
        'total_harga',
        'metode_pembayaran',
        'lokasi_cod',
        'catatan',
        'alasan_penolakan',
        'accepted_at',
        'rejected_at',
        'cancelled_at',
        'completed_at',
    ];

    protected $casts = [
        'total_harga' => 'integer',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected $appends = [
        'status_label',
        'status_badge',
    ];

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PesananItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu Konfirmasi Penjual',
            self::STATUS_ACCEPTED => 'Disetujui, Menunggu COD',
            self::STATUS_REJECTED => 'Ditolak Penjual',
            self::STATUS_CANCELLED => 'Dibatalkan Pembeli',
            self::STATUS_COMPLETED => 'Selesai',
            default => 'Tidak Diketahui',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-700 border-yellow-200',
            self::STATUS_ACCEPTED => 'bg-blue-100 text-blue-700 border-blue-200',
            self::STATUS_REJECTED => 'bg-red-100 text-red-700 border-red-200',
            self::STATUS_CANCELLED => 'bg-gray-100 text-gray-700 border-gray-200',
            self::STATUS_COMPLETED => 'bg-green-100 text-green-700 border-green-200',
            default => 'bg-gray-100 text-gray-700 border-gray-200',
        };
    }

    public function canBeCancelledByBuyer(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function canBeCompletedByBuyer(): bool
    {
        return $this->status === self::STATUS_ACCEPTED;
    }

    public function canBeRespondedBySeller(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }
}