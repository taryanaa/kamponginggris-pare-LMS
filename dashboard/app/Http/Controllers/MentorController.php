<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Material;
use App\Models\Schedule;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\ProgressReport;

class MentorController extends Controller
{
    /**
     * Display mentor dashboard
     */
public function index()
{
    $mentor = auth()->user();
    $mentorId = $mentor->id;
    
    // Statistik utama
    $totalStudents = User::where('role', 'student')->count();
    
    // Materials stats
    $totalMaterials = Material::where('mentor_id', $mentorId)->count();
    
    // Schedules stats
    $upcomingSessions = Schedule::where('mentor_id', $mentorId)
        ->where('schedule_date', '>=', now()->format('Y-m-d'))
        ->where('status', 'scheduled')
        ->count();
        
    // Tasks stats
    $pendingReviews = TaskAssignment::whereHas('task', function($query) use ($mentorId) {
        $query->where('mentor_id', $mentorId);
    })->where('status', 'submitted')->count();
    
    // Data untuk charts
    $studentPerformance = DB::table('basic_english_results')
        ->select(
            DB::raw('AVG(total_percentage) as avg_score'),
            DB::raw('COUNT(*) as total_tests')
        )
        ->first();
        
    // Upcoming sessions detail
    $upcomingSessionsDetail = Schedule::with(['student'])
        ->where('mentor_id', $mentorId)
        ->where('schedule_date', '>=', now()->format('Y-m-d'))
        ->where('status', 'scheduled')
        ->orderBy('schedule_date', 'asc')
        ->orderBy('schedule_time', 'asc')
        ->limit(5)
        ->get();
        
    // Recent student activities (from task submissions)
    $recentActivities = TaskAssignment::with(['student', 'task'])
        ->whereHas('task', function($query) use ($mentorId) {
            $query->where('mentor_id', $mentorId);
        })
        ->whereNotNull('submitted_at')
        ->orderBy('submitted_at', 'desc')
        ->limit(5)
        ->get();

    return view('mentor.mentor', compact(
        'mentor',
        'totalStudents',
        'totalMaterials',
        'upcomingSessions',
        'pendingReviews',
        'studentPerformance',
        'upcomingSessionsDetail',
        'recentActivities'
    ));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mentor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Store new mentor logic
        return redirect()->route('mentor.index')->with('success', 'Mentor berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mentor = User::where('id', $id)->where('role', 'mentor')->firstOrFail();
        return view('mentor.show', compact('mentor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mentor = User::where('id', $id)->where('role', 'mentor')->firstOrFail();
        return view('mentor.edit', compact('mentor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mentor = User::where('id', $id)->where('role', 'mentor')->firstOrFail();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'specialization' => 'nullable|string|max:255'
        ]);

        $mentor->update($validated);

        return redirect()->route('mentor.index')->with('success', 'Data mentor berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mentor = User::where('id', $id)->where('role', 'mentor')->firstOrFail();
        $mentor->delete();

        return redirect()->route('mentor.index')->with('success', 'Mentor berhasil dihapus');
    }

    // Material Methods
    public function materials()
    {
        $mentor = auth()->user();
        $materials = Material::where('mentor_id', $mentor->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('mentor.materials', compact('materials'));
    }

    public function storeMaterial(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'level' => 'required|string',
            'description' => 'nullable|string',
            'material_file' => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,mp4,avi,mov|max:10240'
        ]);

        $material = new Material();
        $material->title = $request->title;
        $material->level = $request->level;
        $material->description = $request->description;
        $material->mentor_id = auth()->id();

        if ($request->hasFile('material_file')) {
            $file = $request->file('material_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials', $fileName, 'public');
            
            $material->file_path = $filePath;
            $material->file_name = $file->getClientOriginalName();
            $material->file_size = $file->getSize();
        }

        $material->save();

        return redirect()->route('mentor.materials')->with('success', 'Material uploaded successfully!');
    }

    // Schedule Methods
    public function schedules()
    {
        $mentor = auth()->user();
        $students = User::where('role', 'student')->get();
        $schedules = Schedule::with(['student'])
            ->where('mentor_id', $mentor->id)
            ->orderBy('schedule_date', 'desc')
            ->orderBy('schedule_time', 'desc')
            ->get();
            
        return view('mentor.schedules', compact('schedules', 'students'));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'lesson_type' => 'required|string|max:100',
            'schedule_date' => 'required|date',
            'schedule_time' => 'required',
            'location' => 'required|in:online,offline',
            'meeting_link' => 'nullable|url',
            'notes' => 'nullable|string'
        ]);

        $schedule = new Schedule();
        $schedule->student_id = $request->student_id;
        $schedule->mentor_id = auth()->id();
        $schedule->lesson_type = $request->lesson_type;
        $schedule->schedule_date = $request->schedule_date;
        $schedule->schedule_time = $request->schedule_time;
        $schedule->location = $request->location;
        $schedule->meeting_link = $request->meeting_link;
        $schedule->notes = $request->notes;
        $schedule->save();

        return redirect()->route('mentor.schedules')->with('success', 'Schedule created successfully!');
    }

    // Progress Methods
    public function progress()
    {
        $mentor = auth()->user();
        $students = User::where('role', 'student')->get();
        $materials = Material::where('mentor_id', $mentor->id)->get();
        $progressReports = ProgressReport::with(['student', 'material'])
            ->where('mentor_id', $mentor->id)
            ->orderBy('progress_date', 'desc')
            ->get();
            
        return view('mentor.progress', compact('progressReports', 'students', 'materials'));
    }

    public function storeProgress(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'material_id' => 'nullable|exists:materials,id',
            'achievement_score' => 'required|numeric|min:0|max:100',
            'last_activity' => 'required|string|max:255',
            'feedback_notes' => 'required|string',
            'progress_date' => 'required|date'
        ]);

