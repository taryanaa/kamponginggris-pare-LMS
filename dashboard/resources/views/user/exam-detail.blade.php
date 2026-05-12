<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->exam_title }} - Kampong Inggris Pare</title>

    <link rel="shortcut icon" href="{{ asset('') }}/assets/compiled/svg/fav.jpg" type="image">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/app-dark.css">
    <style>
        .exam-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e5e7eb;
        }
        .exam-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        #start-exam-btn:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>
</head>

<body>
    <script src="{{ asset('') }}/assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="/dashboard-student"><img src="{{ asset('') }}/assets/compiled/png/logo.png" alt="Logo" style="height: 60px; width: auto;"></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                role="img" class="iconify iconify--system-uicons" width="20" height="20"
                                preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item">
                            <a href="/dashboard-student" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Overview</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/learning-student" class='sidebar-link'>
                                <i class="bi bi-book-fill"></i>
                                <span>Learning</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/tasks-student" class='sidebar-link'>
                                <i class="bi bi-journal-check"></i>
                                <span>Tasks</span>
                            </a>
                        </li>
                        <li class="sidebar-item active">
                            <a href="/exam-student" class='sidebar-link'>
                                <i class="bi bi-pencil-square"></i>
                                <span>Exam</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/report-student" class='sidebar-link'>
                                <i class="bi bi-graph-up"></i>
                                <span>Progress Report</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/talk-mentor" class='sidebar-link'>
                                <i class="bi bi-chat-dots-fill"></i>
                                <span>Talk Mentor</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/logout" class='sidebar-link'>
                                <i class="bi bi-door-open-fill"></i>
                                <span>Log out</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>{{ $exam->exam_title }}</h3>
                            <p class="text-subtitle text-muted">Exam Details and Instructions</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/dashboard-student">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="/exam-student">Exams</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $exam->exam_title }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <div class="card exam-card">
                                <div class="card-header">
                                    <h4 class="card-title">Exam Instructions</h4>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <h6><i class="bi bi-info-circle"></i> Important Instructions</h6>
                                        <ul class="mb-0">
                                            <li>This exam consists of <strong>{{ $exam->total_questions }} questions</strong></li>
                                            <li>You have <strong>{{ $exam->duration_minutes }} minutes</strong> to complete the exam</li>
                                            <li>Once started, you cannot pause or restart the exam</li>
                                            <li>Make sure you have a stable internet connection</li>
                                            <li>Do not refresh or close the browser during the exam</li>
                                            <li>The exam will auto-submit when time runs out</li>
                                        </ul>
                                    </div>
                                    
                                    <h6>Exam Details:</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Type:</strong> {{ $exam->exam_type }}</p>
                                            <p><strong>Category:</strong> {{ $exam->exam_category }}</p>
                                            <p><strong>Duration:</strong> {{ $exam->duration_minutes }} minutes</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Total Questions:</strong> {{ $exam->total_questions }}</p>
                                            <p><strong>Total Points:</strong> {{ $exam->total_points }}</p>
                                            <p><strong>Status:</strong> 
                                                <span class="badge bg-success">Published</span>
                                            </p>
                                        </div>
                                    </div>

                                    @if($exam->exam_type === 'Listening' || $exam->exam_type === 'listening')
                                    <div class="alert alert-warning mt-3">
                                        <h6><i class="bi bi-headphones"></i> Listening Section Note</h6>
                                        <p class="mb-0">This exam contains listening comprehension questions. Make sure your audio is working properly before starting.</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card exam-card">
                                <div class="card-header">
                                    <h4 class="card-title">Ready to Start?</h4>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-4">
                                        <i class="bi bi-clock-history display-4 text-primary"></i>
                                        <h5 class="mt-3">Time Limit: {{ $exam->duration_minutes }} minutes</h5>
                                    </div>
                                    
                                    <p class="text-muted">When you're ready, click the button below to begin the exam. The timer will start immediately.</p>
                                    
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary btn-lg" id="start-exam-btn">
                                            <i class="bi bi-play-circle"></i> Start Exam Now
                                        </button>
                                        <a href="{{ route('exam.student') }}" class="btn btn-outline-secondary">
                                            <i class="bi bi-arrow-left"></i> Back to Exams List
                                        </a>
                                    </div>

                                    <hr>
                                    
                                    <div class="alert alert-light">
                                        <h6><i class="bi bi-lightbulb"></i> Tips for Success:</h6>
                                        <ul class="small mb-0">
                                            <li>Read each question carefully</li>
                                            <li>Manage your time wisely</li>
                                            <li>Review your answers if time permits</li>
                                            <li>Stay calm and focused</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2025 @Kampong Inggris Pare</p>
                    </div>
                    <div class="float-end">
                        <p>Good luck with your exam!</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <script src="{{ asset('') }}/assets/static/js/components/dark.js"></script>
    <script src="{{ asset('') }}/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('') }}/assets/compiled/js/app.js"></script>
    <script src="{{ asset('') }}/assets/extensions/jquery/jquery.min.js"></script>
    
