<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam: {{ $exam->exam_title }} - Kampong Inggris Pare</title>

    <link rel="shortcut icon" href="{{ asset('/') }}/assets/compiled/svg/fav.jpg" type="image">
    <link rel="stylesheet" href="{{ asset('/') }}/assets/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset('/') }}/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #435ebe;
            --primary-light: #eef2ff;
            --secondary: #3a0ca3;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --gray-light: #e2e8f0;
            --border-radius: 8px;
            --shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            background-color: #f2f7ff;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        #exam-main-screen {
            min-height: 100vh;
        }
        
        #exam-finish-screen {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            background: linear-gradient(135deg, #435ebe 0%, #3a0ca3 100%);
            padding: 20px;
        }
        
        .exam-header {
            position: sticky;
            top: 0;
            background: #fff;
            padding: 1rem 2rem;
            border-bottom: 1px solid #ddd;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .exam-title {
            font-weight: 600;
            color: var(--dark);
            font-size: 1.25rem;
            margin: 0;
        }
        
        .timer-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .timer-icon {
            color: var(--primary);
        }
        
        #exam-timer {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--danger);
            background: #fff3cd;
            padding: 5px 15px;
            border-radius: 5px;
            border: 1px solid #ffeaa7;
            transition: var(--transition);
        }
        
        #exam-timer.warning {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
            animation: pulse 1s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .container-fluid {
            display: flex;
            gap: 20px;
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .main-content {
            flex: 1;
        }
        
        .right-navigation {
            width: 320px;
        }
        
        .question-content {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        
        .question-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            background: var(--primary-light);
        }
        
        .question-title {
            font-weight: 600;
            color: var(--dark);
            font-size: 1.1rem;
            margin: 0;
        }
        
        .question-body {
            padding: 1.5rem;
        }
        
        .question-card {
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .question-text {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .options-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .option-item {
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .option-item:hover {
            background-color: #f8f9fa;
            border-color: var(--primary);
        }
        
        .option-item.selected {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .option-letter {
            width: 30px;
            height: 30px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            background: var(--gray-light);
            color: var(--dark);
        }
        
        .option-item.selected .option-letter {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }
        
        .question-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--secondary);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-danger {
            background: var(--danger);
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-success {
            background: var(--success);
            color: white;
        }
        
        .btn-success:hover {
            background: #218838;
        }
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .audio-controls {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .question-navigation {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .nav-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            background: var(--primary-light);
        }
        
        .nav-title {
            font-weight: 600;
            color: var(--dark);
            font-size: 1.1rem;
            margin: 0;
        }
        
        .nav-body {
            padding: 1.5rem;
            flex: 1;
            overflow-y: auto;
        }
        
        .question-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin-bottom: 1.5rem;
        }
        
        .question-nav-item {
            width: 100%;
            aspect-ratio: 1;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid #e5e7eb;
            background: white;
            color: var(--gray);
        }
        
        .question-nav-item:hover {
            background: var(--primary-light);
            border-color: var(--primary);
        }
        
        .question-nav-item.current {
            background-color: #c3e8ff;
            border-color: var(--primary);
            transform: scale(1.1);
        }
        
        .question-nav-item.answered {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .progress-container {
            margin-bottom: 1.5rem;
        }
        
        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: var(--gray);
        }
        
        .progress-bar {
            height: 8px;
            background: var(--gray-light);
            border-radius: 4px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: var(--primary);
            border-radius: 4px;
            transition: width 0.5s ease;
        }
        
        .status-summary {
            display: flex;
            justify-content: space-between;
            margin: 1.5rem 0;
            padding: 1rem;
            background: var(--primary-light);
            border-radius: 5px;
        }
        
        .status-item {
            text-align: center;
            flex: 1;
        }
        
        .status-count {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .status-label {
            font-size: 0.8rem;
            color: var(--gray);
        }
        
        .answered-count {
            color: var(--primary);
        }
        
        .unanswered-count {
            color: var(--danger);
        }
        
        .nav-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid #e5e7eb;
        }
        
        .warning-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        
        .warning-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            flex-direction: column;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .finish-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 2.5rem;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 90%;
        }
        
        .success-icon {
            font-size: 4rem;
            color: var(--success);
            margin-bottom: 1.5rem;
        }
        
        .result-summary {
            background: var(--primary-light);
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }
        
        .result-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        
        .result-label {
            font-weight: 600;
        }
        
        .result-value {
            font-weight: 700;
        }
        
        /* Responsive styles */
        @media (max-width: 1200px) {
            .container-fluid {
                flex-direction: column;
            }
            
            .right-navigation {
                width: 100%;
                order: -1;
            }
            
            .question-grid {
                grid-template-columns: repeat(8, 1fr);
            }
        }
        
        @media (max-width: 992px) {
            .question-grid {
                grid-template-columns: repeat(6, 1fr);
            }
            
            .exam-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
        
        @media (max-width: 768px) {
            .container-fluid {
                padding: 15px;
            }
            
            .question-grid {
                grid-template-columns: repeat(5, 1fr);
            }
            
            .question-footer {
                flex-direction: column;
                gap: 1rem;
            }
            
            .status-summary {
                flex-direction: column;
                gap: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .question-header, .question-body, .question-footer {
                padding: 1rem;
            }
            
            .option-item {
                padding: 10px 12px;
            }
            
            .question-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    </style>
</head>

<body>
    <!-- Loading Screen -->
    <div id="loading-screen" class="loading-screen">
        <div class="spinner"></div>
        <h4>Preparing Your Exam...</h4>
        <p>Please wait while we set up your testing environment</p>
    </div>

    <!-- Main Exam Screen -->
    <div id="exam-main-screen">
        <div class="exam-header">
            <h5 class="exam-title">{{ $exam->exam_title }}</h5>
            <div class="timer-container">
                <i class="fas fa-clock timer-icon"></i>
                <h5 class="mb-0" id="exam-timer">{{ $exam->duration_minutes }}:00</h5>
            </div>
        </div>
        
        <div class="container-fluid mt-4">
            <div class="main-content">
                <div class="question-content">
                    <div class="question-header">
                        <h5 id="question-title">Question 1 of {{ count($questions) }}</h5>
                    </div>
                    <div class="question-body" id="question-body">
                        <!-- Questions will be loaded here -->
                    </div>
                    <div class="question-footer">
                        <button class="btn btn-secondary" id="prev-btn" disabled>
                            <i class="fas fa-arrow-left"></i> Previous
                        </button>
                        <button class="btn btn-primary" id="next-btn">
                            Next <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Right Side Navigation -->
            <div class="right-navigation">
                <div class="question-navigation">
                    <div class="nav-header">
                        <h5 class="nav-title">Question Navigation</h5>
                    </div>
                    <div class="nav-body">
                        <div class="progress-container">
                            <div class="progress-label">
                                <span>Progress</span>
                                <span id="progress-text">0/{{ count($questions) }}</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" id="progress-fill" style="width: 0%"></div>
                            </div>
                        </div>
                        
                        <div class="question-grid" id="question-nav-container">
                            <!-- Navigation items will be generated here -->
                        </div>
                        
                        <div class="status-summary">
                            <div class="status-item">
                                <div class="status-count answered-count" id="answered-count">0</div>
                                <div class="status-label">Answered</div>
                            </div>
                            <div class="status-item">
                                <div class="status-count unanswered-count" id="unanswered-count">0</div>
                                <div class="status-label">Unanswered</div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-footer">
                        <button class="btn btn-danger w-100" id="finish-exam-btn">
                            <i class="fas fa-paper-plane"></i> Finish Exam
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Finish Screen -->
    <div id="exam-finish-screen" style="display: none;">
        <div class="finish-card text-center">
            <i class="fas fa-check-circle success-icon"></i>
            <h3 class="mt-3">Exam Submitted Successfully!</h3>
            <p>Your answers have been saved and submitted.</p>
            
            <div class="result-summary">
                <div class="result-item">
                    <span class="result-label">Total Questions:</span>
                    <span class="result-value" id="result-total">0</span>
                </div>
                <div class="result-item">
                    <span class="result-label">Answered:</span>
                    <span class="result-value text-success" id="result-answered">0</span>
                </div>
                <div class="result-item">
                    <span class="result-label">Unanswered:</span>
                    <span class="result-value text-danger" id="result-unanswered">0</span>
                </div>
                <div class="result-item">
                    <span class="result-label">Time Taken:</span>
                    <span class="result-value" id="result-time">00:00</span>
                </div>
            </div>
            
            <div class="mt-4">
                <div class="spinner" id="submitting-spinner"></div>
                <p id="submitting-text">Submitting your results...</p>
            </div>
            
            <div class="mt-4 d-flex gap-2 justify-content-center">
                <button class="btn btn-primary" id="view-results-btn" style="display: none;">
                    <i class="fas fa-chart-bar me-2"></i>View Results
                </button>
                <button class="btn btn-success" onclick="window.location.href='{{ route('user.dashboard') }}'">
                    <i class="fas fa-home me-2"></i>Back to Home
                </button>
            </div>
        </div>
    </div>
    
    <!-- Warning Modal -->
    <div id="warning-modal" class="warning-modal" style="display: none;">
        <div class="warning-content">
            <h4 class="text-danger">⚠️ Warning!</h4>
            <p>This action is not allowed during the exam. Please focus on your test.</p>
            <button class="btn btn-primary mt-3" id="close-warning">I Understand</button>
        </div>
    </div>

    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            const totalQuestions = {{ count($questions) }};
            const examDurationMinutes = {{ $exam->duration_minutes }};
            let currentQuestionIndex = 0;
            let answers = new Array(totalQuestions).fill(null);
            let timerInterval;
            let examStarted = false;
            let fullScreenEnabled = false;
            let startTime = new Date();
            let endTime;

            // Initialize exam immediately
            setTimeout(initializeExam, 1000);

            function initializeExam() {
                $('#loading-screen').hide();
                $('#exam-main-screen').show();
                examStarted = true;
                
                // Start security measures
                lockScreen();
                startTimer();
                generateNavigation();
                loadQuestion(0);
                updateProgress();
            }

            // --- SECURITY FUNCTIONS ---
            function enterFullScreen(element) {
                if (element.requestFullscreen) {
                    element.requestFullscreen().then(() => {
                        fullScreenEnabled = true;
                    }).catch(err => {
                        console.error('Error attempting to enable fullscreen:', err);
                    });
                } else if (element.webkitRequestFullscreen) {
                    element.webkitRequestFullscreen();
                    fullScreenEnabled = true;
                } else if (element.msRequestFullscreen) {
                    element.msRequestFullscreen();
                    fullScreenEnabled = true;
                }
            }

            function lockScreen() {
                enterFullScreen(document.documentElement);
                
                // Prevent leaving the page
                $(window).on('beforeunload', function(e) {
                    if (examStarted) {
                        e.preventDefault();
                        e.returnValue = 'Are you sure you want to leave? Your progress will be lost.';
                        return e.returnValue;
                    }
                });
                
                // Disable right-click
                $(document).on('contextmenu', function(e) { 
                    e.preventDefault();
                    showWarning();
                });
                
                // Disable copy, cut, paste
                $(document).on('copy cut paste', function(e) { 
                    e.preventDefault();
                    showWarning();
                });
                
                // Disable text selection
                $(document).on('selectstart dragstart', function(e) { 
                    e.preventDefault();
                    return false;
                });
                
                // Disable keyboard shortcuts
                $(document).on('keydown', function(e) {
                    // Block ESC (key code 27)
                    if (e.key === 'Escape' || e.keyCode === 27) {
                        e.preventDefault();
                        showWarning();
                        return false;
                    }
                    
                    // Block F11 (key code 122)
                    if (e.key === 'F11' || e.keyCode === 122) {
                        e.preventDefault();
                        showWarning();
                        return false;
                    }
                    
                    // Block F12 (key code 123)
                    if (e.key === 'F12' || e.keyCode === 123) {
                        e.preventDefault();
                        showWarning();
                        return false;
                    }
                    
                    // Block developer tools shortcuts
                    if (e.ctrlKey && e.shiftKey && e.keyCode === 73) { // Ctrl+Shift+I
                        e.preventDefault();
                        showWarning();
                        return false;
                    }
                    
                    if (e.ctrlKey && e.shiftKey && e.keyCode === 74) { // Ctrl+Shift+J
                        e.preventDefault();
                        showWarning();
                        return false;
                    }
                    
                    if (e.ctrlKey && e.keyCode === 85) { // Ctrl+U
                        e.preventDefault();
                        showWarning();
                        return false;
                    }
                });
                
                // Detect tab switching
                document.addEventListener('visibilitychange', function() {
                    if (document.hidden && examStarted) {
                        showWarning();
                    }
                });
                
                // Prevent leaving fullscreen
                document.addEventListener('fullscreenchange', function() {
                    if (!document.fullscreenElement && examStarted) {
                        enterFullScreen(document.documentElement);
                        showWarning();
                    }
                });
            }

            function unlockScreen() {
                $(window).off('beforeunload');
                $(document).off('contextmenu copy cut paste selectstart dragstart keydown');
                document.removeEventListener('visibilitychange', null);
                document.removeEventListener('fullscreenchange', null);
                
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }

            function showWarning() {
                $('#warning-modal').fadeIn();
            }

            $('#close-warning').on('click', function() {
                $('#warning-modal').fadeOut();
                if (!document.fullscreenElement && examStarted) {
                    enterFullScreen(document.documentElement);
                }
            });

            // --- TIMER FUNCTIONS ---
            function startTimer() {
                let time = examDurationMinutes * 60;
                timerInterval = setInterval(() => {
                    time--;
                    let minutes = Math.floor(time / 60);
                    let seconds = time % 60;
                    $('#exam-timer').text(`${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`);
                    
                    // Change color when time is running out
                    if (time <= 300) { // 5 minutes left
                        $('#exam-timer').addClass('warning');
                    }
                    
                    if (time <= 0) {
                        finishExam(true); // Auto-submit
                    }
                }, 1000);
            }

            // --- NAVIGATION FUNCTIONS ---
            function generateNavigation() {
                const container = $('#question-nav-container');
                for (let i = 0; i < totalQuestions; i++) {
                    container.append(`<button class="question-nav-item" data-index="${i}">${i + 1}</button>`);
                }
            }

            function updateNavigation() {
                $('.question-nav-item').each(function() {
                    const index = $(this).data('index');
                    $(this).removeClass('current answered');
                    
                    if (index === currentQuestionIndex) {
                        $(this).addClass('current');
                    }
                    
                    if (answers[index] !== null) {
                        $(this).addClass('answered');
                    }
                });
            }

            function updateProgress() {
                const answeredCount = answers.filter(a => a !== null).length;
                const progressPercent = (answeredCount / totalQuestions) * 100;
                
                $('#progress-text').text(`${answeredCount}/${totalQuestions}`);
                $('#progress-fill').css('width', `${progressPercent}%`);
                
                // Update status counts
                $('#answered-count').text(answeredCount);
                $('#unanswered-count').text(totalQuestions - answeredCount);
            }

            // --- EXAM LOGIC ---
            function loadQuestion(index) {
                const question = questions[index];
                $('#question-title').text(`Question ${index + 1} of ${totalQuestions}`);

                let questionHtml = `<div class="question-card" data-question-id="${question.id}">
                    <div class="question-text">${question.question_text}</div>`;
                
                // Add audio if available
                if (question.question_type === 'listening' && question.audio_file) {
                    questionHtml += `<div class="audio-controls">
                        <audio controls class="w-100">
                            <source src="{{ asset('storage/audio/') }}/${question.audio_file}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>`;
                }
                
                // Add options
                questionHtml += `<div class="options-container">`;
                
                question.options.forEach((option, i) => {
                    const isSelected = answers[index] == option.id;
                    questionHtml += `<div class="option-item ${isSelected ? 'selected' : ''}" 
                        data-option-id="${option.id}">
                        <div class="option-letter">${String.fromCharCode(65 + i)}</div>
                        <div class="option-text">${option.option_text}</div>
                    </div>`;
                });
                
                questionHtml += `</div></div>`;
                
                $('#question-body').html(questionHtml);

                // Update navigation buttons
                $('#prev-btn').prop('disabled', index === 0);
                $('#next-btn').html(index === totalQuestions - 1 ? 
                    'Finish Exam <i class="fas fa-paper-plane"></i>' : 
                    'Next <i class="fas fa-arrow-right"></i>');

                // Update navigation UI
                updateNavigation();
            }

            function finishExam(isAutoSubmit = false) {
                // Clear timer
                clearInterval(timerInterval);
                endTime = new Date();
                
                // Show finish screen immediately
                $('#exam-main-screen').hide();
                $('#exam-finish-screen').show();
                
                // Update result summary
                const answeredCount = answers.filter(a => a !== null).length;
                $('#result-total').text(totalQuestions);
                $('#result-answered').text(answeredCount);
                $('#result-unanswered').text(totalQuestions - answeredCount);
                
                // Calculate time taken
                const timeDiff = endTime - startTime;
                const minutes = Math.floor(timeDiff / 60000);
                const seconds = Math.floor((timeDiff % 60000) / 1000);
                $('#result-time').text(`${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`);
                
                // Submit exam results
                submitExamResults(isAutoSubmit);
            }

            function submitExamResults(isAutoSubmit) {
                // Show submitting state
                $('#submitting-text').text('Submitting your results...');
                
                // Collect all answers
                const answerData = [];
                questions.forEach((question, index) => {
                    if (answers[index] !== null) {
                        answerData.push({
                            question_id: question.id,
                            selected_option_id: answers[index]
                        });
                    }
                });

                // Submit to server
                $.ajax({
                    url: "{{ route('api.exam.sessions.finish', ['sessionId' => $activeSession->id]) }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        answers: answerData,
                        auto_submit: isAutoSubmit
                    },
                    success: function(response) {
                        $('#submitting-text').html(`
                            <strong class="text-success">✓ Results Submitted Successfully!</strong>
                            ${response.score ? `<div class="mt-3"><h5>Your Score: ${response.score}%</h5></div>` : ''}
                        `);
                        $('#submitting-spinner').hide();
                        
                        // Show view results button if available
                        if (response.results_url) {
                            $('#view-results-btn').show().attr('onclick', `window.location.href='${response.results_url}'`);
                        }
                        
                        // Unlock screen but don't redirect automatically
                        unlockScreen();
                    },
                    error: function(xhr) {
                        console.error('Failed to submit exam:', xhr.responseText);
                        $('#submitting-text').html(`
                            <strong class="text-danger">❌ Error submitting results</strong>
                            <p class="mt-2">Please contact administrator</p>
                        `);
                        $('#submitting-spinner').hide();
                        
                        // Unlock screen even on error
                        unlockScreen();
                    }
                });
            }

            // Submit individual answer function
            function submitAnswer(questionId, optionId) {
                $.ajax({
                    url: "{{ route('api.exam.answers.submit') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        session_id: "{{ $activeSession->id }}",
                        question_id: questionId,
                        selected_option_id: optionId
                    },
                    success: function(response) {
                        console.log('Answer submitted successfully');
                    },
                    error: function(xhr) {
                        console.error('Failed to submit answer:', xhr.responseText);
                    }
                });
            }

            // --- EVENT LISTENERS ---
            $('#next-btn').on('click', function() {
                if (currentQuestionIndex < totalQuestions - 1) {
                    currentQuestionIndex++;
                    loadQuestion(currentQuestionIndex);
                } else {
                    finishExam(false);
                }
            });

            $('#prev-btn').on('click', function() {
                if (currentQuestionIndex > 0) {
                    currentQuestionIndex--;
                    loadQuestion(currentQuestionIndex);
                }
            });

            $('#question-nav-container').on('click', '.question-nav-item', function() {
                currentQuestionIndex = parseInt($(this).data('index'));
                loadQuestion(currentQuestionIndex);
            });

            // Handle option selection
            $(document).on('click', '.option-item', function() {
                const questionCard = $(this).closest('.question-card');
                const questionId = questionCard.data('question-id');
                const optionId = $(this).data('option-id');
                
                // Remove selected class from all options in this question
                questionCard.find('.option-item').removeClass('selected');
                // Add selected class to clicked option
                $(this).addClass('selected');
                
                // Update answers array
                answers[currentQuestionIndex] = optionId;
                
                // Update navigation and progress
                updateNavigation();
                updateProgress();
                
                // Submit answer via AJAX
                submitAnswer(questionId, optionId);
            });

            $('#finish-exam-btn').on('click', function() {
                const unanswered = answers.filter(a => a === null).length;
                if (unanswered > 0) {
                    if (!confirm(`You have ${unanswered} unanswered questions. Are you sure you want to finish?`)) {
                        return;
                    }
                } else {
                    if (!confirm('Are you sure you want to finish and submit your answers?')) {
                        return;
                    }
                }
                finishExam(false);
            });
            
            // Questions data from backend
            const questions = @json($questions);
        });
    </script>
</body>

</html>