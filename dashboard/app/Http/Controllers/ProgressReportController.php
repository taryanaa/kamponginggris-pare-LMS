<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProgressReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get daily activities including tasks
        $dailyActivities = DB::table('daily_learning_activities')
            ->leftJoin('materials', 'daily_learning_activities.material_id', '=', 'materials.id')
            ->where('daily_learning_activities.student_id', $user->id)
            ->select(
                'daily_learning_activities.*',
                'materials.title as material_title'
            )
            ->orderBy('activity_date', 'desc')
            ->limit(10)
            ->get();
        
        // Get task-based activities
        $taskActivities = DB::table('task_assignments')
            ->join('tasks', 'task_assignments.task_id', '=', 'tasks.id')
            ->leftJoin('materials', 'tasks.material_id', '=', 'materials.id')
            ->where('task_assignments.student_id', $user->id)
            ->whereIn('task_assignments.status', ['submitted', 'approved'])
            ->select(
                DB::raw("'exercise' as material_type"),
                'tasks.material_id',
                'tasks.title as material_name',
                'materials.title as material_title',
                DB::raw("CASE 
                    WHEN task_assignments.status = 'approved' THEN 'Task Completed'
                    WHEN task_assignments.status = 'submitted' THEN 'Task Submitted'
                    ELSE 'Task In Progress'
                END as activity_type"),
                DB::raw("CASE 
                    WHEN task_assignments.status = 'approved' THEN 100
                    WHEN task_assignments.status = 'submitted' THEN 50
                    ELSE 25
                END as progress_percentage"),
                'task_assignments.score',
                'task_assignments.updated_at as activity_date'
            )
            ->orderBy('task_assignments.updated_at', 'desc')
            ->limit(5)
            ->get();
        
        // Merge both activities
        $allActivities = $dailyActivities->merge($taskActivities)
            ->sortByDesc('activity_date')
            ->take(10);
        
        // Calculate overall statistics
        $totalTasks = DB::table('task_assignments')
            ->where('student_id', $user->id)
            ->count();
        
        $completedTasks = DB::table('task_assignments')
            ->where('student_id', $user->id)
            ->where('status', 'approved')
            ->count();
        
        $averageScore = DB::table('task_assignments')
            ->where('student_id', $user->id)
            ->where('status', 'approved')
            ->whereNotNull('score')
            ->avg('score') ?? 0;
        
        $overallProgress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;
        
        // Get weekly scores for chart (last 7 days)
        $weeklyScores = DB::table('task_assignments')
            ->where('student_id', $user->id)
            ->where('status', 'approved')
            ->whereNotNull('score')
            ->whereNotNull('reviewed_at')
            ->whereBetween('reviewed_at', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
            ->select(
                DB::raw('DAYNAME(reviewed_at) as day'),
                DB::raw('AVG(score) as avg_score')
            )
            ->groupBy(DB::raw('DAYNAME(reviewed_at)'), DB::raw('DAYOFWEEK(reviewed_at)'))
            ->orderBy(DB::raw('DAYOFWEEK(reviewed_at)'))
            ->get();
        
        return view('user.report', compact(
            'allActivities',
            'totalTasks',
            'completedTasks',
            'averageScore',
            'overallProgress',
            'weeklyScores'
        ));
    }
}