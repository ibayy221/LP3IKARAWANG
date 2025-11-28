<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_mhs' => 'required|string|max:255',
            'NIK_mahasiswa' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_hp' => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:255',
            'tahun_lulus' => 'nullable|digits:4',
            'alamat' => 'nullable|string',
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

        Mahasiswa::create($validated);

        return redirect()->back()->with('success', 'Pendaftaran mahasiswa berhasil dikirimkan.');
    }
}
