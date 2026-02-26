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
        Schema::table('mahasiswa', function (Blueprint $table) {
            // Only drop truly legacy/unused columns to keep fresh installs consistent.
            $cols = ['NIK_mahasiswa', 'jenis_sekolah', 'kategori_sekolah'];
            $existing = array_intersect($cols, Schema::getColumnListing('mahasiswa'));
            if (!empty($existing)) {
                $table->dropColumn($existing);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            // Recreate columns with nullable defaults. Adjust types conservatively.
            if (!Schema::hasColumn('mahasiswa', 'NIK_mahasiswa')) {
                $table->string('NIK_mahasiswa')->nullable();
            }
            if (!Schema::hasColumn('mahasiswa', 'jenis_sekolah')) {
                $table->string('jenis_sekolah')->nullable();
            }
            if (!Schema::hasColumn('mahasiswa', 'kategori_sekolah')) {
                $table->string('kategori_sekolah')->nullable();
            }
        });
    }
};
