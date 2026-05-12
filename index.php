<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Origin, X-Requested-With');
header('Access-Control-Max-Age: 3600');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'u378913818_elearning');
define('DB_PASS', 'Akhmad98@');
define('DB_NAME', 'u378913818_elarning');
define('DB_PORT', 3306);
define('DB_CHARSET', 'utf8mb4');

// Get database connection
function getDbConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection error: " . $e->getMessage());
        return null;
    }
}

// Calculate CEFR level from score
function calculateCefrLevel($score) {
    $score = floatval($score);
    if ($score >= 90) return 'C2';
    elseif ($score >= 80) return 'C1';
    elseif ($score >= 70) return 'B2';
    elseif ($score >= 60) return 'B1';
    elseif ($score >= 50) return 'A2';
    elseif ($score >= 40) return 'A1';
    else return 'Beginner';
}

// Send JSON response
function sendResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit();
}

// Get JSON input
function getJsonInput() {
    $input = file_get_contents('php://input');
    return json_decode($input, true);
}

// Router - Get request URI and method
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Remove /index.php from URI if present
$requestUri = preg_replace('#^/index\.php#', '', $requestUri);

// Remove trailing slash
$requestUri = rtrim($requestUri, '/');

// If empty, set to root
if (empty($requestUri)) {
    $requestUri = '/';
}
if($requestUri === '' || $requestUri === '/' ){
        header('Location: /index.html');
    exit();

}

// Route: Home
if ($requestUri === '/index.php') {
    sendResponse([
        'status' => 'success',
        'message' => 'PHP E-Learning API is running!',
        'endpoints' => [
            'POST' => [
                '/api/submit-toefl',
                '/api/submit-academic',
                '/api/submit-basic',
                '/api/submit-practical',
                '/api/submit-toeic',
                '/api/submit-ielts-a2',
                '/api/submit-ielts-b1',
                '/api/submit-business',
                '/api/contact'
            ],
            'GET' => [
                '/api/placement-results',
                '/health',
                '/api/test'
            ]
        ],
        'timestamp' => date('c')
    ]);
}

// Route: Health check
if ($requestUri === '/health') {
    try {
        $pdo = getDbConnection();
        if ($pdo) {
            $stmt = $pdo->query("SELECT 1");
            $dbStatus = 'connected';
        } else {
            $dbStatus = 'disconnected';
        }
        
        sendResponse([
            'status' => 'healthy',
            'database' => $dbStatus,
            'timestamp' => date('c')
        ]);
    } catch (Exception $e) {
        sendResponse([
            'status' => 'unhealthy',
            'database' => 'disconnected',
            'error' => $e->getMessage(),
            'timestamp' => date('c')
        ], 500);
    }
}

// Route: Test API
if ($requestUri === '/api/test') {
    try {
        $pdo = getDbConnection();
        if ($pdo) {
            $stmt = $pdo->query("SELECT 1 as test");
            $result = $stmt->fetch();
            
            sendResponse([
                'status' => 'success',
                'message' => 'API and database are working perfectly',
                'database_test' => $result['test'] ?? 'no result',
                'timestamp' => date('c')
            ]);
        } else {
            sendResponse([
                'status' => 'error',
                'message' => 'Database connection failed'
            ], 500);
        }
    } catch (Exception $e) {
        sendResponse([
            'status' => 'error',
            'message' => 'Test failed: ' . $e->getMessage()
        ], 500);
    }
}

