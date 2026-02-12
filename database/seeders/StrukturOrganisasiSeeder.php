<?php

namespace Database\Seeders;

use App\Models\StrukturOrganisasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StrukturOrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama
        StrukturOrganisasi::truncate();

        // Tambahkan Director
        StrukturOrganisasi::create([
            'nama' => 'Aceng Ajat, S.T., M.M.',
            'role' => 'Branch Manager',
            'foto' => null,
            'posisi' => 'director',
            'urutan' => 0,
            'is_active' => true,
        ]);

        // Tambahkan Secretary
        StrukturOrganisasi::create([
            'nama' => 'Diba Prajamitha Aziiz, S.Hum.,M.A.',
            'role' => 'Coorporate Secretary',
            'foto' => null,
            'posisi' => 'secretary',
            'urutan' => 0,
            'is_active' => true,
        ]);

        // Tambahkan Staff (Department Heads)
        $staffs = [
            [
                'nama' => 'Eko Marmanto, S.Kom.,M.Kom. ,MOS.,CDMP.',
                'role' => 'Head of Education & IT Department',
                'urutan' => 1,
            ],
            [
                'nama' => 'Asri Rizki Kurnia, S.E.',
                'role' => 'Head of C&P / HRGA Department',
                'urutan' => 2,
            ],
            [
                'nama' => 'Maghfira Fikrandita, A.Md.',
                'role' => 'Head of Finance Department',
                'urutan' => 3,
            ],
            [
                'nama' => 'Rahadian Dwimaribbi, S.Kom.',
                'role' => 'Head of Marketing',
                'urutan' => 4,
            ],
        ];

        foreach ($staffs as $staff) {
            StrukturOrganisasi::create([
                'nama' => $staff['nama'],
                'role' => $staff['role'],
                'foto' => null,
                'posisi' => 'staff',
                'urutan' => $staff['urutan'],
                'is_active' => true,
            ]);
        }
    }
}
