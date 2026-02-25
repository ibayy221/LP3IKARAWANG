<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswa', 'ktp_path')) {
                $table->string('ktp_path')->nullable()->after('file_path');
            }
            if (!Schema::hasColumn('mahasiswa', 'instagram_path')) {
                $table->string('instagram_path')->nullable()->after('ktp_path');
            }
            if (!Schema::hasColumn('mahasiswa', 'nama_wali')) {
                $table->string('nama_wali')->nullable()->after('instagram_path');
            }
            if (!Schema::hasColumn('mahasiswa', 'telp_wali')) {
                $table->string('telp_wali')->nullable()->after('nama_wali');
            }
            if (!Schema::hasColumn('mahasiswa', 'pekerjaan_wali')) {
                $table->string('pekerjaan_wali')->nullable()->after('telp_wali');
            }
            if (!Schema::hasColumn('mahasiswa', 'whatsapp_wali')) {
                $table->string('whatsapp_wali')->nullable()->after('pekerjaan_wali');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            foreach (['ktp_path','instagram_path','nama_wali','telp_wali','pekerjaan_wali','whatsapp_wali'] as $col) {
                if (Schema::hasColumn('mahasiswa', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
