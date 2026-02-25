<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MahasiswaController extends Controller
{
    public function create()
    {
        $kecamatans = Kecamatan::orderBy('name')->get();
        // load desas grouped by kecamatan id for cascading dropdown
        // Note: Desa model/table doesn't exist, using empty collection
        $desas = collect([]);

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
        // Pastikan id_user, id_program_studi, id_kelas valid
        // (Letakkan setelah $validated didapat dari $request->validate)
        // If account fields are present, require them
        $rules = [
            'nama_mhs' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'nipd' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'domisili' => 'required|string',
            'tempat_lahir' => 'nullable|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'angkatan' => 'nullable|string|max:255',
            'periode' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
            'no_tlp' => 'nullable|string|max:255',
            // legacy name used by some older forms/tests
            'no_hp' => 'nullable|string|max:255',
            'tahun_lulus' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'desa' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:255',
            'jenis_kelas' => 'nullable|string|max:255',
            'status_verifikasi' => 'nullable|string|max:255',
            'payment_status' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|max:255',
            'payment_proof_path' => 'nullable|string|max:255',
            'payment_bank_origin' => 'nullable|string|max:255',
            'payment_account_name' => 'nullable|string|max:255',
            'payment_sender_name' => 'nullable|string|max:255',
            'payment_transfer_date' => 'nullable|string|max:255',
            'payment_expires_at' => 'nullable|string|max:255',
            'payment_amount' => 'nullable|string|max:255',
            'asal_sekolah' => 'nullable|string|max:255',
            'file_path' => 'nullable|string|max:255',
            'ktp_path' => 'nullable|string|max:255',
            'akte_kelahiran_path' => 'nullable|string|max:255',
            'ijazah_path' => 'nullable|string|max:255',
            'surat_sudah_bekerja_path' => 'nullable|string|max:255',
            'instagram_path' => 'nullable|string|max:255',
            'nama_wali' => 'nullable|string|max:255',
            'telp_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'whatsapp_wali' => 'nullable|string|max:255',
            'foto' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'id_user' => 'nullable|integer',
            'id_program_studi' => 'nullable|integer|in:1,2,3',
            // legacy name used by older forms
            'program_studi' => 'nullable|integer|in:1,2,3',
            'id_kelas' => 'nullable|integer',
            'file' => 'nullable|file|max:5120'
        ];

        // If the pendaftar created an account (password provided), validate account fields (use account_email to avoid colliding with contact email)
        if ($request->filled('password') || $request->filled('password_confirmation')) {
            $rules['account_email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        $validated = $request->validate($rules);

        // normalize legacy field names
        if (empty($validated['no_tlp']) && !empty($validated['no_hp'])) {
            $validated['no_tlp'] = $validated['no_hp'];
        }
        unset($validated['no_hp']);

        if (empty($validated['id_program_studi']) && !empty($validated['program_studi'])) {
            $validated['id_program_studi'] = (int) $validated['program_studi'];
        }
        unset($validated['program_studi']);

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

        // Tidak perlu mapping, gunakan no_tlp langsung
        // Mapping email ke account_email jika ada
        if (!empty($validated['account_email'])) {
            $validated['email'] = $validated['account_email'];
        }

        // If account is created, make a user and link
        $userId = null;
        $email = $validated['email'] ?? null;
        $user = \App\Models\User::where('email', $email)->first();
        if (!$user && !empty($validated['password'])) {
            $user = new \App\Models\User();
            $user->name = $validated['nama_mhs'];
            $user->email = $email;
            $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
            $user->is_applicant = true;
            $user->save();
        }
        $userId = $user ? $user->id : null;
        $validated['id_user'] = $userId;

        // Generate NIPD jika belum ada
        if (empty($validated['nipd'])) {
            $validated['nipd'] = \App\Models\Mahasiswa::generateNipd($validated['id_program_studi'] ?? null);
        }

        // Pastikan semua field DB ada di $validated (isi default jika tidak ada input)
        // Hapus id_mahasiswa jika kosong/null agar tidak error insert
        if (array_key_exists('id_mahasiswa', $validated) && ($validated['id_mahasiswa'] === '' || $validated['id_mahasiswa'] === null)) {
            unset($validated['id_mahasiswa']);
        }

        // Pastikan field NOT NULL tanpa default selalu terisi string kosong jika tidak ada input
        // Otomatis isi string kosong untuk semua field di $dbFields jika tidak ada input
        $dbFields = [
            'id_mahasiswa', 'nipd', 'nama_mhs', 'alamat', 'domisili', 'tempat_lahir', 'tgl_lahir', 'angkatan', 'periode',
            'email', 'agama', 'no_tlp', 'tahun_lulus', 'kecamatan', 'desa', 'kode_pos', 'jenis_kelamin', 'jenis_kelas',
            'status_verifikasi', 'payment_status', 'payment_method', 'payment_proof_path', 'payment_bank_origin',
            'payment_account_name', 'payment_sender_name', 'payment_transfer_date', 'payment_expires_at', 'payment_amount',
            'asal_sekolah', 'file_path', 'ktp_path', 'akte_kelahiran_path', 'ijazah_path', 'surat_sudah_bekerja_path',
            'instagram_path', 'nama_wali', 'telp_wali', 'pekerjaan_wali', 'whatsapp_wali', 'foto', 'status',
            'id_user', 'id_program_studi', 'id_kelas'
        ];
        foreach ($dbFields as $field) {
            // id_mahasiswa: auto-increment, jangan dikirim jika kosong/null
            if ($field === 'id_mahasiswa') {
                if (!isset($validated[$field]) || $validated[$field] === null || $validated[$field] === '') {
                    unset($validated[$field]);
                    continue;
                }
            }
            // Integer fields
            $integerFields = ['id_user', 'id_program_studi', 'id_kelas'];
            if (in_array($field, $integerFields)) {
                if (!isset($validated[$field]) || $validated[$field] === null || $validated[$field] === '') {
                    $validated[$field] = null;
                }
                continue;
            }
            // Kolom NOT NULL harus diisi string kosong jika tidak ada input
            $notNullFields = [
                'nama_mhs', 'domisili', 'tempat_lahir', 'angkatan', 'periode', 'agama'
            ];
            if (in_array($field, $notNullFields)) {
                if (!isset($validated[$field]) || $validated[$field] === null || $validated[$field] === '') {
                    $validated[$field] = '';
                }
                continue;
            }
            // Kolom lain: null jika kosong
            if (!isset($validated[$field]) || $validated[$field] === null || $validated[$field] === '') {
                $validated[$field] = null;
            }
        }
        $dbFields = [
            'id_mahasiswa', 'nipd', 'nama_mhs', 'alamat', 'domisili', 'tempat_lahir', 'tgl_lahir', 'angkatan', 'periode',
            'email', 'agama', 'no_tlp', 'tahun_lulus', 'kecamatan', 'desa', 'kode_pos', 'jenis_kelamin', 'jenis_kelas',
            'status_verifikasi', 'payment_status', 'payment_method', 'payment_proof_path', 'payment_bank_origin',
            'payment_account_name', 'payment_sender_name', 'payment_transfer_date', 'payment_expires_at', 'payment_amount',
            'asal_sekolah', 'file_path', 'ktp_path', 'akte_kelahiran_path', 'ijazah_path', 'surat_sudah_bekerja_path',
            'instagram_path', 'nama_wali', 'telp_wali', 'pekerjaan_wali', 'whatsapp_wali', 'foto', 'status',
            'id_user', 'id_program_studi', 'id_kelas'
        ];

        // Simpan data ke tabel mahasiswa
        $dataToInsert = array_intersect_key($validated, array_flip($dbFields));

        // Prevent quick duplicate submissions (same email/phone within a short window)
        try {
            $duplicate = Mahasiswa::findRecentDuplicate($dataToInsert, 10);
        } catch (\Exception $e) {
            $duplicate = null;
            Log::warning('Duplicate check failed', ['error' => $e->getMessage()]);
        }

        if ($duplicate) {
            // If we just created a user, try to link it to the existing record
            if (!empty($dataToInsert['id_user']) && empty($duplicate->id_user)) {
                $duplicate->id_user = $dataToInsert['id_user'];
            }
            if (!empty($dataToInsert['id_program_studi']) && empty($duplicate->id_program_studi)) {
                $duplicate->id_program_studi = $dataToInsert['id_program_studi'];
            }
            $duplicate->save();

            if ($user) {
                \Illuminate\Support\Facades\Auth::login($user);
            }

            return back()->with('success', 'Pendaftaran sudah tercatat.');
        }

        try {
            $mahasiswa = \App\Models\Mahasiswa::create($dataToInsert);
            // Login otomatis setelah pendaftaran
            if ($user) {
                \Illuminate\Support\Facades\Auth::login($user);
            }
        } catch (\Exception $e) {
            \Log::error('Gagal insert mahasiswa: ' . $e->getMessage(), ['data' => $dataToInsert]);
            return back()->withInput()->withErrors(['mahasiswa' => 'Gagal menyimpan data mahasiswa: ' . $e->getMessage()]);
        }
        // Redirect atau tampilkan pesan sukses
        return redirect()->route('pendaftar.dashboard')->with('success', 'Pendaftaran berhasil!');
    }
}
