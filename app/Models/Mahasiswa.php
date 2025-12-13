<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';

    protected $fillable = [
        'nama_mhs', 'email', 'no_hp', 'jurusan', 'tahun_lulus', 'alamat', 'kecamatan',
        'tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'jenis_sekolah', 'kategori_sekolah',
        'status_verifikasi', 'asal_sekolah', 'file_path', 'desa', 'kode_pos'
    ];
}
