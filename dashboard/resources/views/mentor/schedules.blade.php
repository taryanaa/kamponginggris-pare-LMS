<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Schedule - Kampong Inggris Pare</title>

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

                        <li class="sidebar-item ">
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

                        <li class="sidebar-item active">
                            <a href="/dashboard/mentor/schedules" class='sidebar-link'>
                                <i class="bi bi-grid-1x2-fill"></i>
                                <span>Schedule</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
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
                            <h3>Input Schedule</h3>
                            <p class="text-subtitle text-muted">Create and manage mentor schedules.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/dashboard-mentor">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Input Schedule</li>
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
                                    <h4 class="card-title">Create New Schedule</h4>
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

                                        <form class="form form-horizontal" method="POST" action="{{ route('mentor.schedules.store') }}">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="student_id">Student</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="choices form-select" id="student_id" name="student_id" required>
                                                            <option value="">Select Student</option>
                                                            @foreach($students as $student)
                                                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                                                    {{ $student->name }} ({{ $student->email }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="lesson_type">Lesson Type</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" id="lesson_type" name="lesson_type" required>
                                                            <option value="">Select Lesson</option>
                                                            <option value="Speaking Practice" {{ old('lesson_type') == 'Speaking Practice' ? 'selected' : '' }}>Speaking Practice</option>
                                                            <option value="Reading Comprehension" {{ old('lesson_type') == 'Reading Comprehension' ? 'selected' : '' }}>Reading Comprehension</option>
                                                            <option value="Grammar Lesson" {{ old('lesson_type') == 'Grammar Lesson' ? 'selected' : '' }}>Grammar Lesson</option>
                                                            <option value="IELTS Preparation" {{ old('lesson_type') == 'IELTS Preparation' ? 'selected' : '' }}>IELTS Preparation</option>
                                                            <option value="TOEIC Preparation" {{ old('lesson_type') == 'TOEIC Preparation' ? 'selected' : '' }}>TOEIC Preparation</option>
                                                            <option value="TOEFL Preparation" {{ old('lesson_type') == 'TOEFL Preparation' ? 'selected' : '' }}>TOEFL Preparation</option>
                                                            <option value="Vocabulary Building" {{ old('lesson_type') == 'Vocabulary Building' ? 'selected' : '' }}>Vocabulary Building</option>
                                                            <option value="Writing Practice" {{ old('lesson_type') == 'Writing Practice' ? 'selected' : '' }}>Writing Practice</option>
                                                            <option value="Listening Practice" {{ old('lesson_type') == 'Listening Practice' ? 'selected' : '' }}>Listening Practice</option>
                                                            <option value="Pronunciation Practice" {{ old('lesson_type') == 'Pronunciation Practice' ? 'selected' : '' }}>Pronunciation Practice</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="schedule_date">Date</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="date" id="schedule_date" class="form-control" name="schedule_date" 
                                                               value="{{ old('schedule_date') }}" min="{{ date('Y-m-d') }}" required>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="schedule_time">Time</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="time" id="schedule_time" class="form-control" name="schedule_time" 
                                                               value="{{ old('schedule_time') }}" required>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="location">Location</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" id="location" name="location" required>
                                                            <option value="online" {{ old('location') == 'online' ? 'selected' : '' }}>Online</option>
                                                            <option value="offline" {{ old('location') == 'offline' ? 'selected' : '' }}>Offline</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="meeting_link">Meeting Link (for online sessions)</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="url" id="meeting_link" class="form-control" name="meeting_link" 
                                                               placeholder="https://zoom.us/j/..." value="{{ old('meeting_link') }}">
                                                        <small class="text-muted">Only required for online sessions</small>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label for="notes">Additional Notes</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                                                  placeholder="Any additional notes or instructions...">{{ old('notes') }}</textarea>
                                                    </div>

                                                    <div class="col-sm-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit Schedule</button>
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

                <!-- Schedule List Section -->
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Your Schedules</h4>
                            <p class="card-subtitle">Upcoming and recent schedules</p>
                        </div>
                        <div class="card-body">
                            @if($schedules->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Student</th>
                                                <th>Lesson Type</th>
                                                <th>Date & Time</th>
                                                <th>Location</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($schedules as $schedule)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar bg-light-primary me-2">
                                                                <div class="avatar-content">
                                                                    <i class="bi bi-person-fill"></i>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="fw-bold">{{ $schedule->student->name }}</div>
                                                                <small class="text-muted">{{ $schedule->student->email }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light-info">{{ $schedule->lesson_type }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-bold">{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('M d, Y') }}</div>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($schedule->schedule_time)->format('h:i A') }}</small>
                                                    </td>
                                                    <td>
                                                        @if($schedule->location == 'online')
                                                            <span class="badge bg-light-success">Online</span>
                                                        @else
                                                            <span class="badge bg-light-warning">Offline</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($schedule->status == 'scheduled')
                                                            @if(\Carbon\Carbon::parse($schedule->schedule_date . ' ' . $schedule->schedule_time)->isFuture())
                                                                <span class="badge bg-light-primary">Upcoming</span>
                                                            @else
                                                                <span class="badge bg-light-warning">Today</span>
                                                            @endif
                                                        @elseif($schedule->status == 'completed')
                                                            <span class="badge bg-light-success">Completed</span>
                                                        @else
                                                            <span class="badge bg-light-danger">Cancelled</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            @if($schedule->location == 'online' && $schedule->meeting_link)
                                                                <a href="{{ $schedule->meeting_link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                    <i class="bi bi-camera-video"></i> Join
                                                                </a>
                                                            @endif
                                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#scheduleModal{{ $schedule->id }}">
                                                                <i class="bi bi-eye"></i> View
                                                            </button>
                                                        </div>

                                                        <!-- Schedule Details Modal -->
                                                        <div class="modal fade" id="scheduleModal{{ $schedule->id }}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Schedule Details</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-12 mb-2">
                                                                                <strong>Student:</strong> {{ $schedule->student->name }}
                                                                            </div>
                                                                            <div class="col-12 mb-2">
                                                                                <strong>Lesson Type:</strong> {{ $schedule->lesson_type }}
                                                                            </div>
                                                                            <div class="col-12 mb-2">
                                                                                <strong>Date:</strong> {{ \Carbon\Carbon::parse($schedule->schedule_date)->format('F d, Y') }}
                                                                            </div>
                                                                            <div class="col-12 mb-2">
                                                                                <strong>Time:</strong> {{ \Carbon\Carbon::parse($schedule->schedule_time)->format('h:i A') }}
                                                                            </div>
                                                                            <div class="col-12 mb-2">
                                                                                <strong>Location:</strong> 
                                                                                <span class="badge bg-light-{{ $schedule->location == 'online' ? 'success' : 'warning' }}">
                                                                                    {{ ucfirst($schedule->location) }}
                                                                                </span>
                                                                            </div>
                                                                            @if($schedule->meeting_link)
                                                                                <div class="col-12 mb-2">
                                                                                    <strong>Meeting Link:</strong> 
                                                                                    <a href="{{ $schedule->meeting_link }}" target="_blank">{{ $schedule->meeting_link }}</a>
                                                                                </div>
                                                                            @endif
                                                                            @if($schedule->notes)
                                                                                <div class="col-12 mb-2">
                                                                                    <strong>Notes:</strong> {{ $schedule->notes }}
                                                                                </div>
                                                                            @endif
                                                                            <div class="col-12 mb-2">
                                                                                <strong>Status:</strong> 
                                                                                <span class="badge bg-light-{{ $schedule->status == 'scheduled' ? 'primary' : ($schedule->status == 'completed' ? 'success' : 'danger') }}">
                                                                                    {{ ucfirst($schedule->status) }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-calendar-x" style="font-size: 3rem; color: #6c757d;"></i>
                                    <p class="text-muted mt-2">No schedules created yet.</p>
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
        // Auto-set minimum date to today
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('schedule_date');
            if (!dateInput.value) {
                const today = new Date().toISOString().split('T')[0];
                dateInput.value = today;
            }

            // Show/hide meeting link field based on location
            const locationSelect = document.getElementById('location');
            const meetingLinkGroup = document.getElementById('meeting_link').closest('.form-group');

            function toggleMeetingLink() {
                if (locationSelect.value === 'online') {
                    meetingLinkGroup.style.display = 'block';
                } else {
                    meetingLinkGroup.style.display = 'none';
                }
            }

            locationSelect.addEventListener('change', toggleMeetingLink);
            toggleMeetingLink(); // Initial call
        });
    </script>
</body>

</html>