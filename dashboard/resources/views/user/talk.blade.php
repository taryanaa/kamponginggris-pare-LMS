<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talk With Mentor - Kampong Inggris Pare</title>

    <link rel="shortcut icon" href="{{ asset("") }}/assets/compiled/svg/fav.jpg" type="image">
    <link rel="stylesheet" href="{{ asset("") }}/assets/compiled/css/ui-widgets-chatbox.css">
    <link rel="stylesheet" href="{{ asset("") }}/assets/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset("") }}/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="{{ asset("") }}/assets/compiled/css/iconly.css">
</head>

<body>
    <script src="{{ asset("") }}/assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="{{ route('user.dashboard') }}">
                                <img src="{{ asset("") }}/assets/compiled/png/logo.png" alt="Logo" style="height: 60px; width: auto;">
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

                        <li class="sidebar-item ">
                            <a href="{{ route('user.tasks') }}" class='sidebar-link'>
                                <i class="bi bi-journal-check"></i>
                                <span>My Tasks</span>
                            </a>
                        </li>

                        <li class="sidebar-item active">
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
                            <h3>Chat with Mentor</h3>
                            <p class="text-subtitle text-muted">Connect with your mentor for guidance.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Mentor Talk</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- My Course Info -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">My Course: Intensive English Program</h5>
                        <p class="text-muted">A comprehensive program designed to improve your speaking, listening, reading, and writing skills. This learning path is tailored to your current level.</p>
                        <div class="d-flex align-items-center">
                            <span class="me-3">Your Progress:</span>
                            <div class="progress flex-grow-1" style="height: 10px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $overallProgress }}%;" 
                                     aria-valuenow="{{ $overallProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ms-3 fw-bold">{{ $overallProgress }}%</span>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="row" id="table-head">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Upcoming Schedule with Mentor</h4>
                                </div>
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>DATE</th>
                                                    <th>TIME</th>
                                                    <th>LESSON</th>
                                                    <th>MENTOR</th>
                                                    <th>LOCATION</th>
                                                    <th class="text-center">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($schedules as $schedule)
                                                    <tr>
                                                        <td class="text-bold-500">
                                                            {{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d F Y') }}
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-light-primary">
                                                                {{ \Carbon\Carbon::parse($schedule->schedule_time)->format('h:i A') }}
                                                            </span>
                                                        </td>
                                                        <td class="text-bold-500">{{ $schedule->lesson_type }}</td>
                                                        <td>{{ $schedule->mentor_name }}</td>
                                                        <td>
                                                            <span class="badge bg-light-{{ $schedule->location == 'online' ? 'success' : 'info' }}">
                                                                {{ ucfirst($schedule->location) }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            @if($schedule->location == 'online' && $schedule->meeting_link)
                                                                <a href="{{ $schedule->meeting_link }}" target="_blank" class="btn btn-primary btn-sm">
                                                                    <i class="bi bi-camera-video"></i> Join
                                                                </a>
                                                            @else
                                                                <span class="badge bg-light-secondary">
                                                                    {{ $schedule->location == 'offline' ? 'In Person' : 'No Link' }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted py-4">
                                                            <i class="bi bi-calendar-x" style="font-size: 2rem;"></i>
                                                            <p class="mt-2 mb-0">No upcoming schedules. Your mentor will schedule sessions soon.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- WhatsApp Contact Button -->
                    @if($mentorPhone)
                        <div class="d-flex justify-content-center mt-4">
                            <a href="https://wa.me/{{ $mentorPhone }}?text=Hello%2C%20I%20would%20like%20to%20discuss%20my%20learning%20progress" 
                               target="_blank" 
                               class="chat-btn">
                                <i class="bi bi-whatsapp"></i>
                                <span>Talk With Mentor via WhatsApp</span>
                            </a>
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="bi bi-journal-check text-primary" style="font-size: 2.5rem;"></i>
                                    <h5 class="mt-3">View My Tasks</h5>
                                    <p class="text-muted">Check assignments from your mentor</p>
                                    <a href="{{ route('user.tasks') }}" class="btn btn-outline-primary">Go to Tasks</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="bi bi-book text-success" style="font-size: 2.5rem;"></i>
                                    <h5 class="mt-3">Learning Materials</h5>
                                    <p class="text-muted">Access study materials</p>
                                    <a href="{{ route('learning.index') }}" class="btn btn-outline-success">View Materials</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="bi bi-graph-up text-warning" style="font-size: 2.5rem;"></i>
                                    <h5 class="mt-3">My Progress</h5>
                                    <p class="text-muted">Track your learning journey</p>
                                    <a href="{{ route('progress.report') }}" class="btn btn-outline-warning">View Progress</a>
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
                </div>
            </footer>
        </div>
    </div>

    <style>
    .chat-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background-color: #25D366;
        color: white;
        padding: 15px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: bold;
        font-size: 1.1rem;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
        transition: all 0.3s ease;
    }
    .chat-btn:hover {
        background-color: #1ebc57;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        color: white;
    }
    .chat-btn i {
        font-size: 1.5rem;
    }
    </style>

    <script src="{{ asset("") }}/assets/static/js/components/dark.js"></script>
    <script src="{{ asset("") }}/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{ asset("") }}/assets/compiled/js/app.js"></script>
</body>

</html>