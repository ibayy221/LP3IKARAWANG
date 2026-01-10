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
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswas', 'agama')) {
                $table->string('agama')->nullable()->after('kategori_sekolah');
            }
            if (!Schema::hasColumn('mahasiswas', 'status')) {
                $table->string('status')->default('aktif')->after('agama');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (Schema::hasColumn('mahasiswas', 'agama')) {
                $table->dropColumn('agama');
            }
            if (Schema::hasColumn('mahasiswas', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
