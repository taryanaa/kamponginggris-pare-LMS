<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LearningController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Get student level
            $studentLevel = $this->getStudentLevel($user);
            
            // Get course progress from material completion
            $courseProgress = $this->getCourseProgress($user->id);
            
            // Get learning videos
            $learningVideos = $this->getLearningVideos($user->id);
            
            // Get materials FROM MENTOR dengan file type detection
            $materials = $this->getMaterialsFromMentor($user->id);
            
            // Get unread notifications
            $unreadNotifications = 0;
            try {
                $unreadNotifications = DB::table('notifications')
                    ->where('user_id', $user->id)
                    ->where('is_read', 0)
                    ->count();
            } catch (\Exception $e) {
                // Ignore if table doesn't exist
                Log::info('Notifications table not found or error: ' . $e->getMessage());
            }
            
            return view('user.learning', compact(
                'user',
                'studentLevel',
                'courseProgress',
                'learningVideos',
                'materials',
                'unreadNotifications'
            ));
        } catch (\Exception $e) {
            Log::error('Error in LearningController@index: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return view dengan data default jika error
            return view('user.learning', [
                'user' => Auth::user(),
                'studentLevel' => 'Level 0',
                'courseProgress' => 0,
                'learningVideos' => collect([]),
                'materials' => collect([]),
                'unreadNotifications' => 0
            ]);
        }
    }
    
    private function getStudentLevel($user)
    {
        try {
            $latestTest = DB::table('basic_english_results')
                ->where('user_email', $user->email)
                ->orderBy('created_at', 'desc')
                ->first();
            
            return $latestTest ? $latestTest->overall_level : 'Level 0';
        } catch (\Exception $e) {
            Log::info('Error getting student level: ' . $e->getMessage());
            return 'Level 0';
        }
    }
    
    private function getCourseProgress($userId)
    {
        try {
            $tableExists = $this->checkMaterialProgressTableExists();
            
            if (!$tableExists) {
                return 0;
            }
            
            // Hitung SEMUA materials (baik terkunci maupun tidak)
            $totalMaterials = DB::table('materials')
                ->where('file_path', '!=', '')
                ->whereNotNull('file_path')
                ->count();
            
            if ($totalMaterials == 0) {
                return 0;
            }
            
            // Hitung materials yang sudah diselesaikan
            $completedMaterials = DB::table('student_material_progress')
                ->where('student_id', $userId)
                ->where('is_completed', 1)
                ->count();
            
            return round(($completedMaterials / $totalMaterials) * 100, 0);
        } catch (\Exception $e) {
            Log::error('Error getting course progress: ' . $e->getMessage());
            return 0;
        }
    }
    
    private function checkMaterialProgressTableExists()
    {
        try {
            $result = DB::select("SHOW TABLES LIKE 'student_material_progress'");
            return count($result) > 0;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    private function getLearningVideos($userId)
    {
        // Hardcoded videos
        return collect([
            (object)[
                'id' => 1,
                'title' => 'Speaking Practice',
                'video_url' => 'https://www.youtube.com/embed/2b9txcAt4e0',
                'category' => 'Speaking',
                'description' => 'Improve your speaking skills with practice and tips from this video.',
                'progress_percentage' => 0,
                'completed' => 0
            ],
            (object)[
                'id' => 2,
                'title' => 'Reading Comprehension',
                'video_url' => 'https://www.youtube.com/embed/2b9txcAt4e0',
                'category' => 'Reading',
                'description' => 'Sharpen your reading comprehension through various texts and discussions.',
                'progress_percentage' => 0,
                'completed' => 0
            ]
        ]);
    }
    
    private function getMaterialsFromMentor($userId)
    {
        try {
            // Check if is_locked column exists
            $hasIsLockedColumn = $this->checkIsLockedColumnExists();
            
            // Check if student_material_progress table exists
            $hasProgressTable = $this->checkMaterialProgressTableExists();
            
            // Get materials query
            $query = DB::table('materials')
                ->where('file_path', '!=', '')
                ->whereNotNull('file_path')
                ->orderBy('created_at', 'desc')
                ->limit(20);
            
            $materials = $query->get();
            
            // Filter dan enhance materials
            $validMaterials = collect([]);
            
            foreach ($materials as $material) {
                // Check if file exists
                $filePath = storage_path('app/public/' . $material->file_path);
                if (!file_exists($filePath)) {
                    // Skip if file doesn't exist (don't delete from DB for safety)
                    Log::warning("Material file not found: " . $material->file_path);
                    continue;
                }
                
                // Detect file type
                $extension = strtolower(pathinfo($material->file_name ?? 'file.txt', PATHINFO_EXTENSION));
                $material->file_type = $this->getFileType($extension);
                $material->file_extension = $extension;
                
                // Set is_locked property safely
                if ($hasIsLockedColumn) {
                    $material->is_locked = isset($material->is_locked) && $material->is_locked == 1;
                } else {
                    // If column doesn't exist, default to false (unlocked)
                    $material->is_locked = false;
                }
                
                // Check if material is completed by student
                if ($hasProgressTable) {
                    $progress = DB::table('student_material_progress')
                        ->where('student_id', $userId)
                        ->where('material_id', $material->id)
                        ->first();
                    
                    $material->is_completed = $progress ? $progress->is_completed : false;
                    $material->view_count = $progress ? $progress->view_count : 0;
                } else {
                    $material->is_completed = false;
                    $material->view_count = 0;
                }
                
                // Generate preview/thumbnail
                $material->preview_url = $this->generatePreviewUrl($material);
                $material->can_preview_online = in_array($material->file_type, ['video', 'pdf', 'image']) && !$material->is_locked;
                
                // Add assigned count
                try {
                    $assignedCount = DB::table('task_assignments')
                        ->join('tasks', 'task_assignments.task_id', '=', 'tasks.id')
                        ->where('tasks.material_id', $material->id)
                        ->where('task_assignments.student_id', $userId)
                        ->count();
                    
                    $material->assigned_count = $assignedCount;
                } catch (\Exception $e) {
                    $material->assigned_count = 0;
                }
                
                $validMaterials->push($material);
            }
            
            return $validMaterials;
        } catch (\Exception $e) {
            Log::error('Error getting materials from mentor: ' . $e->getMessage());
            return collect([]);
        }
    }
    
    private function checkIsLockedColumnExists()
    {
        try {
            // Try to check if column exists
            $columns = DB::select('SHOW COLUMNS FROM materials LIKE "is_locked"');
            return count($columns) > 0;
        } catch (\Exception $e) {
            Log::info('Could not check is_locked column: ' . $e->getMessage());
            return false;
        }
    }
    
    private function getFileType($extension)
    {
        $types = [
            'video' => ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm'],
            'pdf' => ['pdf'],
            'document' => ['doc', 'docx', 'txt', 'rtf'],
            'presentation' => ['ppt', 'pptx'],
            'image' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']
        ];
        
        foreach ($types as $type => $extensions) {
            if (in_array($extension, $extensions)) {
                return $type;
            }
        }
        
        return 'other';
    }
    
    private function generatePreviewUrl($material)
    {
        try {
            if ($material->file_type == 'video') {
                return asset('storage/' . $material->file_path);
            } elseif ($material->file_type == 'pdf') {
                return asset('storage/' . $material->file_path);
            } elseif ($material->file_type == 'image') {
                return asset('storage/' . $material->file_path);
            }
        } catch (\Exception $e) {
            Log::error('Error generating preview URL: ' . $e->getMessage());
        }
        
        return null;
    }
    
    public function viewMaterial($materialId)
    {
        try {
            $user = Auth::user();
            $material = DB::table('materials')->where('id', $materialId)->first();
            
            if (!$material || !$material->file_path) {
                return response()->json(['error' => 'Material not found'], 404);
            }

            // Check if material is locked (only if column exists)
            if (property_exists($material, 'is_locked') && $material->is_locked == 1) {
                return response()->json(['error' => 'This material is locked by your mentor'], 403);
            }
            
            $filePath = storage_path('app/public/' . $material->file_path);
            
            if (!file_exists($filePath)) {
                return response()->json(['error' => 'File not found'], 404);
            }
            
            // Track material view and mark as completed
            $this->trackMaterialProgress($user->id, $materialId);
            
            // Detect mime type
            $mimeType = mime_content_type($filePath);
            
            // Return file for inline viewing
            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . ($material->file_name ?? 'file') . '"'
            ]);
        } catch (\Exception $e) {
            Log::error('Error viewing material: ' . $e->getMessage());
            return response()->json(['error' => 'Error loading material: ' . $e->getMessage()], 500);
        }
    }
    
    public function downloadMaterial($materialId)
    {
        try {
            $user = Auth::user();
            $material = DB::table('materials')->where('id', $materialId)->first();
            
            if (!$material || !$material->file_path) {
                return redirect()->back()->with('error', 'Material not found');
            }

            // Check if material is locked (only if column exists)
            if (property_exists($material, 'is_locked') && $material->is_locked == 1) {
                return redirect()->back()->with('error', 'This material is locked by your mentor. You cannot download it.');
            }
            
            $filePath = storage_path('app/public/' . $material->file_path);
            
            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', 'File not found');
            }
            
            // Track material view and mark as completed
            $this->trackMaterialProgress($user->id, $materialId);
            
            return response()->download($filePath, $material->file_name ?? 'download');
        } catch (\Exception $e) {
            Log::error('Error downloading material: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error downloading material: ' . $e->getMessage());
        }
    }
    
    private function trackMaterialProgress($studentId, $materialId)
    {
        try {
            // Check if table exists
            $tableExists = $this->checkMaterialProgressTableExists();
            
            if (!$tableExists) {
                return;
            }
            
            // Check if progress record exists
            $progress = DB::table('student_material_progress')
                ->where('student_id', $studentId)
                ->where('material_id', $materialId)
                ->first();
            
            if ($progress) {
                // Update existing record - increment view count
                DB::table('student_material_progress')
                    ->where('student_id', $studentId)
                    ->where('material_id', $materialId)
                    ->update([
                        'view_count' => $progress->view_count + 1,
                        'last_viewed' => now(),
                        'updated_at' => now()
                    ]);
            } else {
                // Create new record - mark as completed for the first time
                DB::table('student_material_progress')->insert([
                    'student_id' => $studentId,
                    'material_id' => $materialId,
                    'is_completed' => 1,
                    'completed_at' => now(),
                    'view_count' => 1,
                    'last_viewed' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error tracking material progress: ' . $e->getMessage());
        }
    }
    
    // API endpoint untuk menandai materi sebagai selesai
    public function markMaterialAsCompleted($materialId)
    {
        try {
            $user = Auth::user();
            
            $this->trackMaterialProgress($user->id, $materialId);
            
            return response()->json([
                'success' => true,
                'message' => 'Material marked as completed',
                'progress' => $this->getCourseProgress($user->id)
            ]);
        } catch (\Exception $e) {
            Log::error('Error marking material as completed: ' . $e->getMessage());
            return response()->json(['error' => 'Error marking material as completed'], 500);
        }
    }
}