<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TalkMentorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get schedules for this student
        $schedules = DB::table('schedules')
            ->join('users as mentors', 'schedules.mentor_id', '=', 'mentors.id')
            ->where('schedules.student_id', $user->id)
            ->where('schedules.status', 'scheduled')
            ->where('schedules.schedule_date', '>=', Carbon::today())
            ->select(
                'schedules.*',
                'mentors.name as mentor_name',
                'mentors.phone as mentor_phone'
            )
            ->orderBy('schedules.schedule_date', 'asc')
            ->orderBy('schedules.schedule_time', 'asc')
            ->get();
        
        // Calculate overall progress from completed tasks
        $totalTasks = DB::table('task_assignments')
            ->where('student_id', $user->id)
            ->count();
        
        $completedTasks = DB::table('task_assignments')
            ->where('student_id', $user->id)
            ->where('status', 'approved')
            ->count();
        
        $overallProgress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 0) : 0;
        
        // Get mentor phone for WhatsApp (get primary mentor or first mentor from schedules)
        $mentorPhone = null;
        if ($schedules->count() > 0) {
            $mentorPhone = $schedules->first()->mentor_phone;
        } else {
            // Get any mentor as fallback
            $mentor = DB::table('users')
                ->where('role', 'mentor')
                ->first();
            if ($mentor) {
                $mentorPhone = $mentor->phone;
            }
        }
        
        // Format WhatsApp number (remove non-numeric, add country code if needed)
        if ($mentorPhone) {
            $mentorPhone = preg_replace('/[^0-9]/', '', $mentorPhone);
            // Add +62 if not already there
            if (!str_starts_with($mentorPhone, '62')) {
                // Remove leading 0 if exists
                $mentorPhone = ltrim($mentorPhone, '0');
                $mentorPhone = '62' . $mentorPhone;
            }
        }
        
        return view('user.talk', compact('schedules', 'overallProgress', 'mentorPhone'));
    }
}