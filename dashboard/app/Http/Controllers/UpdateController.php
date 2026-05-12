<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Schedule;
use App\Models\ProgressReport;
use App\Models\Material;
use App\Models\TaskAssignment;

class UpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil update terbaru dari berbagai tabel
        $recentTasks = Task::with('mentor')
                          ->orderBy('created_at', 'desc')
                          ->limit(5)
                          ->get();

        $upcomingSchedules = Schedule::with(['student', 'mentor'])
                                    ->where('schedule_date', '>=', now()->format('Y-m-d'))
                                    ->where('status', 'scheduled')
                                    ->orderBy('schedule_date', 'asc')
                                    ->orderBy('schedule_time', 'asc')
                                    ->limit(5)
                                    ->get();

        $recentProgress = ProgressReport::with(['student', 'mentor'])
                                       ->orderBy('progress_date', 'desc')
                                       ->limit(5)
                                       ->get();

        $newMaterials = Material::with('mentor')
                               ->orderBy('created_at', 'desc')
                               ->limit(5)
                               ->get();

        $pendingAssignments = TaskAssignment::with(['task', 'student'])
                                          ->where('status', 'submitted')
                                          ->orderBy('submitted_at', 'desc')
                                          ->limit(5)
                                          ->get();

        // Hitung statistik
        $totalUpdates = Task::count() + Schedule::count() + ProgressReport::count() + Material::count();
        $pendingReviews = TaskAssignment::where('status', 'submitted')->count();
        $todaySchedules = Schedule::where('schedule_date', now()->format('Y-m-d'))->count();

        return view('update', compact(
            'recentTasks', 
            'upcomingSchedules', 
            'recentProgress', 
            'newMaterials', 
            'pendingAssignments',
            'totalUpdates',
            'pendingReviews',
            'todaySchedules'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('update.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Method untuk membuat update baru (jika diperlukan)
        // Bisa digunakan untuk announcements atau system updates
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:announcement,maintenance,update'
        ]);

        // Simpan ke database jika ada tabel updates
        // Update::create($validated);

        return redirect()->route('update.index')->with('success', 'Update berhasil diposting');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Tampilkan detail update tertentu
        return view('update.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('update.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Update data tertentu
        return redirect()->route('update.index')->with('success', 'Update berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hapus update
        return redirect()->route('update.index')->with('success', 'Update berhasil dihapus');
    }

    /**
     * Get dashboard statistics
     */
    public function dashboardStats()
    {
        $stats = [
            'totalStudents' => \App\Models\User::where('role', 'student')->count(),
            'totalMentors' => \App\Models\User::where('role', 'mentor')->count(),
            'totalTasks' => Task::count(),
            'completedTasks' => TaskAssignment::where('status', 'approved')->count(),
            'upcomingSchedules' => Schedule::where('schedule_date', '>=', now()->format('Y-m-d'))
                                         ->where('status', 'scheduled')
                                         ->count(),
            'totalMaterials' => Material::count()
        ];

        return response()->json($stats);
    }
}