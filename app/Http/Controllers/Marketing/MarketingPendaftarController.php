<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Helpers\JurusanHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MarketingPendaftarController extends Controller
{
    private function normalizeProgramId(mixed $value): ?int
    {
        if ($value === null || $value === '') return null;

        $trim = trim((string) $value);
        if ($trim === '') return null;

        if (ctype_digit($trim)) {
            $n = (int) $trim;
            return in_array($n, [1, 2, 3], true) ? $n : null;
        }

        $code = strtoupper($trim);
        return match ($code) {
            'ASE' => 1,
            'AIS' => 2,
            'OAA' => 3,
            default => null,
        };
    }

    private function programCodeFromId(?int $id): string
    {
        return match ((int) $id) {
            1 => 'ASE',
            2 => 'AIS',
            3 => 'OAA',
            default => '',
        };
    }

    public function dashboard()
    {
        // Compute simple statistics for dashboard
        $total = Mahasiswa::count();
        $programTerbanyak = Mahasiswa::select('id_program_studi', DB::raw('count(*) as cnt'))
            ->whereNotNull('id_program_studi')
            ->groupBy('id_program_studi')
            ->orderByDesc('cnt')
            ->pluck('id_program_studi')
            ->first();
        $pendaftarToday = Mahasiswa::whereDate('created_at', \Carbon\Carbon::today())->count();

        return view('marketing.dashboard', [
            'totalPendaftar' => $total,
            'jurusanTerbanyak' => $programTerbanyak ? JurusanHelper::getFormat((int) $programTerbanyak) : '-',
            'pendaftarToday' => $pendaftarToday,
        ]);
    }

    public function index()
    {
        // read registration image setting for background (reuse MahasiswaController logic)
        $registrationImage = null;
        $settingsFile = public_path('data/settings.csv');
        if (file_exists($settingsFile) && ($handle = fopen($settingsFile, 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) === count($header)) {
                    $entry = array_combine($header, $row);
                    if (($entry['key'] ?? '') === 'registration_image') {
                        $registrationImage = $entry['value'] ?? null;
                        break;
                    }
                }
            }
            fclose($handle);
        }
        $registrationImageUrl = null;
        if (!empty($registrationImage)) {
            if (preg_match('#^https?://#i', $registrationImage)) {
                $registrationImageUrl = $registrationImage;
            } else {
                $registrationImageUrl = '/' . ltrim($registrationImage, '/');
            }
        }

        // Fetch distinct program IDs for the filter dropdown
        $jurusans = Mahasiswa::select('id_program_studi')
            ->whereNotNull('id_program_studi')
            ->distinct()
            ->orderBy('id_program_studi')
            ->pluck('id_program_studi')
            ->values();

        return view('marketing.pendaftar.index', compact('registrationImageUrl','jurusans'));
    }

    public function list(Request $request)
    {
        $q = $request->input('q');
        $status = $request->input('status');
        $jurusan = $this->normalizeProgramId($request->input('jurusan'));

        $query = Mahasiswa::query();
        if ($q) {
            $query->where(function($qr) use ($q){
                $qr->where('nama_mhs', 'like', "%{$q}%")->orWhere('email','like',"%{$q}%");
            });
        }
        if ($status) {
            $query->where('status_verifikasi', $status);
        }
        if ($jurusan) {
            $query->where('id_program_studi', $jurusan);
        }

        $data = $query
            ->orderBy('created_at', 'desc')
            ->get([
                'id_mahasiswa',
                'nama_mhs',
                'email',
                'nipd',
                'no_tlp',
                'id_program_studi',
                'status_verifikasi',
                'created_at',
            ])
            ->map(function ($r) {
                $programId = $r->id_program_studi ? (int) $r->id_program_studi : null;
                return [
                    'id' => $r->id_mahasiswa,
                    'nama_mhs' => $r->nama_mhs,
                    'email' => $r->email,
                    'nipd' => $r->nipd,
                    'no_hp' => $r->no_tlp,
                    'id_program_studi' => $r->id_program_studi,
                    // keep legacy key used by frontend
                    'jurusan' => $this->programCodeFromId($programId),
                    // preferred label for display (no abbreviation)
                    'jurusan_label' => JurusanHelper::getNamaLengkap($programId),
                    'status_verifikasi' => $r->status_verifikasi,
                    'created_at' => $r->created_at,
                ];
            })
            ->values();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function create()
    {
        // registration image
        $registrationImage = null;
        $settingsFile = public_path('data/settings.csv');
        if (file_exists($settingsFile) && ($handle = fopen($settingsFile, 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) === count($header)) {
                    $entry = array_combine($header, $row);
                    if (($entry['key'] ?? '') === 'registration_image') {
                        $registrationImage = $entry['value'] ?? null;
                        break;
                    }
                }
            }
            fclose($handle);
        }
        $registrationImageUrl = null;
        if (!empty($registrationImage)) {
            if (preg_match('#^https?://#i', $registrationImage)) {
                $registrationImageUrl = $registrationImage;
            } else {
                $registrationImageUrl = '/' . ltrim($registrationImage, '/');
            }
        }

        return view('marketing.pendaftar.create', compact('registrationImageUrl'));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'nama_mhs' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_hp' => 'nullable|string|max:50',
            'id_program_studi' => 'nullable|integer|in:1,2,3',
            // legacy name used by older forms
            'jurusan' => 'nullable',
            'jenis_kelas' => 'nullable|string|max:50',
            'asal_sekolah' => 'nullable|string|max:255'
        ]);
        $v['status_verifikasi'] = $v['status_verifikasi'] ?? 'pending';

        // normalize payload to actual DB columns
        if (!empty($v['no_hp']) && empty($v['no_tlp'])) {
            $v['no_tlp'] = $v['no_hp'];
        }
        unset($v['no_hp']);

        if (empty($v['id_program_studi'])) {
            $v['id_program_studi'] = $this->normalizeProgramId($request->input('jurusan'));
        }
        unset($v['jurusan']);

        // Prevent accidental duplicates when marketing adds pendaftar manually
        $duplicate = null;
        try {
            $duplicate = Mahasiswa::findRecentDuplicate($v, null);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Marketing duplicate check failed: '.$e->getMessage());
        }

        if ($duplicate) {
            return redirect()->route('marketing.pendaftar.show', $duplicate->getKey())->with('success','Pendaftar sudah ada — membuka data yang tersedia.');
        }

        try {
            // NIPD dibuat saat verifikasi (status_verifikasi=verified)
            $m = Mahasiswa::create($v);
        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos(strtolower($e->getMessage()), 'duplicate') !== false || $e->getCode() === '23000') {
                $existing = Mahasiswa::findRecentDuplicate($v, null);
                if ($existing) {
                    return redirect()->route('marketing.pendaftar.show', $existing->getKey())->with('success','Pendaftar sudah ada — membuka data yang tersedia.');
                }
            }
            throw $e;
        }

        return redirect()->route('marketing.pendaftar.show', $m->getKey())->with('success','Calon mahasiswa ditambahkan.');
    }

    public function show($id)
    {
        $m = Mahasiswa::findOrFail($id);

        // registration image
        $registrationImage = null;
        $settingsFile = public_path('data/settings.csv');
        if (file_exists($settingsFile) && ($handle = fopen($settingsFile, 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) === count($header)) {
                    $entry = array_combine($header, $row);
                    if (($entry['key'] ?? '') === 'registration_image') {
                        $registrationImage = $entry['value'] ?? null;
                        break;
                    }
                }
            }
            fclose($handle);
        }
        $registrationImageUrl = null;
        if (!empty($registrationImage)) {
            if (preg_match('#^https?://#i', $registrationImage)) {
                $registrationImageUrl = $registrationImage;
            } else {
                $registrationImageUrl = '/' . ltrim($registrationImage, '/');
            }
        }

        return view('marketing.pendaftar.show', compact('m','registrationImageUrl'));
    }

    /**
     * Download KTP file for a given pendaftar (marketing use).
     */
    public function downloadKtp($id)
    {
        $m = Mahasiswa::findOrFail($id);
        if (empty($m->ktp_path)) {
            return redirect()->back()->with('error','Dokumen KTP tidak ditemukan untuk pendaftar ini.');
        }

        // Normalize stored path to a storage/public relative path like 'ktp/filename.ext'
        $rel = $m->ktp_path;
        $rel = preg_replace('#^/storage/#', '', $rel);
        $rel = preg_replace('#^public/#', '', $rel);
        $rel = ltrim($rel, '/');

        // Try public disk first (storage/app/public)
        if (Storage::disk('public')->exists($rel)) {
            $full = Storage::disk('public')->path($rel);
            return response()->download($full, basename($full));
        }

        // Fall back to local disk where uploaded files may have been stored under 'public/ktp' inside private root
        $localRel = 'public/' . ltrim($rel, '/');
        if (Storage::disk('local')->exists($localRel)) {
            $full = Storage::disk('local')->path($localRel);
            return response()->download($full, basename($full));
        }

        return redirect()->back()->with('error','File KTP tidak ditemukan di server.');
    }

    /**
     * Download Ijazah file for a given pendaftar (marketing use).
     */
    public function downloadIjazah($id)
    {
        $m = Mahasiswa::findOrFail($id);
        if (empty($m->ijazah_path)) {
            return redirect()->back()->with('error','Dokumen Ijazah tidak ditemukan untuk pendaftar ini.');
        }
        $rel = $m->ijazah_path;
        $rel = preg_replace('#^/storage/#', '', $rel);
        $rel = preg_replace('#^public/#', '', $rel);
        $rel = ltrim($rel, '/');
        if (Storage::disk('public')->exists($rel)) {
            $full = Storage::disk('public')->path($rel);
            return response()->download($full, basename($full));
        }
        $localRel = 'public/' . ltrim($rel, '/');
        if (Storage::disk('local')->exists($localRel)) {
            $full = Storage::disk('local')->path($localRel);
            return response()->download($full, basename($full));
        }
        return redirect()->back()->with('error','File Ijazah tidak ditemukan di server.');
    }

    public function downloadAkte($id)
    {
        $m = Mahasiswa::findOrFail($id);
        if (empty($m->akte_kelahiran_path)) {
            return redirect()->back()->with('error','Dokumen Akte Kelahiran tidak ditemukan untuk pendaftar ini.');
        }
        $rel = $m->akte_kelahiran_path;
        $rel = preg_replace('#^/storage/#', '', $rel);
        $rel = preg_replace('#^public/#', '', $rel);
        $rel = ltrim($rel, '/');
        if (Storage::disk('public')->exists($rel)) {
            $full = Storage::disk('public')->path($rel);
            return response()->download($full, basename($full));
        }
        $localRel = 'public/' . ltrim($rel, '/');
        if (Storage::disk('local')->exists($localRel)) {
            $full = Storage::disk('local')->path($localRel);
            return response()->download($full, basename($full));
        }
        return redirect()->back()->with('error','File Akte Kelahiran tidak ditemukan di server.');
    }

    public function downloadSuratBekerja($id)
    {
        $m = Mahasiswa::findOrFail($id);
        if (empty($m->surat_sudah_bekerja_path)) {
            return redirect()->back()->with('error','Dokumen Surat belum ditemukan untuk pendaftar ini.');
        }
        $rel = $m->surat_sudah_bekerja_path;
        $rel = preg_replace('#^/storage/#', '', $rel);
        $rel = preg_replace('#^public/#', '', $rel);
        $rel = ltrim($rel, '/');
        if (Storage::disk('public')->exists($rel)) {
            $full = Storage::disk('public')->path($rel);
            return response()->download($full, basename($full));
        }
        $localRel = 'public/' . ltrim($rel, '/');
        if (Storage::disk('local')->exists($localRel)) {
            $full = Storage::disk('local')->path($localRel);
            return response()->download($full, basename($full));
        }
        return redirect()->back()->with('error','File Surat belum ditemukan di server.');
    }

    public function updateNote(Request $request, $id)
    {
        $m = Mahasiswa::findOrFail($id);
        $m->marketing_notes = $request->input('marketing_notes');
        $m->save();
        return redirect()->back()->with('success','Catatan diperbarui.');
    }

    public function exportCsv(Request $request)
    {
        $q = $request->input('q');
        $status = $request->input('status');
        $jurusan = $this->normalizeProgramId($request->input('jurusan'));
        $query = Mahasiswa::query();
        if ($q) {
            $query->where(function($qr) use ($q){ $qr->where('nama_mhs','like',"%{$q}%")->orWhere('email','like',"%{$q}%"); });
        }
        if ($status) $query->where('status_verifikasi',$status);
        if ($jurusan) $query->where('id_program_studi',$jurusan);
        $rows = $query->orderBy('created_at','desc')->get();

        $filename = 'pendaftar_export_'.date('Ymd_His').'.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}"
        ];

        // keep legacy column headers that the UI expects
        $columns = ['id','nama_mhs','email','no_hp','jurusan','status_verifikasi','payment_status','payment_amount','marketing_notes','created_at'];
        $callback = function() use ($rows, $columns) {
            $f = fopen('php://output','w');
            fputcsv($f,$columns);
            foreach($rows as $r) {
                $mapped = [
                    'id' => $r->id_mahasiswa,
                    'nama_mhs' => $r->nama_mhs,
                    'email' => $r->email,
                    'no_hp' => $r->no_tlp,
                    'jurusan' => $this->programCodeFromId($r->id_program_studi ? (int) $r->id_program_studi : null),
                    'status_verifikasi' => $r->status_verifikasi,
                    'payment_status' => $r->payment_status,
                    'payment_amount' => $r->payment_amount,
                    'marketing_notes' => $r->marketing_notes,
                    'created_at' => $r->created_at,
                ];
                $line = array_map(function($c) use ($mapped) { return $mapped[$c] ?? ''; }, $columns);
                fputcsv($f,$line);
            }
            fclose($f);
        };

        return response()->stream($callback,200,$headers);
    }

    public function print(Request $request)
    {
        // reuse list filters
        $q = $request->input('q');
        $status = $request->input('status');
        $jurusan = $this->normalizeProgramId($request->input('jurusan'));
        $query = Mahasiswa::query();
        if ($q) {
            $query->where(function($qr) use ($q){ $qr->where('nama_mhs','like',"%{$q}%")->orWhere('email','like',"%{$q}%"); });
        }
        if ($status) $query->where('status_verifikasi',$status);
        if ($jurusan) $query->where('id_program_studi',$jurusan);
        $rows = $query->orderBy('created_at','desc')->get();
        return view('marketing.pendaftar.print', compact('rows'));
    }

    public function updatePayment(Request $request, $id)
    {
        $m = Mahasiswa::findOrFail($id);
        $payment = $request->input('payment');
        if (!in_array($payment, ['paid','unpaid'])) {
            return response()->json(['success' => false, 'error' => 'Nilai pembayaran tidak valid']);
        }
        $m->payment_status = $payment;
        $m->save();

        // Optionally send notification if paid
        if ($payment === 'paid' && !empty($m->email)) {
            try {
                \Illuminate\Support\Facades\Mail::to($m->email)->queue(new \App\Mail\PendaftarStatusChanged($m, 'paid'));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send payment email: '.$e->getMessage());
            }
        }

        return response()->json(['success' => true, 'data' => $m]);
    }

    /**
     * Show trash — development helper. Currently lists no items unless you add soft deletes.
     */
    public function trash()
    {
        // If you later add SoftDeletes to Mahasiswa, you can change this to: Mahasiswa::onlyTrashed()->get();
        $trashed = [];
        return view('marketing.pendaftar.trash', compact('trashed'));
    }

    /**
     * Dangerous: delete all pendaftar (for development/testing only).
     * Protected by EnsureMarketing middleware and requires confirmation on the UI.
     */
    public function destroyAll(Request $request)
    {
        // A safety gate: only accept when in local or testing env, or when an explicit env var allows it
        if (!in_array(app()->environment(), ['local','testing']) && env('ALLOW_MARKETING_DELETE_ALL', false) !== true) {
            return redirect()->route('marketing.pendaftar.index')->with('error','Hapus semua tidak diizinkan pada lingkungan ini.');
        }

        \Illuminate\Support\Facades\DB::transaction(function() {
            // Hard delete all records — careful!
            \App\Models\Mahasiswa::query()->delete();
        });

        return redirect()->route('marketing.pendaftar.index')->with('success','Semua pendaftar telah dihapus.');
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        if (!in_array($status, ['pending','verified','rejected'])) {
            return response()->json(['success' => false, 'error' => 'Status tidak valid']);
        }
        $m = Mahasiswa::find($id);
        if (!$m) return response()->json(['success' => false, 'error' => 'Pendaftar tidak ditemukan']);

        // If moving to verified, assign NIPD now (with simple retry on rare collisions)
        $m->status_verifikasi = $status;
        $attempts = 0;
        $normalized = trim(strtolower((string) $status));
        while (true) {
            $attempts++;
            try {
                $m->save();
                break;
            } catch (\Illuminate\Database\QueryException $e) {
                $msg = strtolower($e->getMessage());
                if ($normalized === 'verified' && (str_contains($msg, 'nipd') || $e->getCode() === '23000') && $attempts < 5) {
                    // Force regenerate next attempt
                    $m->nipd = null;
                    continue;
                }
                throw $e;
            }
        }

        // Send notification email to applicant if email exists
        try {
            if (!empty($m->email)) {
                \Illuminate\Support\Facades\Mail::to($m->email)->queue(new \App\Mail\PendaftarStatusChanged($m, $status));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send pendaftar status email: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'data' => $m]);
    }
}
