<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\User;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data jadwal dari database
        $schedules = Schedule::with(['student', 'mentor'])
                            ->orderBy('schedule_date', 'asc')
                            ->orderBy('schedule_time', 'asc')
                            ->get();

        // Hitung statistik
        $totalSchedules = Schedule::count();
        $upcomingSchedules = Schedule::where('schedule_date', '>=', now()->format('Y-m-d'))
                                    ->where('status', 'scheduled')
                                    ->count();
        $completedSchedules = Schedule::where('status', 'completed')->count();

        return view('schedule', compact('schedules', 'totalSchedules', 'upcomingSchedules', 'completedSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = User::where('role', 'student')->get();
        $mentors = User::where('role', 'mentor')->get();
        
        return view('schedule.create', compact('students', 'mentors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'mentor_id' => 'required|exists:users,id',
            'lesson_type' => 'required|string|max:100',
            'schedule_date' => 'required|date',
            'schedule_time' => 'required',
            'location' => 'required|in:online,offline',
            'meeting_link' => 'nullable|string|max:500',
            'notes' => 'nullable|string'
        ]);

        Schedule::create($validated);

        return redirect()->route('schedule.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schedule = Schedule::with(['student', 'mentor'])->findOrFail($id);
        return view('schedule.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $students = User::where('role', 'student')->get();
        $mentors = User::where('role', 'mentor')->get();
        
        return view('schedule.edit', compact('schedule', 'students', 'mentors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'mentor_id' => 'required|exists:users,id',
            'lesson_type' => 'required|string|max:100',
            'schedule_date' => 'required|date',
            'schedule_time' => 'required',
            'location' => 'required|in:online,offline',
            'meeting_link' => 'nullable|string|max:500',
            'status' => 'required|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string'
        ]);

        $schedule->update($validated);

        return redirect()->route('schedule.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedule.index')->with('success', 'Jadwal berhasil dihapus');
    }

    /**
     * Get today's schedules
     */
    public function today()
    {
        $todaySchedules = Schedule::with(['student', 'mentor'])
                                 ->where('schedule_date', now()->format('Y-m-d'))
                                 ->where('status', 'scheduled')
                                 ->orderBy('schedule_time', 'asc')
                                 ->get();

        return view('schedule.today', compact('todaySchedules'));
    }
}