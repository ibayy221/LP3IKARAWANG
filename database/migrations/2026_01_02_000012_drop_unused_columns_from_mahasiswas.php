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
            $cols = ['NIK_mahasiswa','sumber_pendaftaran','tahun_lulus','tempat_lahir','tgl_lahir','jenis_sekolah','kategori_sekolah'];
            $existing = array_intersect($cols, Schema::getColumnListing('mahasiswas'));
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
        Schema::table('mahasiswas', function (Blueprint $table) {
            // Recreate columns with nullable defaults. Adjust types conservatively.
            if (!Schema::hasColumn('mahasiswas', 'NIK_mahasiswa')) {
                $table->string('NIK_mahasiswa')->nullable()->after('nama_mhs');
            }
            if (!Schema::hasColumn('mahasiswas', 'sumber_pendaftaran')) {
                $table->string('sumber_pendaftaran')->nullable()->after('kode_pos');
            }
            if (!Schema::hasColumn('mahasiswas', 'tahun_lulus')) {
                $table->string('tahun_lulus')->nullable()->after('jurusan');
            }
            if (!Schema::hasColumn('mahasiswas', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('mahasiswas', 'tgl_lahir')) {
                $table->date('tgl_lahir')->nullable()->after('tempat_lahir');
            }
            if (!Schema::hasColumn('mahasiswas', 'jenis_sekolah')) {
                $table->string('jenis_sekolah')->nullable()->after('jenis_kelamin');
            }
            if (!Schema::hasColumn('mahasiswas', 'kategori_sekolah')) {
                $table->string('kategori_sekolah')->nullable()->after('jenis_sekolah');
            }
        });
    }
};
