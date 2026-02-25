<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fokus hanya pada tabel mahasiswa
        if (Schema::hasTable('mahasiswa')) {
            Schema::table('mahasiswa', function (Blueprint $table) {
                if (Schema::hasColumn('mahasiswa', 'domisili')) {
                    $table->string('domisili')->nullable()->default('')->change();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('mahasiswa')) {
            Schema::table('mahasiswa', function (Blueprint $table) {
                if (Schema::hasColumn('mahasiswa', 'domisili')) {
                    $table->string('domisili')->nullable(false)->default(null)->change();
                }
            });
        }
    }
};
