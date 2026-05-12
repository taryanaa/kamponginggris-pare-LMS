<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentExamController extends Controller
{
    /**
     * Display list of available exams for student
     */
    public function index()
    {
        try {
            $exams = DB::table('exams')
                ->where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('user.exam-list', compact('exams'));
        } catch (\Exception $e) {
            Log::error('Failed to load exams: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load exams');
        }
    }

    /**
     * Show specific exam details
     */
    public function show($examId)
    {
        try {
            $exam = DB::table('exams')
                ->where('id', $examId)
                ->where('status', 'published')
                ->first();

            if (!$exam) {
                abort(404, 'Exam not found');
            }

            return view('user.exam-detail', compact('exam'));
        } catch (\Exception $e) {
            Log::error('Failed to load exam details: ' . $e->getMessage());
            return redirect()->route('exam.student')->with('error', 'Failed to load exam details');
        }
    }

    /**
     * Start exam - redirect to exam interface
     */
    public function start($examId)
    {
        try {
            $exam = DB::table('exams')
                ->where('id', $examId)
                ->where('status', 'published')
                ->first();

            if (!$exam) {
                abort(404, 'Exam not found');
            }

            // Redirect to exam interface with exam ID
            return redirect()->route('exam.interface', $examId);
        } catch (\Exception $e) {
            Log::error('Failed to start exam: ' . $e->getMessage());
            return redirect()->route('exam.student')->with('error', 'Failed to start exam');
        }
    }

    /**
     * Display exam interface
     */
/**
 * Display exam interface
 */
public function showExamInterface($examId)
{
    try {
        \Log::info('Loading exam interface for exam ID: ' . $examId);
        
        $exam = DB::table('exams')
            ->where('id', $examId)
            ->where('status', 'published')
            ->first();

        if (!$exam) {
            \Log::error('Exam not found or not published: ' . $examId);
            abort(404, 'Exam not found or not available');
        }

        // Get questions with options
        $questions = DB::table('exam_questions')
            ->where('exam_id', $examId)
            ->orderBy('question_order')
            ->get()
            ->map(function($question) {
                $question->options = DB::table('exam_question_options')
                    ->where('question_id', $question->id)
                    ->orderBy('option_order')
                    ->get();
                return $question;
            });

        // Check if there's an active session or create new one
        $activeSession = DB::table('exam_sessions')
            ->where('student_id', auth()->id())
            ->where('exam_id', $examId)
            ->where('status', 'in_progress')
            ->first();

        if (!$activeSession) {
            // Create new session
            $sessionId = DB::table('exam_sessions')->insertGetId([
                'student_id' => auth()->id(),
                'exam_id' => $examId,
                'start_time' => now(),
                'end_time' => now()->addMinutes($exam->duration_minutes),
                'status' => 'in_progress',
                'total_questions' => $exam->total_questions,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $activeSession = (object)['id' => $sessionId];
        }

        // Get existing answers
        $existingAnswers = DB::table('exam_answers')
            ->where('session_id', $activeSession->id)
            ->get()
            ->keyBy('question_id');

        \Log::info('Successfully loaded exam interface with ' . $questions->count() . ' questions');

        return view('user.exam-interface', compact('exam', 'questions', 'activeSession', 'existingAnswers'));

    } catch (\Exception $e) {
        \Log::error('Failed to load exam interface: ' . $e->getMessage());
        return redirect()->route('exam.student')->with('error', 'Failed to load exam: ' . $e->getMessage());
    }
}

    /**
     * API: Create exam session
     */
    public function createSession(Request $request)
    {
        try {
            $examId = $request->exam_id;
            
            $exam = DB::table('exams')
                ->where('id', $examId)
                ->where('status', 'published')
                ->first();

            if (!$exam) {
                return response()->json([
                    'success' => false,
                    'message' => 'Exam not found'
                ], 404);
            }

            // Check if there's an active session
            $activeSession = DB::table('exam_sessions')
                ->where('student_id', auth()->id())
                ->where('exam_id', $examId)
                ->where('status', 'in_progress')
                ->first();

            if ($activeSession) {
                return response()->json([
                    'success' => true,
                    'session_id' => $activeSession->id,
                    'message' => 'Resuming existing session'
                ]);
            }

            // Create new session
            $sessionId = DB::table('exam_sessions')->insertGetId([
                'student_id' => auth()->id(),
                'exam_id' => $examId,
                'start_time' => now(),
                'status' => 'in_progress',
                'total_questions' => $exam->total_questions,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'session_id' => $sessionId,
                'message' => 'Exam session started'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to create exam session: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to start exam session'
            ], 500);
        }
    }

    /**
     * Submit answer
     */
    public function submitAnswer(Request $request)
    {
        try {
            $sessionId = $request->session_id;
            
            $session = DB::table('exam_sessions')
                ->where('id', $sessionId)
                ->where('student_id', auth()->id())
                ->first();

            if (!$session || $session->status !== 'in_progress') {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid exam session'
                ], 400);
            }

            // Check if answer already exists
            $existingAnswer = DB::table('exam_answers')
                ->where('session_id', $sessionId)
                ->where('question_id', $request->question_id)
                ->first();

            $isCorrect = $this->checkAnswer($request->question_id, $request->selected_option_id);

            if ($existingAnswer) {
                // Update existing answer
                DB::table('exam_answers')
                    ->where('id', $existingAnswer->id)
                    ->update([
                        'selected_option_id' => $request->selected_option_id,
                        'is_correct' => $isCorrect,
                        'answered_at' => now()
                    ]);
            } else {
                // Insert new answer
                DB::table('exam_answers')->insert([
                    'session_id' => $sessionId,
                    'question_id' => $request->question_id,
                    'selected_option_id' => $request->selected_option_id,
                    'is_correct' => $isCorrect,
                    'answered_at' => now()
                ]);
            }

            // Update session stats
            $this->updateSessionStats($sessionId);

            return response()->json([
                'success' => true,
                'message' => 'Answer submitted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to submit answer: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit answer'
            ], 500);
        }
    }

    /**
     * Finish exam session
     */
    public function finishSession(Request $request, $sessionId)
    {
        try {
            $session = DB::table('exam_sessions')
                ->where('id', $sessionId)
                ->where('student_id', auth()->id())
                ->first();

            if (!$session) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid exam session'
                ], 400);
            }

            // Calculate final score
            $correctAnswers = DB::table('exam_answers')
                ->where('session_id', $sessionId)
                ->where('is_correct', true)
                ->count();

            $score = $session->total_questions > 0 ? ($correctAnswers / $session->total_questions) * 100 : 0;

            // Update session
            DB::table('exam_sessions')
                ->where('id', $sessionId)
                ->update([
                    'end_time' => now(),
                    'status' => 'completed',
                    'score' => $score,
                    'correct_answers' => $correctAnswers,
                    'answered_questions' => DB::table('exam_answers')->where('session_id', $sessionId)->count(),
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Exam completed successfully',
                'score' => $score,
                'correct_answers' => $correctAnswers
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to finish exam: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to finish exam'
            ], 500);
        }
    }

    /**
     * Get exam session
     */
    public function getSession($sessionId)
    {
        try {
            $session = DB::table('exam_sessions')
                ->where('id', $sessionId)
                ->where('student_id', auth()->id())
                ->first();

            if (!$session) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'session' => $session
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get session: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get session'
            ], 500);
        }
    }

    /**
     * Get answers for session
     */
    public function getAnswers($sessionId)
    {
        try {
            $answers = DB::table('exam_answers')
                ->where('session_id', $sessionId)
                ->get();

            return response()->json([
                'success' => true,
                'answers' => $answers
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get answers: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get answers'
            ], 500);
        }
    }

    /**
     * Check if answer is correct
     */
    private function checkAnswer($questionId, $selectedOptionId)
    {
        try {
            $correctOption = DB::table('exam_question_options')
                ->where('question_id', $questionId)
                ->where('is_correct', true)
                ->first();

            return $correctOption && $correctOption->id == $selectedOptionId;
        } catch (\Exception $e) {
            Log::error('Failed to check answer: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update session statistics
     */
    private function updateSessionStats($sessionId)
    {
        try {
            $answered = DB::table('exam_answers')
                ->where('session_id', $sessionId)
                ->count();

            $correct = DB::table('exam_answers')
                ->where('session_id', $sessionId)
                ->where('is_correct', true)
                ->count();

            DB::table('exam_sessions')
                ->where('id', $sessionId)
                ->update([
                    'answered_questions' => $answered,
                    'correct_answers' => $correct,
                    'updated_at' => now()
                ]);
        } catch (\Exception $e) {
            Log::error('Failed to update session stats: ' . $e->getMessage());
        }
    }
}