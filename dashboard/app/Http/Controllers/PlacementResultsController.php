<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademicResults;
use App\Models\BasicEnglishResults;
use App\Models\ToeflPreparationResults;
use App\Models\ToeicResults;
use App\Models\IeltsA2Results;
use App\Models\IeltsB1Results;
use App\Models\PracticalEnglishResults;
use App\Models\BusinessSpeakingResults;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlacementResultsController extends Controller
{
    /**
     * Display placement results page
     */
    public function index(Request $request)
    {
        Log::info('=== PLACEMENT RESULTS CONTROLLER START ===');
        
        $testType = $request->get('test_type', 'all');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $results = $this->getAllResults($testType, $dateFrom, $dateTo);
        $resultsCount = count($results);

        Log::info("Final results count: {$resultsCount}");

        $testTypes = [
            'all' => 'All Tests',
            'toefl' => 'TOEFL Preparation',
            'academic' => 'Academic English', 
            'basic-english' => 'Basic English',
            'practical' => 'Practical English',
            'toeic' => 'TOEIC',
            'ielts-a2' => 'IELTS A2',
            'ielts-b1' => 'IELTS B1',
            'business' => 'Business Speaking'
        ];

        return view('admin.placement_results', compact(
            'results', 
            'resultsCount', 
            'testTypes',
            'testType',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Update placement result
     */
    public function update(Request $request)
    {
        try {
            Log::info('Update request received', $request->all());

            $validated = $request->validate([
                'id' => 'required|integer',
                'test_type' => 'required|string',
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:50',
                'overall_score' => 'nullable|string|max:50',
                'level' => 'nullable|string|max:50',
                'test_date' => 'nullable|date',
            ]);

            $model = $this->getModelByTestType($validated['test_type']);
            
            if (!$model) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Invalid test type'
                ], 400);
            }
            
            $result = $model::find($validated['id']);
            
            if (!$result) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Result not found'
                ], 404);
            }
            
            // Update fields based on test type
            $this->updateResultFields($result, $request, $validated['test_type']);
            
            $result->save();
            
            Log::info("Updated {$validated['test_type']} result #{$validated['id']}");
            
            return response()->json([
                'success' => true, 
                'message' => 'Result updated successfully'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating result: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false, 
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete placement result
     */
    public function delete(Request $request)
    {
        try {
            Log::info('Delete request received', $request->all());

            $validated = $request->validate([
                'id' => 'required|integer',
                'test_type' => 'required|string',
            ]);

            $model = $this->getModelByTestType($validated['test_type']);
            
            if (!$model) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Invalid test type'
                ], 400);
            }
            
            $result = $model::find($validated['id']);
            
            if (!$result) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Result not found'
                ], 404);
            }
            
            $result->delete();
            
            Log::info("Deleted {$validated['test_type']} result #{$validated['id']}");
            
            return response()->json([
                'success' => true, 
                'message' => 'Result deleted successfully'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error deleting result: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false, 
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export results to CSV
     */
    public function export(Request $request)
    {
        try {
            Log::info('Export request received', $request->all());

            $testType = $request->get('test_type', 'all');
            $dateFrom = $request->get('date_from');
            $dateTo = $request->get('date_to');

            $results = $this->getAllResults($testType, $dateFrom, $dateTo);
            
            if (empty($results)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No results to export'
                ], 404);
            }

            $filename = 'placement_results_' . date('Y-m-d_His') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ];

            $callback = function() use ($results) {
                $file = fopen('php://output', 'w');
                
                // Add BOM for UTF-8
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                
                // Header row
                fputcsv($file, [
                    'ID', 'Test Type', 'Name', 'Email', 'Phone/WhatsApp', 
                    'Overall Score', 'Level', 'Band/Percentage',
                    'Listening', 'Reading', 'Writing', 'Speaking',
                    'Grammar', 'Vocabulary', 'Pronunciation', 'Test Date'
                ]);
                
                // Data rows
                foreach ($results as $result) {
                    fputcsv($file, [
                        $result['id'] ?? '',
                        strtoupper($result['test_type'] ?? ''),
                        $result['name'] ?? '',
                        $result['email'] ?? '',
                        $result['phone'] ?? '',
                        $result['overall_score'] ?? '',
                        $result['level'] ?? '',
                        $this->formatScoreDisplayForExport($result),
                        $this->getSkillScoreForExport($result, 'listening'),
                        $this->getSkillScoreForExport($result, 'reading'),
                        $this->getSkillScoreForExport($result, 'writing'),
                        $this->getSkillScoreForExport($result, 'speaking'),
                        $this->getSkillScoreForExport($result, 'grammar'),
                        $this->getSkillScoreForExport($result, 'vocab'),
                        $this->getSkillScoreForExport($result, 'pronoun'),
                        $result['test_date'] ?? '',
                    ]);
                }
                
                fclose($file);
            };

            Log::info("Exporting {$resultsCount} results");

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            Log::error('Error exporting results: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error exporting results: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get model by test type
     */
    private function getModelByTestType($testType)
    {
        $models = [
            'academic' => AcademicResults::class,
            'basic-english' => BasicEnglishResults::class,
            'toefl' => ToeflPreparationResults::class,
            'toeic' => ToeicResults::class,
            'ielts-a2' => IeltsA2Results::class,
            'ielts-b1' => IeltsB1Results::class,
            'practical' => PracticalEnglishResults::class,
            'business' => BusinessSpeakingResults::class,
        ];
        
        return $models[$testType] ?? null;
    }

    /**
     * Update result fields based on test type
     */
    private function updateResultFields($result, $request, $testType)
    {
        // Get field names for this test type
        $nameField = $this->getNameField($testType);
        $emailField = $this->getEmailField($testType);
        $phoneField = $this->getPhoneField($testType);
        $levelField = $this->getLevelField($testType);
        $dateField = $this->getDateField($testType);
        
        // Update name
        if ($nameField && $request->has('name')) {
            $result->$nameField = $request->input('name');
        }
        
        // Update email
        if ($emailField && $request->has('email')) {
            $result->$emailField = $request->input('email');
        }
        
        // Update phone
        if ($phoneField && $request->has('phone')) {
            $result->$phoneField = $request->input('phone');
        }
        
        // Update overall score
        if ($request->has('overall_score')) {
            $result->overall_score = $request->input('overall_score');
        }
        
        // Update level
        if ($levelField && $request->has('level')) {
            $result->$levelField = $request->input('level');
        }
        
        // Update date
        if ($dateField && $request->has('test_date')) {
            $result->$dateField = $request->input('test_date');
        }

        Log::info("Updated fields for {$testType}", [
            'name_field' => $nameField,
            'email_field' => $emailField,
            'phone_field' => $phoneField,
            'level_field' => $levelField,
            'date_field' => $dateField
        ]);
    }

    /**
     * Get name field by test type
     */
    private function getNameField($testType)
    {
        $nameFields = [
            'academic' => 'user_name',
            'basic-english' => 'user_name',
            'toefl' => 'user_name',
            'toeic' => 'name',
            'ielts-a2' => 'name',
            'ielts-b1' => 'name',
            'practical' => 'name',
            'business' => 'name',
        ];
        
        return $nameFields[$testType] ?? null;
    }

    /**
     * Get email field by test type
     */
    private function getEmailField($testType)
    {
        $emailFields = [
            'academic' => 'user_email',
            'basic-english' => 'user_email',
            'toefl' => 'user_email',
            'toeic' => 'email',
            'ielts-a2' => 'email',
            'ielts-b1' => 'email',
            'practical' => 'email',
            'business' => 'email',
        ];
        
        return $emailFields[$testType] ?? null;
    }

    /**
     * Get phone field by test type
     */
    private function getPhoneField($testType)
    {
        $phoneFields = [
            'academic' => 'whatsapp_number',
            'basic-english' => 'whatsapp_number',
            'toefl' => 'user_whatsapp',
            'toeic' => 'whatsapp',
            'ielts-a2' => 'phone',
            'ielts-b1' => 'phone',
            'practical' => null,
            'business' => null,
        ];
        
        return $phoneFields[$testType] ?? null;
    }

    /**
     * Get level field by test type
     */
    private function getLevelField($testType)
    {
        $levelFields = [
            'academic' => 'overall_level',
            'basic-english' => 'overall_level',
            'toefl' => 'cefr_level',
            'toeic' => 'overall_cefr',
            'ielts-a2' => 'overall_level',
            'ielts-b1' => 'overall_level',
            'practical' => 'overall_level',
            'business' => null,
        ];
        
        return $levelFields[$testType] ?? null;
    }

    /**
     * Get date field by test type
     */
    private function getDateField($testType)
    {
        $dateFields = [
            'academic' => 'test_date',
            'basic-english' => 'test_date',
            'toefl' => 'test_date',
            'toeic' => 'submitted_at',
            'ielts-a2' => 'submitted_at',
            'ielts-b1' => 'submitted_at',
            'practical' => 'test_date',
            'business' => 'test_date',
        ];
        
        return $dateFields[$testType] ?? null;
    }

    /**
     * Format score display for export
     */
    private function formatScoreDisplayForExport($result)
    {
        if (isset($result['overall_band'])) return 'Band ' . $result['overall_band'];
        if (isset($result['percentage'])) return $result['percentage'] . '%';
        if (isset($result['total_percentage'])) return $result['total_percentage'] . '%';
        if (isset($result['overall_percent'])) return $result['overall_percent'] . '%';
        return 'N/A';
    }

    /**
     * Get skill score for export
     */
    private function getSkillScoreForExport($result, $skill)
    {
        if ($skill === 'pronoun') {
            $pronounKeys = [
                'pronoun_score', 'pronoun_correct', 'pronoun_percentage',
                'pronunciation_correct', 'pronunciation_score', 'pronunciation_percentage'
            ];
            
            foreach ($pronounKeys as $key) {
                if (isset($result[$key]) && $result[$key] !== '' && $result[$key] !== null) {
                    return $result[$key];
                }
            }
            return '-';
        }
        
        $keys = [
            $skill . '_score', 
            $skill . '_correct', 
            $skill . '_percentage',
            $skill . '_percent', 
            $skill . '_ielts', 
            $skill . '_toeic', 
            $skill . '_level'
        ];
        
        foreach ($keys as $key) {
            if (isset($result[$key]) && $result[$key] !== '' && $result[$key] !== null) {
                return $result[$key];
            }
        }
        
        return '-';
    }

    /**
     * Get all results dengan data skill scores lengkap
     */
    private function getAllResults($testType = 'all', $dateFrom = null, $dateTo = null)
    {
        $allResults = [];

        try {
            // 1. Academic Results
            if ($testType === 'all' || $testType === 'academic') {
                $query = AcademicResults::query();
                
                if ($dateFrom) {
                    $query->whereDate('test_date', '>=', $dateFrom);
                }
                if ($dateTo) {
                    $query->whereDate('test_date', '<=', $dateTo);
                }
                
                $academicResults = $query->orderBy('created_at', 'desc')->get();
                Log::info("Academic Results found: " . $academicResults->count());

                foreach ($academicResults as $item) {
                    $allResults[] = $this->formatAcademicResult($item);
                }
            }

            // 2. Basic English Results  
            if ($testType === 'all' || $testType === 'basic-english') {
                $query = BasicEnglishResults::query();
                
                if ($dateFrom) {
                    $query->whereDate('test_date', '>=', $dateFrom);
                }
                if ($dateTo) {
                    $query->whereDate('test_date', '<=', $dateTo);
                }
                
                $basicResults = $query->orderBy('created_at', 'desc')->get();
                Log::info("Basic English Results found: " . $basicResults->count());

                foreach ($basicResults as $item) {
                    $allResults[] = $this->formatBasicEnglishResult($item);
                }
            }

            // 3. TOEFL Results
            if ($testType === 'all' || $testType === 'toefl') {
                $query = ToeflPreparationResults::query();
                
                if ($dateFrom) {
                    $query->whereDate('test_date', '>=', $dateFrom);
                }
                if ($dateTo) {
                    $query->whereDate('test_date', '<=', $dateTo);
                }
                
                $toeflResults = $query->orderBy('test_date', 'desc')->get();
                Log::info("TOEFL Results found: " . $toeflResults->count());

                foreach ($toeflResults as $item) {
                    $allResults[] = $this->formatToeflResult($item);
                }
            }

            // 4. TOEIC Results
            if ($testType === 'all' || $testType === 'toeic') {
                $query = ToeicResults::query();
                
                if ($dateFrom) {
                    $query->whereDate('submitted_at', '>=', $dateFrom);
                }
                if ($dateTo) {
                    $query->whereDate('submitted_at', '<=', $dateTo);
                }
                
                $toeicResults = $query->orderBy('submitted_at', 'desc')->get();
                Log::info("TOEIC Results found: " . $toeicResults->count());

                foreach ($toeicResults as $item) {
                    $allResults[] = $this->formatToeicResult($item);
                }
            }

            // 5. IELTS A2 Results
            if ($testType === 'all' || $testType === 'ielts-a2') {
                $query = IeltsA2Results::query();
                
                if ($dateFrom) {
                    $query->whereDate('submitted_at', '>=', $dateFrom);
                }
                if ($dateTo) {
                    $query->whereDate('submitted_at', '<=', $dateTo);
                }
                
                $ieltsA2Results = $query->orderBy('submitted_at', 'desc')->get();
                Log::info("IELTS A2 Results found: " . $ieltsA2Results->count());

                foreach ($ieltsA2Results as $item) {
                    $allResults[] = $this->formatIeltsA2Result($item);
                }
            }

            // 6. IELTS B1 Results
            if ($testType === 'all' || $testType === 'ielts-b1') {
                $query = IeltsB1Results::query();
                
                if ($dateFrom) {
                    $query->whereDate('submitted_at', '>=', $dateFrom);
                }
                if ($dateTo) {
                    $query->whereDate('submitted_at', '<=', $dateTo);
                }
                
                $ieltsB1Results = $query->orderBy('submitted_at', 'desc')->get();
                Log::info("IELTS B1 Results found: " . $ieltsB1Results->count());

                foreach ($ieltsB1Results as $item) {
                    $allResults[] = $this->formatIeltsB1Result($item);
                }
            }

            // 7. Practical English Results
            if ($testType === 'all' || $testType === 'practical') {
                $query = PracticalEnglishResults::query();
                
                if ($dateFrom) {
                    $query->whereDate('test_date', '>=', $dateFrom);
                }
                if ($dateTo) {
                    $query->whereDate('test_date', '<=', $dateTo);
                }
                
                $practicalResults = $query->orderBy('created_at', 'desc')->get();
                Log::info("Practical English Results found: " . $practicalResults->count());

                foreach ($practicalResults as $item) {
                    $allResults[] = $this->formatPracticalEnglishResult($item);
                }
            }

            // 8. Business Speaking Results
            if ($testType === 'all' || $testType === 'business') {
                $query = BusinessSpeakingResults::query();
                
                if ($dateFrom) {
                    $query->whereDate('test_date', '>=', $dateFrom);
                }
                if ($dateTo) {
                    $query->whereDate('test_date', '<=', $dateTo);
                }
                
                $businessResults = $query->orderBy('created_at', 'desc')->get();
                Log::info("Business Speaking Results found: " . $businessResults->count());

                foreach ($businessResults as $item) {
                    $allResults[] = $this->formatBusinessSpeakingResult($item);
                }
            }

        } catch (\Exception $e) {
            Log::error('Error in getAllResults: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }

        // Sort by date (newest first)
        usort($allResults, function($a, $b) {
            return strtotime($b['sort_date']) - strtotime($a['sort_date']);
        });

        return $allResults;
    }

    /**
     * Format Academic Result
     */
    private function formatAcademicResult($item)
    {
        return [
            'id' => $item->id,
            'test_type' => 'academic',
            'name' => $item->user_name ?? 'N/A',
            'email' => $item->user_email ?? 'N/A',
            'phone' => $item->whatsapp_number ?? 'N/A',
            'overall_score' => $item->overall_score ?? 'N/A',
            'level' => $item->overall_level ?? 'N/A',
            'overall_band' => $item->overall_band ?? null,
            'percentage' => $item->total_percentage ?? null,
            'total_percentage' => $item->total_percentage ?? null,
            'test_date' => $item->test_date,
            'sort_date' => $item->created_at,
            'listening_score' => $item->listening_score,
            'listening_percentage' => $item->listening_percentage,
            'reading_score' => $item->reading_score,
            'reading_percentage' => $item->reading_percentage,
        ];
    }

    /**
     * Format Basic English Result
     */
    private function formatBasicEnglishResult($item)
    {
        return [
            'id' => $item->id,
            'test_type' => 'basic-english',
            'name' => $item->user_name ?? 'N/A',
            'email' => $item->user_email ?? 'N/A',
            'phone' => $item->whatsapp_number ?? 'N/A',
            'overall_score' => $item->overall_score ?? 'N/A',
            'level' => $item->overall_level ?? 'N/A',
            'percentage' => $item->total_percentage ?? null,
            'total_percentage' => $item->total_percentage ?? null,
            'test_date' => $item->test_date,
            'sort_date' => $item->created_at,
            'listening_score' => $item->listening_correct . '/' . $item->listening_total,
            'listening_percentage' => $item->listening_percentage,
            'listening_level' => $item->listening_level,
            'reading_score' => $item->reading_correct . '/' . $item->reading_total,
            'reading_percentage' => $item->reading_percentage,
            'reading_level' => $item->reading_level,
            'grammar_score' => $item->grammar_correct . '/' . $item->grammar_total,
            'grammar_percentage' => $item->grammar_percentage,
            'grammar_level' => $item->grammar_level,
            'vocab_score' => $item->vocabulary_correct . '/' . $item->vocabulary_total,
            'vocab_percentage' => $item->vocabulary_percentage,
            'vocab_level' => $item->vocabulary_level,
            'pronoun_score' => $item->pronunciation_correct . '/' . $item->pronunciation_total,
            'pronoun_percentage' => $item->pronunciation_percentage,
            'pronoun_level' => $item->pronunciation_level,
        ];
    }

    /**
     * Format TOEFL Result
     */
    private function formatToeflResult($item)
    {
        return [
            'id' => $item->id,
            'test_type' => 'toefl',
            'name' => $item->user_name ?? 'N/A',
            'email' => $item->user_email ?? 'N/A',
            'phone' => $item->user_whatsapp ?? 'N/A',
            'overall_score' => $item->overall_score ?? 'N/A',
            'level' => $item->cefr_level ?? 'N/A',
            'percentage' => $item->overall_percentage ?? null,
            'total_percentage' => $item->overall_percentage ?? null,
            'test_date' => $item->test_date,
            'sort_date' => $item->test_date,
            'listening_score' => $item->listening_score,
            'listening_percentage' => $item->listening_percentage,
            'reading_score' => $item->reading_score,
            'reading_percentage' => $item->reading_percentage,
            'grammar_score' => $item->grammar_score,
            'grammar_percentage' => $item->grammar_percentage,
        ];
    }

    /**
     * Format TOEIC Result
     */
    private function formatToeicResult($item)
    {
        return [
            'id' => $item->id,
            'test_type' => 'toeic',
            'name' => $item->name ?? 'N/A',
            'email' => $item->email ?? 'N/A',
            'phone' => $item->whatsapp ?? 'N/A',
            'overall_score' => $item->overall_score ?? 'N/A',
            'level' => $item->overall_cefr ?? 'N/A',
            'percentage' => $item->overall_percentage ?? null,
            'total_percentage' => $item->overall_percentage ?? null,
            'test_date' => $item->submitted_at,
            'sort_date' => $item->submitted_at,
            'listening_score' => $item->listening_score,
            'listening_percentage' => $item->listening_percentage,
            'reading_score' => $item->reading_score,
            'reading_percentage' => $item->reading_percentage,
        ];
    }

    /**
     * Format IELTS A2 Result
     */
    private function formatIeltsA2Result($item)
    {
        return [
            'id' => $item->id,
            'test_type' => 'ielts-a2',
            'name' => $item->name ?? 'N/A',
            'email' => $item->email ?? 'N/A',
            'phone' => $item->phone ?? 'N/A',
            'overall_score' => $item->overall_score ?? 'N/A',
            'level' => $item->overall_level ?? 'N/A',
            'overall_band' => $item->overall_band ?? null,
            'test_date' => $item->submitted_at,
            'sort_date' => $item->submitted_at,
            'listening_score' => $item->listening_correct,
            'listening_percentage' => $item->listening_accuracy,
            'listening_ielts' => $item->listening_ielts,
            'reading_score' => $item->reading_correct,
            'reading_percentage' => $item->reading_accuracy,
            'reading_ielts' => $item->reading_ielts,
            'writing_score' => $item->writing_overall,
        ];
    }

    /**
     * Format IELTS B1 Result
     */
    private function formatIeltsB1Result($item)
    {
        return [
            'id' => $item->id,
            'test_type' => 'ielts-b1',
            'name' => $item->name ?? 'N/A',
            'email' => $item->email ?? 'N/A',
            'phone' => $item->phone ?? 'N/A',
            'overall_score' => $item->overall_score ?? 'N/A',
            'level' => $item->overall_level ?? 'N/A',
            'overall_band' => $item->overall_band ?? null,
            'test_date' => $item->submitted_at,
            'sort_date' => $item->submitted_at,
            'listening_score' => $item->listening_correct,
            'listening_percentage' => $item->listening_accuracy,
            'listening_ielts' => $item->listening_ielts,
            'reading_score' => $item->reading_correct,
            'reading_percentage' => $item->reading_accuracy,
            'reading_ielts' => $item->reading_ielts,
            'writing_score' => $item->writing_overall,
            'speaking_score' => $item->speaking_ielts,
        ];
    }

    /**
     * Format Practical English Result
     */
    private function formatPracticalEnglishResult($item)
    {
        return [
            'id' => $item->id,
            'test_type' => 'practical',
            'name' => $item->name ?? 'N/A',
            'email' => $item->email ?? 'N/A',
            'phone' => 'N/A',
            'overall_score' => $item->overall_score ?? 'N/A',
            'level' => $item->overall_level ?? 'N/A',
            'percentage' => $item->total_percentage ?? null,
            'total_percentage' => $item->total_percentage ?? null,
            'test_date' => $item->test_date,
            'sort_date' => $item->created_at,
            'listening_score' => $item->listening_score,
            'listening_percentage' => $item->listening_percentage,
            'reading_score' => $item->reading_score,
            'reading_percentage' => $item->reading_percentage,
            'speaking_score' => $item->speaking_completed,
            'grammar_score' => $item->grammar_score,
            'grammar_percentage' => $item->grammar_percentage,
        ];
    }

    /**
     * Format Business Speaking Result
     */
    private function formatBusinessSpeakingResult($item)
    {
        return [
            'id' => $item->id,
            'test_type' => 'business',
            'name' => $item->name ?? 'N/A',
            'email' => $item->email ?? 'N/A',
            'phone' => 'N/A',
            'overall_score' => $item->overall_score ?? 'N/A',
            'level' => 'N/A',
            'percentage' => $item->overall_percent ?? null,
            'total_percentage' => $item->overall_percent ?? null,
            'test_date' => $item->test_date,
            'sort_date' => $item->created_at,
            'speaking_score' => $item->total_completed . '/' . $item->total_tasks,
        ];
    }
}