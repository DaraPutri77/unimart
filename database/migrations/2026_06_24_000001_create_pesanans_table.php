<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pesanans')) {
            Schema::create('pesanans', function (Blueprint $table) {
                $table->id();
                $table->string('kode_pesanan')->unique();

                $table->foreignId('buyer_id')
                    ->constrained('users')
                    ->cascadeOnDelete();

                $table->foreignId('seller_id')
                    ->constrained('users')
                    ->cascadeOnDelete();

                $table->enum('status', [
                    'pending',
                    'accepted',
                    'rejected',
                    'cancelled',
                    'completed',
                ])->default('pending');

                $table->unsignedBigInteger('total_harga')->default(0);
                $table->string('metode_pembayaran')->default('COD');
                $table->string('lokasi_cod')->nullable();
                $table->text('catatan')->nullable();

                $table->timestamp('accepted_at')->nullable();
                $table->timestamp('rejected_at')->nullable();
                $table->timestamp('cancelled_at')->nullable();
                $table->timestamp('completed_at')->nullable();

                $table->timestamps();

                $table->index(['buyer_id', 'status']);
                $table->index(['seller_id', 'status']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};