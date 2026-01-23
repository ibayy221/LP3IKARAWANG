<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    use HasFactory;

    protected $table = 'struktur_organisasis';

    protected $fillable = [
        'nama',
        'role',
        'foto',
        'posisi',
        'parent_id',
        'urutan',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship ke parent (untuk staff yang punya parent)
    public function parent()
    {
        return $this->belongsTo(StrukturOrganisasi::class, 'parent_id');
    }

    // Relationship ke children (untuk role head yang punya subordinates)
    public function children()
    {
        return $this->hasMany(StrukturOrganisasi::class, 'parent_id');
    }

    // Scope untuk mendapatkan data yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk mendapatkan data berdasarkan posisi
    public function scopeByPosisi($query, $posisi)
    {
        return $query->where('posisi', $posisi);
    }
}
