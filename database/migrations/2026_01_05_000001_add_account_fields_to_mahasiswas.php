<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswas', 'ktp_path')) {
                $table->string('ktp_path')->nullable()->after('file_path');
            }
            if (!Schema::hasColumn('mahasiswas', 'instagram')) {
                $table->string('instagram')->nullable()->after('ktp_path');
            }
            if (!Schema::hasColumn('mahasiswas', 'nama_wali')) {
                $table->string('nama_wali')->nullable()->after('instagram');
            }
            if (!Schema::hasColumn('mahasiswas', 'telp_wali')) {
                $table->string('telp_wali')->nullable()->after('nama_wali');
            }
            if (!Schema::hasColumn('mahasiswas', 'pekerjaan_wali')) {
                $table->string('pekerjaan_wali')->nullable()->after('telp_wali');
            }
            if (!Schema::hasColumn('mahasiswas', 'whatsapp')) {
                $table->string('whatsapp')->nullable()->after('pekerjaan_wali');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            foreach (['ktp_path','instagram','nama_wali','telp_wali','pekerjaan_wali','whatsapp'] as $col) {
                if (Schema::hasColumn('mahasiswas', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
