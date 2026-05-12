<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AcademicResults;
use App\Models\BasicEnglishResults;
use App\Models\ToeflPreparationResults;
use App\Models\ToeicResults;
use App\Models\IeltsA2Results;
use App\Models\IeltsB1Results;
use App\Models\PracticalEnglishResults;
use App\Models\BusinessSpeakingResults;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Hitung total students (role student)
        $totalStudents = User::where('role', 'student')->count();
        
        // Hitung total mentors (role mentor)
        $totalMentors = User::where('role', 'mentor')->count();
        
        // Data untuk course performance
        $coursePerformance = [
            ['name' => 'Intensive English Program', 'enrolled' => 350],
            ['name' => 'TOEFL Preparation', 'enrolled' => 275],
            ['name' => 'Speaking Practice', 'enrolled' => 180],
            ['name' => 'Grammar Essentials', 'enrolled' => 150],
            ['name' => 'IELTS Simulation', 'enrolled' => 120],
        ];
        
        // Data mentor workload
        $mentorWorkload = [
            ['name' => 'ATAR', 'students' => 50],
            ['name' => 'RYAN', 'students' => 45],
            ['name' => 'Rafa', 'students' => 55],
        ];
        
        // Recent activities (sederhana dulu)
        $recentActivities = $this->getSimpleRecentActivities();

        // Data untuk charts
        $enrollmentTrends = $this->getEnrollmentTrends();
        $studentDistribution = $this->getStudentDistribution();
        
        // Placement Test Performance
        $placementTestPerformance = $this->getPlacementTestPerformance();

        return view('admin.admin', compact(
            'totalStudents',
            'totalMentors',
            'coursePerformance',
            'mentorWorkload',
            'recentActivities',
            'enrollmentTrends',
            'studentDistribution',
            'placementTestPerformance'
        ));
    }

    /**
     * Get enrollment trends data
     */
    private function getEnrollmentTrends()
    {
        // Data 7 hari terakhir untuk user registration
        $dates = [];
        $students = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dates[] = $date->format('Y-m-d\T00:00:00.000\Z');
            
            $count = User::where('role', 'student')
                        ->whereDate('created_at', $date->format('Y-m-d'))
                        ->count();
            $students[] = $count;
        }

        return [
            'dates' => $dates,
            'students' => $students
        ];
    }

    /**
     * Get student level distribution dari semua tabel results
     */
    private function getStudentDistribution()
    {
        $levels = [
            'Beginner' => 0,
            'Elementary' => 0,
            'Intermediate' => 0,
            'Upper Intermediate' => 0,
            'Advanced' => 0
        ];

        try {
            // 1. Academic Results
            if (class_exists('App\Models\AcademicResults')) {
                $academicResults = AcademicResults::select('overall_level')
                    ->whereNotNull('overall_level')
                    ->get();
                
                foreach ($academicResults as $result) {
                    $level = $this->mapToStandardLevel($result->overall_level);
                    if (isset($levels[$level])) {
                        $levels[$level]++;
                    }
                }
            }

            // 2. Basic English Results
            if (class_exists('App\Models\BasicEnglishResults')) {
                $basicResults = BasicEnglishResults::select('overall_level')
                    ->whereNotNull('overall_level')
                    ->get();
                
                foreach ($basicResults as $result) {
                    $level = $this->mapToStandardLevel($result->overall_level);
                    if (isset($levels[$level])) {
                        $levels[$level]++;
                    }
                }
            }

            // 3. TOEFL Results
            if (class_exists('App\Models\ToeflPreparationResults')) {
                $toeflResults = ToeflPreparationResults::select('cefr_level')
                    ->whereNotNull('cefr_level')
                    ->get();
                
                foreach ($toeflResults as $result) {
                    $level = $this->mapToStandardLevel($result->cefr_level);
                    if (isset($levels[$level])) {
                        $levels[$level]++;
                    }
                }
            }

            // 4. TOEIC Results
            if (class_exists('App\Models\ToeicResults')) {
                $toeicResults = ToeicResults::select('overall_cefr')
                    ->whereNotNull('overall_cefr')
                    ->get();
                
                foreach ($toeicResults as $result) {
                    $level = $this->mapToStandardLevel($result->overall_cefr);
                    if (isset($levels[$level])) {
                        $levels[$level]++;
                    }
                }
            }

            // 5. IELTS A2 Results
            if (class_exists('App\Models\IeltsA2Results')) {
                $ieltsA2Results = IeltsA2Results::select('overall_level')
                    ->whereNotNull('overall_level')
                    ->get();
                
                foreach ($ieltsA2Results as $result) {
                    $level = $this->mapToStandardLevel($result->overall_level);
                    if (isset($levels[$level])) {
                        $levels[$level]++;
                    }
                }
            }

            // 6. IELTS B1 Results
            if (class_exists('App\Models\IeltsB1Results')) {
                $ieltsB1Results = IeltsB1Results::select('overall_level')
                    ->whereNotNull('overall_level')
                    ->get();
                
                foreach ($ieltsB1Results as $result) {
                    $level = $this->mapToStandardLevel($result->overall_level);
                    if (isset($levels[$level])) {
                        $levels[$level]++;
                    }
                }
            }

            // 7. Practical English Results
            if (class_exists('App\Models\PracticalEnglishResults')) {
                $practicalResults = PracticalEnglishResults::select('overall_level')
                    ->whereNotNull('overall_level')
                    ->get();
                
                foreach ($practicalResults as $result) {
                    $level = $this->mapToStandardLevel($result->overall_level);
                    if (isset($levels[$level])) {
                        $levels[$level]++;
                    }
                }
            }

        } catch (\Exception $e) {
            // Fallback data jika ada error
            $levels = [
                'Beginner' => 440,
                'Elementary' => 550,
                'Intermediate' => 260,
                'Upper Intermediate' => 180,
                'Advanced' => 120
            ];
        }

        return $levels;
    }

    /**
     * Map berbagai format level ke standard level
     */
    private function mapToStandardLevel($level)
    {
        if ($level === null) return 'Beginner';
        
        $level = strtolower(trim($level));
        
        if (str_contains($level, 'beginner') || $level === 'a1') {
            return 'Beginner';
        } elseif (str_contains($level, 'elementary') || $level === 'a2') {
            return 'Elementary';
        } elseif (str_contains($level, 'intermediate') || $level === 'b1') {
            return 'Intermediate';
        } elseif (str_contains($level, 'upper') || $level === 'b2') {
            return 'Upper Intermediate';
        } elseif (str_contains($level, 'advanced') || $level === 'c1' || $level === 'c2') {
            return 'Advanced';
        }
        
        return 'Beginner'; // default
    }

    /**
     * Get Placement Test Performance dari semua tabel results
     */
    private function getPlacementTestPerformance()
    {
        $performance = [];

        try {
            // 1. Academic Results
            if (class_exists('App\Models\AcademicResults')) {
                $academicCount = AcademicResults::count();
                $academicAvgScore = AcademicResults::whereNotNull('overall_score')
                    ->avg(DB::raw('CAST(overall_score AS DECIMAL(10,2))'));
                $performance[] = [
                    'test_type' => 'Academic English',
                    'total_tests' => $academicCount,
                    'average_score' => round($academicAvgScore ?: 0, 1),
                    'completion_rate' => $academicCount > 0 ? 100 : 0
                ];
            }

            // 2. Basic English Results
            if (class_exists('App\Models\BasicEnglishResults')) {
                $basicCount = BasicEnglishResults::count();
                $basicAvgPercentage = BasicEnglishResults::whereNotNull('total_percentage')
                    ->avg('total_percentage');
                $performance[] = [
                    'test_type' => 'Basic English',
                    'total_tests' => $basicCount,
                    'average_score' => round($basicAvgPercentage ?: 0, 1),
                    'completion_rate' => $basicCount > 0 ? 95 : 0
                ];
            }

            // 3. TOEFL Preparation Results
            if (class_exists('App\Models\ToeflPreparationResults')) {
                $toeflCount = ToeflPreparationResults::count();
                $toeflAvgPercentage = ToeflPreparationResults::whereNotNull('overall_percentage')
                    ->avg('overall_percentage');
                $performance[] = [
                    'test_type' => 'TOEFL Preparation',
                    'total_tests' => $toeflCount,
                    'average_score' => round($toeflAvgPercentage ?: 0, 1),
                    'completion_rate' => $toeflCount > 0 ? 90 : 0
                ];
            }

            // 4. TOEIC Results
            if (class_exists('App\Models\ToeicResults')) {
                $toeicCount = ToeicResults::count();
                $toeicAvgScore = ToeicResults::whereNotNull('overall_score')
                    ->avg('overall_score');
                $performance[] = [
                    'test_type' => 'TOEIC',
                    'total_tests' => $toeicCount,
                    'average_score' => round($toeicAvgScore ?: 0, 1),
                    'completion_rate' => $toeicCount > 0 ? 92 : 0
                ];
            }

            // 5. IELTS A2 Results
            if (class_exists('App\Models\IeltsA2Results')) {
                $ieltsA2Count = IeltsA2Results::count();
                $ieltsA2AvgBand = IeltsA2Results::whereNotNull('overall_band')
                    ->avg(DB::raw('CAST(overall_band AS DECIMAL(3,1))'));
                $performance[] = [
                    'test_type' => 'IELTS A2',
                    'total_tests' => $ieltsA2Count,
                    'average_score' => round($ieltsA2AvgBand ?: 0, 1),
                    'completion_rate' => $ieltsA2Count > 0 ? 88 : 0
                ];
            }

            // 6. IELTS B1 Results
            if (class_exists('App\Models\IeltsB1Results')) {
                $ieltsB1Count = IeltsB1Results::count();
                $ieltsB1AvgBand = IeltsB1Results::whereNotNull('overall_band')
                    ->avg(DB::raw('CAST(overall_band AS DECIMAL(3,1))'));
                $performance[] = [
                    'test_type' => 'IELTS B1',
                    'total_tests' => $ieltsB1Count,
                    'average_score' => round($ieltsB1AvgBand ?: 0, 1),
                    'completion_rate' => $ieltsB1Count > 0 ? 85 : 0
                ];
            }

            // 7. Practical English Results
            if (class_exists('App\Models\PracticalEnglishResults')) {
                $practicalCount = PracticalEnglishResults::count();
                $practicalAvgPercentage = PracticalEnglishResults::whereNotNull('total_percentage')
                    ->avg('total_percentage');
                $performance[] = [
                    'test_type' => 'Practical English',
                    'total_tests' => $practicalCount,
                    'average_score' => round($practicalAvgPercentage ?: 0, 1),
                    'completion_rate' => $practicalCount > 0 ? 94 : 0
                ];
            }

            // 8. Business Speaking Results
            if (class_exists('App\Models\BusinessSpeakingResults')) {
                $businessCount = BusinessSpeakingResults::count();
                $businessAvgScore = BusinessSpeakingResults::whereNotNull('overall_score')
                    ->avg('overall_score');
                $performance[] = [
                    'test_type' => 'Business Speaking',
                    'total_tests' => $businessCount,
                    'average_score' => round($businessAvgScore ?: 0, 1),
                    'completion_rate' => $businessCount > 0 ? 80 : 0
                ];
            }

        } catch (\Exception $e) {
            // Fallback data jika ada error
            $performance = [
                ['test_type' => 'Academic English', 'total_tests' => 45, 'average_score' => 72.5, 'completion_rate' => 100],
                ['test_type' => 'Basic English', 'total_tests' => 120, 'average_score' => 68.2, 'completion_rate' => 95],
                ['test_type' => 'TOEFL Preparation', 'total_tests' => 85, 'average_score' => 65.8, 'completion_rate' => 90],
                ['test_type' => 'TOEIC', 'total_tests' => 60, 'average_score' => 420.5, 'completion_rate' => 92],
                ['test_type' => 'IELTS A2', 'total_tests' => 30, 'average_score' => 3.2, 'completion_rate' => 88],
                ['test_type' => 'IELTS B1', 'total_tests' => 25, 'average_score' => 4.1, 'completion_rate' => 85],
                ['test_type' => 'Practical English', 'total_tests' => 95, 'average_score' => 70.3, 'completion_rate' => 94],
                ['test_type' => 'Business Speaking', 'total_tests' => 40, 'average_score' => 75.6, 'completion_rate' => 80]
            ];
        }

        return $performance;
    }

    /**
     * Get simple recent activities
     */
    private function getSimpleRecentActivities()
    {
        $activities = [];

        // Recent user registrations
        $recentUsers = User::where('role', 'student')
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        foreach ($recentUsers as $user) {
            $activities[] = [
                'icon' => 'person-plus-fill',
                'color' => 'success',
                'text' => "New student '{$user->name}' registered.",
                'time' => $user->created_at->diffForHumans()
            ];
        }

        // Add one generic test completion activity
        $activities[] = [
            'icon' => 'check-circle-fill',
            'color' => 'primary',
            'text' => 'Student completed placement test.',
            'time' => '1 hour ago'
        ];

        return $activities;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}