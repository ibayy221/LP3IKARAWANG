<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaRegisterController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            // NIPD dibuat saat verifikasi (status_verifikasi = verified)
            'nipd' => 'nullable|string|max:255',
            'nama_mhs' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'domisili' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'no_tlp' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'angkatan' => 'nullable|string|max:255',
            'periode' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
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
            'id_program_studi' => 'nullable|integer',
            'id_kelas' => 'nullable|integer',
        ]);

        if (empty($validated['status_verifikasi'])) {
            $validated['status_verifikasi'] = 'pending';
        }

        if (empty($validated['nipd']) && trim(strtolower((string) $validated['status_verifikasi'])) === 'verified') {
            // This controller uses DB::table (no model hooks), so generate here when verified.
            $validated['nipd'] = \App\Models\Mahasiswa::generateNipd($validated['id_program_studi'] ?? null);
        }

        $validated['created_at'] = now();
        $validated['updated_at'] = now();
        DB::table('mahasiswa')->insert($validated);
        return response()->json(['message' => 'Pendaftaran mahasiswa berhasil!']);
    }
}
