<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Task - Kampong Inggris Pare</title>

    <link rel="shortcut icon" href="{{ asset('') }}/assets/compiled/svg/fav.jpg" type="image">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/extensions/choices.js/public/assets/styles/choices.css">
</head>

<body>
    <script src="{{ asset('') }}/assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="/dashboard-mentor"><img src="{{ asset('') }}/assets/compiled/png/logo.png" alt="Logo" style="height: 60px; width: auto;" srcset=""></a>
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
                            <a href="/dashboard/mentor" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Overview</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="/dashboard/mentor/progress" class='sidebar-link'>
                                <i class="bi bi-graph-up"></i>
                                <span>Progress Report</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="/dashboard/mentor/schedules" class='sidebar-link'>
                                <i class="bi bi-grid-1x2-fill"></i>
                                <span>Schedule</span>
                            </a>
                        </li>

                        <li class="sidebar-item active">
                            <a href="/dashboard/mentor/tasks" class='sidebar-link'>
                                <i class="bi bi-journal-check"></i>
                                <span>Input Task</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="/dashboard/mentor/materials" class='sidebar-link'>
                                <i class="bi bi-book-fill"></i>
                                <span>Material</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/dashboard/profile" class='sidebar-link'>
                                <i class="bi bi-pen-fill"></i>
                                <span>Update Profile</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="/dashboard/logout" class='sidebar-link'>
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
                            <h3>Input Task</h3>
                            <p class="text-subtitle text-muted">Create and assign tasks to students.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/dashboard-mentor">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Input Task</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Basic Horizontal form layout section start -->
                <section id="basic-horizontal-layouts">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Create New Task</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        @if(session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif

                                        @if($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <ul class="mb-0">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif

                                        <form class="form form-horizontal" method="POST" action="{{ route('mentor.tasks.store') }}">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="title">Task Title</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="title" class="form-control" name="title" 
                                                               placeholder="e.g., Reading Comprehension Exercise" value="{{ old('title') }}" required>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="description">Task Description</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <textarea class="form-control" id="description" name="description" rows="4" 
                                                                  placeholder="Provide detailed instructions for the task..." required>{{ old('description') }}</textarea>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="material_id">Related Material (Optional)</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="choices form-select" id="material_id" name="material_id">
                                                            <option value="">Select Material (Optional)</option>
                                                            @foreach($materials as $material)
                                                                <option value="{{ $material->id }}" {{ old('material_id') == $material->id ? 'selected' : '' }}>
                                                                    {{ $material->title }} ({{ $material->level }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="difficulty_level">Difficulty Level</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" id="difficulty_level" name="difficulty_level" required>
                                                            <option value="">Select Difficulty</option>
                                                            <option value="easy" {{ old('difficulty_level') == 'easy' ? 'selected' : '' }}>Easy</option>
                                                            <option value="medium" {{ old('difficulty_level') == 'medium' ? 'selected' : '' }}>Medium</option>
                                                            <option value="hard" {{ old('difficulty_level') == 'hard' ? 'selected' : '' }}>Hard</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="deadline">Deadline</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="date" id="deadline" class="form-control" name="deadline" 
                                                               value="{{ old('deadline') }}" min="{{ date('Y-m-d') }}" required>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="student_ids">Assign to Students</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="choices form-select" id="student_ids" name="student_ids[]" multiple required>
                                                            @foreach($students as $student)
                                                                <option value="{{ $student->id }}" {{ in_array($student->id, old('student_ids', [])) ? 'selected' : '' }}>
                                                                    {{ $student->name }} ({{ $student->email }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="text-muted">Hold Ctrl/Cmd to select multiple students</small>
                                                    </div>

                                                    <div class="col-sm-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary me-1 mb-1">Assign Task</button>
                                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic Horizontal form layout section end -->

                <!-- Pending Submissions Section -->
                @if($pendingSubmissions->count() > 0)
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Pending Submissions</h4>
                            <p class="card-subtitle">Tasks waiting for your review</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Student</th>
                                            <th>Task</th>
                                            <th>Submitted At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingSubmissions as $submission)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-light-primary me-2">
                                                            <div class="avatar-content">
                                                                <i class="bi bi-person-fill"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $submission->student->name }}</div>
                                                            <small class="text-muted">{{ $submission->student->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fw-bold">{{ $submission->task->title }}</div>
                                                    <small class="text-muted">
                                                        <span class="badge bg-light-{{ $submission->task->difficulty_level == 'easy' ? 'success' : ($submission->task->difficulty_level == 'medium' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($submission->task->difficulty_level) }}
                                                        </span>
                                                    </small>
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($submission->submitted_at)->format('M d, Y h:i A') }}
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                                            data-bs-toggle="modal" data-bs-target="#reviewModal{{ $submission->id }}">
                                                        <i class="bi bi-eye"></i> Review
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Review Modal -->
                                            <div class="modal fade" id="reviewModal{{ $submission->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Review Submission</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="POST" action="{{ route('mentor.tasks.review', $submission->id) }}">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-12 mb-3">
                                                                        <strong>Student:</strong> {{ $submission->student->name }}
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <strong>Task:</strong> {{ $submission->task->title }}
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <strong>Description:</strong> {{ $submission->task->description }}
                                                                    </div>
                                                                    @if($submission->submission_content)
                                                                    <div class="col-12 mb-3">
                                                                        <strong>Submission Content:</strong>
                                                                        <div class="border p-3 mt-1 bg-light">
                                                                            {{ $submission->submission_content }}
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    @if($submission->submission_file)
                                                                    <div class="col-12 mb-3">
                                                                        <strong>Submitted File:</strong>
                                                                        <a href="{{ asset('storage/' . $submission->submission_file) }}" 
                                                                           target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                                            <i class="bi bi-download"></i> Download File
                                                                        </a>
                                                                    </div>
                                                                    @endif
                                                                    <div class="col-12 mb-3">
                                                                        <label for="score{{ $submission->id }}" class="form-label">Score (0-100)</label>
                                                                        <input type="number" class="form-control" id="score{{ $submission->id }}" 
                                                                               name="score" min="0" max="100" placeholder="Enter score">
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <label for="feedback{{ $submission->id }}" class="form-label">Feedback</label>
                                                                        <textarea class="form-control" id="feedback{{ $submission->id }}" 
                                                                                  name="feedback" rows="4" placeholder="Provide constructive feedback..." required></textarea>
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <label for="status{{ $submission->id }}" class="form-label">Status</label>
                                                                        <select class="form-select" id="status{{ $submission->id }}" name="status" required>
                                                                            <option value="approved">Approved</option>
                                                                            <option value="revision_needed">Revision Needed</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Submit Review</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
                @endif

                <!-- Task List Section -->
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Your Tasks</h4>
                            <p class="card-subtitle">All tasks you have created</p>
                        </div>
                        <div class="card-body">
                            @if($tasks->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Task Title</th>
                                                <th>Difficulty</th>
                                                <th>Deadline</th>
                                                <th>Assigned To</th>
                                                <th>Submissions</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tasks as $task)
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold">{{ $task->title }}</div>
                                                        <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light-{{ $task->difficulty_level == 'easy' ? 'success' : ($task->difficulty_level == 'medium' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($task->difficulty_level) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-bold {{ \Carbon\Carbon::parse($task->deadline)->isPast() ? 'text-danger' : '' }}">
                                                            {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}
                                                        </div>
                                                        @if($task->material)
                                                            <small class="text-muted">Material: {{ $task->material->title }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="avatar-group">
                                                            @foreach($task->assignments->take(3) as $assignment)
                                                                <div class="avatar bg-light-primary" data-bs-toggle="tooltip" 
                                                                     title="{{ $assignment->student->name }}">
                                                                    <div class="avatar-content">
                                                                        <i class="bi bi-person-fill"></i>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            @if($task->assignments->count() > 3)
                                                                <div class="avatar bg-light-secondary">
                                                                    <div class="avatar-content">
                                                                        +{{ $task->assignments->count() - 3 }}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <small class="text-muted">{{ $task->assignments->count() }} students</small>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $submitted = $task->assignments->where('status', 'submitted')->count();
                                                            $total = $task->assignments->count();
                                                        @endphp
                                                        <div class="progress mb-1" style="height: 8px;">
                                                            <div class="progress-bar bg-{{ $submitted == $total ? 'success' : ($submitted > 0 ? 'warning' : 'secondary') }}" 
                                                                 style="width: {{ $total > 0 ? ($submitted / $total * 100) : 0 }}%"></div>
                                                        </div>
                                                        <small>{{ $submitted }}/{{ $total }} submitted</small>
                                                    </td>
                                                    <td>
                                                        @if(\Carbon\Carbon::parse($task->deadline)->isPast())
                                                            <span class="badge bg-light-danger">Expired</span>
                                                        @elseif($submitted == $total)
                                                            <span class="badge bg-light-success">All Submitted</span>
                                                        @elseif($submitted > 0)
                                                            <span class="badge bg-light-warning">In Progress</span>
                                                        @else
                                                            <span class="badge bg-light-secondary">Not Started</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-journal-x" style="font-size: 3rem; color: #6c757d;"></i>
                                    <p class="text-muted mt-2">No tasks created yet.</p>
                                </div>
                            @endif
                        </div>
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
    <script src="{{ asset('') }}/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script src="{{ asset('') }}/assets/static/js/pages/form-element-select.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-set minimum date to today
            const deadlineInput = document.getElementById('deadline');
            if (!deadlineInput.value) {
                const today = new Date().toISOString().split('T')[0];
                deadlineInput.value = today;
            }

            // Initialize Choices.js for student selection
            const studentSelect = new Choices('#student_ids', {
                removeItemButton: true,
                searchEnabled: true,
                placeholder: true,
                placeholderValue: 'Select students...',
                noResultsText: 'No students found',
                noChoicesText: 'No students to choose from'
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>

</html>