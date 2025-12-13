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
        $validated = $request->validate([
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
            'jenis_sekolah' => 'nullable|string|max:50',
            'kategori_sekolah' => 'nullable|string|max:50',
            'status_verifikasi' => 'nullable|string|max:50',
            'asal_sekolah' => 'nullable|string|max:255',
            'file' => 'nullable|file|max:5120'
        ]);

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

        Mahasiswa::create($validated);

        return redirect()->back()->with('success', 'Pendaftaran mahasiswa berhasil dikirimkan.');
    }
}
