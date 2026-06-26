<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'foto_profil')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('foto_profil')->nullable()->after('whatsapp');
            });
        }

        if (! Schema::hasColumn('users', 'bio')) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('bio')->nullable()->after('foto_profil');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'bio')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('bio');
            });
        }

        if (Schema::hasColumn('users', 'foto_profil')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('foto_profil');
            });
        }
    }
};
