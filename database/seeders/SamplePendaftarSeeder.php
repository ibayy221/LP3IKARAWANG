<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;

class SamplePendaftarSeeder extends Seeder
{
    public function run()
    {
        Mahasiswa::firstOrCreate(
            ['email' => 'offline1@example.com'],
            [
                'nama_mhs' => 'Offline Test 1',
                'no_hp' => '081234567890',
                'jurusan' => 'Manajemen Informatika',
                'sumber_pendaftaran' => 'offline',
                'marketing_notes' => 'Sudah dihubungi via WA',
                'status_verifikasi' => 'pending',
                'payment_status' => 'unpaid'
            ]
        );
    }
}
