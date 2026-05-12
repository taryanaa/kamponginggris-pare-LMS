<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Exams - Kampong Inggris Pare</title>

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
        .exam-badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }
        .toefl-badge { background: #fff8e1; color: #ff8f00; }
        .ielts-badge { background: #e8f5e9; color: #388e3c; }
        .toeic-badge { background: #e3f2fd; color: #1976d2; }
        .basic-badge { background: #e0f2f1; color: #00796b; }
        .academic-badge { background: #fce4ec; color: #c2185b; }
        .business-badge { background: #f3e5f5; color: #7b1fa2; }
        .practical-badge { background: #fff3e0; color: #f57c00; }
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
                            <a href="{{ route('user.dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Overview</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="https://kamponginggrispare.com/page2.html" class='sidebar-link' target="_blank">
                                <i class="bi bi-clipboard-check-fill"></i>
                                <span>Placement Test</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('learning.index') }}" class='sidebar-link'>
                                <i class="bi bi-book-fill"></i>
                                <span>Learning</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('user.tasks') }}" class='sidebar-link'>
                                <i class="bi bi-journal-check"></i>
                                <span>My Tasks</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('talk.mentor') }}" class='sidebar-link'>
                                <i class="bi bi-chat-dots-fill"></i>
                                <span>Mentor Talk</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('progress.report') }}" class='sidebar-link'>
                                <i class="bi bi-graph-up"></i>
                                <span>Progress Report</span>
                            </a>
                        </li>

                        <li class="sidebar-item active">
                            <a href="{{ route('exam.student') }}" class='sidebar-link'>
                                <i class="bi bi-link"></i>
                                <span>Exam</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('profile.edit') }}" class='sidebar-link'>
                                <i class="bi bi-pen-fill"></i>
                                <span>Update Profile</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('logout') }}" class='sidebar-link'>
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
                            <h3>Available Exams</h3>
                            <p class="text-subtitle text-muted">Choose an exam to test your English proficiency.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/dashboard-student">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Exams</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="row" id="exams-container">
                        @if($exams->count() > 0)
                            @foreach($exams as $exam)
                                @php
                                    $badgeClass = 'toefl-badge';
                                    switch($exam->exam_type) {
                                        case 'IELTS A2':
                                        case 'IELTS B1':
                                            $badgeClass = 'ielts-badge';
                                            break;
                                        case 'TOEIC':
                                            $badgeClass = 'toeic-badge';
                                            break;
                                        case 'Basic English':
                                            $badgeClass = 'basic-badge';
                                            break;
                                        case 'Academic English':
                                            $badgeClass = 'academic-badge';
                                            break;
                                        case 'Business Speaking':
                                            $badgeClass = 'business-badge';
                                            break;
                                        case 'Practical English':
                                            $badgeClass = 'practical-badge';
                                            break;
                                    }
                                @endphp
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="card exam-card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ $exam->exam_title }}</h4>
                                            <span class="badge {{ $badgeClass }} exam-badge">{{ $exam->exam_type }}</span>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text">{{ $exam->exam_category }}</p>
                                            <div class="exam-info">
                                                <div class="d-flex justify-content-between text-muted mb-2">
                                                    <span><i class="bi bi-question-circle"></i> Questions</span>
                                                    <span>{{ $exam->total_questions }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between text-muted mb-2">
                                                    <span><i class="bi bi-clock"></i> Duration</span>
                                                    <span>{{ $exam->duration_minutes }} mins</span>
                                                </div>
                                                <div class="d-flex justify-content-between text-muted mb-3">
                                                    <span><i class="bi bi-star"></i> Points</span>
                                                    <span>{{ $exam->total_points }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{ route('exam.student.show', $exam->id) }}" class="btn btn-primary w-100">
                                                <i class="bi bi-play-circle"></i> Start Exam
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body text-center py-5">
                                        <i class="bi bi-inbox display-4 text-muted"></i>
                                        <h5 class="mt-3">No Exams Available</h5>
                                        <p class="text-muted">There are no exams available at the moment. Please check back later.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2025 @Kampong Inggris Pare</p>
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
            // Theme toggle functionality
            const toggleDark = document.getElementById('toggle-dark');
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
        });
    </script>
</body>
</html>