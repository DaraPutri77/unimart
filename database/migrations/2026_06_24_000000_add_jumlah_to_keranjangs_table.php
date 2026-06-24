<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('keranjangs') && ! Schema::hasColumn('keranjangs', 'jumlah')) {
            Schema::table('keranjangs', function (Blueprint $table) {
                $table->unsignedInteger('jumlah')->default(1)->after('produk_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('keranjangs') && Schema::hasColumn('keranjangs', 'jumlah')) {
            Schema::table('keranjangs', function (Blueprint $table) {
                $table->dropColumn('jumlah');
            });
        }
    }
};