        $progress = new ProgressReport();
        $progress->student_id = $request->student_id;
        $progress->mentor_id = auth()->id();
        $progress->material_id = $request->material_id;
        $progress->achievement_score = $request->achievement_score;
        $progress->last_activity = $request->last_activity;
        $progress->feedback_notes = $request->feedback_notes;
        $progress->progress_date = $request->progress_date;
        $progress->save();

        return redirect()->route('mentor.progress')->with('success', 'Progress report saved successfully!');
    }

    // Task Methods
    public function tasks()
    {
        $mentor = auth()->user();
        $students = User::where('role', 'student')->get();
        $materials = Material::where('mentor_id', $mentor->id)->get();
        
        $tasks = Task::with(['assignments.student'])
            ->where('mentor_id', $mentor->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $pendingSubmissions = TaskAssignment::with(['student', 'task'])
            ->whereHas('task', function($query) use ($mentor) {
                $query->where('mentor_id', $mentor->id);
            })
            ->where('status', 'submitted')
            ->get();

        return view('mentor.tasks', compact('tasks', 'students', 'materials', 'pendingSubmissions'));
    }

    public function storeTask(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'material_id' => 'nullable|exists:materials,id',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'deadline' => 'required|date',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id'
        ]);

        // Create task
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->material_id = $request->material_id;
        $task->difficulty_level = $request->difficulty_level;
        $task->deadline = $request->deadline;
        $task->mentor_id = auth()->id();
        $task->save();

        // Assign to students
        foreach ($request->student_ids as $studentId) {
            $assignment = new TaskAssignment();
            $assignment->task_id = $task->id;
            $assignment->student_id = $studentId;
            $assignment->save();
        }

        return redirect()->route('mentor.tasks')->with('success', 'Task assigned successfully!');
    }

    public function reviewTask(Request $request, $assignmentId)
    {
        $request->validate([
            'feedback' => 'required|string',
            'status' => 'required|in:approved,revision_needed',
            'score' => 'nullable|numeric|min:0|max:100'
        ]);

        $assignment = TaskAssignment::findOrFail($assignmentId);
        
        // Check if mentor owns this task
        if ($assignment->task->mentor_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $assignment->feedback = $request->feedback;
        $assignment->status = $request->status;
        $assignment->score = $request->score;
        $assignment->reviewed_at = now();
        $assignment->save();

        return redirect()->route('mentor.tasks')->with('success', 'Task reviewed successfully!');
    }
}