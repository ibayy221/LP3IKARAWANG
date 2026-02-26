<?php

namespace App\Helpers;

class JurusanHelper
{
    private static function codeFromProgramId(int $id): ?string
    {
        return match ($id) {
            1 => 'ASE',
            2 => 'AIS',
            3 => 'OAA',
            default => null,
        };
    }

    private static function normalizeJurusanCode(string|int|null $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_int($value)) {
            return self::codeFromProgramId($value);
        }

        $trim = trim((string) $value);
        if ($trim === '') {
            return null;
        }

        if (ctype_digit($trim)) {
            return self::codeFromProgramId((int) $trim);
        }

        return strtoupper($trim);
    }

    /**
     * Konversi singkatan jurusan menjadi nama lengkap
     * 
     * @param string|int|null $jurusan
     * @return string
     */
    public static function getNamaLengkap(string|int|null $jurusan = null): string
    {
        $jurusanCode = self::normalizeJurusanCode($jurusan);
        if (!$jurusanCode) {
            return '-';
        }

        $jurusanMap = [
            'AIS' => 'Accounting Information System',
            'ASE' => 'Application Software Engineering',
            'OAA' => 'Office Administration Automatization',
        ];

        return $jurusanMap[$jurusanCode] ?? $jurusanCode;
    }

    /**
     * Konversi singkatan jurusan menjadi format "SINGKATAN (Nama Lengkap)"
     * 
     * @param string|int|null $jurusan
     * @return string
     */
    public static function getFormat(string|int|null $jurusan = null): string
    {
        $jurusanCode = self::normalizeJurusanCode($jurusan);
        if (!$jurusanCode) {
            return '-';
        }

        $namaLengkap = self::getNamaLengkap($jurusanCode);

        if ($namaLengkap === $jurusanCode) {
            // Jika tidak ditemukan mapping, return seperti biasa
            return $namaLengkap;
        }

        return "{$jurusanCode} ({$namaLengkap})";
    }
}
