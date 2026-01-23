<?php

namespace App\Helpers;

class JurusanHelper
{
    /**
     * Konversi singkatan jurusan menjadi nama lengkap
     * 
     * @param string|null $jurusan
     * @return string
     */
    public static function getNamaLengkap(?string $jurusan = null): string
    {
        if (!$jurusan) {
            return '-';
        }

        $jurusanMap = [
            'AIS' => 'Accounting Information System',
            'ASE' => 'Application Software Engineering',
            'OAA' => 'Office Administration Automatization',
        ];

        return $jurusanMap[strtoupper($jurusan)] ?? $jurusan;
    }

    /**
     * Konversi singkatan jurusan menjadi format "SINGKATAN (Nama Lengkap)"
     * 
     * @param string|null $jurusan
     * @return string
     */
    public static function getFormat(?string $jurusan = null): string
    {
        if (!$jurusan) {
            return '-';
        }

        $jurusanUpper = strtoupper($jurusan);
        $namaLengkap = self::getNamaLengkap($jurusan);

        if ($namaLengkap === $jurusan) {
            // Jika tidak ditemukan mapping, return seperti biasa
            return $namaLengkap;
        }

        return "{$jurusanUpper} ({$namaLengkap})";
    }
}
