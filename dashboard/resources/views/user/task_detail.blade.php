<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Detail - Kampong Inggris Pare</title>

    <link rel="shortcut icon" href="{{ asset('') }}/assets/compiled/svg/fav.jpg" type="image">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/iconly.css">
</head>

<body>
    <script src="{{ asset('') }}/assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="{{ route('user.dashboard') }}">
                                <img src="{{ asset('') }}/assets/compiled/png/logo.png" alt="Logo" style="height: 60px; width: auto;">
                            </a>
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

                        <li class="sidebar-item active">
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

                        <li class="sidebar-item">
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
                            <h3>Task Detail</h3>
                            <p class="text-subtitle text-muted">Complete and submit your task.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('user.tasks') }}">My Tasks</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Task Detail</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Task Information -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">{{ $task->title }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p><strong>Mentor:</strong> {{ $task->mentor_name }}</p>
                                        <p><strong>Difficulty:</strong> 
                                            <span class="badge bg-{{ $task->difficulty_level == 'easy' ? 'success' : ($task->difficulty_level == 'medium' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($task->difficulty_level) }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}</p>
                                        <p><strong>Status:</strong> 
                                            <span class="badge bg-{{ $task->status == 'approved' ? 'success' : ($task->status == 'submitted' ? 'info' : ($task->status == 'revision_needed' ? 'danger' : 'warning')) }}">
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <hr>

                                <h5>Task Description</h5>
                                <p>{{ $task->description }}</p>

                                @if($task->material_title)
                                    <hr>
                                    <h5>Related Material</h5>
                                    <div class="alert alert-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-file-earmark-text"></i> {{ $task->material_title }}
                                            </div>
                                            @if($task->material_file)
                                                <a href="{{ route('learning.material.download', $task->material_id) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-download"></i> Download Material
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if($task->status == 'approved' || $task->status == 'revision_needed')
                                    <hr>
                                    <div class="alert alert-{{ $task->status == 'approved' ? 'success' : 'warning' }}">
                                        <h5><i class="bi bi-chat-left-text"></i> Mentor Feedback</h5>
                                        <p class="mb-0">{{ $task->feedback }}</p>
                                        @if($task->score)
                                            <hr>
                                            <h4 class="mb-0">Score: {{ $task->score }}/100</h4>
                                        @endif
                                    </div>
                                @endif

                                @if($task->status == 'submitted')
                                    <hr>
                                    <div class="alert alert-info">
                                        <i class="bi bi-clock-history"></i> Your submission is waiting for mentor review.
                                    </div>
                                    
                                    @if($task->submission_content)
                                        <div class="mb-3">
                                            <strong>Your Answer:</strong>
                                            <div class="p-3 bg-light border rounded mt-2">
                                                {{ $task->submission_content }}
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($task->submission_file)
                                        <div>
                                            <strong>Submitted File:</strong>
                                            <a href="{{ asset('storage/' . $task->submission_file) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="bi bi-download"></i> Download Your Submission
                                            </a>
                                        </div>
                                    @endif
                                @endif

                                @if(in_array($task->status, ['assigned', 'revision_needed']))
                                    <hr>
                                    <h5>Submit Your Work</h5>
                                    
                                    <form action="{{ route('user.task.submit', $task->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Submission Type</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="submission_type" id="typeText" value="text" checked>
                                                <label class="form-check-label" for="typeText">
                                                    Write Answer Directly
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="submission_type" id="typeFile" value="file">
                                                <label class="form-check-label" for="typeFile">
                                                    Upload File
                                                </label>
                                            </div>
                                        </div>

                                        <div id="textSubmission" class="mb-3">
                                            <label for="submission_content" class="form-label">Your Answer</label>
                                            <textarea class="form-control" id="submission_content" name="submission_content" rows="6" placeholder="Write your answer here...">{{ old('submission_content') }}</textarea>
                                        </div>

                                        <div id="fileSubmission" class="mb-3" style="display: none;">
                                            <label for="submission_file" class="form-label">Upload File (Max 10MB)</label>
                                            <input type="file" class="form-control" id="submission_file" name="submission_file">
                                            <small class="text-muted">Supported formats: PDF, DOC, DOCX, JPG, PNG, ZIP</small>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check-circle"></i> Submit Task
                                            </button>
                                            <a href="{{ route('user.tasks') }}" class="btn btn-secondary">
                                                <i class="bi bi-arrow-left"></i> Back to Tasks
                                            </a>
                                        </div>
                                    </form>
                                @else
                                    <hr>
                                    <a href="{{ route('user.tasks') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Back to Tasks
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Task Progress</h5>
                            </div>
                            <div class="card-body">
                                @if($task->status == 'assigned')
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle"></i> Not started yet
                                    </div>
                                @elseif($task->status == 'submitted')
                                    <div class="alert alert-info">
                                        <i class="bi bi-clock-history"></i> Under review
                                    </div>
                                @elseif($task->status == 'approved')
                                    <div class="alert alert-success">
                                        <i class="bi bi-check-circle"></i> Approved!
                                    </div>
                                @elseif($task->status == 'revision_needed')
                                    <div class="alert alert-danger">
                                        <i class="bi bi-arrow-repeat"></i> Needs revision
                                    </div>
                                @endif

                                <div class="progress mb-3" style="height: 20px;">
                                    @php
                                        $progressPercent = 0;
                                        if ($task->status == 'submitted') $progressPercent = 50;
                                        if ($task->status == 'approved') $progressPercent = 100;
                                        if ($task->status == 'revision_needed') $progressPercent = 25;
                                    @endphp
                                    <div class="progress-bar bg-{{ $task->status == 'approved' ? 'success' : 'primary' }}" role="progressbar" 
                                         style="width: {{ $progressPercent }}%;" aria-valuenow="{{ $progressPercent }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $progressPercent }}%
                                    </div>
                                </div>

                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Assigned
                                        <i class="bi bi-check-circle text-success"></i>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Submitted
                                        @if(in_array($task->status, ['submitted', 'approved', 'revision_needed']))
                                            <i class="bi bi-check-circle text-success"></i>
                                        @else
                                            <i class="bi bi-circle text-muted"></i>
                                        @endif
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Reviewed
                                        @if(in_array($task->status, ['approved', 'revision_needed']))
                                            <i class="bi bi-check-circle text-success"></i>
                                        @else
                                            <i class="bi bi-circle text-muted"></i>
                                        @endif
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Completed
                                        @if($task->status == 'approved')
                                            <i class="bi bi-check-circle text-success"></i>
                                        @else
                                            <i class="bi bi-circle text-muted"></i>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>

                        @if($task->status == 'approved' && $task->score)
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Your Score</h5>
                                </div>
                                <div class="card-body text-center">
                                    <h1 class="display-1 text-success mb-0">{{ $task->score }}</h1>
                                    <p class="text-muted">out of 100</p>
                                    
                                    @if($task->score >= 90)
                                        <div class="alert alert-success">
                                            <i class="bi bi-trophy"></i> Excellent!
                                        </div>
                                    @elseif($task->score >= 75)
                                        <div class="alert alert-info">
                                            <i class="bi bi-star"></i> Great job!
                                        </div>
                                    @elseif($task->score >= 60)
                                        <div class="alert alert-warning">
                                            <i class="bi bi-hand-thumbs-up"></i> Good work!
                                        </div>
                                    @else
                                        <div class="alert alert-secondary">
                                            <i class="bi bi-arrow-repeat"></i> Keep trying!
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h5>Need Help?</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">Contact your mentor if you have questions about this task.</p>
                                <a href="{{ route('talk.mentor') }}" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-chat-dots"></i> Message Mentor
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
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
    
    <script>
        // Toggle between text and file submission
        document.getElementById('typeText').addEventListener('change', function() {
            document.getElementById('textSubmission').style.display = 'block';
            document.getElementById('fileSubmission').style.display = 'none';
            document.getElementById('submission_content').required = true;
            document.getElementById('submission_file').required = false;
        });
        
        document.getElementById('typeFile').addEventListener('change', function() {
            document.getElementById('textSubmission').style.display = 'none';
            document.getElementById('fileSubmission').style.display = 'block';
            document.getElementById('submission_content').required = false;
            document.getElementById('submission_file').required = true;
        });
    </script>
</body>

</html>