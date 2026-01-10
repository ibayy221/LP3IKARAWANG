<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function create()
    {
        $kecamatans = Kecamatan::orderBy('name')->get();
        // load desas grouped by kecamatan id for cascading dropdown
        $desas = \App\Models\Desa::orderBy('name')->get()->groupBy('kecamatan_id')->map(function($items) {
            return $items->map(function($it) { return ['id' => $it->id, 'name' => $it->name, 'kode_pos' => $it->kode_pos]; })->values();
        });

        // Read optional registration image setting from public/data/settings.csv
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
        // Normalize registration image URL
        $registrationImageUrl = null;
        if (!empty($registrationImage)) {
            if (preg_match('#^https?://#i', $registrationImage)) {
                $registrationImageUrl = $registrationImage;
            } else {
                // ensure leading slash
                $registrationImageUrl = '/' . ltrim($registrationImage, '/');
            }
        }
        \Illuminate\Support\Facades\Log::info('mahasiswa.create registration_image', ['registration_image' => $registrationImageUrl]);
        return view('mahasiswa.create', compact('kecamatans', 'desas', 'registrationImageUrl'));
    }

    public function store(Request $request)
    {
        // If account fields are present, require them
        $rules = [
            'nama_mhs' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_hp' => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:255',
            'tahun_lulus' => 'nullable|digits:4',
            'alamat' => 'nullable|string',
            'kecamatan' => 'nullable|string|max:255',
            'desa' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'kecamatan' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:10',
            'agama' => 'nullable|string|max:50',
            'jenis_sekolah' => 'nullable|string|max:50',
            'jenis_kelas' => 'nullable|string|max:50',
            'kategori_sekolah' => 'nullable|string|max:50',
            'sumber_pendaftaran' => 'nullable|string|in:online,offline',
            'status_verifikasi' => 'nullable|string|max:50',
            'asal_sekolah' => 'nullable|string|max:255',
            'file' => 'nullable|file|max:5120'
        ];

        // If the pendaftar created an account (password provided), validate account fields (use account_email to avoid colliding with contact email)
        if ($request->filled('password') || $request->filled('password_confirmation')) {
            $rules['account_email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        $validated = $request->validate($rules);

        // handle file if present
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('mahasiswa', ['disk' => 'public']);
            $validated['file_path'] = $path;
        }

        // If kecamatan input was an ID, convert to the kecamatan name for storage
        if (!empty($validated['kecamatan']) && is_numeric($validated['kecamatan'])) {
            $kec = Kecamatan::find($validated['kecamatan']);
            if ($kec) {
                $validated['kecamatan'] = $kec->name;
            }
        }

        // If account is created, make a user and link
        $userId = null;
        if (!empty($validated['password'])) {
            // Prefer explicit account_email (from the 'Buat Akun' section); fall back to contact email if provided
            $email = $validated['account_email'] ?? $validated['email'] ?? null;
            $password = $validated['password'];

            // Create User
            $u = new \App\Models\User();
            $u->name = $validated['nama_mhs'];
            $u->email = $email;
            $u->password = \Illuminate\Support\Facades\Hash::make($password);
            $u->is_applicant = true;
            $u->save();
            $userId = $u->id;
        }

        $validated['user_id'] = $userId;
        // Persist contact email into mahasiswa.email: prefer account_email if provided
        if (!empty($validated['account_email'])) {
            $validated['email'] = $validated['account_email'];
        }
        // set default payment fields if not present
        $validated['payment_status'] = $validated['payment_status'] ?? 'unpaid';
        $validated['payment_amount'] = $validated['payment_amount'] ?? 350000;
        // set default status for every pendaftar
        $validated['status'] = $validated['status'] ?? 'aktif';

        // Remove account-related fields so they are not persisted into mahasiswas table
        unset($validated['account_email'], $validated['password'], $validated['password_confirmation']);

        // Prevent accidental duplicate submissions: if a recent record exists with same email or phone and same jurusan, skip creating a new one.
        $duplicate = null;
        try {
            // look for any existing record with same email/phone & jurusan
            \Illuminate\Support\Facades\Log::info('Running duplicate check', ['email' => $validated['email'] ?? null, 'no_hp' => $validated['no_hp'] ?? null, 'jurusan' => $validated['jurusan'] ?? null]);
            $duplicate = Mahasiswa::findRecentDuplicate($validated, null);
            \Illuminate\Support\Facades\Log::info('Duplicate check result', ['found' => (bool)$duplicate, 'duplicate_id' => $duplicate ? $duplicate->id : null]);
        } catch (\Exception $e) {
            // If anything goes wrong, we fall back to creating a record rather than blocking signups
            \Illuminate\Support\Facades\Log::warning('Duplicate check failed: '.$e->getMessage());
        }

        if ($duplicate) {
            // Redirect to a friendly page (or back) indicating the record already exists
            return redirect()->back()->with('success', 'Pendaftaran sudah diterima sebelumnya. Nomor pendaftaran: ' . ($duplicate->nipd ?? $duplicate->id));
        }

        // Generate NIPD if not set using the model helper (ensures consistent format)
        if (empty($validated['nipd'])) {
            $validated['nipd'] = \App\Models\Mahasiswa::generateNipd($validated['jurusan'] ?? null);
        }

        // create the mahasiswa record inside a try/catch to handle unique-constraint races
        try {
            $mahasiswa = Mahasiswa::createWithUniqueNipd($validated);
        } catch (\Illuminate\Database\QueryException $e) {
            // duplicate entry (unique index on email/jurusan/no_hp) -> find existing and redirect gracefully
            if (strpos(strtolower($e->getMessage()), 'duplicate') !== false || $e->getCode() === '23000') {
                $existing = Mahasiswa::findRecentDuplicate($validated, null);
                if ($existing) {
                    return redirect()->back()->with('success', 'Pendaftaran sudah diterima sebelumnya. Nomor pendaftaran: ' . ($existing->nipd ?? $existing->id));
                }
            }

            // rethrow for unexpected DB errors
            throw $e;
        }

        // If account created, redirect to pendaftar login
        if (!empty($userId)) {
            return redirect()->route('pendaftar.login')->with('success','Akun dibuat. Silakan login untuk melihat status pendaftaran.');
        }

        return redirect()->back()->with('success', 'Pendaftaran mahasiswa berhasil dikirimkan.');
        // If account created, redirect to pendaftar login
        if (!empty($userId)) {
            return redirect()->route('pendaftar.login')->with('success','Akun dibuat. Silakan login untuk melihat status pendaftaran.');
        }

        return redirect()->back()->with('success', 'Pendaftaran mahasiswa berhasil dikirimkan.');
    }
}
