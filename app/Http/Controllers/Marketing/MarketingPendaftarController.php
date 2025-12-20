<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MarketingPendaftarController extends Controller
{
    public function dashboard()
    {
        // Compute simple statistics for dashboard
        $total = Mahasiswa::count();
        $jurusanTerbanyak = Mahasiswa::select('jurusan', \Illuminate\Support\Facades\DB::raw('count(*) as cnt'))
            ->groupBy('jurusan')
            ->orderByDesc('cnt')
            ->pluck('jurusan')
            ->first();
        $pendaftarToday = Mahasiswa::whereDate('created_at', \Carbon\Carbon::today())->count();

        return view('marketing.dashboard', [
            'totalPendaftar' => $total,
            'jurusanTerbanyak' => $jurusanTerbanyak ?: '-',
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

        // Fetch distinct jurusans for the filter dropdown
        $jurusans = Mahasiswa::select('jurusan')
            ->whereNotNull('jurusan')
            ->where('jurusan', '<>', '')
            ->distinct()
            ->orderBy('jurusan')
            ->pluck('jurusan')
            ->values();

        return view('marketing.pendaftar.index', compact('registrationImageUrl','jurusans'));
    }

    public function list(Request $request)
    {
        $q = $request->input('q');
        $status = $request->input('status');
        $jurusan = $request->input('jurusan');

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
            $query->where('jurusan', $jurusan);
        }

        $data = $query->orderBy('created_at', 'desc')->get(['id','nama_mhs','email','no_hp','jurusan','status_verifikasi','created_at','sumber_pendaftaran']);
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function create()
    {
        $jurusans = Mahasiswa::select('jurusan')->distinct()->pluck('jurusan')->filter()->values();

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

        return view('marketing.pendaftar.create', compact('jurusans','registrationImageUrl'));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'nama_mhs' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_hp' => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:255',
            'sumber_pendaftaran' => 'nullable|string|in:online,offline'
        ]);
        $v['sumber_pendaftaran'] = $v['sumber_pendaftaran'] ?? 'offline';
        $v['status_verifikasi'] = $v['status_verifikasi'] ?? 'pending';

        // Prevent accidental duplicates when marketing adds pendaftar manually
        $duplicate = null;
        try {
            $duplicate = Mahasiswa::findRecentDuplicate($v, null);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Marketing duplicate check failed: '.$e->getMessage());
        }

        if ($duplicate) {
            return redirect()->route('marketing.pendaftar.show', $duplicate->id)->with('success','Pendaftar sudah ada — membuka data yang tersedia.');
        }

        try {
            $m = Mahasiswa::createWithUniqueNipd($v);
        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos(strtolower($e->getMessage()), 'duplicate') !== false || $e->getCode() === '23000') {
                $existing = Mahasiswa::findRecentDuplicate($v, null);
                if ($existing) {
                    return redirect()->route('marketing.pendaftar.show', $existing->id)->with('success','Pendaftar sudah ada — membuka data yang tersedia.');
                }
            }
            throw $e;
        }

        return redirect()->route('marketing.pendaftar.show', $m->id)->with('success','Calon mahasiswa ditambahkan.');
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
        $jurusan = $request->input('jurusan');
        $query = Mahasiswa::query();
        if ($q) {
            $query->where(function($qr) use ($q){ $qr->where('nama_mhs','like',"%{$q}%")->orWhere('email','like',"%{$q}%"); });
        }
        if ($status) $query->where('status_verifikasi',$status);
        if ($jurusan) $query->where('jurusan',$jurusan);
        $rows = $query->orderBy('created_at','desc')->get();

        $filename = 'pendaftar_export_'.date('Ymd_His').'.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}"
        ];

        $columns = ['id','nama_mhs','email','no_hp','jurusan','sumber_pendaftaran','status_verifikasi','payment_status','payment_amount','marketing_notes','created_at'];
        $callback = function() use ($rows, $columns) {
            $f = fopen('php://output','w');
            fputcsv($f,$columns);
            foreach($rows as $r) {
                $line = array_map(function($c) use ($r) { return $r->{$c} ?? ''; }, $columns);
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
        $jurusan = $request->input('jurusan');
        $query = Mahasiswa::query();
        if ($q) {
            $query->where(function($qr) use ($q){ $qr->where('nama_mhs','like',"%{$q}%")->orWhere('email','like',"%{$q}%"); });
        }
        if ($status) $query->where('status_verifikasi',$status);
        if ($jurusan) $query->where('jurusan',$jurusan);
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

        \DB::transaction(function() {
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
        $m->status_verifikasi = $status;
        $m->save();

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
