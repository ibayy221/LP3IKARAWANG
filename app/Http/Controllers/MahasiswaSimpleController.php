<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaSimpleController extends Controller
{
    public function insertDummy()
    {
        // Insert data ke tabel mahasiswa dengan field sesuai database
        DB::table('mahasiswa')->insert([
            'nipd' => 'DUMMY123',
            'nama_mhs' => 'Dummy Mahasiswa',
            'alamat' => 'Jl. Dummy No.1',
            'domisili' => 'Karawang',
            'email' => 'dummy@email.com',
            'no_tlp' => '08123456789',
            'tempat_lahir' => 'Karawang',
            'tgl_lahir' => '2000-01-01',
            'angkatan' => '2026',
            'periode' => 'Genap',
            'agama' => 'Islam',
            'tahun_lulus' => '2025',
            'kecamatan' => 'Karawang Barat',
            'desa' => 'Purwadana',
            'kode_pos' => '41361',
            'jenis_kelamin' => 'Laki-laki',
            'jenis_kelas' => 'Reguler',
            'status_verifikasi' => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => '',
            'payment_proof_path' => '',
            'payment_bank_origin' => '',
            'payment_account_name' => '',
            'payment_sender_name' => '',
            'payment_transfer_date' => '',
            'payment_expires_at' => '',
            'payment_amount' => '350000',
            'asal_sekolah' => 'SMA Dummy',
            'file_path' => '',
            'ktp_path' => '',
            'akte_kelahiran_path' => '',
            'ijazah_path' => '',
            'surat_sudah_bekerja_path' => '',
            'instagram_path' => '',
            'nama_wali' => 'Dummy Wali',
            'telp_wali' => '08123456789',
            'pekerjaan_wali' => 'Karyawan',
            'whatsapp_wali' => '08123456789',
            'foto' => '',
            'status' => 'aktif',
            'id_user' => null,
            'id_program_studi' => null,
            'id_kelas' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return 'Data dummy mahasiswa berhasil ditambahkan!';
    }
}
