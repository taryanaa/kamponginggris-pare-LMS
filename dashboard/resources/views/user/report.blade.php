<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Report - Student</title>

    <link rel="shortcut icon" href="{{ asset("") }}/assets/compiled/svg/fav.jpg" type="image">
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

                        <li class="sidebar-item active">
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
                            <h3>Student Progress Report</h3>
                            <p class="text-subtitle text-muted">Monitor your learning progress here.</p>
                            <p class="text-sm text-muted"><i class="bi bi-clock-history"></i> Last online: <span id="last-online-time"></span></p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Progress Report</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-light-primary me-3">
                                        <div class="avatar-content">
                                            <i class="bi bi-journal-check" style="font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-0">Total Tasks</h6>
                                        <h4 class="mb-0">{{ $totalTasks ?? 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-light-success me-3">
                                        <div class="avatar-content">
                                            <i class="bi bi-check-circle" style="font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-0">Completed</h6>
                                        <h4 class="mb-0">{{ $completedTasks ?? 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-light-warning me-3">
                                        <div class="avatar-content">
                                            <i class="bi bi-trophy" style="font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-0">Avg Score</h6>
                                        <h4 class="mb-0">{{ number_format($averageScore ?? 0, 1) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-light-info me-3">
                                        <div class="avatar-content">
                                            <i class="bi bi-graph-up" style="font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-0">Progress</h6>
                                        <h4 class="mb-0">{{ $overallProgress ?? 0 }}%</h4>
                                    </div>
                                </div>
                            </div>
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
                                <div class="progress-bar" role="progressbar" style="width: {{ $overallProgress ?? 0 }}%;" aria-valuenow="{{ $overallProgress ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ms-3 fw-bold">{{ $overallProgress ?? 0 }}%</span>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Weekly Score</h4>
                                </div>
                                <div class="card-body">
                                    <div id="area"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Overall Achievement</h4>
                                </div>
                                <div class="card-body">
                                    <div id="radialGradient"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Daily Progress Report -->
                <section class="section">
                    <div class="row" id="table-contexual">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Daily Progress Report</h4>
                                </div>
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th>Material</th>
                                                    <th>Last Activity</th>
                                                    <th>Achievement</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($allActivities ?? [] as $index => $activity)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td class="text-bold-500">
                                                        <i class="bi bi-{{ $activity->progress_percentage == 100 ? 'check-circle' : 'clock' }}-fill 
                                                           text-{{ $activity->progress_percentage == 100 ? 'success' : ($activity->progress_percentage >= 50 ? 'warning' : 'secondary') }} me-2"></i>
                                                        {{ $activity->material_name }}
                                                        @if($activity->material_title ?? false)
                                                            <br><small class="text-muted">Material: {{ $activity->material_title }}</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ $activity->activity_type }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress" style="height: 10px; width: 80%;">
                                                                <div class="progress-bar progress-bar-striped bg-{{ $activity->progress_percentage == 100 ? 'success' : ($activity->progress_percentage >= 50 ? 'warning' : 'secondary') }}" 
                                                                     role="progressbar" style="width: {{ $activity->progress_percentage }}%" 
                                                                     aria-valuenow="{{ $activity->progress_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                            <span class="ms-2 text-{{ $activity->progress_percentage == 100 ? 'success' : ($activity->progress_percentage >= 50 ? 'warning' : 'secondary') }}">
                                                                {{ $activity->progress_percentage }}%
                                                            </span>
                                                        </div>
                                                        @if($activity->score ?? false)
                                                            <small class="text-muted">Score: {{ $activity->score }}/100</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-4">No recent activities</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
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
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset("") }}/assets/static/js/components/dark.js"></script>
    <script src="{{ asset("") }}/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{ asset("") }}/assets/compiled/js/app.js"></script>
    <script src="{{ asset("") }}/assets/extensions/dayjs/dayjs.min.js"></script>
    <script src="{{ asset("") }}/assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Set Last Online Time
        const lastOnlineEl = document.getElementById('last-online-time');
        if (lastOnlineEl) {
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            lastOnlineEl.textContent = now.toLocaleDateString('en-US', options);
        }

        // Area Chart - Weekly Score (Real Data from Database)
        @php
            // Prepare weekly score data from database
            $weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            $weekScores = array_fill(0, 7, 0);
            
            if(isset($weeklyScores) && $weeklyScores->count() > 0) {
                foreach($weeklyScores as $score) {
                    $dayIndex = array_search($score->day, $weekDays);
                    if($dayIndex !== false) {
                        $weekScores[$dayIndex] = round($score->avg_score, 0);
                    }
                }
            }
            
            // If no data, show empty chart
            $hasWeeklyData = array_sum($weekScores) > 0;
        @endphp

        var areaOptions = {
            series: [{
                name: 'Score',
                data: [@foreach($weekScores as $score){{ $score }},@endforeach]
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                type: 'category',
                categories: [@foreach($weekDays as $day)"{{ $day }}",@endforeach]
            },
            tooltip: {
                x: {
                    format: 'ddd'
                },
            },
            @if(!$hasWeeklyData)
            noData: {
                text: 'No score data available yet',
                align: 'center',
                verticalAlign: 'middle',
                style: {
                    fontSize: '14px'
                }
            }
            @endif
        };

        var areaChart = new ApexCharts(document.querySelector("#area"), areaOptions);
        areaChart.render();

        // Radial Gradient Chart - Overall Achievement
        var radialGradientOptions = {
            series: [{{ $overallProgress ?? 75 }}],
            chart: {
                height: 350,
                type: 'radialBar',
                toolbar: {
                    show: true
                }
            },
            plotOptions: {
                radialBar: {
                    startAngle: -135,
                    endAngle: 225,
                    hollow: {
                        margin: 0,
                        size: '70%',
                        background: '#fff',
                        image: undefined,
                        imageOffsetX: 0,
                        imageOffsetY: 0,
                        position: 'front',
                        dropShadow: {
                            enabled: true,
                            top: 3,
                            left: 0,
                            blur: 4,
                            opacity: 0.24
                        }
                    },
                    track: {
                        background: '#fff',
                        strokeWidth: '67%',
                        margin: 0,
                        dropShadow: {
                            enabled: true,
                            top: -3,
                            left: 0,
                            blur: 4,
                            opacity: 0.35
                        }
                    },
                    dataLabels: {
                        show: true,
                        name: {
                            offsetY: -10,
                            show: true,
                            color: '#888',
                            fontSize: '17px'
                        },
                        value: {
                            formatter: function(val) {
                                return parseInt(val) + "%";
                            },
                            color: '#111',
                            fontSize: '36px',
                            show: true,
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#ABE5A1'],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                }
            },
            stroke: {
                lineCap: 'round'
            },
            labels: ['Achievement'],
        };

        var radialGradientChart = new ApexCharts(document.querySelector("#radialGradient"), radialGradientOptions);
        radialGradientChart.render();
    });
    </script>
</body>

</html>