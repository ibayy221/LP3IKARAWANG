<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesaSeeder extends Seeder
{
    public function run(): void
    {
        // Minimal sample desa for selected kecamatan in Karawang
        $map = [
            'Karawang Barat' => [
                ['name' => 'Karawang', 'kode_pos' => '41311'],
                ['name' => 'Talagasari', 'kode_pos' => '41312'],
                ['name' => 'Kotabaru', 'kode_pos' => '41317'],
            ],
            'Karawang Timur' => [
                ['name' => 'Tanjungpura', 'kode_pos' => '41314'],
                ['name' => 'Mekarbaru', 'kode_pos' => '41313'],
                ['name' => 'Munduwangi', 'kode_pos' => '41315'],
            ],
            'Klari' => [
                ['name' => 'Klari', 'kode_pos' => '41371'],
                ['name' => 'Cilamaya', 'kode_pos' => '41372'],
            ],
            'Ciampel' => [
                ['name' => 'Jatisari', 'kode_pos' => '41351'],
                ['name' => 'Prenggan', 'kode_pos' => '41352'],
            ],
            'Cikampek' => [
                ['name' => 'Cikampek Barat', 'kode_pos' => '41372'],
                ['name' => 'Cikampek Timur', 'kode_pos' => '41373'],
            ],
            'Telukjambe Barat' => [
                ['name' => 'Industri', 'kode_pos' => '41361'],
            ],
            'Jayakerta' => [
                ['name' => 'Jayakerta', 'kode_pos' => '41364'],
            ],
            'Batujaya' => [
                ['name' => 'Batujaya', 'kode_pos' => '41362'],
            ],
            'Pedes' => [
                ['name' => 'Pedes', 'kode_pos' => '41363'],
            ],
            'Purwasari' => [
                ['name' => 'Purwasari', 'kode_pos' => '41354'],
            ],
            'Rengasdengklok' => [
                ['name' => 'Rengasdengklok', 'kode_pos' => '41372'],
            ],
            'Tempuran' => [
                ['name' => 'Tempuran', 'kode_pos' => '41381'],
            ],
            'Lemahabang' => [
                ['name' => 'Lemahabang', 'kode_pos' => '41379'],
            ],
            'Majalaya' => [
                ['name' => 'Majalaya', 'kode_pos' => '41391'],
            ],
            'Pakisjaya' => [
                ['name' => 'Pakisjaya', 'kode_pos' => '41392'],
            ],
            // Add more mappings as needed — keep sample small for now
        ];

        foreach ($map as $kecName => $desas) {
            // find kecamatan id
            $kecamatan = DB::table('kecamatans')->where('name', $kecName)->first();
            $kecamatan_id = $kecamatan ? $kecamatan->id : null;

            foreach ($desas as $desa) {
                DB::table('desas')->updateOrInsert([
                    'kecamatan_id' => $kecamatan_id,
                    'name' => $desa['name']
                ], [
                    'kode_pos' => $desa['kode_pos'],
                ]);
            }
        }
    }
}

