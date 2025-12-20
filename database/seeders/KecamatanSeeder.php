<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatans = [
            'Karawang Barat', 'Karawang Timur', 'Klari', 'Pedes', 'Pakisjaya', 'Majalaya', 'Telukjambe Barat', 'Telukjambe Timur',
            'Lemahabang', 'Jayakerta', 'Batujaya', 'Rawamerta', 'Cilamaya Wetan', 'Cilamaya Kulon', 'Cikampek', 'Purwasari',
            'Ciampel', 'Rengasdengklok', 'Tempuran'
        ];

        foreach ($kecamatans as $name) {
            DB::table('kecamatans')->updateOrInsert(['name' => $name], ['name' => $name]);
        }
    }
}

