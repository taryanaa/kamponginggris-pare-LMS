<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data tugas dari database
        $tasks = Task::with(['mentor', 'material'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Hitung statistik
        $totalTasks = Task::count();
        $completedTasks = TaskAssignment::where('status', 'approved')->count();
        $pendingTasks = TaskAssignment::where('status', 'assigned')->count();
        $revisionTasks = TaskAssignment::where('status', 'revision_needed')->count();

        return view('task', compact('tasks', 'totalTasks', 'completedTasks', 'pendingTasks', 'revisionTasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mentors = User::where('role', 'mentor')->get();
        return view('task.create', compact('mentors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'material_id' => 'nullable|exists:materials,id',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'deadline' => 'required|date',
            'mentor_id' => 'required|exists:users,id'
        ]);

        Task::create($validated);

        return redirect()->route('task.index')->with('success', 'Tugas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with(['mentor', 'material', 'assignments.student'])
                   ->findOrFail($id);
        
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        $mentors = User::where('role', 'mentor')->get();
        
        return view('task.edit', compact('task', 'mentors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'material_id' => 'nullable|exists:materials,id',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'deadline' => 'required|date',
            'mentor_id' => 'required|exists:users,id'
        ]);

        $task->update($validated);

        return redirect()->route('task.index')->with('success', 'Tugas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('task.index')->with('success', 'Tugas berhasil dihapus');
    }

    /**
     * Assign task to students
     */
    public function assign(Request $request, $taskId)
    {
        $validated = $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id'
        ]);

        $task = Task::findOrFail($taskId);

        foreach ($validated['student_ids'] as $studentId) {
            TaskAssignment::create([
                'task_id' => $taskId,
                'student_id' => $studentId,
                'status' => 'assigned'
            ]);
        }

        return redirect()->route('task.show', $taskId)->with('success', 'Tugas berhasil ditugaskan kepada siswa');
    }

    /**
     * Update task assignment status
     */
    public function updateAssignment(Request $request, $assignmentId)
    {
        $assignment = TaskAssignment::findOrFail($assignmentId);

        $validated = $request->validate([
            'status' => 'required|in:assigned,submitted,approved,revision_needed',
            'feedback' => 'nullable|string',
            'score' => 'nullable|numeric|min:0|max:100'
        ]);

        $assignment->update($validated);

        return redirect()->back()->with('success', 'Status tugas berhasil diperbarui');
    }
}