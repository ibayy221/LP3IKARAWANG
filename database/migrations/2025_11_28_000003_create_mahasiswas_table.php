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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->bigIncrements('id_mahasiswa');
            $table->string('nipd', 255)->nullable();
            $table->string('nama_mhs', 255);
            $table->text('alamat')->nullable();
            $table->string('domisili', 255)->nullable();
            $table->string('tempat_lahir', 255)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('angkatan', 255)->nullable();
            $table->string('periode', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('agama', 255)->nullable();
            $table->string('no_tlp', 255)->nullable();
            $table->string('tahun_lulus', 255)->nullable();
            $table->string('kecamatan', 255)->nullable();
            $table->string('desa', 255)->nullable();
            $table->string('kode_pos', 255)->nullable();
            $table->string('jenis_kelamin', 255)->nullable();
            $table->string('jenis_kelas', 255)->nullable();
            $table->string('status_verifikasi', 255)->nullable();
            $table->string('payment_status', 255)->nullable();
            $table->string('payment_method', 255)->nullable();
            $table->string('payment_proof_path', 255)->nullable();
            $table->string('payment_bank_origin', 255)->nullable();
            $table->string('payment_account_name', 255)->nullable();
            $table->string('payment_sender_name', 255)->nullable();
            $table->string('payment_transfer_date', 255)->nullable();
            $table->string('payment_expires_at', 255)->nullable();
            $table->string('payment_amount', 255)->nullable();
            $table->string('asal_sekolah', 255)->nullable();
            $table->string('file_path', 255)->nullable();
            $table->string('ktp_path', 255)->nullable();
            $table->string('akte_kelahiran_path', 255)->nullable();
            $table->string('ijazah_path', 255)->nullable();
            $table->string('surat_sudah_bekerja_path', 255)->nullable();
            $table->string('instagram_path', 255)->nullable();
            $table->string('nama_wali', 255)->nullable();
            $table->string('telp_wali', 255)->nullable();
            $table->string('pekerjaan_wali', 255)->nullable();
            $table->string('whatsapp_wali', 255)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_program_studi')->nullable();
            $table->unsignedBigInteger('id_kelas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
