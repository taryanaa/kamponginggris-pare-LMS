<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Exam API</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        .test-section {
            background: #f5f5f5;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        button {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
        }
        button:hover {
            background: #45a049;
        }
        .result {
            background: white;
            padding: 15px;
            margin-top: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .success { color: green; }
        .error { color: red; }
        pre {
            background: #f9f9f9;
            padding: 10px;
            overflow-x: auto;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>🧪 Test Exam API</h1>
    <p>Halaman ini untuk testing API Exam Builder</p>

    <!-- Test 1: Check CSRF Token -->
    <div class="test-section">
        <h2>Test 1: CSRF Token</h2>
        <button onclick="testCSRF()">Check CSRF Token</button>
        <div id="csrf-result" class="result" style="display:none;"></div>
    </div>

    <!-- Test 2: Get Exams -->
    <div class="test-section">
        <h2>Test 2: GET /api/exams</h2>
        <button onclick="testGetExams()">Get All Exams</button>
        <div id="get-result" class="result" style="display:none;"></div>
    </div>

    <!-- Test 3: Create Simple Exam -->
    <div class="test-section">
        <h2>Test 3: POST /api/exams (Create Exam)</h2>
        <button onclick="testCreateExam()">Create Test Exam</button>
        <div id="create-result" class="result" style="display:none;"></div>
    </div>

    <!-- Test 4: Database Check -->
    <div class="test-section">
        <h2>Test 4: Database Direct Check</h2>
        <button onclick="testDatabase()">Check Database Tables</button>
        <div id="db-result" class="result" style="display:none;"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Setup CSRF for all AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function testCSRF() {
            const token = $('meta[name="csrf-token"]').attr('content');
            const result = $('#csrf-result');
            result.show();
            
            if (token && token.length > 0) {
                result.html(`
                    <p class="success">✅ CSRF Token Found!</p>
                    <pre>${token}</pre>
                `);
            } else {
                result.html(`
                    <p class="error">❌ CSRF Token NOT Found!</p>
                    <p>Check if meta tag exists in head.</p>
                `);
            }
        }

        function testGetExams() {
            const result = $('#get-result');
            result.html('<p>Loading...</p>').show();

            $.ajax({
                url: '/api/exams',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    result.html(`
                        <p class="success">✅ GET Request Success!</p>
                        <p>Found ${response.exams ? response.exams.length : 0} exams</p>
                        <pre>${JSON.stringify(response, null, 2)}</pre>
                    `);
                },
                error: function(xhr) {
                    result.html(`
                        <p class="error">❌ GET Request Failed!</p>
                        <p>Status: ${xhr.status} ${xhr.statusText}</p>
                        <pre>${xhr.responseText}</pre>
                    `);
                }
            });
        }

        function testCreateExam() {
            const result = $('#create-result');
            result.html('<p>Creating exam...</p>').show();

            const testData = {
                title: 'Test Exam ' + new Date().getTime(),
                type: 'TOEFL Preparation',
                category: 'Test Category',
                duration: 120,
                status: 'draft',
                questions: [
                    {
                        type: 'multiple-choice',
                        question: 'What is 2 + 2?',
                        points: 10,
                        skill: 'reading',
                        options: [
                            { text: '3', isCorrect: false },
                            { text: '4', isCorrect: true },
                            { text: '5', isCorrect: false }
                        ]
                    }
                ]
            };

            console.log('Sending data:', testData);

            $.ajax({
                url: '/api/exams',
                method: 'POST',
                data: JSON.stringify(testData),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    console.log('Success response:', response);
                    result.html(`
                        <p class="success">✅ POST Request Success!</p>
                        <p>Exam created with ID: ${response.exam_id}</p>
                        <pre>${JSON.stringify(response, null, 2)}</pre>
                    `);
                },
                error: function(xhr) {
                    console.error('Error response:', xhr);
                    result.html(`
                        <p class="error">❌ POST Request Failed!</p>
                        <p>Status: ${xhr.status} ${xhr.statusText}</p>
                        <pre>${xhr.responseText}</pre>
                    `);
                }
            });
        }

        function testDatabase() {
            const result = $('#db-result');
            result.html(`
                <p>⚠️ Database check harus dilakukan manual.</p>
                <p>Jalankan query berikut di phpMyAdmin atau MySQL client:</p>
                <pre>
-- Check tabel ada atau tidak
SHOW TABLES LIKE 'exam%';

-- Check struktur tabel exams
DESCRIBE exams;

-- Check struktur tabel exam_questions
DESCRIBE exam_questions;

-- Check struktur tabel exam_question_options
DESCRIBE exam_question_options;

-- Check data yang ada
SELECT COUNT(*) as total_exams FROM exams;
SELECT COUNT(*) as total_questions FROM exam_questions;
SELECT COUNT(*) as total_options FROM exam_question_options;

-- Check data terakhir
SELECT * FROM exams ORDER BY id DESC LIMIT 5;
                </pre>
            `).show();
        }

        // Auto test on page load
        $(document).ready(function() {
            console.log('Test page loaded');
            console.log('CSRF Token:', $('meta[name="csrf-token"]').attr('content'));
        });
    </script>
</body>
</html>