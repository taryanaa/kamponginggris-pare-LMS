<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\ProgressReportController;
use App\Http\Controllers\PlacementResultsController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskSubmissionController;
use App\Http\Controllers\TalkMentorController;
use App\Http\Controllers\StudentExamController;

// Login routes
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'login'])->name('login.post');

// Authenticated routes
Route::middleware(['auth'])->group(function(){
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard routes untuk setiap role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'mentor':
                return redirect()->route('mentor.dashboard');
            case 'student':
                return redirect()->route('user.dashboard');
            default:
                return redirect()->route('login');
        }
    })->name('dashboard');
    
    // Profile routes - UNTUK SEMUA ROLE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Admin routes
    Route::middleware('role:admin')->group(function() {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/dashboard-admin', [AdminController::class, 'index']);
        
        // Exam Management Routes untuk Admin
        Route::get('/exam-list', [ExamController::class, 'index'])->name('exam.list');
        Route::get('/exam-results', [ExamController::class, 'results'])->name('exam.results');
    });

    // Mentor routes
    Route::middleware('role:mentor')->group(function() {
        Route::get('/mentor', [MentorController::class, 'index'])->name('mentor.dashboard');
        
        // Resource routes untuk mentor dengan prefix /mentor
        Route::prefix('mentor')->group(function() {
            // Materials
            Route::get('/materials', [MaterialController::class, 'index'])->name('mentor.materials');
            Route::post('/materials', [MaterialController::class, 'store'])->name('mentor.materials.store');
            Route::delete('/materials/{id}', [MaterialController::class, 'destroy'])->name('mentor.materials.destroy');
            Route::patch('/materials/{id}/toggle-lock', [MaterialController::class, 'toggleLock'])->name('mentor.materials.toggle-lock');
            Route::get('/materials/{id}/download', [MaterialController::class, 'download'])->name('mentor.materials.download');
            
            // Schedules
            Route::get('/schedules', [MentorController::class, 'schedules'])->name('mentor.schedules');
            Route::post('/schedules', [MentorController::class, 'storeSchedule'])->name('mentor.schedules.store');
            
            // Progress
            Route::get('/progress', [MentorController::class, 'progress'])->name('mentor.progress');
            Route::post('/progress', [MentorController::class, 'storeProgress'])->name('mentor.progress.store');
            
            // Tasks
            Route::get('/tasks', [MentorController::class, 'tasks'])->name('mentor.tasks');
            Route::post('/tasks', [MentorController::class, 'storeTask'])->name('mentor.tasks.store');
            Route::post('/tasks/{assignmentId}/review', [MentorController::class, 'reviewTask'])->name('mentor.tasks.review');
            
            // Exam Results untuk Mentor
            Route::get('/exam-results', [ExamController::class, 'mentorResults'])->name('mentor.exam.results');
        });
    });
    
    // Student routes - DIPERBAIKI
    Route::middleware('role:student')->group(function() {
        // Dashboard
        Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');
        Route::get('/dashboard-student', [UserController::class, 'index']);
        
        // Learning - DENGAN VIEW & DOWNLOAD MATERIAL
        Route::get('/learning-student', [LearningController::class, 'index'])->name('learning.index');
        Route::get('/learning/material/{id}/view', [LearningController::class, 'viewMaterial'])->name('learning.material.view');
        Route::get('/learning/material/{id}/download', [LearningController::class, 'downloadMaterial'])->name('learning.material.download');
        
        // Progress Report
        Route::get('/report-student', [ProgressReportController::class, 'index'])->name('progress.report');
        
        // Attendance
        Route::post('/attendance/store', [UserController::class, 'storeAttendance'])->name('attendance.store');
        
        // Tasks - TASK SUBMISSION SYSTEM
        Route::get('/tasks-student', [TaskSubmissionController::class, 'index'])->name('user.tasks');
        Route::get('/tasks-student/{id}', [TaskSubmissionController::class, 'show'])->name('user.task.show');
        Route::post('/tasks-student/{id}/submit', [TaskSubmissionController::class, 'submit'])->name('user.task.submit');
        
        // Talk Mentor - WITH CONTROLLER
        Route::get('/talk-mentor', [TalkMentorController::class, 'index'])->name('talk.mentor');
        
        // Exam Student - ROUTES YANG DIPERBAIKI
    Route::get('/exam-student', [StudentExamController::class, 'index'])->name('exam.student');
    Route::get('/exam-student/{examId}', [StudentExamController::class, 'show'])->name('exam.student.show');
        // Route::get('/exam-student/{examId}/start', [StudentExamController::class, 'start'])->name('exam.student.start');
        Route::get('/exam/{examId}/take', [StudentExamController::class, 'showExamInterface'])->name('exam.interface');
        
        // API Routes untuk Exam (POST methods)
    Route::post('/api/exam-sessions', [StudentExamController::class, 'createSession'])->name('api.exam.sessions.create');
    Route::post('/api/exam-answers', [StudentExamController::class, 'submitAnswer'])->name('api.exam.answers.submit');
    Route::post('/api/exam-sessions/{sessionId}/finish', [StudentExamController::class, 'finishSession'])->name('api.exam.sessions.finish');
    });
});

