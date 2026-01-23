<?php

namespace App\Http\Controllers;

use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $strukturs = StrukturOrganisasi::orderBy('urutan')->get();
        return view('admin.struktur_organisasi.index', compact('strukturs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $posisiOptions = ['director' => 'Director', 'secretary' => 'Corporate Secretary', 'staff' => 'Staff'];
        return view('admin.struktur_organisasi.create', compact('posisiOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'posisi' => 'required|in:director,secretary,staff',
            'parent_id' => 'nullable|exists:struktur_organisasis,id',
            'urutan' => 'nullable|integer',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoPath = $file->store('struktur_organisasi', 'public');
        }

        StrukturOrganisasi::create([
            'nama' => $validated['nama'],
            'role' => $validated['role'],
            'foto' => $fotoPath,
            'posisi' => $validated['posisi'],
            'parent_id' => $validated['parent_id'] ?? null,
            'urutan' => $validated['urutan'] ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('struktur-organisasi.index')->with('success', 'Data struktur organisasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StrukturOrganisasi $strukturOrganisasi)
    {
        $posisiOptions = ['director' => 'Director', 'secretary' => 'Corporate Secretary', 'staff' => 'Staff'];
        return view('admin.struktur_organisasi.edit', compact('strukturOrganisasi', 'posisiOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StrukturOrganisasi $strukturOrganisasi)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'posisi' => 'required|in:director,secretary,staff',
            'parent_id' => 'nullable|exists:struktur_organisasis,id',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $fotoPath = $strukturOrganisasi->foto;
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($fotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }
            $file = $request->file('foto');
            $fotoPath = $file->store('struktur_organisasi', 'public');
        }

        $strukturOrganisasi->update([
            'nama' => $validated['nama'],
            'role' => $validated['role'],
            'foto' => $fotoPath,
            'posisi' => $validated['posisi'],
            'parent_id' => $validated['parent_id'] ?? null,
            'urutan' => $validated['urutan'] ?? $strukturOrganisasi->urutan,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('struktur-organisasi.index')->with('success', 'Data struktur organisasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StrukturOrganisasi $strukturOrganisasi)
    {
        if ($strukturOrganisasi->foto) {
            Storage::disk('public')->delete($strukturOrganisasi->foto);
        }
        $strukturOrganisasi->delete();
        return redirect()->route('struktur-organisasi.index')->with('success', 'Data struktur organisasi berhasil dihapus.');
    }

    /**
     * Get data for struktur page - organized with parent-child relationship
     */
    public static function getOrgData()
    {
        $director = StrukturOrganisasi::active()->byPosisi('director')->first();
        
        // Get all active staff that are NOT directors or secretaries
        $allStaff = StrukturOrganisasi::active()
            ->whereNotIn('posisi', ['director', 'secretary'])
            ->orderBy('urutan')
            ->get();
        
        // Group staff by parent_id
        $staffByParent = $allStaff->groupBy('parent_id');

        // Identify heads: staff with role containing 'Head' or 'Kepala' (limit 4)
        $heads = StrukturOrganisasi::active()
            ->where(function($q){
                $q->where('role', 'like', '%Head%')
                  ->orWhere('role', 'like', '%Kepala%');
            })
            ->orderBy('urutan')
            ->get()
            ->take(4);

        return [
            'director' => $director,
            'secretary' => StrukturOrganisasi::active()->byPosisi('secretary')->first(),
            'heads' => $heads,
            'staff' => $allStaff,
            'staffByParent' => $staffByParent, // grouped by parent_id
            'allActive' => StrukturOrganisasi::active()->orderBy('urutan')->get(),
        ];
    }

    /**
     * API endpoint to get all struktur organisasi
     */
    public function apiIndex()
    {
        $strukturs = StrukturOrganisasi::orderBy('urutan')->get();
        return response()->json($strukturs);
    }
}
