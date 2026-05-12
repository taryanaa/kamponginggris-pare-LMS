<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get student's current level and course info
        $studentProfile = $this->getStudentProfile($user->id, $user->email);
        
        // Get quick stats
        $stats = $this->getStudentStats($user->id);
        
        // Get learning time for chart (last 7 days)
        $learningTime = $this->getLearningTimeData($user->id);
        
        // Get upcoming classes
        $upcomingClasses = $this->getUpcomingClasses($user->id);
        
        // Get pending assignments (tasks)
        $pendingAssignments = $this->getPendingAssignments($user->id);
        
        // Get mentor feedback
        $mentorFeedback = $this->getLatestMentorFeedback($user->id);
        
        // Get quiz average score
        $quizScore = $this->getQuizAverageScore($user->id);
        
        // Get study streak
        $studyStreak = $this->getStudyStreak($user->id);
        
        // Get attendance data
        $attendanceData = $this->getAttendanceData($user->id);
        
        return view('user.student', compact(
            'user',
            'studentProfile',
            'stats',
            'learningTime',
            'upcomingClasses',
            'pendingAssignments',
            'mentorFeedback',
            'quizScore',
            'studyStreak',
            'attendanceData'
        ));
    }
    
    private function getStudentProfile($userId, $email)
    {
        // Get latest test result to determine level
        $latestTest = DB::table('basic_english_results')
            ->where('user_email', $email)
            ->orderBy('created_at', 'desc')
            ->first();
        
        // Calculate progress from tasks
        $totalTasks = DB::table('task_assignments')
            ->where('student_id', $userId)
            ->count();
        
        $completedTasks = DB::table('task_assignments')
            ->where('student_id', $userId)
            ->where('status', 'approved')
            ->count();
        
        $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 0) : 0;
        
        return [
            'level' => $latestTest->overall_level ?? 'Level 1',
            'course' => 'Intensive English Program',
            'progress' => $progress
        ];
    }
    
    public function storeAttendance(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();
        
        // Check if already marked
        $exists = DB::table('student_attendance')
            ->where('student_id', $user->id)
            ->whereDate('attendance_date', $today)
            ->exists();
        
        if (!$exists) {
            DB::table('student_attendance')->insert([
                'student_id' => $user->id,
                'attendance_date' => $today,
                'check_in_time' => Carbon::now()->format('H:i:s'),
                'status' => 'present',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            return redirect()->back()->with('success', 'Attendance marked successfully!');
        }
        
        return redirect()->back()->with('info', 'You have already marked your attendance today.');
    }
    
    private function getStudentStats($userId)
    {
        // Get completed lessons count from approved tasks
        $completedLessons = DB::table('task_assignments')
            ->where('student_id', $userId)
            ->where('status', 'approved')
            ->count();
        
        return [
            'current_level' => 'Level 2',
            'completed_lessons' => $completedLessons,
        ];
    }
    
    private function getLearningTimeData($userId)
    {
        // Get learning time for last 7 days
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            
            // Calculate minutes from attendance or activity logs
            $minutes = DB::table('student_attendance')
                ->where('student_id', $userId)
                ->whereDate('attendance_date', $date)
                ->sum('duration_minutes') ?? rand(30, 90);
            
            $data[] = $minutes;
        }
        
        return $data;
    }
    
    private function getUpcomingClasses($userId)
    {
        return DB::table('schedules')
            ->join('users as mentors', 'schedules.mentor_id', '=', 'mentors.id')
            ->where('schedules.student_id', $userId)
            ->where('schedules.status', 'scheduled')
            ->where('schedules.schedule_date', '>=', Carbon::now()->toDateString())
            ->select(
                'schedules.*',
                'mentors.name as mentor_name'
            )
            ->orderBy('schedules.schedule_date')
            ->orderBy('schedules.schedule_time')
            ->limit(5)
            ->get();
    }
    
    private function getPendingAssignments($userId)
    {
        return DB::table('task_assignments')
            ->join('tasks', 'task_assignments.task_id', '=', 'tasks.id')
            ->where('task_assignments.student_id', $userId)
            ->whereIn('task_assignments.status', ['assigned', 'revision_needed'])
            ->where('tasks.deadline', '>=', Carbon::now()->toDateString())
            ->select(
                'task_assignments.*',
                'tasks.title',
                'tasks.deadline',
                'tasks.difficulty_level',
                'tasks.description'
            )
            ->orderBy('tasks.deadline')
            ->limit(5)
            ->get();
    }
    
    private function getLatestMentorFeedback($userId)
    {
        return DB::table('progress_reports')
            ->join('users as mentors', 'progress_reports.mentor_id', '=', 'mentors.id')
            ->where('progress_reports.student_id', $userId)
            ->select(
                'progress_reports.*',
                'mentors.name as mentor_name',
                'mentors.profile_photo as mentor_photo'
            )
            ->orderBy('progress_reports.created_at', 'desc')
            ->first();
    }
    
    private function getQuizAverageScore($userId)
    {
        // Calculate average from task scores
        $taskAverage = DB::table('task_assignments')
            ->where('student_id', $userId)
            ->whereNotNull('score')
            ->avg('score');
        
        return $taskAverage ? round($taskAverage, 1) : 0;
    }
    
    private function getStudyStreak($userId)
    {
        // Calculate consecutive days of attendance
        $attendances = DB::table('student_attendance')
            ->where('student_id', $userId)
            ->where('status', 'present')
            ->orderBy('attendance_date', 'desc')
            ->pluck('attendance_date')
            ->toArray();
        
        if (empty($attendances)) {
            return 0;
        }
        
        $streak = 1;
        $currentDate = Carbon::parse($attendances[0]);
        
        for ($i = 1; $i < count($attendances); $i++) {
            $prevDate = Carbon::parse($attendances[$i]);
            
            if ($currentDate->diffInDays($prevDate) === 1) {
                $streak++;
                $currentDate = $prevDate;
            } else {
                break;
            }
        }
        
        return $streak;
    }
    
    private function getAttendanceData($userId)
    {
        $today = Carbon::now()->toDateString();
        
        $attendance = DB::table('student_attendance')
            ->where('student_id', $userId)
            ->whereDate('attendance_date', $today)
            ->first();
        
        return [
            'is_present' => $attendance ? true : false,
            'attendance_time' => $attendance->check_in_time ?? null,
            'status' => $attendance->status ?? 'absent'
        ];
    }
}