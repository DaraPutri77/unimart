<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pesanan_items')) {
            Schema::create('pesanan_items', function (Blueprint $table) {
                $table->id();

                $table->foreignId('pesanan_id')
                    ->constrained('pesanans')
                    ->cascadeOnDelete();

                $table->foreignId('produk_id')
                    ->nullable()
                    ->constrained('produks')
                    ->nullOnDelete();

                $table->string('nama_produk');
                $table->unsignedBigInteger('harga');
                $table->unsignedInteger('jumlah')->default(1);
                $table->unsignedBigInteger('subtotal');

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan_items');
    }
};