// Route: Submit TOEFL Preparation
if ($requestUri === '/api/submit-toefl' && $requestMethod === 'POST') {
    try {
        $data = getJsonInput();
        
        if (!$data) {
            sendResponse(['status' => 'error', 'message' => 'No JSON data provided'], 400);
        }
        
        $pdo = getDbConnection();
        if (!$pdo) {
            sendResponse(['status' => 'error', 'message' => 'Database connection failed'], 500);
        }
        
        // Get user data
        $userName = $data['user_name'] ?? 'Student';
        $userEmail = $data['user_email'] ?? '';
        $userWhatsapp = $data['user_whatsapp'] ?? '';
        
        // Get test type
        $testType = $data['test_type'] ?? 'TOEFL Preparation';
        
        // Get test date
        $testDate = date('Y-m-d');
        if (!empty($data['test_date'])) {
            $testDate = date('Y-m-d', strtotime($data['test_date']));
        }
        
        // Get scores
        $listeningScore = intval($data['listening_score'] ?? 0);
        $listeningCorrect = intval($data['listening_correct'] ?? 0);
        $listeningTotal = intval($data['listening_total'] ?? 0);
        $listeningPercentage = floatval($data['listening_percentage'] ?? 0);
        
        $readingScore = intval($data['reading_score'] ?? 0);
        $readingCorrect = intval($data['reading_correct'] ?? 0);
        $readingTotal = intval($data['reading_total'] ?? 0);
        $readingPercentage = floatval($data['reading_percentage'] ?? 0);
        
        $grammarScore = intval($data['grammar_score'] ?? 0);
        $grammarCorrect = intval($data['grammar_correct'] ?? 0);
        $grammarTotal = intval($data['grammar_total'] ?? 0);
        $grammarPercentage = floatval($data['grammar_percentage'] ?? 0);
        
        $overallScore = intval($data['overall_score'] ?? 0);
        $totalCorrect = intval($data['total_correct'] ?? 0);
        $totalQuestions = intval($data['total_questions'] ?? 0);
        $overallPercentage = floatval($data['overall_percentage'] ?? 0);
        
        // Calculate CEFR level
        $cefrLevel = calculateCefrLevel($overallPercentage);
        
        // Insert into database
        $sql = "INSERT INTO toefl_preparation_results (
                    user_name, user_email, user_whatsapp, test_type, test_date,
                    listening_score, listening_correct, listening_total, listening_percentage,
                    reading_score, reading_correct, reading_total, reading_percentage,
                    grammar_score, grammar_correct, grammar_total, grammar_percentage,
                    overall_score, total_correct, total_questions, overall_percentage,
                    cefr_level, submitted_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $userName, $userEmail, $userWhatsapp, $testType, $testDate,
            $listeningScore, $listeningCorrect, $listeningTotal, $listeningPercentage,
            $readingScore, $readingCorrect, $readingTotal, $readingPercentage,
            $grammarScore, $grammarCorrect, $grammarTotal, $grammarPercentage,
            $overallScore, $totalCorrect, $totalQuestions, $overallPercentage,
            $cefrLevel, date('Y-m-d H:i:s')
        ]);
        
        $resultId = $pdo->lastInsertId();
        
        sendResponse([
            'status' => 'success',
            'message' => 'TOEFL Preparation results saved successfully',
            'result_id' => $resultId,
            'cefr_level' => $cefrLevel,
            'data' => [
                'name' => $userName,
                'email' => $userEmail,
                'overall_score' => $overallScore,
                'overall_percentage' => $overallPercentage,
                'cefr_level' => $cefrLevel
            ],
            'timestamp' => date('c')
        ]);
        
    } catch (Exception $e) {
        error_log("Error in submit_toefl: " . $e->getMessage());
        sendResponse([
            'status' => 'error',
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

// Route: Submit Academic English
if ($requestUri === '/api/submit-academic' && $requestMethod === 'POST') {
    try {
        $data = getJsonInput();
        
        if (!$data) {
            sendResponse(['status' => 'error', 'message' => 'No JSON data provided'], 400);
        }
        
        $pdo = getDbConnection();
        if (!$pdo) {
            sendResponse(['status' => 'error', 'message' => 'Database connection failed'], 500);
        }
        
        $userName = $data['user_name'] ?? 'Student';
        $userEmail = $data['user_email'] ?? '';
        $whatsappNumber = $data['whatsapp_number'] ?? '';
        
        $testDate = date('Y-m-d');
        if (!empty($data['test_date'])) {
            $testDate = date('Y-m-d', strtotime($data['test_date']));
        }
        
        $overallScore = $data['overall_score'] ?? 'B2';
        $overallLevel = $data['overall_level'] ?? 'B2 Level';
        $totalCorrect = intval($data['total_correct'] ?? 0);
        $totalQuestions = intval($data['total_questions'] ?? 0);
        $totalPercentage = $totalQuestions > 0 ? round(($totalCorrect / $totalQuestions) * 100, 2) : 0;
        
        $listeningScore = $data['listening_score'] ?? '0';
        $listeningPercentage = $data['listening_percentage'] ?? '0';
        $listeningIelts = $data['listening_ielts'] ?? 'N/A';
        
        $readingScore = $data['reading_score'] ?? '0';
        $readingPercentage = $data['reading_percentage'] ?? '0';
        $readingIelts = $data['reading_ielts'] ?? 'N/A';
        
        $certificateType = $data['certificate_type'] ?? 'Academic English Certificate';
        
        $sql = "INSERT INTO academic_results (
                    user_name, user_email, whatsapp_number, test_type, test_date, submitted_at,
                    overall_score, overall_level, total_correct, total_questions, total_percentage,
                    listening_score, listening_percentage, listening_ielts,
                    reading_score, reading_percentage, reading_ielts,
                    certificate_type
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $userName, $userEmail, $whatsappNumber, 'Academic English',
            $testDate, date('Y-m-d H:i:s'),
            $overallScore, $overallLevel, $totalCorrect, $totalQuestions, $totalPercentage,
            $listeningScore, $listeningPercentage, $listeningIelts,
            $readingScore, $readingPercentage, $readingIelts,
            $certificateType
        ]);
        
        $resultId = $pdo->lastInsertId();
        
        sendResponse([
            'status' => 'success',
            'message' => 'Academic English results saved successfully',
            'result_id' => $resultId,
            'timestamp' => date('c')
        ]);
        
    } catch (Exception $e) {
        error_log("Error in submit_academic: " . $e->getMessage());
        sendResponse([
            'status' => 'error',
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

// Route: Submit Basic English - FIXED TO MATCH DATABASE SCHEMA
if (($requestUri === '/api/submit-basic' || $requestUri === '/data/api/submit-basic') && $requestMethod === 'POST') {
    try {
        $data = getJsonInput();
        
        if (!$data) {
            sendResponse(['status' => 'error', 'message' => 'No JSON data provided'], 400);
        }
        
        error_log("Basic English Data Received: " . json_encode($data));
        
        $pdo = getDbConnection();
        if (!$pdo) {
            sendResponse(['status' => 'error', 'message' => 'Database connection failed'], 500);
        }
        
        // Get user data
        $userName = $data['name'] ?? 'Student';
        $userEmail = $data['email'] ?? '';
        $whatsappNumber = $data['whatsapp'] ?? '';
        
        // Get overall scores
        $overallScore = $data['overall_score'] ?? 'B1';
        $overallLevel = $data['overall_level'] ?? "$overallScore Level";
        $totalCorrect = intval($data['total_correct'] ?? 0);
        $totalQuestions = intval($data['total_questions'] ?? 0);
        $totalPercentage = floatval($data['total_percentage'] ?? 0);
        
        // Get vocabulary data
        $vocabCorrect = intval($data['vocab_score'] ?? 0);
        $vocabTotal = 25;
        $vocabPercentage = floatval($data['vocab_percentage'] ?? 0);
        $vocabLevel = $data['vocab_level'] ?? 'A1';
        
        // Get grammar data
        $grammarCorrect = intval($data['grammar_score'] ?? 0);
        $grammarTotal = 25;
        $grammarPercentage = floatval($data['grammar_percentage'] ?? 0);
        $grammarLevel = $data['grammar_level'] ?? 'A1';
        
        // Get pronunciation data (dari pronoun di HTML)
        // PENTING: Database menggunakan "pronunciation" bukan "pronoun"
        $pronunciationCorrect = intval($data['pronoun_score'] ?? 0);
        $pronunciationTotal = 25;
        $pronunciationPercentage = floatval($data['pronoun_percentage'] ?? 0);
        $pronunciationLevel = $data['pronoun_level'] ?? 'A1';
        
        // Get reading data
        $readingCorrect = intval($data['reading_score'] ?? 0);
        $readingTotal = 25;
        $readingPercentage = floatval($data['reading_percentage'] ?? 0);
        $readingLevel = $data['reading_level'] ?? 'A1';
        
        // Get listening data
        $listeningCorrect = intval($data['listening_score'] ?? 0);
        $listeningTotal = 25;
        $listeningPercentage = floatval($data['listening_percentage'] ?? 0);
        $listeningLevel = $data['listening_level'] ?? 'A1';
        
        $testDate = date('Y-m-d');
        $submittedAt = date('Y-m-d H:i:s');
        
        // SQL statement matching exact database schema
        $sql = "INSERT INTO basic_english_results (
                    user_name, user_email, whatsapp_number, test_type, test_date, submitted_at,
                    overall_score, overall_level, total_correct, total_questions, total_percentage,
                    vocabulary_correct, vocabulary_total, vocabulary_percentage, vocabulary_level,
                    grammar_correct, grammar_total, grammar_percentage, grammar_level,
                    pronunciation_correct, pronunciation_total, pronunciation_percentage, pronunciation_level,
                    reading_correct, reading_total, reading_percentage, reading_level,
                    listening_correct, listening_total, listening_percentage, listening_level
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $userName, $userEmail, $whatsappNumber, 'Basic English', $testDate, $submittedAt,
            $overallScore, $overallLevel, $totalCorrect, $totalQuestions, $totalPercentage,
            $vocabCorrect, $vocabTotal, $vocabPercentage, $vocabLevel,
            $grammarCorrect, $grammarTotal, $grammarPercentage, $grammarLevel,
            $pronunciationCorrect, $pronunciationTotal, $pronunciationPercentage, $pronunciationLevel,
            $readingCorrect, $readingTotal, $readingPercentage, $readingLevel,
            $listeningCorrect, $listeningTotal, $listeningPercentage, $listeningLevel
        ];
        
        error_log("SQL Params: " . json_encode($params));
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute($params);
        
        if (!$result) {
            $errorInfo = $stmt->errorInfo();
            error_log("SQL Error: " . json_encode($errorInfo));
            sendResponse([
                'status' => 'error',
                'message' => 'Failed to insert data: ' . $errorInfo[2],
                'sql_state' => $errorInfo[0],
                'error_code' => $errorInfo[1]
            ], 500);
        }
        
        $resultId = $pdo->lastInsertId();
        error_log("Basic English saved successfully. Result ID: " . $resultId);
        
        sendResponse([
            'status' => 'success',
            'message' => 'Basic English results saved successfully',
            'result_id' => $resultId,
            'data' => [
                'name' => $userName,
                'email' => $userEmail,
                'overall_score' => $overallScore,
                'overall_level' => $overallLevel,
                'total_score' => "$totalCorrect/$totalQuestions ($totalPercentage%)",
                'vocabulary' => "$vocabCorrect/$vocabTotal ($vocabPercentage%) - $vocabLevel",
                'grammar' => "$grammarCorrect/$grammarTotal ($grammarPercentage%) - $grammarLevel",
                'pronunciation' => "$pronunciationCorrect/$pronunciationTotal ($pronunciationPercentage%) - $pronunciationLevel",
                'reading' => "$readingCorrect/$readingTotal ($readingPercentage%) - $readingLevel",
                'listening' => "$listeningCorrect/$listeningTotal ($listeningPercentage%) - $listeningLevel"
            ],
            'timestamp' => date('c')
        ]);
        
    } catch (PDOException $e) {
        error_log("PDO Error in submit_basic: " . $e->getMessage());
        error_log("PDO Error Code: " . $e->getCode());
        error_log("PDO Error Info: " . print_r($e->errorInfo ?? [], true));
        sendResponse([
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage(),
            'code' => $e->getCode()
        ], 500);
    } catch (Exception $e) {
        error_log("Error in submit_basic: " . $e->getMessage());
        sendResponse([
            'status' => 'error',
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

// Route: Submit Practical English
if ($requestUri === '/api/submit-practical' && $requestMethod === 'POST') {
    try {
        $data = getJsonInput();
        
        if (!$data) {
            sendResponse(['status' => 'error', 'message' => 'No JSON data provided'], 400);
        }
        
        $pdo = getDbConnection();
        if (!$pdo) {
            sendResponse(['status' => 'error', 'message' => 'Database connection failed'], 500);
        }
        
        $name = $data['name'] ?? $data['user_name'] ?? 'Student';
        $email = $data['email'] ?? $data['user_email'] ?? '';
        
        $testDate = date('Y-m-d');
        if (!empty($data['test_date'])) {
            $testDate = date('Y-m-d', strtotime($data['test_date']));
        }
        
        $overallScore = $data['overall_score'] ?? 'B2';
        $overallLevel = $data['overall_level'] ?? 'B2 Level';
        $totalCorrect = intval($data['total_correct'] ?? 0);
        $totalQuestions = intval($data['total_questions'] ?? 0);
        $totalPercentage = floatval($data['total_percentage'] ?? 0);
        
        $readingPercentage = floatval($data['reading_percentage'] ?? 0);
        $readingLevel = $data['reading_level'] ?? 'B2';
        $readingScore = $data['reading_score'] ?? '0';
        $readingIelts = $data['reading_ielts'] ?? 'N/A';
        $readingProgress = floatval($data['reading_progress'] ?? 0);
        
        $listeningPercentage = floatval($data['listening_percentage'] ?? 0);
        $listeningLevel = $data['listening_level'] ?? 'B2';
        $listeningScore = $data['listening_score'] ?? '0';
        $listeningIelts = $data['listening_ielts'] ?? 'N/A';
        $listeningProgress = floatval($data['listening_progress'] ?? 0);
        
        $grammarPercentage = floatval($data['grammar_percentage'] ?? 0);
        $grammarLevel = $data['grammar_level'] ?? 'B2';
        $grammarScore = $data['grammar_score'] ?? '0';
        $grammarIelts = $data['grammar_ielts'] ?? 'N/A';
        $grammarProgress = floatval($data['grammar_progress'] ?? 0);
        
        $speakingCompleted = $data['speaking_completed'] ?? '0';
        $speakingLevel = $data['speaking_level'] ?? 'B2';
        
        $sql = "INSERT INTO practical_english_results (
                    name, email, test_date,
                    overall_score, overall_level, 
                    total_correct, total_questions, total_percentage,
                    reading_percentage, reading_level, reading_score, reading_ielts, reading_progress,
                    listening_percentage, listening_level, listening_score, listening_ielts, listening_progress,
                    grammar_percentage, grammar_level, grammar_score, grammar_ielts, grammar_progress,
                    speaking_completed, speaking_level
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $name, $email, $testDate,
            $overallScore, $overallLevel, 
            $totalCorrect, $totalQuestions, round($totalPercentage, 2),
            round($readingPercentage, 2), $readingLevel, $readingScore, $readingIelts, round($readingProgress, 2),
            round($listeningPercentage, 2), $listeningLevel, $listeningScore, $listeningIelts, round($listeningProgress, 2),
            round($grammarPercentage, 2), $grammarLevel, $grammarScore, $grammarIelts, round($grammarProgress, 2),
            $speakingCompleted, $speakingLevel
        ]);
        
        $resultId = $pdo->lastInsertId();
        
        sendResponse([
            'status' => 'success',
            'message' => 'Practical English results saved successfully',
            'result_id' => $resultId,
            'timestamp' => date('c'),
            'data' => [
                'name' => $name,
                'overall_score' => $overallScore,
                'overall_level' => $overallLevel,
                'total_score' => "$totalCorrect/$totalQuestions"
            ]
        ]);
        
    } catch (Exception $e) {
        error_log("Error in submit_practical: " . $e->getMessage());
        sendResponse([
            'status' => 'error',
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

// Route: Submit TOEIC
if ($requestUri === '/api/submit-toeic' && $requestMethod === 'POST') {
    try {
        $data = getJsonInput();
        
        if (!$data) {
            sendResponse(['status' => 'error', 'message' => 'No JSON data provided'], 400);
        }
        
        $pdo = getDbConnection();
        if (!$pdo) {
            sendResponse(['status' => 'error', 'message' => 'Database connection failed'], 500);
        }
        
        $name = $data['name'] ?? 'Student';
        $email = $data['email'] ?? '';
        $whatsapp = $data['whatsapp'] ?? '';
        
        $listeningCorrect = intval($data['listening_correct'] ?? 0);
        $listeningTotal = intval($data['listening_total'] ?? 0);
        $listeningPercentage = ($listeningTotal > 0) ? ($listeningCorrect / $listeningTotal * 100) : 0;
        $listeningScore = intval($data['listening_score'] ?? ($listeningPercentage * 5));
        
        $readingCorrect = intval($data['reading_correct'] ?? 0);
        $readingTotal = intval($data['reading_total'] ?? 0);
        $readingPercentage = ($readingTotal > 0) ? ($readingCorrect / $readingTotal * 100) : 0;
        $readingScore = intval($data['reading_score'] ?? ($readingPercentage * 5));
        
        $overallCorrect = $listeningCorrect + $readingCorrect;
        $overallTotal = $listeningTotal + $readingTotal;
        $overallPercentage = ($overallTotal > 0) ? ($overallCorrect / $overallTotal * 100) : 0;
        $overallScore = $listeningScore + $readingScore;
        
        $listeningCefr = calculateCefrLevel($listeningPercentage);
        $readingCefr = calculateCefrLevel($readingPercentage);
        $overallCefr = calculateCefrLevel($overallPercentage);
        
        $sql = "INSERT INTO toeic_results (
                    name, email, whatsapp,
                    listening_correct, listening_total, listening_percentage, listening_score, listening_cefr,
                    reading_correct, reading_total, reading_percentage, reading_score, reading_cefr,
                    overall_correct, overall_total, overall_percentage, overall_score, overall_cefr
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $name, $email, $whatsapp,
            $listeningCorrect, $listeningTotal, intval($listeningPercentage), $listeningScore, $listeningCefr,
            $readingCorrect, $readingTotal, intval($readingPercentage), $readingScore, $readingCefr,
            $overallCorrect, $overallTotal, intval($overallPercentage), $overallScore, $overallCefr
        ]);
        
        $resultId = $pdo->lastInsertId();
        
        sendResponse([
            'status' => 'success',
            'message' => 'TOEIC results saved successfully',
            'result_id' => $resultId,
            'timestamp' => date('c')
        ]);
        
    } catch (Exception $e) {
        error_log("Error in submit_toeic: " . $e->getMessage());
        sendResponse([
            'status' => 'error',
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

// Route: Submit IELTS A2
if ($requestUri === '/api/submit-ielts-a2' && $requestMethod === 'POST') {
    try {
        $data = getJsonInput();
        
        if (!$data) {
            sendResponse(['status' => 'error', 'message' => 'No JSON data provided'], 400);
        }
        
        $pdo = getDbConnection();
        if (!$pdo) {
            sendResponse(['status' => 'error', 'message' => 'Database connection failed'], 500);
        }
        
        $name = $data['name'] ?? 'Student';
        $email = $data['email'] ?? '';
        $phone = $data['phone'] ?? '';
        
        $listeningAccuracy = floatval($data['listening_accuracy'] ?? 0);
        $listeningCorrect = $data['listening_correct'] ?? '0';
        $listeningIelts = floatval($data['listening_ielts'] ?? 0);
        
        $readingAccuracy = floatval($data['reading_accuracy'] ?? 0);
        $readingCorrect = $data['reading_correct'] ?? '0';
        $readingIelts = floatval($data['reading_ielts'] ?? 0);
        
        $writingTask1 = floatval($data['writing_task1'] ?? 0);
        $writingTask2 = floatval($data['writing_task2'] ?? 0);
        $writingOverall = floatval($data['writing_overall'] ?? 0);
        
        $overallBand = ($listeningAccuracy + $readingAccuracy) / 20;
        $overallLevel = calculateCefrLevel($overallBand * 10);
        $overallScore = $overallLevel;
        
        $sql = "INSERT INTO ielts_a2_results (
                    name, email, phone, 
                    overall_score, overall_level, overall_band,
                    listening_accuracy, listening_correct, listening_ielts, listening_percent,
                    reading_accuracy, reading_correct, reading_ielts, reading_percent,
                    writing_task1, writing_task2, writing_overall, writing_percent
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $name, $email, $phone,
            $overallScore, $overallLevel, number_format($overallBand, 1),
            $listeningAccuracy, $listeningCorrect, $listeningIelts, $listeningAccuracy,
            $readingAccuracy, $readingCorrect, $readingIelts, $readingAccuracy,
            $writingTask1, $writingTask2, $writingOverall, floatval($data['writing_percent'] ?? 0)
        ]);
        
        $resultId = $pdo->lastInsertId();
        
        sendResponse([
            'status' => 'success',
            'message' => 'IELTS A2 results saved successfully',
            'result_id' => $resultId,
            'timestamp' => date('c')
        ]);
        
    } catch (Exception $e) {
        error_log("Error in submit_ielts_a2: " . $e->getMessage());
        sendResponse([
            'status' => 'error',
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

// Route: Submit IELTS B1
if ($requestUri === '/api/submit-ielts-b1' && $requestMethod === 'POST') {
    try {
        $data = getJsonInput();
        
        if (!$data) {
            sendResponse(['status' => 'error', 'message' => 'No JSON data provided'], 400);
        }
        
        $pdo = getDbConnection();
        if (!$pdo) {
            sendResponse(['status' => 'error', 'message' => 'Database connection failed'], 500);
        }
        
        $name = $data['name'] ?? 'Student';
        $email = $data['email'] ?? '';
        $phone = $data['phone'] ?? '';
        
        $listeningAccuracy = floatval($data['listening_accuracy'] ?? 0);
        $listeningCorrect = $data['listening_correct'] ?? '0';
        $listeningIelts = floatval($data['listening_ielts'] ?? 0);
        
        $readingAccuracy = floatval($data['reading_accuracy'] ?? 0);
        $readingCorrect = $data['reading_correct'] ?? '0';
        $readingIelts = floatval($data['reading_ielts'] ?? 0);
        
        $writingTask1 = floatval($data['writing_task1'] ?? 0);
        $writingTask2 = floatval($data['writing_task2'] ?? 0);
        $writingOverall = floatval($data['writing_overall'] ?? 0);
        
        $speakingIelts = floatval($data['speaking_ielts'] ?? 0);
        $speakingFluency = floatval($data['speaking_fluency'] ?? 0);
        $speakingPronunciation = floatval($data['speaking_pronunciation'] ?? 0);
        $speakingGrammar = floatval($data['speaking_grammar'] ?? 0);
        $speakingTasks = $data['speaking_tasks'] ?? '0';
        
        $overallBand = ($listeningAccuracy + $readingAccuracy) / 20;
        $overallLevel = calculateCefrLevel($overallBand * 10);
        $overallScore = $overallLevel;
        
        $sql = "INSERT INTO ielts_b1_results (
                    name, email, phone, 
                    overall_score, overall_level, overall_band,
                    listening_accuracy, listening_correct, listening_ielts, listening_percent,
                    reading_accuracy, reading_correct, reading_ielts, reading_percent,
                    writing_task1, writing_task2, writing_overall, writing_percent,
                    speaking_ielts, speaking_fluency, speaking_pronunciation, speaking_grammar, speaking_tasks
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $name, $email, $phone,
            $overallScore, $overallLevel, number_format($overallBand, 1),
            $listeningAccuracy, $listeningCorrect, $listeningIelts, $listeningAccuracy,
            $readingAccuracy, $readingCorrect, $readingIelts, $readingAccuracy,
            $writingTask1, $writingTask2, $writingOverall, floatval($data['writing_percent'] ?? 0),
            $speakingIelts, $speakingFluency, $speakingPronunciation, $speakingGrammar, $speakingTasks
        ]);
        
        $resultId = $pdo->lastInsertId();
        
        sendResponse([
            'status' => 'success',
            'message' => 'IELTS B1 results saved successfully',
            'result_id' => $resultId,
            'timestamp' => date('c')
        ]);
        
    } catch (Exception $e) {
        error_log("Error in submit_ielts_b1: " . $e->getMessage());
        sendResponse([
            'status' => 'error',
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

// Route: Submit Business Speaking
if ($requestUri === '/api/submit-business' && $requestMethod === 'POST') {
    try {
        $data = getJsonInput();
        
        if (!$data) {
            sendResponse(['status' => 'error', 'message' => 'No JSON data provided'], 400);
        }
        
        $pdo = getDbConnection();
        if (!$pdo) {
            sendResponse(['status' => 'error', 'message' => 'Database connection failed'], 500);
        }
        
        $name = $data['name'] ?? 'Student';
        $email = $data['email'] ?? '';
        
        $negotiatingCompleted = intval($data['negotiating_completed'] ?? 0);
        $negotiatingTotal = intval($data['negotiating_total'] ?? 0);
        
        $issuesCompleted = intval($data['issues_completed'] ?? 0);
        $issuesTotal = intval($data['issues_total'] ?? 0);
        
        $meetingCompleted = intval($data['meeting_completed'] ?? 0);
        $meetingTotal = intval($data['meeting_total'] ?? 0);
        
        $totalCompleted = intval($data['total_completed'] ?? 0);
        $totalTasks = intval($data['total_tasks'] ?? 0);
        $overallPercent = ($totalTasks > 0) ? ($totalCompleted / $totalTasks * 100) : 0;
        $overallScore = round($overallPercent / 10, 1);
        
        $completionInfo = $data['completion_info'] ?? null;
        
        $sql = "INSERT INTO business_speaking_results (
                    name, email, test_date, overall_score, completion_info,
                    negotiating_completed, negotiating_total,
                    issues_completed, issues_total,
                    meeting_completed, meeting_total,
                    total_completed, total_tasks, overall_percent
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $name, $email, date('Y-m-d'), $overallScore, $completionInfo,
            $negotiatingCompleted, $negotiatingTotal,
            $issuesCompleted, $issuesTotal,
            $meetingCompleted, $meetingTotal,
            $totalCompleted, $totalTasks, round($overallPercent, 2)
        ]);
        
        $resultId = $pdo->lastInsertId();
        
        sendResponse([
            'status' => 'success',
            'message' => 'Business Speaking results saved successfully',
            'result_id' => $resultId,
            'timestamp' => date('c')
        ]);
        
    } catch (Exception $e) {
        error_log("Error in submit_business: " . $e->getMessage());
        sendResponse([
            'status' => 'error',
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

// Route: Submit Contact Form
if ($requestUri === '/api/contact' && $requestMethod === 'POST') {
    try {
        $data = getJsonInput();
        
        if (!$data) {
            sendResponse(['status' => 'error', 'message' => 'No JSON data provided'], 400);
        }
        
        if (empty($data['name']) || empty($data['email'])) {
            sendResponse(['status' => 'error', 'message' => 'Name and email are required'], 400);
        }
        
        sendResponse([
            'status' => 'success',
            'message' => 'Contact form submitted successfully',
            'data_received' => $data,
            'timestamp' => date('c')
        ]);
        
    } catch (Exception $e) {
        error_log("Error in submit_contact: " . $e->getMessage());
        sendResponse([
            'status' => 'error',
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

// Route: Get Placement Results - FIXED COLUMN NAMES
if ($requestUri === '/api/placement-results' && $requestMethod === 'GET') {
    try {
        $testType = $_GET['test_type'] ?? 'all';
        $dateFrom = $_GET['date_from'] ?? null;
        $dateTo = $_GET['date_to'] ?? null;
        
        $pdo = getDbConnection();
        if (!$pdo) {
            sendResponse(['status' => 'error', 'message' => 'Database connection failed'], 500);
        }
        
        $queries = [];
        $params = [];
        $toeflQuery = "SELECT 
                       'toefl' as test_type, 
                       id, 
                       CONVERT(user_name USING utf8mb4) COLLATE utf8mb4_unicode_ci as name, 
                       CONVERT(user_email USING utf8mb4) COLLATE utf8mb4_unicode_ci as email, 
                       CONVERT(user_whatsapp USING utf8mb4) COLLATE utf8mb4_unicode_ci as phone,
                       CONVERT(cefr_level USING utf8mb4) COLLATE utf8mb4_unicode_ci as overall_score, 
                       CONVERT(cefr_level USING utf8mb4) COLLATE utf8mb4_unicode_ci as level, 
                       NULL as overall_band, 
                       overall_percentage as percentage,
                       listening_score, listening_correct, listening_total, listening_percentage,
                       reading_score, reading_correct, reading_total, reading_percentage,
                       grammar_score, grammar_correct, grammar_total, grammar_percentage,
                       NULL as writing_score, 
                       NULL as speaking_score, 
                       NULL as vocab_score,
                       NULL as pronoun_score,
                       NULL as pronoun_percentage,
                       NULL as pronoun_level,
                       test_date
                FROM toefl_preparation_results WHERE 1=1";
        
        $toeflParams = [];
        if ($dateFrom) {
            $toeflQuery .= " AND DATE(test_date) >= ?";
            $toeflParams[] = $dateFrom;
        }
        if ($dateTo) {
            $toeflQuery .= " AND DATE(test_date) <= ?";
            $toeflParams[] = $dateTo;
        }
        if ($testType === 'all' || $testType === 'toefl') {
            $queries[] = $toeflQuery;
            $params = array_merge($params, $toeflParams);
        }
        
        // Academic English Query - UPDATED
        $academicQuery = "SELECT 
                          'academic' as test_type, 
                          id, 
                          CONVERT(user_name USING utf8mb4) COLLATE utf8mb4_unicode_ci as name, 
                          CONVERT(user_email USING utf8mb4) COLLATE utf8mb4_unicode_ci as email, 
                          CONVERT(whatsapp_number USING utf8mb4) COLLATE utf8mb4_unicode_ci as phone,
                          CONVERT(overall_score USING utf8mb4) COLLATE utf8mb4_unicode_ci as overall_score, 
                          CONVERT(overall_level USING utf8mb4) COLLATE utf8mb4_unicode_ci as level, 
                          NULL as overall_band,
                          CAST(total_percentage AS DECIMAL(10,2)) as percentage,
                          NULL as listening_score, NULL as listening_correct, NULL as listening_total, 
                          CAST(listening_percentage AS DECIMAL(10,2)) as listening_percentage,
                          NULL as reading_score, NULL as reading_correct, NULL as reading_total, 
                          CAST(reading_percentage AS DECIMAL(10,2)) as reading_percentage,
                          NULL as grammar_score, NULL as grammar_correct, NULL as grammar_total, 
                          NULL as grammar_percentage,
                          NULL as writing_score, 
                          NULL as speaking_score, 
                          NULL as vocab_score,
                          NULL as pronoun_score,
                          NULL as pronoun_percentage,
                          NULL as pronoun_level,
                          test_date
                   FROM academic_results WHERE 1=1";
        
        $academicParams = [];
        if ($dateFrom) {
            $academicQuery .= " AND DATE(test_date) >= ?";
            $academicParams[] = $dateFrom;
        }
        if ($dateTo) {
            $academicQuery .= " AND DATE(test_date) <= ?";
            $academicParams[] = $dateTo;
        }
        if ($testType === 'all' || $testType === 'academic') {
            $queries[] = $academicQuery;
            $params = array_merge($params, $academicParams);
        }
        
        // Basic English Query - UPDATED WITH PRONUNCIATION DATA
        $basicQuery = "SELECT 
                       'basic-english' as test_type, 
                       id, 
                       CONVERT(user_name USING utf8mb4) COLLATE utf8mb4_unicode_ci as name, 
                       CONVERT(user_email USING utf8mb4) COLLATE utf8mb4_unicode_ci as email, 
                       CONVERT(whatsapp_number USING utf8mb4) COLLATE utf8mb4_unicode_ci as phone,
                       CONVERT(overall_score USING utf8mb4) COLLATE utf8mb4_unicode_ci as overall_score, 
                       CONVERT(overall_level USING utf8mb4) COLLATE utf8mb4_unicode_ci as level, 
                       NULL as overall_band,
                       total_percentage as percentage,
                       NULL as listening_score, 
                       listening_correct, 
                       listening_total, 
                       listening_percentage,
                       NULL as reading_score, 
                       reading_correct, 
                       reading_total, 
                       reading_percentage,
                       NULL as grammar_score, 
                       grammar_correct, 
                       grammar_total, 
                       grammar_percentage,
                       NULL as writing_score, 
                       NULL as speaking_score, 
                       vocabulary_correct as vocab_score,
                       pronunciation_correct as pronoun_score,
                       pronunciation_percentage as pronoun_percentage,
                       CONVERT(pronunciation_level USING utf8mb4) COLLATE utf8mb4_unicode_ci as pronoun_level,
                       test_date
                FROM basic_english_results WHERE 1=1";
        
        $basicParams = [];
        if ($dateFrom) {
            $basicQuery .= " AND DATE(test_date) >= ?";
            $basicParams[] = $dateFrom;
        }
        if ($dateTo) {
            $basicQuery .= " AND DATE(test_date) <= ?";
            $basicParams[] = $dateTo;
        }
        if ($testType === 'all' || $testType === 'basic-english') {
            $queries[] = $basicQuery;
            $params = array_merge($params, $basicParams);
        }
        
        // Practical English Query - UPDATED
        $practicalQuery = "SELECT 
                           'practical' as test_type, 
                           id, 
                           CONVERT(name USING utf8mb4) COLLATE utf8mb4_unicode_ci as name, 
                           CONVERT(email USING utf8mb4) COLLATE utf8mb4_unicode_ci as email, 
                           NULL as phone,
                           CONVERT(overall_score USING utf8mb4) COLLATE utf8mb4_unicode_ci as overall_score, 
                           CONVERT(overall_level USING utf8mb4) COLLATE utf8mb4_unicode_ci as level, 
                           NULL as overall_band,
                           total_percentage as percentage,
                           NULL as listening_score, NULL as listening_correct, NULL as listening_total, 
                           listening_percentage,
                           NULL as reading_score, NULL as reading_correct, NULL as reading_total, 
                           reading_percentage,
                           NULL as grammar_score, NULL as grammar_correct, NULL as grammar_total, 
                           grammar_percentage,
                           NULL as writing_score, 
                           CONVERT(speaking_completed USING utf8mb4) COLLATE utf8mb4_unicode_ci as speaking_score, 
                           NULL as vocab_score,
                           NULL as pronoun_score,
                           NULL as pronoun_percentage,
                           NULL as pronoun_level,
                           test_date
                    FROM practical_english_results WHERE 1=1";
        
        $practicalParams = [];
        if ($dateFrom) {
            $practicalQuery .= " AND DATE(test_date) >= ?";
            $practicalParams[] = $dateFrom;
        }
        if ($dateTo) {
            $practicalQuery .= " AND DATE(test_date) <= ?";
            $practicalParams[] = $dateTo;
        }
        if ($testType === 'all' || $testType === 'practical') {
            $queries[] = $practicalQuery;
            $params = array_merge($params, $practicalParams);
        }
        
        // TOEIC Query - UPDATED
        $toeicQuery = "SELECT 
                       'toeic' as test_type, 
                       id, 
                       CONVERT(name USING utf8mb4) COLLATE utf8mb4_unicode_ci as name, 
                       CONVERT(email USING utf8mb4) COLLATE utf8mb4_unicode_ci as email, 
                       CONVERT(whatsapp USING utf8mb4) COLLATE utf8mb4_unicode_ci as phone,
                       CONVERT(overall_cefr USING utf8mb4) COLLATE utf8mb4_unicode_ci as overall_score, 
                       CONVERT(overall_cefr USING utf8mb4) COLLATE utf8mb4_unicode_ci as level, 
                       NULL as overall_band,
                       CAST(overall_percentage AS DECIMAL(10,2)) as percentage,
                       listening_score, listening_correct, listening_total, 
                       CAST(listening_percentage AS DECIMAL(10,2)) as listening_percentage,
                       reading_score, reading_correct, reading_total, 
                       CAST(reading_percentage AS DECIMAL(10,2)) as reading_percentage,
                       NULL as grammar_score, NULL as grammar_correct, NULL as grammar_total, 
                       NULL as grammar_percentage,
                       NULL as writing_score, 
                       NULL as speaking_score, 
                       NULL as vocab_score,
                       NULL as pronoun_score,
                       NULL as pronoun_percentage,
                       NULL as pronoun_level,
                       DATE(submitted_at) as test_date
                FROM toeic_results WHERE 1=1";
        
        $toeicParams = [];
        if ($dateFrom) {
            $toeicQuery .= " AND DATE(submitted_at) >= ?";
            $toeicParams[] = $dateFrom;
        }
        if ($dateTo) {
            $toeicQuery .= " AND DATE(submitted_at) <= ?";
            $toeicParams[] = $dateTo;
        }
        if ($testType === 'all' || $testType === 'toeic') {
            $queries[] = $toeicQuery;
            $params = array_merge($params, $toeicParams);
        }
        
        // IELTS A2 Query - UPDATED
        $ieltsA2Query = "SELECT 
                         'ielts-a2' as test_type, 
                         id, 
                         CONVERT(name USING utf8mb4) COLLATE utf8mb4_unicode_ci as name, 
                         CONVERT(email USING utf8mb4) COLLATE utf8mb4_unicode_ci as email, 
                         CONVERT(phone USING utf8mb4) COLLATE utf8mb4_unicode_ci as phone,
                         CONVERT(overall_score USING utf8mb4) COLLATE utf8mb4_unicode_ci as overall_score, 
                         CONVERT(overall_level USING utf8mb4) COLLATE utf8mb4_unicode_ci as level, 
                         CONVERT(overall_band USING utf8mb4) COLLATE utf8mb4_unicode_ci as overall_band,
                         NULL as percentage,
                         NULL as listening_score, NULL as listening_correct, NULL as listening_total, 
                         listening_accuracy as listening_percentage,
                         NULL as reading_score, NULL as reading_correct, NULL as reading_total, 
                         reading_accuracy as reading_percentage,
                         NULL as grammar_score, NULL as grammar_correct, NULL as grammar_total, 
                         NULL as grammar_percentage,
                         writing_overall as writing_score, 
                         NULL as speaking_score, 
                         NULL as vocab_score,
                         NULL as pronoun_score,
                         NULL as pronoun_percentage,
                         NULL as pronoun_level,
                         DATE(submitted_at) as test_date
                  FROM ielts_a2_results WHERE 1=1";
        
        $ieltsA2Params = [];
        if ($dateFrom) {
            $ieltsA2Query .= " AND DATE(submitted_at) >= ?";
            $ieltsA2Params[] = $dateFrom;
        }
        if ($dateTo) {
            $ieltsA2Query .= " AND DATE(submitted_at) <= ?";
            $ieltsA2Params[] = $dateTo;
        }
        if ($testType === 'all' || $testType === 'ielts-a2') {
            $queries[] = $ieltsA2Query;
            $params = array_merge($params, $ieltsA2Params);
        }
        
        // IELTS B1 Query - UPDATED
        $ieltsB1Query = "SELECT 
                         'ielts-b1' as test_type, 
                         id, 
                         CONVERT(name USING utf8mb4) COLLATE utf8mb4_unicode_ci as name, 
                         CONVERT(email USING utf8mb4) COLLATE utf8mb4_unicode_ci as email, 
                         CONVERT(phone USING utf8mb4) COLLATE utf8mb4_unicode_ci as phone,
                         CONVERT(overall_score USING utf8mb4) COLLATE utf8mb4_unicode_ci as overall_score, 
                         CONVERT(overall_level USING utf8mb4) COLLATE utf8mb4_unicode_ci as level, 
                         CONVERT(overall_band USING utf8mb4) COLLATE utf8mb4_unicode_ci as overall_band,
                         NULL as percentage,
                         NULL as listening_score, NULL as listening_correct, NULL as listening_total, 
                         listening_accuracy as listening_percentage,
                         NULL as reading_score, NULL as reading_correct, NULL as reading_total, 
                         reading_accuracy as reading_percentage,
                         NULL as grammar_score, NULL as grammar_correct, NULL as grammar_total, 
                         NULL as grammar_percentage,
                         writing_overall as writing_score, 
                         speaking_ielts as speaking_score, 
                         NULL as vocab_score,
                         NULL as pronoun_score,
                         NULL as pronoun_percentage,
                         NULL as pronoun_level,
                         DATE(submitted_at) as test_date
                  FROM ielts_b1_results WHERE 1=1";
        
        $ieltsB1Params = [];
        if ($dateFrom) {
            $ieltsB1Query .= " AND DATE(submitted_at) >= ?";
            $ieltsB1Params[] = $dateFrom;
        }
        if ($dateTo) {
            $ieltsB1Query .= " AND DATE(submitted_at) <= ?";
            $ieltsB1Params[] = $dateTo;
        }
        if ($testType === 'all' || $testType === 'ielts-b1') {
            $queries[] = $ieltsB1Query;
            $params = array_merge($params, $ieltsB1Params);
        }
        
        // Business Speaking Query - UPDATED
        $businessQuery = "SELECT 
                          'business' as test_type, 
                          id, 
                          CONVERT(name USING utf8mb4) COLLATE utf8mb4_unicode_ci as name, 
                          CONVERT(email USING utf8mb4) COLLATE utf8mb4_unicode_ci as email, 
                          NULL as phone,
                          CONVERT(CAST(overall_score AS CHAR) USING utf8mb4) COLLATE utf8mb4_unicode_ci as overall_score, 
                          CONVERT(CONCAT(CAST(overall_score AS CHAR), '/10') USING utf8mb4) COLLATE utf8mb4_unicode_ci as level, 
                          NULL as overall_band,
                          overall_percent as percentage,
                          NULL as listening_score, NULL as listening_correct, NULL as listening_total, 
                          NULL as listening_percentage,
                          NULL as reading_score, NULL as reading_correct, NULL as reading_total, 
                          NULL as reading_percentage,
                          NULL as grammar_score, NULL as grammar_correct, NULL as grammar_total, 
                          NULL as grammar_percentage,
                          NULL as writing_score, 
                          total_completed as speaking_score, 
                          NULL as vocab_score,
                          NULL as pronoun_score,
                          NULL as pronoun_percentage,
                          NULL as pronoun_level,
                          test_date
                   FROM business_speaking_results WHERE 1=1";
        
        $businessParams = [];
        if ($dateFrom) {
            $businessQuery .= " AND DATE(test_date) >= ?";
            $businessParams[] = $dateFrom;
        }
        if ($dateTo) {
            $businessQuery .= " AND DATE(test_date) <= ?";
            $businessParams[] = $dateTo;
        }
        if ($testType === 'all' || $testType === 'business') {
            $queries[] = $businessQuery;
            $params = array_merge($params, $businessParams);
        }
        
        // Execute combined query
        if (empty($queries)) {
            sendResponse([
                'status' => 'success',
                'count' => 0,
                'results' => []
            ]);
        }
        
        $finalQuery = implode(" UNION ALL ", $queries) . " ORDER BY test_date DESC, id DESC";
        
        $stmt = $pdo->prepare($finalQuery);
        $stmt->execute($params);
        $results = $stmt->fetchAll();
        
        // Clean up results
        foreach ($results as &$result) {
            // Format date
            if (!empty($result['test_date'])) {
                $result['test_date'] = date('Y-m-d', strtotime($result['test_date']));
            }
            
            // Convert null to empty string
            foreach ($result as $key => $value) {
                if ($value === null) {
                    $result[$key] = '';
                }
            }
        }
        
        sendResponse([
            'status' => 'success',
            'count' => count($results),
            'results' => $results,
            'timestamp' => date('c')
        ]);
        
    } catch (Exception $e) {
        error_log("Error in get_placement_results: " . $e->getMessage());
        sendResponse([
            'status' => 'error',
            'message' => 'Error fetching placement results: ' . $e->getMessage()
        ], 500);
    }
}

// Route: Test endpoint (jagoan)
if ($requestUri === '/api/jagoan' && $requestMethod === 'POST') {
    $data = getJsonInput();
    $name = $data['name'] ?? null;
    
    sendResponse([
        'status' => 'success',
        'message' => $name ? "Halo $name" : "Tidak ada nama dikirim"
    ]);
}

// 404 - Not Found
sendResponse([
    'status' => 'error',
    'message' => 'Endpoint not found',
    'requested_uri' => $requestUri,
    'method' => $requestMethod
], 404);