<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('produks') && ! Schema::hasColumn('produks', 'kondisi')) {
            Schema::table('produks', function (Blueprint $table) {
                $table->enum('kondisi', ['baru', 'bekas'])
                    ->default('bekas')
                    ->after('kategori');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('produks') && Schema::hasColumn('produks', 'kondisi')) {
            Schema::table('produks', function (Blueprint $table) {
                $table->dropColumn('kondisi');
            });
        }
    }
};