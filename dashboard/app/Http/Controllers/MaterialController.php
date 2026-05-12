<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data materi berdasarkan mentor yang login
        $materials = Material::where('mentor_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Hitung statistik berdasarkan level yang sesuai
        $totalMaterials = $materials->count();
        $beginnerMaterials = $materials->where('level', 'Beginner')->count();
        $elementaryMaterials = $materials->where('level', 'Elementary')->count();
        $intermediateMaterials = $materials->where('level', 'Intermediate')->count();
        $upperIntermediateMaterials = $materials->where('level', 'Upper Intermediate')->count();
        $advancedMaterials = $materials->where('level', 'Advanced')->count();

        return view('mentor.materials', compact(
            'materials', 
            'totalMaterials', 
            'beginnerMaterials',
            'elementaryMaterials',
            'intermediateMaterials',
            'upperIntermediateMaterials',
            'advancedMaterials'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:Beginner,Elementary,Intermediate,Upper Intermediate,Advanced',
            'material_file' => 'required|file|max:512000', // max 500MB
            'is_locked' => 'nullable|boolean'
        ]);

        // Handle file upload
        $filePath = null;
        $fileName = null;
        $fileSize = null;

        if ($request->hasFile('material_file')) {
            $file = $request->file('material_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials', $fileName, 'public');
            $fileSize = $file->getSize();
            $fileName = $file->getClientOriginalName(); // Simpan nama asli file
        }

        // Create material dengan mentor_id otomatis
        Material::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'level' => $validated['level'],
            'mentor_id' => Auth::id(),
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'is_locked' => $request->has('is_locked') ? 1 : 0
        ]);

        return redirect()->route('mentor.materials')->with('success', 'Material berhasil diupload!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = Material::findOrFail($id);
        
        // Pastikan hanya mentor pemilik yang bisa menghapus
        if ($material->mentor_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        
        // Hapus file jika ada
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }
        
        $material->delete();

        return redirect()->route('material.index')->with('success', 'Material berhasil dihapus');
    }

    /**
     * Download material file
     */
    public function download($id)
    {
        $material = Material::findOrFail($id);
        
        if (!$material->file_path || !Storage::disk('public')->exists($material->file_path)) {
            return redirect()->back()->with('error', 'File materi tidak ditemukan');
        }

        return Storage::disk('public')->download($material->file_path, $material->file_name);
    }

    /**
     * Toggle lock status of a material
     */
    public function toggleLock($id)
    {
        $material = Material::findOrFail($id);
        
        // Pastikan hanya mentor pemilik yang bisa mengubah
        if ($material->mentor_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $material->is_locked = !$material->is_locked;
        $material->save();

        $status = $material->is_locked ? 'dikunci' : 'dibuka';
        return redirect()->back()->with('success', 'Material berhasil ' . $status);
    }
}