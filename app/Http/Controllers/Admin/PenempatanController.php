<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penempatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenempatanController extends Controller
{
    public function index()
    {
        $items = Penempatan::orderBy('created_at','desc')->paginate(12);
        return view('admin.penempatan.index', compact('items'));
    }

    public function create()
    {
        return view('admin.penempatan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'source_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('penempatan','public');
            $data['image_path'] = 'storage/' . $path;
        }

        Penempatan::create($data);
        return redirect()->route('admin.penempatan.index')->with('success','Item penempatan berhasil disimpan.');
    }

    public function edit(Penempatan $penempatan)
    {
        return view('admin.penempatan.edit', compact('penempatan'));
    }

    public function update(Request $request, Penempatan $penempatan)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'source_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // delete old if exists
            if ($penempatan->image_path) {
                $old = str_replace('storage/','',$penempatan->image_path);
                Storage::disk('public')->delete($old);
            }
            $path = $request->file('image')->store('penempatan','public');
            $data['image_path'] = 'storage/' . $path;
        }

        $penempatan->update($data);
        return redirect()->route('admin.penempatan.index')->with('success','Item penempatan berhasil diperbarui.');
    }

    public function destroy(Penempatan $penempatan)
    {
        if ($penempatan->image_path) {
            $old = str_replace('storage/','',$penempatan->image_path);
            Storage::disk('public')->delete($old);
        }
        $penempatan->delete();
        return redirect()->route('admin.penempatan.index')->with('success','Item penempatan dihapus.');
    }

    // --- AJAX endpoints for admin panel integration ---
    public function jsonIndex()
    {
        $items = Penempatan::orderBy('created_at','desc')->get();
        return response()->json(['success' => true, 'data' => $items]);
    }

    public function ajaxStore(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'source_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('penempatan','public');
            $data['image_path'] = 'storage/' . $path;
        }

        $item = Penempatan::create($data);
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function ajaxUpdate(Request $request, Penempatan $penempatan)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'source_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($penempatan->image_path) {
                $old = str_replace('storage/','',$penempatan->image_path);
                Storage::disk('public')->delete($old);
            }
            $path = $request->file('image')->store('penempatan','public');
            $data['image_path'] = 'storage/' . $path;
        }

        $penempatan->update($data);
        return response()->json(['success' => true, 'data' => $penempatan]);
    }

    public function ajaxDestroy(Penempatan $penempatan)
    {
        if ($penempatan->image_path) {
            $old = str_replace('storage/','',$penempatan->image_path);
            Storage::disk('public')->delete($old);
        }
        $penempatan->delete();
        return response()->json(['success' => true]);
    }
}
