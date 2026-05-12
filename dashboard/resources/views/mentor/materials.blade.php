<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Material - Kampong Inggris Pare</title>

    <link rel="shortcut icon" href="{{ asset('') }}/assets/compiled/svg/fav.jpg" type="image">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/extensions/quill/quill.snow.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/extensions/filepond/filepond.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>

<body>
    <script src="{{ asset('') }}/assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="/dashboard/mentor"><img src="{{ asset('') }}/assets/compiled/png/logo.png" alt="Logo" style="height: 60px; width: auto;" srcset=""></a>
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

                        <li class="sidebar-item">
                            <a href="/dashboard/mentor/tasks" class='sidebar-link'>
                                <i class="bi bi-journal-check"></i>
                                <span>Input Task</span>
                            </a>
                        </li>

                        <li class="sidebar-item active">
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
                            <h3>Input Material</h3>
                            <p class="text-subtitle text-muted">Upload new learning materials for students.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/dashboard/mentor">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Input Material</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <section class="section">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Upload Material Form -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Upload New Material</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('mentor.materials.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" 
                                                   placeholder="Enter material title" value="{{ old('title') }}" required>
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="level">Level</label>
                                            <select class="form-select" id="level" name="level" required>
                                                <option value="" disabled selected>Choose level</option>
                                                <option value="Beginner" {{ old('level') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                                <option value="Elementary" {{ old('level') == 'Elementary' ? 'selected' : '' }}>Elementary</option>
                                                <option value="Intermediate" {{ old('level') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                                <option value="Upper Intermediate" {{ old('level') == 'Upper Intermediate' ? 'selected' : '' }}>Upper Intermediate</option>
                                                <option value="Advanced" {{ old('level') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                                            </select>
                                            @error('level')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4" 
                                                      placeholder="Provide a brief description of the material here..." required>{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="material_file">Upload File</label>
                                            <p class="card-text">Upload PDF, PPT, DOC, DOCX, or video files (MP4, AVI, MOV) - Max 500MB</p>
                                            <input type="file" class="form-control" id="material_file" name="material_file" 
                                                   accept=".pdf,.ppt,.pptx,.doc,.docx,.mp4,.avi,.mov" required>
                                            <small class="text-muted">Supported formats: PDF, PPT, PPTX, DOC, DOCX, MP4, AVI, MOV</small>
                                            @error('material_file')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_locked" name="is_locked" value="1" {{ old('is_locked') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_locked">
                                                    <i class="bi bi-lock-fill text-warning"></i> <strong>Kunci Materi</strong>
                                                    <small class="d-block text-muted">Jika dicentang, siswa tidak dapat mengakses materi ini namun tetap dapat melihatnya di daftar</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- List of Uploaded Materials -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Your Uploaded Materials</h4>
                    </div>
                    <div class="card-body">
                        @if($materials->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Level</th>
                                            <th>File Name</th>
                                            <th>Status</th>
                                            <th>Upload Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($materials as $material)
                                            <tr>
                                                <td>{{ $material->title }}</td>
                                                <td>
                                                    <span class="badge bg-light-primary">{{ $material->level }}</span>
                                                </td>
                                                <td>
                                                    @if($material->file_name)
                                                        <i class="bi bi-file-earmark"></i> {{ $material->file_name }}
                                                    @else
                                                        <span class="text-muted">No file</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($material->is_locked)
                                                        <span class="badge bg-warning">
                                                            <i class="bi bi-lock-fill"></i> Locked
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-unlock-fill"></i> Unlocked
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $material->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        @if($material->file_path)
                                                            <a href="{{ route('mentor.materials.download', $material->id) }}" 
                                                               class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-download"></i>
                                                            </a>
                                                        @endif
                                                        
                                                        <!-- Toggle Lock Button -->
                                                        <form action="{{ route('mentor.materials.toggle-lock', $material->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-outline-warning" 
                                                                    title="{{ $material->is_locked ? 'Unlock Material' : 'Lock Material' }}">
                                                                <i class="bi bi-{{ $material->is_locked ? 'unlock' : 'lock' }}-fill"></i>
                                                            </button>
                                                        </form>

                                                        <!-- Delete Button -->
                                                        <form action="{{ route('mentor.materials.destroy', $material->id) }}" method="POST" class="d-inline" 
                                                              onsubmit="return confirm('Are you sure you want to delete this material?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-folder-x" style="font-size: 3rem; color: #6c757d;"></i>
                                <p class="text-muted mt-2">No materials uploaded yet.</p>
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

    <script src="{{ asset('') }}/assets/static/js/components/dark.js"></script>
    <script src="{{ asset('') }}/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('') }}/assets/compiled/js/app.js"></script>

    <script>
        // File upload validation
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('material_file');
            const maxSize = 500 * 1024 * 1024; // 500MB in bytes
            
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > maxSize) {
                        alert('File size exceeds 500MB limit. Please choose a smaller file.');
                        e.target.value = ''; // Clear the file input
                    }
                    
                    // Validate file type
                    const allowedTypes = [
                        'application/pdf',
                        'application/vnd.ms-powerpoint',
                        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'video/mp4',
                        'video/avi',
                        'video/quicktime'
                    ];
                    
                    if (!allowedTypes.includes(file.type)) {
                        alert('Please select a valid file type (PDF, PPT, DOC, or video files).');
                        e.target.value = ''; // Clear the file input
                    }
                }
            });
        });
    </script>
</body>

</html>