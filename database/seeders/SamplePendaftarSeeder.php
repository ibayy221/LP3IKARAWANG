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
                'no_tlp' => '081234567890',
                'id_program_studi' => 1,
                'sumber_pendaftaran' => 'offline',
                'marketing_notes' => 'Sudah dihubungi via WA',
                'status_verifikasi' => 'pending',
                'payment_status' => 'unpaid'
            ]
        );
    }
}
