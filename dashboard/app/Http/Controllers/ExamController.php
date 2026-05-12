<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ExamController extends Controller
{
    /**
     * Display exam builder page
     */
    public function create()
    {
        return view('admin.exam');
    }

    /**
     * Display exam list page
     */
    public function index()
    {
        $exams = DB::table('exams')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.exam-list', compact('exams'));
    }

    /**
     * Display exam results page
     */
    public function results()
    {
        $results = DB::table('exam_sessions')
            ->join('exams', 'exam_sessions.exam_id', '=', 'exams.id')
            ->join('users', 'exam_sessions.student_id', '=', 'users.id')
            ->select('exam_sessions.*', 'exams.exam_title', 'users.name as student_name')
            ->where('exam_sessions.status', 'completed')
            ->orderBy('exam_sessions.created_at', 'desc')
            ->get();

        return view('admin.exam-results', compact('results'));
    }

    /**
     * Display exam results for mentor
     */
    public function mentorResults()
    {
        $results = DB::table('exam_sessions')
            ->join('exams', 'exam_sessions.exam_id', '=', 'exams.id')
            ->join('users', 'exam_sessions.student_id', '=', 'users.id')
            ->select('exam_sessions.*', 'exams.exam_title', 'users.name as student_name')
            ->where('exam_sessions.status', 'completed')
            ->orderBy('exam_sessions.created_at', 'desc')
            ->get();

        return view('mentor.exam-results', compact('results'));
    }

    /**
     * Get existing exams for dropdown
     */
    public function getExams()
    {
        try {
            $exams = DB::table('exams')
                ->select('id', 'exam_title', 'exam_type', 'status')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'exams' => $exams
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to load exams: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load exams: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save new exam - FIXED VERSION
     */
    public function store(Request $request)
    {
        Log::info('=== EXAM STORE REQUEST START ===');
        
        try {
            // Validasi dasar
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'type' => 'required|string|max:100',
                'category' => 'required|string|max:100',
                'duration' => 'required|integer|min:1',
                'status' => 'required|in:draft,published,archived'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // DEBUG: Log semua data request
            Log::info('=== RAW REQUEST DATA ===');
            foreach ($request->all() as $key => $value) {
                if ($key === 'questions') {
                    Log::info("questions: " . json_encode($value));
                } else {
                    Log::info("{$key}: {$value}");
                }
            }

            // Parse questions dengan cara yang benar
            $questions = [];
            $rawQuestions = $request->input('questions', []);

            Log::info('Raw questions type: ' . gettype($rawQuestions));
            Log::info('Raw questions count: ' . count($rawQuestions));

            if (is_array($rawQuestions) && count($rawQuestions) > 0) {
                foreach ($rawQuestions as $index => $questionValue) {
                    Log::info("Processing question {$index}: " . gettype($questionValue));
                    
                    if (is_string($questionValue)) {
                        // Case 1: JSON string
                        $questionData = json_decode($questionValue, true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            Log::info("Question {$index} parsed as JSON - Type: " . ($questionData['type'] ?? 'unknown'));
                            $questions[] = $questionData;
                        } else {
                            Log::error("JSON decode error for question {$index}: " . json_last_error_msg());
                            Log::error("Raw value: " . substr($questionValue, 0, 200));
                        }
                    } elseif (is_array($questionValue)) {
                        // Case 2: Already an array
                        Log::info("Question {$index} is already array - Type: " . ($questionValue['type'] ?? 'unknown'));
                        $questions[] = $questionValue;
                    } else {
                        Log::warning("Unknown question format for index {$index}: " . gettype($questionValue));
                    }
                }
            }

            Log::info('Final questions count: ' . count($questions));

            // Debug each question
            foreach ($questions as $index => $question) {
                Log::info("Question {$index} details:");
                Log::info("  Type: " . ($question['type'] ?? 'NOT SET'));
                Log::info("  Skill: " . ($question['skill'] ?? 'NOT SET'));
                Log::info("  Question: " . ($question['question'] ?? 'NOT SET'));
                Log::info("  Points: " . ($question['points'] ?? 'NOT SET'));
                if (isset($question['options']) && is_array($question['options'])) {
                    Log::info("  Options count: " . count($question['options']));
                }
            }

            if (count($questions) === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid questions found. Please check the question data format.'
                ], 422);
            }

            DB::beginTransaction();

            // 1. Insert exam
            $examId = DB::table('exams')->insertGetId([
                'exam_title' => $request->title,
                'exam_type' => $request->type,
                'exam_category' => $request->category,
                'duration_minutes' => $request->duration,
                'total_questions' => count($questions),
                'total_points' => collect($questions)->sum('points'),
                'status' => $request->status,
                'created_by' => auth()->check() ? auth()->id() : 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('Exam created with ID: ' . $examId);

            // 2. Process each question dengan data yang benar
            foreach ($questions as $index => $questionData) {
                $this->processQuestion($examId, $index, $questionData, $request);
            }

            DB::commit();

            Log::info('=== EXAM STORE SUCCESS ===');

            return response()->json([
                'success' => true,
                'message' => 'Exam created successfully!',
                'exam_id' => $examId
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('=== EXAM STORE FAILED ===');
            Log::error('Error: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process individual question - FIXED AUDIO FILE HANDLING
     */
    private function processQuestion($examId, $index, $questionData, $request)
    {
        $type = $questionData['type'] ?? 'multiple-choice';
        $skill = $questionData['skill'] ?? 'reading';
        
        Log::info("Processing question {$index} - Type: {$type}, Skill: {$skill}");

        // Handle audio file dengan key yang sederhana
        $audioPath = null;
        $audioFilename = null;
        
        if ($type === 'listening') {
            // Gunakan key yang sederhana: audio_0, audio_1, etc.
            $audioKey = "audio_{$index}";
            Log::info("Checking for audio file with key: {$audioKey}");
            
            if ($request->hasFile($audioKey)) {
                $audioFile = $request->file($audioKey);
                Log::info("Audio file found: " . $audioFile->getClientOriginalName());
                
                if ($audioFile->isValid()) {
                    try {
                        // Pastikan directory exists
                        Storage::disk('public')->makeDirectory('exam_audio');
                        
                        $audioFilename = 'audio_' . time() . '_' . $examId . '_' . $index . '.' . $audioFile->getClientOriginalExtension();
                        $audioPath = $audioFile->storeAs('exam_audio', $audioFilename, 'public');
                        
                        Log::info('Audio file saved: ' . $audioPath);
                    } catch (\Exception $e) {
                        Log::error('Failed to save audio file: ' . $e->getMessage());
                    }
                } else {
                    Log::error('Audio file is invalid');
                }
            } else {
                Log::warning("No audio file found with key: {$audioKey}");
                
                // Debug: List semua file yang ada di request
                $files = $request->allFiles();
                Log::info('Available files in request: ' . implode(', ', array_keys($files)));
            }
        }

        // Insert question
        $questionId = DB::table('exam_questions')->insertGetId([
            'exam_id' => $examId,
            'question_type' => $type,
            'question_text' => $questionData['question'] ?? '',
            'question_points' => $questionData['points'] ?? 10,
            'question_order' => $index,
            'audio_file' => $audioPath,
            'audio_filename' => $audioFilename,
            'skill_category' => $skill,
            'created_at' => now()
        ]);

        Log::info("Question inserted - ID: {$questionId}");

        // Process question data
        $this->processQuestionData($questionId, $questionData);
    }

    /**
     * Process question data based on type
     */
    private function processQuestionData($questionId, $questionData)
    {
        $type = $questionData['type'] ?? 'multiple-choice';
        
        Log::info("Processing question data for ID: {$questionId}, Type: {$type}");

        try {
            switch ($type) {
                case 'multiple-choice':
                case 'listening':
                    // Insert options ke exam_question_options
                    if (isset($questionData['options']) && is_array($questionData['options'])) {
                        foreach ($questionData['options'] as $optIndex => $option) {
                            DB::table('exam_question_options')->insert([
                                'question_id' => $questionId,
                                'option_text' => $option['text'] ?? '',
                                'is_correct' => $option['isCorrect'] ?? false,
                                'option_order' => $optIndex
                            ]);
                        }
                        Log::info('Added ' . count($questionData['options']) . ' options for question ' . $questionId);
                    }
                    break;

                case 'true-false':
                    // Insert correct answer ke exam_question_answers
                    if (isset($questionData['correctAnswer'])) {
                        DB::table('exam_question_answers')->insert([
                            'question_id' => $questionId,
                            'correct_answer' => $questionData['correctAnswer'],
                            'answer_explanation' => null
                        ]);
                        Log::info('Added true/false answer for question ' . $questionId);
                    }
                    break;

                case 'fill-blank':
                    // Insert correct answer ke exam_question_answers
                    if (isset($questionData['correctAnswer'])) {
                        DB::table('exam_question_answers')->insert([
                            'question_id' => $questionId,
                            'correct_answer' => $questionData['correctAnswer'],
                            'answer_explanation' => null,
                            'created_at' => now()
                        ]);
                        Log::info('Added fill-blank answer for question ' . $questionId);
                    }
                    break;

                case 'essay':
                    // Insert essay placeholder ke exam_question_answers
                    DB::table('exam_question_answers')->insert([
                        'question_id' => $questionId,
                        'correct_answer' => 'Essay question - manual grading required',
                        'answer_explanation' => null,
                        'created_at' => now()
                    ]);
                    Log::info('Added essay placeholder for question ' . $questionId);
                    break;

                case 'matching':
                    // Insert matching pairs ke exam_question_answers sebagai JSON
                    if (isset($questionData['pairs']) && is_array($questionData['pairs'])) {
                        DB::table('exam_question_answers')->insert([
                            'question_id' => $questionId,
                            'correct_answer' => json_encode($questionData['pairs']),
                            'answer_explanation' => null,
                            'created_at' => now()
                        ]);
                        Log::info('Added ' . count($questionData['pairs']) . ' matching pairs for question ' . $questionId);
                    }
                    break;

                case 'ordering':
                    // Insert ordering items ke exam_question_answers sebagai JSON
                    if (isset($questionData['items']) && is_array($questionData['items'])) {
                        DB::table('exam_question_answers')->insert([
                            'question_id' => $questionId,
                            'correct_answer' => json_encode($questionData['items']),
                            'answer_explanation' => null,
                            'created_at' => now()
                        ]);
                        Log::info('Added ' . count($questionData['items']) . ' ordering items for question ' . $questionId);
                    }
                    break;

                default:
                    Log::warning("Unknown question type: {$type} for question ID: {$questionId}");
                    break;
            }

            Log::info("Successfully processed question data for ID: {$questionId}");

        } catch (\Exception $e) {
            Log::error("Failed to process question data for ID: {$questionId} - " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get exam details for editing
     */
    public function show($id)
    {
        try {
            $exam = DB::table('exams')
                ->where('id', $id)
                ->first();

            if (!$exam) {
                return response()->json([
                    'success' => false,
                    'message' => 'Exam not found'
                ], 404);
            }

            $questions = DB::table('exam_questions')
                ->where('exam_id', $id)
                ->orderBy('question_order')
                ->get()
                ->map(function($question) {
                    $questionData = [
                        'type' => $question->question_type,
                        'question' => $question->question_text,
                        'points' => $question->question_points,
                        'skill' => $question->skill_category,
                        'audio_file' => $question->audio_file,
                        'audio_filename' => $question->audio_filename,
                        'options' => [],
                        'correctAnswer' => null
                    ];

                    // Get options for multiple choice questions
                    if (in_array($question->question_type, ['multiple-choice', 'listening'])) {
                        $options = DB::table('exam_question_options')
                            ->where('question_id', $question->id)
                            ->orderBy('option_order')
                            ->get();
                        
                        $questionData['options'] = $options->map(function($option) {
                            return [
                                'text' => $option->option_text,
                                'isCorrect' => (bool)$option->is_correct
                            ];
                        })->toArray();
                    }

                    // Get correct answer for other question types
                    $answer = DB::table('exam_question_answers')
                        ->where('question_id', $question->id)
                        ->first();

                    if ($answer) {
                        if (in_array($question->question_type, ['matching', 'ordering'])) {
                            $questionData['correctAnswer'] = json_decode($answer->correct_answer, true);
                        } else {
                            $questionData['correctAnswer'] = $answer->correct_answer;
                        }
                    }

                    return $questionData;
                });

            return response()->json([
                'success' => true,
                'exam' => $exam,
                'questions' => $questions
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to load exam: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load exam'
            ], 500);
        }
    }

    /**
     * Get exam data with questions and options for student
     */
    public function getExamForStudent($id)
    {
        try {
            // Get exam data
            $exam = DB::table('exams')
                ->where('id', $id)
                ->where('status', 'published')
                ->first();

            if (!$exam) {
                return response()->json([
                    'success' => false,
                    'message' => 'Exam not found'
                ], 404);
            }

            // Get questions with options
            $questions = DB::table('exam_questions')
                ->where('exam_id', $id)
                ->orderBy('question_order')
                ->get()
                ->map(function($question) {
                    $question->options = DB::table('exam_question_options')
                        ->where('question_id', $question->id)
                        ->orderBy('option_order')
                        ->get();
                    return $question;
                });

            return response()->json([
                'success' => true,
                'exam' => $exam,
                'questions' => $questions
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to load exam for student: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load exam'
            ], 500);
        }
    }

    /**
     * Update exam
     */
    public function update(Request $request, $id)
    {
        try {
            // Validasi
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'type' => 'required|string|max:100',
                'category' => 'required|string|max:100',
                'duration' => 'required|integer|min:1',
                'status' => 'required|in:draft,published,archived'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Update exam data
            DB::table('exams')
                ->where('id', $id)
                ->update([
                    'exam_title' => $request->title,
                    'exam_type' => $request->type,
                    'exam_category' => $request->category,
                    'duration_minutes' => $request->duration,
                    'status' => $request->status,
                    'updated_at' => now()
                ]);

            // Jika ada questions yang dikirim, update questions juga
            if ($request->has('questions') && is_array($request->questions)) {
                // Delete existing questions and related data
                $this->deleteExamData($id);
                
                // Process new questions
                foreach ($request->questions as $index => $questionData) {
                    $this->processQuestion($id, $index, $questionData, $request);
                }

                // Update total questions and points
                $totalQuestions = count($request->questions);
                $totalPoints = collect($request->questions)->sum('points');

                DB::table('exams')
                    ->where('id', $id)
                    ->update([
                        'total_questions' => $totalQuestions,
                        'total_points' => $totalPoints,
                        'updated_at' => now()
                    ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Exam updated successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update exam: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update exam: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete exam data
     */
    private function deleteExamData($examId)
    {
        $questions = DB::table('exam_questions')->where('exam_id', $examId)->get();
        $questionIds = $questions->pluck('id');

        // Delete audio files
        foreach ($questions as $question) {
            if ($question->audio_file && Storage::disk('public')->exists($question->audio_file)) {
                Storage::disk('public')->delete($question->audio_file);
            }
        }

        DB::table('exam_question_options')->whereIn('question_id', $questionIds)->delete();
        DB::table('exam_question_answers')->whereIn('question_id', $questionIds)->delete();
        DB::table('exam_questions')->where('exam_id', $examId)->delete();
    }

    /**
     * Delete exam
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $this->deleteExamData($id);
            DB::table('exams')->where('id', $id)->delete();

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Exam deleted successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete exam: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete exam'
            ], 500);
        }
    }

    /**
     * Get audio file
     */
    public function getAudio($filename)
    {
        try {
            $path = 'exam_audio/' . $filename;
            
            if (Storage::disk('public')->exists($path)) {
                return response()->file(Storage::disk('public')->path($path));
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Audio file not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to get audio file: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get audio file'
            ], 500);
        }
    }

    /**
     * Import questions from CSV
     */
    public function importCSV(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt|max:1024'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $file = $request->file('csv_file');
            $csvData = array_map('str_getcsv', file($file));
            array_shift($csvData); // Remove header

            $questions = [];
            foreach ($csvData as $row) {
                if (count($row) >= 4) {
                    $questions[] = [
                        'type' => $row[0] ?? 'multiple-choice',
                        'question' => $row[1] ?? '',
                        'points' => intval($row[2] ?? 10),
                        'skill' => $row[3] ?? 'reading'
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'CSV imported successfully',
                'questions' => $questions
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to import CSV: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to import CSV'
            ], 500);
        }
    }

    /**
     * Get exam statistics
     */
    public function getStatistics($examId = null)
    {
        try {
            $query = DB::table('exam_sessions')
                ->join('exams', 'exam_sessions.exam_id', '=', 'exams.id')
                ->join('users', 'exam_sessions.student_id', '=', 'users.id')
                ->where('exam_sessions.status', 'completed');

            if ($examId) {
                $query->where('exam_sessions.exam_id', $examId);
            }

            $stats = $query->select(
                DB::raw('COUNT(exam_sessions.id) as total_attempts'),
                DB::raw('AVG(exam_sessions.score) as average_score'),
                DB::raw('MAX(exam_sessions.score) as highest_score'),
                DB::raw('MIN(exam_sessions.score) as lowest_score'),
                DB::raw('COUNT(DISTINCT exam_sessions.student_id) as unique_students')
            )->first();

            return response()->json([
                'success' => true,
                'statistics' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get exam statistics: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get statistics'
            ], 500);
        }
    }

    /**
     * Get student exam history
     */
    public function getStudentExamHistory($studentId)
    {
        try {
            $history = DB::table('exam_sessions')
                ->join('exams', 'exam_sessions.exam_id', '=', 'exams.id')
                ->where('exam_sessions.student_id', $studentId)
                ->where('exam_sessions.status', 'completed')
                ->select(
                    'exam_sessions.*',
                    'exams.exam_title',
                    'exams.exam_type',
                    'exams.duration_minutes'
                )
                ->orderBy('exam_sessions.created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'history' => $history
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get student exam history: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get exam history'
            ], 500);
        }
    }

    /**
     * Export exam results to CSV
     */
    public function exportResults($examId)
    {
        try {
            $results = DB::table('exam_sessions')
                ->join('exams', 'exam_sessions.exam_id', '=', 'exams.id')
                ->join('users', 'exam_sessions.student_id', '=', 'users.id')
                ->where('exam_sessions.exam_id', $examId)
                ->where('exam_sessions.status', 'completed')
                ->select(
                    'users.name as student_name',
                    'users.email',
                    'exam_sessions.score',
                    'exam_sessions.correct_answers',
                    'exam_sessions.total_questions',
                    'exam_sessions.start_time',
                    'exam_sessions.end_time'
                )
                ->get();

            $filename = "exam_results_" . date('Y-m-d_H-i-s') . ".csv";
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Student Name',
                'Email',
                'Score',
                'Correct Answers',
                'Total Questions',
                'Start Time',
                'End Time'
            ]);

            foreach ($results as $result) {
                fputcsv($handle, [
                    $result->student_name,
                    $result->email,
                    $result->score,
                    $result->correct_answers,
                    $result->total_questions,
                    $result->start_time,
                    $result->end_time
                ]);
            }

            fclose($handle);

            return response()->streamDownload(function() use ($handle) {
                //
            }, $filename, [
                'Content-Type' => 'text/csv',
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to export exam results: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to export results'
            ], 500);
        }
    }
}