<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgressReport;
use App\Models\User;
use App\Models\Material;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data progress dari database
        $progress = ProgressReport::with(['student', 'mentor', 'material'])
                                 ->orderBy('progress_date', 'desc')
                                 ->get();

        // Hitung statistik
        $totalStudents = User::where('role', 'student')->count();
        $averageScore = ProgressReport::avg('achievement_score');
        $excellentStudents = ProgressReport::where('achievement_score', '>=', 85)->count();

        return view('progress', compact('progress', 'totalStudents', 'averageScore', 'excellentStudents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = User::where('role', 'student')->get();
        $mentors = User::where('role', 'mentor')->get();
        $materials = Material::all();
        
        return view('progress.create', compact('students', 'mentors', 'materials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'mentor_id' => 'required|exists:users,id',
            'material_id' => 'nullable|exists:materials,id',
            'achievement_score' => 'required|numeric|min:0|max:100',
            'last_activity' => 'required|string|max:255',
            'feedback_notes' => 'required|string',
            'progress_date' => 'required|date'
        ]);

        ProgressReport::create($validated);

        return redirect()->route('progress.index')->with('success', 'Laporan progress berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $progress = ProgressReport::with(['student', 'mentor', 'material'])->findOrFail($id);
        return view('progress.show', compact('progress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $progress = ProgressReport::findOrFail($id);
        $students = User::where('role', 'student')->get();
        $mentors = User::where('role', 'mentor')->get();
        $materials = Material::all();
        
        return view('progress.edit', compact('progress', 'students', 'mentors', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $progress = ProgressReport::findOrFail($id);

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'mentor_id' => 'required|exists:users,id',
            'material_id' => 'nullable|exists:materials,id',
            'achievement_score' => 'required|numeric|min:0|max:100',
            'last_activity' => 'required|string|max:255',
            'feedback_notes' => 'required|string',
            'progress_date' => 'required|date'
        ]);

        $progress->update($validated);

        return redirect()->route('progress.index')->with('success', 'Laporan progress berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $progress = ProgressReport::findOrFail($id);
        $progress->delete();

        return redirect()->route('progress.index')->with('success', 'Laporan progress berhasil dihapus');
    }

    /**
     * Get student progress report
     */
    public function studentProgress($studentId)
    {
        $student = User::findOrFail($studentId);
        $progressReports = ProgressReport::with(['mentor', 'material'])
                                        ->where('student_id', $studentId)
                                        ->orderBy('progress_date', 'desc')
                                        ->get();

        return view('progress.student', compact('student', 'progressReports'));
    }
}