<script>
    $(document).ready(function() {
        console.log('Document ready - exam detail page loaded');
        
        // Theme toggle functionality
        const toggleDark = document.getElementById('toggle-dark');
        if (toggleDark) {
            const html = document.querySelector('html');
            
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                html.classList.add('dark');
                toggleDark.checked = true;
            } else {
                html.classList.remove('dark');
                toggleDark.checked = false;
            }
            
            toggleDark.addEventListener('change', function() {
                if (this.checked) {
                    html.classList.add('dark');
                    localStorage.theme = 'dark';
                } else {
                    html.classList.remove('dark');
                    localStorage.theme = 'light';
                }
            });
        }

        // Debug: Check if button exists
        const startButton = $('#start-exam-btn');
        console.log('Start button found:', startButton.length > 0);
        
        if (startButton.length === 0) {
            console.error('Start button not found!');
            return;
        }

        // Start exam button handler - PERBAIKAN URL YANG BENAR
        startButton.on('click', function() {
            console.log('Start exam button clicked');
            
            const button = $(this);
            const originalText = button.html();
            
            // Show loading state
            button.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Preparing Exam...');
            
            // PERBAIKAN UTAMA: Gunakan URL dengan prefix dashboard yang sesuai
            const examInterfaceUrl = "/dashboard/exam/{{ $exam->id }}/take";
            console.log('Exam interface URL:', examInterfaceUrl);
            console.log('Full URL will be:', window.location.origin + examInterfaceUrl);
            
            if (!examInterfaceUrl || examInterfaceUrl === '') {
                console.error('Exam interface URL not valid!');
                alert('Error: Exam URL not configured. Please contact administrator.');
                button.prop('disabled', false).html(originalText);
                return;
            }

            const confirmationMessage = 
                'Are you ready to start the exam?\n\n' +
                '⚠️ IMPORTANT:\n' +
                '• The timer will begin immediately\n' +
                '• You cannot pause or restart\n' +
                '• Do not refresh or close the browser\n' +
                '• Make sure you have stable internet connection\n\n' +
                'Click OK to continue or Cancel to go back.';

            if (confirm(confirmationMessage)) {
                console.log('User confirmed, redirecting to:', examInterfaceUrl);
                
                // Add a small delay to show loading state
                setTimeout(() => {
                    window.location.href = examInterfaceUrl;
                }, 500);
                
            } else {
                console.log('User cancelled exam start');
                // Reset button if user cancels
                setTimeout(() => {
                    button.prop('disabled', false).html(originalText);
                }, 300);
            }
        });

        // Add keyboard shortcut (Enter key to start exam)
        $(document).on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                console.log('Enter key pressed, triggering start exam');
                $('#start-exam-btn').click();
            }
        });

        // Debug: Log route information
        console.log('Current exam ID:', {{ $exam->id }});
        console.log('Correct URL should be:', '/dashboard/exam/{{ $exam->id }}/take');
        
        // Additional debugging info
        console.log('Current path:', window.location.pathname);
        console.log('Base URL:', window.location.origin);
    });
</script>
</body>
</html>