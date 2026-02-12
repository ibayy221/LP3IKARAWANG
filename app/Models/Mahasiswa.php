<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';

    protected $fillable = [
        'user_id', 'nipd', 'nama_mhs', 'email', 'no_hp', 'jurusan', 'tahun_lulus', 'alamat', 'kecamatan',
        'tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'jenis_sekolah', 'kategori_sekolah', 'jenis_kelas',
        'status_verifikasi', 'payment_status', 'payment_amount', 'payment_method', 'payment_proof_path', 'payment_bank_origin', 'payment_account_name', 'payment_sender_name', 'payment_transfer_date', 'payment_expires_at', 'asal_sekolah', 'file_path', 'desa', 'kode_pos', 'marketing_notes', 'agama', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // Generate a NIPD for a given jurusan using config/nipd.php
    public static function generateNipd(?string $jurusan = null): string
    {
        // Use branch_code but replace the leading year portion with the current year (2-digit)
        // so NIPD reflects the actual year automatically.
        $branchCfg = config('nipd.branch_code', '240781');
        $currentYearTwo = date('y');
        // if branch code is at least 2 chars, replace its first two chars with current year two-digit
        $branch = strlen($branchCfg) >= 2 ? ($currentYearTwo . substr($branchCfg, 2)) : $branchCfg;
        $programCodes = config('nipd.program_codes', []);
        $seqDigits = (int) config('nipd.sequence_digits', 4);
        $programKey = strtoupper($jurusan ?? '');
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
     * Try to find a recent duplicate based on email or phone and same jurusan within a short window.
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
            if (!empty($attrs['no_hp'])) {
                $q->orWhere('no_hp', $attrs['no_hp']);
            }
        });

        if (!empty($attrs['jurusan'])) {
            $query->where('jurusan', $attrs['jurusan']);
        }

        return $query->orderByDesc('id')->first();
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->nipd)) {
                // attempt to set nipd using generateNipd
                $model->nipd = self::generateNipd($model->jurusan ?? null);
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
                $attrs['nipd'] = self::generateNipd($attrs['jurusan'] ?? null);
            }

            try {
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

