<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_mahasiswa';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_mahasiswa', 'nipd', 'nama_mhs', 'alamat', 'domisili', 'tempat_lahir', 'tgl_lahir', 'angkatan', 'periode',
        'email', 'agama', 'no_tlp', 'tahun_lulus', 'kecamatan', 'desa', 'kode_pos', 'jenis_kelamin', 'jenis_kelas',
        'status_verifikasi', 'payment_status', 'payment_method', 'payment_proof_path', 'payment_bank_origin',
        'payment_account_name', 'payment_sender_name', 'payment_transfer_date', 'payment_expires_at', 'payment_amount',
        'asal_sekolah', 'file_path', 'ktp_path', 'akte_kelahiran_path', 'ijazah_path', 'surat_sudah_bekerja_path',
        'instagram_path', 'nama_wali', 'telp_wali', 'pekerjaan_wali', 'whatsapp_wali', 'foto', 'status',
        'id_user', 'id_program_studi', 'id_kelas'
    ];

    // Compatibility alias so older code can use $mahasiswa->id
    public function getIdAttribute()
    {
        return $this->getKey();
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_user', 'id_user');
    }

    // Generate a NIPD for a given program (numeric program id or legacy code) using config/nipd.php
    public static function generateNipd(string|int|null $program = null): string
    {
        // Use branch_code but replace the leading year portion with the current year (2-digit)
        // so NIPD reflects the actual year automatically.
        $branchCfg = config('nipd.branch_code', '240781');
        $currentYearTwo = date('y');
        // if branch code is at least 2 chars, replace its first two chars with current year two-digit
        $branch = strlen($branchCfg) >= 2 ? ($currentYearTwo . substr($branchCfg, 2)) : $branchCfg;
        $programCodes = config('nipd.program_codes', []);
        $seqDigits = (int) config('nipd.sequence_digits', 4);
        // Normalize program key: accept numeric IDs (1/2/3) or legacy codes (ASE/AIS/OAA)
        $programKey = '';
        if (is_int($program)) {
            $programKey = match ($program) {
                1 => 'ASE',
                2 => 'AIS',
                3 => 'OAA',
                default => '',
            };
        } else {
            $trim = trim((string) ($program ?? ''));
            if (ctype_digit($trim)) {
                $n = (int) $trim;
                $programKey = match ($n) {
                    1 => 'ASE',
                    2 => 'AIS',
                    3 => 'OAA',
                    default => '',
                };
            } else {
                $programKey = strtoupper($trim);
            }
        }
        $deptCode = $programCodes[$programKey] ?? '000';
        $prefix = $branch . $deptCode;

        // Find current max sequence for this prefix using a database query on nipd
        $max = self::where('nipd', 'like', $prefix . '%')
            ->selectRaw("MAX(CAST(SUBSTRING(nipd, -$seqDigits) AS UNSIGNED)) as max_seq")
            ->value('max_seq');

        $next = ((int)$max) + 1;
        $sequence = str_pad((string)$next, $seqDigits, '0', STR_PAD_LEFT);

        return $prefix . $sequence;
    }

    /**
        * Try to find a recent duplicate based on email or phone within a short window.
     * Returns the Mahasiswa model if found, otherwise null.
     */
    public static function findRecentDuplicate(array $attrs, ?int $minutes = 10)
    {
        $query = self::query();

        if ($minutes !== null) {
            $now = \Carbon\Carbon::now();
            $since = $now->subMinutes($minutes);
            $query->where('created_at', '>=', $since);
        }

        $query->where(function($q) use ($attrs) {
            if (!empty($attrs['email'])) {
                $q->orWhere('email', $attrs['email']);
            }
            if (!empty($attrs['no_tlp'])) {
                $q->orWhere('no_tlp', $attrs['no_tlp']);
            }
        });

        // Jika ingin lebih spesifik, tambahkan pengecekan lain di sini

        return $query->orderByDesc('id_mahasiswa')->first();
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $status = trim(strtolower((string) ($model->status_verifikasi ?? '')));
            if ($status === 'verified' && empty($model->nipd)) {
                $model->nipd = self::generateNipd(
                    $model->id_program_studi ?? ($model->id_program_study ?? null)
                );
            }
        });

        static::updating(function ($model) {
            if (!$model->isDirty('status_verifikasi')) {
                return;
            }

            $status = trim(strtolower((string) ($model->status_verifikasi ?? '')));
            if ($status === 'verified' && empty($model->nipd)) {
                $model->nipd = self::generateNipd(
                    $model->id_program_studi ?? ($model->id_program_study ?? null)
                );
            }
        });
    }

    /**
     * Create a Mahasiswa with automatic NIPD generation and retry on NIPD collisions.
     * This helps avoid race conditions where two concurrent requests generate the same NIPD.
     *
     * @param array $attrs
     * @param int $maxAttempts
     * @return self
     * @throws \Throwable
     */
    public static function createWithUniqueNipd(array $attrs, int $maxAttempts = 5): self
    {
        $attempt = 0;
        do {
            $attempt++;
            // Ensure NIPD is present for this attempt. Leave it empty to let booted() hook generate it if desired.
            if (empty($attrs['nipd'])) {
                $attrs['nipd'] = self::generateNipd($attrs['id_program_studi'] ?? ($attrs['id_program_study'] ?? null));
            }

            try {
                // Pastikan domisili selalu ada
                if (!array_key_exists('domisili', $attrs)) {
                    $attrs['domisili'] = '';
                }
                return self::create($attrs);
            } catch (\Illuminate\Database\QueryException $e) {
                $msg = strtolower($e->getMessage());
                // Detect NIPD-specific unique constraint failure (SQLite message, MySQL, PostgreSQL variants)
                if (str_contains($msg, 'nipd') || str_contains($msg, 'mahasiswas_nipd') || str_contains($msg, 'mahasiswas.nipd')) {
                    \Illuminate\Support\Facades\Log::warning('NIPD collision detected, retrying create', ['attempt' => $attempt, 'error' => $e->getMessage()]);
                    // Remove nipd so next loop generates a fresh one
                    unset($attrs['nipd']);
                    if ($attempt >= $maxAttempts) {
                        // give up and rethrow the DB exception
                        throw $e;
                    }
                    // small backoff to reduce thundering herd in very tight loops
                    usleep(100000); // 100ms
                    continue;
                }
                // Not a NIPD collision — rethrow
                throw $e;
            }
        } while ($attempt <= $maxAttempts);

        throw new \RuntimeException("Failed to create Mahasiswa after {$maxAttempts} attempts due to NIPD collisions.");
    }
}

