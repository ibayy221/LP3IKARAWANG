<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswas', 'ijazah_path')) {
                $table->string('ijazah_path')->nullable()->after('ktp_path');
            }
            if (!Schema::hasColumn('mahasiswas', 'akte_kelahiran_path')) {
                $table->string('akte_kelahiran_path')->nullable()->after('ijazah_path');
            }
            if (!Schema::hasColumn('mahasiswas', 'surat_sudah_bekerja_path')) {
                $table->string('surat_sudah_bekerja_path')->nullable()->after('akte_kelahiran_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (Schema::hasColumn('mahasiswas', 'surat_sudah_bekerja_path')) {
                $table->dropColumn('surat_sudah_bekerja_path');
            }
            if (Schema::hasColumn('mahasiswas', 'akte_kelahiran_path')) {
                $table->dropColumn('akte_kelahiran_path');
            }
            if (Schema::hasColumn('mahasiswas', 'ijazah_path')) {
                $table->dropColumn('ijazah_path');
            }
        });
    }
};
