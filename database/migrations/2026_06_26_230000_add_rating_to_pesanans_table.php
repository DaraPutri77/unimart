<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('pesanans', 'rating')) {
            Schema::table('pesanans', function (Blueprint $table) {
                $table->unsignedTinyInteger('rating')->nullable()->after('status');
            });
        }

        if (! Schema::hasColumn('pesanans', 'ulasan')) {
            Schema::table('pesanans', function (Blueprint $table) {
                $table->text('ulasan')->nullable()->after('rating');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pesanans', 'ulasan')) {
            Schema::table('pesanans', function (Blueprint $table) {
                $table->dropColumn('ulasan');
            });
        }

        if (Schema::hasColumn('pesanans', 'rating')) {
            Schema::table('pesanans', function (Blueprint $table) {
                $table->dropColumn('rating');
            });
        }
    }
};
