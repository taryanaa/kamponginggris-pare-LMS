<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Path - Kampong Inggris Pare</title>

    <link rel="shortcut icon" href="{{ asset("") }}/assets/compiled/svg/fav.jpg" type="image">

    <link rel="stylesheet" href="{{ asset("") }}/assets/compiled/css/ui-widgets-chatbox.css">
    <link rel="stylesheet" href="{{ asset("") }}/assets/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset("") }}/assets/compiled/css/app-dark.css">
    <style>
        .level-btn {
            transition: all 0.3s ease-in-out;
        }
        .level-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .level-btn .level-text {
            font-weight: bold;
        }
        .card-img-top {
            height: 300px;
            object-fit: cover;
        }
        video::-webkit-media-controls-panel {
            background-image: linear-gradient(transparent, rgba(0,0,0,0.5));
        }
        video::-webkit-media-controls-play-button {
            background-color: rgba(255,255,255,0.8);
            border-radius: 50%;
        }
        .badge i {
            margin-right: 3px;
        }
        .file-icon-wrapper {
            transition: transform 0.3s ease;
        }
        .file-icon-wrapper:hover {
            transform: scale(1.1);
        }
        .locked-overlay {
            position: relative;
        }
        .locked-overlay::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .locked-material {
            opacity: 0.6;
            filter: grayscale(50%);
        }
    </style>
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

                        <li class="sidebar-item active">
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

                        <li class="sidebar-item">
                            <a href="{{ route('profile.edit') }}" class='sidebar-link'>
                                <i class="bi bi-person-badge-fill"></i>
                                <span>Profile</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('logout') }}" class='sidebar-link'>
                                <i class="bi bi-box-arrow-left"></i>
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
                <h3>Learning Path</h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon purple mb-2">
                                                    <i class="iconly-boldShow"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Student Level</h6>
                                                <h6 class="font-extrabold mb-0">{{ $studentLevel }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            <section class="row">
                <div class="col-12">
                    <!-- Course Progress Card -->
                    <div class="card">
                        <div class="card-header">
                            <h4>Course Progress</h4>
                        </div>
                        <div class="card-body d-flex align-items-center">
                            <div class="progress flex-grow-1" style="height: 10px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $courseProgress }}%;" 
                                     aria-valuenow="{{ $courseProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ms-3 fw-bold">{{ $courseProgress }}%</span>
                        </div>
                    </div>
                </div>

                <!-- Additional Materials -->
                <h4 class="my-3">Materials from Your Mentor</h4>
                <div class="row">
                    @forelse($materials as $material)
                    <div class="col-md-6 col-12">
                        <div class="card {{ $material->is_locked ? 'locked-material' : '' }}">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0">
                                        {{ $material->title }}
                                        @if($material->is_locked)
                                            <i class="bi bi-lock-fill text-warning ms-2" title="Locked by mentor"></i>
                                        @endif
                                    </h5>
                                    <span class="badge bg-light-primary mt-1">{{ $material->level }}</span>
                                </div>
                                <div>
                                    @if($material->is_locked)
                                        <span class="badge bg-warning"><i class="bi bi-lock-fill"></i> Locked</span>
                                    @endif
                                    @if($material->file_type == 'video')
                                        <span class="badge bg-danger"><i class="bi bi-camera-video"></i> Video</span>
                                    @elseif($material->file_type == 'pdf')
                                        <span class="badge bg-warning"><i class="bi bi-file-pdf"></i> PDF</span>
                                    @elseif($material->file_type == 'document')
                                        <span class="badge bg-primary"><i class="bi bi-file-word"></i> Document</span>
                                    @elseif($material->file_type == 'presentation')
                                        <span class="badge bg-info"><i class="bi bi-file-slides"></i> Slides</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="bi bi-file-earmark"></i> File</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-content">
                                @if($material->is_locked)
                                    <!-- Locked Material Preview -->
                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-dark" style="height: 300px; position: relative;">
                                        <div class="text-center" style="z-index: 10;">
                                            <i class="bi bi-lock-fill text-warning" style="font-size: 5rem;"></i>
                                            <p class="mt-3 text-white fw-bold">Material Locked</p>
                                            <p class="text-white-50">Contact your mentor to unlock this material</p>
                                        </div>
                                    </div>
                                @else
                                    @if($material->file_type == 'video')
                                        <!-- Video Preview -->
                                        <video class="card-img-top" controls style="width: 100%; height: 300px; background: #000;">
                                            <source src="{{ route('learning.material.view', $material->id) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @elseif($material->file_type == 'pdf')
                                        <!-- PDF Thumbnail -->
                                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 300px; cursor: pointer;"
                                             data-bs-toggle="modal" data-bs-target="#pdfModal{{ $material->id }}">
                                            <div class="text-center file-icon-wrapper">
                                                <i class="bi bi-file-pdf text-danger" style="font-size: 5rem;"></i>
                                                <p class="mt-2 text-muted">Click to view PDF</p>
                                            </div>
                                        </div>
                                    @elseif($material->file_type == 'document')
                                        <!-- Document Icon -->
                                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 300px;">
                                            <div class="text-center file-icon-wrapper">
                                                <i class="bi bi-file-word text-primary" style="font-size: 5rem;"></i>
                                                <p class="mt-2 text-muted">{{ strtoupper($material->file_extension) }} Document</p>
                                            </div>
                                        </div>
                                    @elseif($material->file_type == 'presentation')
                                        <!-- Presentation Icon -->
                                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 300px;">
                                            <div class="text-center file-icon-wrapper">
                                                <i class="bi bi-file-slides text-warning" style="font-size: 5rem;"></i>
                                                <p class="mt-2 text-muted">Presentation</p>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Generic File Icon -->
                                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 300px;">
                                            <div class="text-center file-icon-wrapper">
                                                <i class="bi bi-file-earmark text-secondary" style="font-size: 5rem;"></i>
                                                <p class="mt-2 text-muted">File</p>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                
                                <div class="card-body">
                                    <p class="card-text">{{ Str::limit($material->description, 100) }}</p>
                                    
                                    @if($material->is_locked)
                                        <div class="alert alert-warning mb-3">
                                            <i class="bi bi-lock-fill me-2"></i>
                                            <strong>This material is currently locked.</strong> Please contact your mentor for access.
                                        </div>
                                    @else
                                        <div class="d-flex gap-2 flex-wrap">
                                            @if($material->file_type == 'pdf')
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pdfModal{{ $material->id }}">
                                                    <i class="bi bi-eye"></i> View PDF
                                                </button>
                                            @endif
                                            
                                            <a href="{{ route('learning.material.download', $material->id) }}" class="btn btn-success btn-sm">
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                            
                                            @if($material->assigned_count > 0)
                                                <span class="badge bg-light-info align-self-center">
                                                    <i class="bi bi-check-circle"></i> In {{ $material->assigned_count }} task(s)
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <small class="text-muted d-block mt-2">
                                        <i class="bi bi-calendar"></i> Uploaded {{ \Carbon\Carbon::parse($material->created_at)->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- PDF Modal -->
                    @if($material->file_type == 'pdf' && !$material->is_locked)
                    <div class="modal fade" id="pdfModal{{ $material->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $material->title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0">
                                    <iframe src="{{ route('learning.material.view', $material->id) }}" 
                                            style="width: 100%; height: 80vh; border: none;">
                                    </iframe>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="{{ route('learning.material.download', $material->id) }}" class="btn btn-primary">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>No materials available yet. Your mentor will upload materials soon.
                        </div>
                    </div>
                    @endforelse
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

</body>

</html>