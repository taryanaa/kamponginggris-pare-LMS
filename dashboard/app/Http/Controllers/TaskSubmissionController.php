<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TaskSubmissionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all tasks assigned to student
        $tasks = DB::table('task_assignments')
            ->join('tasks', 'task_assignments.task_id', '=', 'tasks.id')
            ->leftJoin('materials', 'tasks.material_id', '=', 'materials.id')
            ->leftJoin('users as mentors', 'tasks.mentor_id', '=', 'mentors.id')
            ->where('task_assignments.student_id', $user->id)
            ->select(
                'task_assignments.*',
                'tasks.title',
                'tasks.description',
                'tasks.difficulty_level',
                'tasks.deadline',
                'materials.title as material_title',
                'materials.id as material_id',
                'mentors.name as mentor_name'
            )
            ->orderBy('tasks.deadline', 'asc')
            ->get();
        
        return view('user.tasks', compact('tasks'));
    }
    
    public function submit(Request $request, $assignmentId)
    {
        $user = Auth::user();
        
        // Validate assignment belongs to user
        $assignment = DB::table('task_assignments')
            ->where('id', $assignmentId)
            ->where('student_id', $user->id)
            ->first();
        
        if (!$assignment) {
            return redirect()->back()->with('error', 'Assignment not found.');
        }
        
        $request->validate([
            'submission_type' => 'required|in:text,file',
            'submission_content' => 'required_if:submission_type,text',
            'submission_file' => 'required_if:submission_type,file|file|max:10240' // Max 10MB
        ]);
        
        $submissionFile = null;
        
        // Handle file upload
        if ($request->submission_type === 'file' && $request->hasFile('submission_file')) {
            $file = $request->file('submission_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('task_submissions', $filename, 'public');
            $submissionFile = $path;
        }
        
        // Update task assignment
        DB::table('task_assignments')
            ->where('id', $assignmentId)
            ->update([
                'status' => 'submitted',
                'submission_content' => $request->submission_type === 'text' ? $request->submission_content : null,
                'submission_file' => $submissionFile,
                'submitted_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        
        // Create learning activity record
        $task = DB::table('tasks')
            ->join('task_assignments', 'tasks.id', '=', 'task_assignments.task_id')
            ->where('task_assignments.id', $assignmentId)
            ->select('tasks.*')
            ->first();
        
        DB::table('daily_learning_activities')->insert([
            'student_id' => $user->id,
            'material_type' => 'exercise',
            'material_id' => $task->material_id,
            'material_name' => $task->title,
            'activity_type' => 'Task Submitted',
            'progress_percentage' => 50, // 50% when submitted, 100% when approved
            'activity_date' => Carbon::now()->toDateString(),
            'created_at' => Carbon::now()
        ]);
        
        return redirect()->route('user.tasks')->with('success', 'Task submitted successfully! Waiting for mentor review.');
    }
    
    public function show($assignmentId)
    {
        $user = Auth::user();
        
        // Get task details
        $task = DB::table('task_assignments')
            ->join('tasks', 'task_assignments.task_id', '=', 'tasks.id')
            ->leftJoin('materials', 'tasks.material_id', '=', 'materials.id')
            ->leftJoin('users as mentors', 'tasks.mentor_id', '=', 'mentors.id')
            ->where('task_assignments.id', $assignmentId)
            ->where('task_assignments.student_id', $user->id)
            ->select(
                'task_assignments.*',
                'tasks.title',
                'tasks.description',
                'tasks.difficulty_level',
                'tasks.deadline',
                'materials.title as material_title',
                'materials.id as material_id',
                'materials.file_path as material_file',
                'mentors.name as mentor_name'
            )
            ->first();
        
        if (!$task) {
            return redirect()->route('user.tasks')->with('error', 'Task not found.');
        }
        
        return view('user.task_detail', compact('task'));
    }
}