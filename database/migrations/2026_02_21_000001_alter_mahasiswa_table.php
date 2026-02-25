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
            // Contoh: tambahkan kolom baru jika belum ada
            // $table->string('contoh_field', 255)->nullable();
            // Tambahkan/ubah kolom sesuai kebutuhan dari struktur DB utama
            // Kolom sudah sesuai, jadi ini hanya template
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            // Contoh: drop kolom jika perlu
            // $table->dropColumn('contoh_field');
        });
    }
};
