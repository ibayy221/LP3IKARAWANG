<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswa', 'desa')) {
                $table->string('desa')->nullable()->after('kecamatan');
            }
            if (!Schema::hasColumn('mahasiswa', 'kode_pos')) {
                $table->string('kode_pos')->nullable()->after('desa');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $toDrop = [];
            foreach (['desa', 'kode_pos'] as $col) {
                if (Schema::hasColumn('mahasiswa', $col)) {
                    $toDrop[] = $col;
                }
            }

            if (!empty($toDrop)) {
                $table->dropColumn($toDrop);
            }
        });
    }
};