// API Routes untuk Exam System - DIPERBAIKI
Route::middleware(['auth'])->prefix('api')->group(function() {
    // Exam Data (GET methods)
    Route::get('/exams', [ExamController::class, 'getExams'])->name('api.exams.list');
    Route::get('/exams/{id}', [ExamController::class, 'getExamForStudent'])->name('api.exams.show');
    
    // Exam Sessions (GET methods)
    Route::get('/exam-sessions/{id}', [StudentExamController::class, 'getSession'])->name('api.exam.sessions.show');
    Route::get('/exam-sessions/{sessionId}/answers', [StudentExamController::class, 'getAnswers'])->name('api.exam.answers.list');
    
    // Audio Files
    Route::get('/audio/{filename}', [ExamController::class, 'getAudio'])->name('api.audio.get');
});

// Placement Results routes
Route::get('/placement-results', [PlacementResultsController::class, 'index'])->name('placement.results');
Route::post('/placement-results/update', [PlacementResultsController::class, 'update'])
    ->name('placement.results.update');
Route::post('/placement-results/delete', [PlacementResultsController::class, 'delete'])
    ->name('placement.results.delete');
Route::get('/placement-results/export', [PlacementResultsController::class, 'export'])
    ->name('placement.results.export');

// Exam Management Routes - DIPERBAIKI
Route::middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/edit-exam', [ExamController::class, 'create'])->name('exam.create');
    Route::post('/exams', [ExamController::class, 'store'])->name('exam.store');
    Route::get('/exams/{id}', [ExamController::class, 'show'])->name('exam.show');
    Route::put('/exams/{id}', [ExamController::class, 'update'])->name('exam.update');
    Route::delete('/exams/{id}', [ExamController::class, 'destroy'])->name('exam.destroy');
    Route::post('/exams/import-csv', [ExamController::class, 'importCSV'])->name('exam.import.csv');
});

// Public Audio Route
Route::get('/exam/audio/{filename}', [ExamController::class, 'getAudio'])->name('exam.audio');

// User Management routes
Route::get('/add-user', function () {
    return view('admin.add', ['user' => null]);
})->name('users.create');
Route::post('/add-user', [UserManagementController::class, 'store'])->name('users.store');
Route::get('/data-admin', [UserManagementController::class, 'index'])->name('users.index');
Route::get('/edit-user/{id}', [UserManagementController::class, 'edit'])->name('users.edit');
Route::put('/edit-user/{id}', [UserManagementController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('users.destroy');

// Resource routes untuk modul lainnya
Route::resource('task', TaskController::class);
Route::resource('schedule', ScheduleController::class);
Route::resource('progress', ProgressController::class);
Route::resource('material', MaterialController::class);
Route::resource('update', UpdateController::class);

// Health check route
Route::get('/api/health', [PlacementResultsController::class, 'health']);
Route::get('/api/placement-results', [PlacementResultsController::class, 'getPlacementResults']);