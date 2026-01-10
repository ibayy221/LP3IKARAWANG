<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;

class PendaftarDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $calon = $user->mahasiswa ?? $user->mahasiswas ?? \App\Models\Mahasiswa::where('user_id', $user->id)->first();

        // If there's no calon, just render the view — the Blade template shows a friendly message for missing data
        if (!$calon) {
            return view('pendaftar.dashboard', compact('calon'));
        }

        // Derive simple status flags for the view
        $verif = $calon->status_verifikasi ?? 'pending';
        // Normalize known synonyms
        if (!in_array($verif, ['verified','rejected','pending'])) {
            $verif = $verif === 'accepted' ? 'verified' : 'pending';
        }

        // If user was just redirected after uploading proof, show pending_verification on the UI immediately
        if ($request->query('uploaded')) {
            $payment = 'pending_verification';
        } else {
            $payment = $calon->payment_status ?? 'unpaid';
        }
        $amount = $calon->payment_amount ?? 350000;

        // Compute step classes (sequence: Pendaftaran -> Pembayaran -> Verifikasi -> Selesai)
        $step1 = 'completed';

        // Default values
        $step2 = 'inactive'; // Pembayaran
        $step3 = 'inactive'; // Verifikasi

        // Determine pembayaran (step2) and verifikasi (step3) based on payment_status and verification status
        if ($payment === 'paid') {
            // Payment done
            $step2 = 'completed';
            // Verification depends on verif state
            if ($verif === 'verified') {
                $step3 = 'completed';
            } elseif ($verif === 'pending') {
                $step3 = 'active';
            } elseif ($verif === 'rejected') {
                $step3 = 'rejected';
            } else {
                $step3 = 'inactive';
            }
        } elseif ($payment === 'pending_verification') {
            // Proof uploaded: pembayaran marked as completed, verification active
            $step2 = 'completed';
            $step3 = 'active';
        } else {
            // unpaid or unknown: pembayaran is the active step
            $step2 = 'active';
            $step3 = 'inactive';
        }

        // If verification has been completed by admin, mark pembayaran and verifikasi as completed
        // and advance Selesai to active (or completed if payment is paid).
        if ($verif === 'verified') {
            $step2 = 'completed';
            $step3 = 'completed';
            $step4 = $payment === 'paid' ? 'completed' : 'active';
        } else {
            $step4 = ($verif === 'verified' && $payment === 'paid') ? 'completed' : 'inactive';
        }

        return view('pendaftar.dashboard', compact('calon','verif','payment','amount','step1','step2','step3','step4'));
    }

    public function markPaid(Request $request)
    {
        $user = Auth::user();
        $calon = \App\Models\Mahasiswa::where('user_id', $user->id)->first();
        if (!$calon) return back()->with('error','Data pendaftar tidak ditemukan.');
        $calon->payment_status = 'paid';
        // save selected payment method if provided
        $method = $request->input('method');
        if (!empty($method)) {
            $calon->payment_method = $method;
        }
        $calon->save();
        return back()->with('success','Pembayaran tercatat. Terima kasih.');
    }

    public function payment()
    {
        $user = Auth::user();
        $calon = \App\Models\Mahasiswa::where('user_id', $user->id)->first();
        if (!$calon) return redirect()->route('pendaftar.dashboard')->with('error','Data pendaftar tidak ditemukan.');
        // compute expiry: 3 weeks from initial registration
        $expiresAt = null;
        if (!empty($calon->payment_expires_at)) {
            $expiresAt = \Carbon\Carbon::parse($calon->payment_expires_at);
        } elseif (!empty($calon->created_at)) {
            $expiresAt = \Carbon\Carbon::parse($calon->created_at)->addWeeks(3);
        } else {
            $expiresAt = \Carbon\Carbon::now()->addWeeks(3);
        }
        return view('pendaftar.payment', compact('calon','expiresAt'));
    }

    /**
     * Handle uploaded payment proof from applicant
     */
    public function uploadPaymentProof(Request $request)
    {
        $user = Auth::user();
        $calon = \App\Models\Mahasiswa::where('user_id', $user->id)->first();
        if (!$calon) return redirect()->route('pendaftar.dashboard')->with('error','Data pendaftar tidak ditemukan.');

        $v = $request->validate([
            'sender_name' => 'required|string|max:255',
            'bank_origin' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'transfer_date' => 'nullable|date',
            'method' => 'nullable|string|max:100',
            'proof_file' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // store file in Laravel storage (storage/app/public/bukti_bayar)
        $file = $request->file('proof_file');
        $ext = $file->getClientOriginalExtension();
        $slug = \Illuminate\Support\Str::slug($v['sender_name'] ?? ($calon->nama_mhs ?? 'pendaftar'));
        $ts = time();
        $filename = "bukti_pendaftaran_{$slug}_{$ts}.{$ext}";
        // store under the public disk so the file is accessible via /storage/...
        $path = $file->storeAs('public/bukti_bayar', $filename);
        // $path will be like "public/bukti_bayar/filename.ext"; generate a public URL
        $publicUrl = Storage::url($path);

        // store info on mahasiswa
        $calon->payment_status = 'pending_verification';
        if (!empty($v['method'])) $calon->payment_method = $v['method'];
        $calon->payment_sender_name = $v['sender_name'];
        $calon->payment_bank_origin = $v['bank_origin'];
        $calon->payment_account_name = $v['account_name'];
        // if transfer_date wasn't provided from the form, use today's date
        $calon->payment_transfer_date = $v['transfer_date'] ?? \Carbon\Carbon::now()->toDateString();
        // save public-accessible URL (e.g. /storage/bukti_bayar/filename.ext)
        $calon->payment_proof_path = $publicUrl;
        // set expires at to 3 weeks from registration if not set
        if (empty($calon->payment_expires_at) && !empty($calon->created_at)) {
            $calon->payment_expires_at = \Carbon\Carbon::parse($calon->created_at)->addWeeks(3);
        }
        try {
            $calon->save();
        } catch (\Illuminate\Database\QueryException $e) {
            // handle enum/column truncation errors (e.g., trying to write 'pending_verification' into an enum)
            Log::warning('Save failed, retrying with safe payment_status: '.$e->getMessage(), ['userId' => $user->id]);
            try {
                $calon->payment_status = 'unpaid';
                $calon->save();
            } catch (\Exception $e2) {
                // if retry also fails, return a 500 JSON error for AJAX or abort
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success'=>false,'error'=>'Server error while saving payment data.'],500);
                }
                abort(500, 'Server error while saving payment data.');
            }
        }

        // If this was an AJAX request, return JSON so fetch() can handle it.
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => route('pendaftar.dashboard') . '?uploaded=1',
                'proof_url' => $publicUrl
            ]);
        }

        return redirect(route('pendaftar.dashboard') . '?uploaded=1')->with('success','Bukti pembayaran berhasil diunggah. Menunggu verifikasi.');
    }

    /**
     * Show biodata page for the authenticated applicant.
     */
    public function showBiodata()
    {
        $user = Auth::user();
        $pendaftar = \App\Models\Mahasiswa::where('user_id', $user->id)->first();
        return view('pendaftar.biodata', compact('pendaftar'));
    }

    /**
     * Generate and download payment receipt (kuitansi) for the authenticated applicant.
     */
    public function downloadReceipt()
    {
        $user = Auth::user();
        $calon = \App\Models\Mahasiswa::where('user_id', $user->id)->first();
        if (!$calon) return redirect()->route('pendaftar.dashboard')->with('error', 'Data pendaftar tidak ditemukan.');

        // Only allow after marketing verification
        if ((($calon->status_verifikasi ?? 'pending') !== 'verified') && (trim(strtolower($calon->status_verifikasi ?? '')) !== 'verified')) {
            return redirect()->route('pendaftar.dashboard')->with('error', 'Kuitansi hanya tersedia setelah verifikasi oleh marketing.');
        }

        $data = [
            'calon' => $calon,
            'amount' => $calon->payment_amount ?? 350000,
            'date' => $calon->payment_transfer_date ?? $calon->updated_at?->toDateString() ?? now()->toDateString()
        ];

        $pdf = Pdf::loadView('pendaftar.receipt', $data);
        $filename = 'kuitansi_' . ($calon->nipd ?? ($calon->id ?? 'pendaftar')) . '_' . date('Ymd') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Show edit form for biodata.
     */
    public function editBiodata()
    {
        $user = Auth::user();
        $pendaftar = \App\Models\Mahasiswa::where('user_id', $user->id)->first();
        return view('pendaftar.biodata_edit', compact('pendaftar'));
    }

    /**
     * Update biodata and optional profile photo.
     */
    public function updateBiodata(Request $request)
    {
        $user = Auth::user();
        $pendaftar = \App\Models\Mahasiswa::where('user_id', $user->id)->first();
        if (!$pendaftar) return redirect()->route('pendaftar.dashboard')->with('error','Data pendaftar tidak ditemukan.');

        $v = $request->validate([
            'nama_mhs' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:20',
            'agama' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'jenis_kelas' => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:255',
            'asal_sekolah' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:1000',
            'kecamatan' => 'nullable|string|max:255',
            'desa' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:20',
            'tahun_lulus' => 'nullable|digits:4',
            'instagram' => 'nullable|string|max:255',
            'nama_wali' => 'nullable|string|max:255',
            'telp_wali' => 'nullable|string|max:50',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'ktp_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ijazah_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'akte_kelahiran_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_sudah_bekerja_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'photo' => 'nullable|image|mimes:jpg,png|max:2048'
        ]);

        // assign allowed fields, but only if the corresponding DB column exists
        $fields = ['nama_mhs','no_hp','email','jenis_kelas','jurusan','asal_sekolah','alamat','kecamatan','desa','kode_pos','jenis_kelamin','agama','tahun_lulus','instagram','nama_wali','telp_wali','pekerjaan_wali'];
        foreach ($fields as $f) {
            if (array_key_exists($f, $v)) {
                if (Schema::hasColumn('mahasiswas', $f)) {
                    $pendaftar->{$f} = $v[$f];
                } else {
                    Log::info('Skipping assignment for missing column', ['column' => $f, 'user_id' => $user->id ?? null]);
                }
            }
        }

        // handle photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = 'pendaftar_' . ($pendaftar->id ?? 'unknown') . '_' . time() . '.' . $file->getClientOriginalExtension();
            // Save uploaded photos into the existing `public/image` storage folder so files are visible
            // (there are already site images under storage/app/public/image)
            try {
                $path = $file->storeAs('public/image', $name);
            } catch (\Exception $e) {
                // if storeAs fails for any reason, attempt a direct move to the storage folder
                Log::warning('storeAs failed, attempting move', ['error' => $e->getMessage(), 'user_id' => $user->id ?? null]);
                $targetDir = storage_path('app/public/image');
                if (!is_dir($targetDir)) {
                    @mkdir($targetDir, 0755, true);
                }
                try {
                    $file->move($targetDir, $name);
                    $path = 'public/image/' . $name;
                } catch (\Exception $e2) {
                    Log::error('Failed to move uploaded file to storage folder', ['error' => $e2->getMessage()]);
                    $path = null;
                }
            }

            // Ensure file actually exists under storage/app when possible; if not, attempt move fallback
            if (!empty($path)) {
                $physical = storage_path('app/' . ltrim($path, '/'));
                if (!file_exists($physical)) {
                    // try moving directly as a fallback
                    $targetDir = storage_path('app/public/image');
                    if (!is_dir($targetDir)) {
                        @mkdir($targetDir, 0755, true);
                    }
                    try {
                        $file->move($targetDir, $name);
                        $path = 'public/image/' . $name;
                    } catch (\Exception $e) {
                        Log::warning('Fallback move failed', ['error' => $e->getMessage(), 'user_id' => $user->id ?? null]);
                    }
                }
            }

            // generate public URL (/storage/...)
            $publicUrl = $path ? Storage::url($path) : '/storage/image/' . $name;
            // Save into existing column `file_path` (mahasiswas table) to avoid adding new column
            $pendaftar->file_path = $publicUrl;
            // Log for debugging: stored path and public URL
            Log::info('Uploaded pendafatar photo', ['user_id' => $user->id ?? null, 'mahasiswa_id' => $pendaftar->id ?? null, 'path' => $path, 'publicUrl' => $publicUrl]);
        }

        // handle KTP / kartu pelajar upload
        if ($request->hasFile('ktp_file')) {
            $file = $request->file('ktp_file');
            $name = 'ktp_' . ($pendaftar->id ?? 'unknown') . '_' . time() . '.' . $file->getClientOriginalExtension();
            try {
                $ktpPath = $file->storeAs('public/ktp', $name);
            } catch (\Exception $e) {
                Log::warning('storeAs ktp failed, attempting move', ['error' => $e->getMessage(), 'user_id' => $user->id ?? null]);
                $targetDir = storage_path('app/public/ktp');
                if (!is_dir($targetDir)) {@mkdir($targetDir,0755,true);} 
                try {
                    $file->move($targetDir, $name);
                    $ktpPath = 'public/ktp/' . $name;
                } catch (\Exception $e2) {
                    Log::error('Failed to move ktp file', ['error' => $e2->getMessage()]);
                    $ktpPath = null;
                }
            }

            if (!empty($ktpPath)) {
                $publicKtpUrl = Storage::url($ktpPath);
                $pendaftar->ktp_path = $publicKtpUrl;
                Log::info('Uploaded KTP file', ['user_id' => $user->id ?? null, 'mahasiswa_id' => $pendaftar->id ?? null, 'ktpPath' => $ktpPath, 'public' => $publicKtpUrl]);
            }
        }

        // helper to store and assign file paths safely
        $storeAndAssign = function($inputName, $dir, $columnKey) use ($request, $pendaftar, $user) {
            if (!$request->hasFile($inputName)) return null;
            $file = $request->file($inputName);
            $name = $columnKey . '_' . ($pendaftar->id ?? 'unknown') . '_' . time() . '.' . $file->getClientOriginalExtension();
            try {
                $p = $file->storeAs('public/' . trim($dir,'/'), $name);
            } catch (\Exception $e) {
                Log::warning('storeAs '.$inputName.' failed, attempting move', ['error' => $e->getMessage(), 'user_id' => $user->id ?? null]);
                $targetDir = storage_path('app/public/' . trim($dir,'/'));
                if (!is_dir($targetDir)) {@mkdir($targetDir,0755,true);} 
                try {
                    $file->move($targetDir, $name);
                    $p = 'public/' . trim($dir,'/') . '/' . $name;
                } catch (\Exception $e2) {
                    Log::error('Failed to move '.$inputName.' file', ['error' => $e2->getMessage()]);
                    $p = null;
                }
            }

            if (!empty($p)) {
                $publicUrl = \Illuminate\Support\Facades\Storage::url($p);
                // assign to column if exists, else try other_documents JSON column
                if (\Illuminate\Support\Facades\Schema::hasColumn('mahasiswas', $columnKey)) {
                    $pendaftar->{$columnKey} = $publicUrl;
                } elseif (\Illuminate\Support\Facades\Schema::hasColumn('mahasiswas', 'other_documents')) {
                    $cur = json_decode($pendaftar->other_documents ?? '{}', true) ?: [];
                    $cur[$columnKey] = $publicUrl;
                    $pendaftar->other_documents = json_encode($cur);
                } else {
                    Log::info('Skipping assignment for missing column', ['column' => $columnKey, 'user_id' => $user->id ?? null]);
                }
                Log::info('Uploaded '.$inputName.' file', ['user_id' => $user->id ?? null, 'mahasiswa_id' => $pendaftar->id ?? null, 'path' => $p, 'public' => $publicUrl]);
                return $publicUrl;
            }
            return null;
        };

        // store additional document files if provided
        $storeAndAssign('ijazah_file', 'ijazah', 'ijazah_path');
        $storeAndAssign('akte_kelahiran_file', 'akte_kelahiran', 'akte_kelahiran_path');
        $storeAndAssign('surat_sudah_bekerja_file', 'surat_sudah_bekerja', 'surat_sudah_bekerja_path');

        // ensure status is set to 'aktif' for every pendaftar if not already set
        if (empty($pendaftar->status)) {
            $pendaftar->status = 'aktif';
        }

        try {
            $pendaftar->save();
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Failed saving biodata', ['error' => $e->getMessage(), 'user_id' => $user->id ?? null]);
            return back()->with('error','Gagal menyimpan biodata. Periksa log server (mungkin kolom DB belum ada).');
        }

        return redirect()->route('pendaftar.biodata.show')->with('success','Biodata berhasil disimpan.');
    }
}