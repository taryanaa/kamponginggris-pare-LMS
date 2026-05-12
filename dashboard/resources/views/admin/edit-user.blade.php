<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit User - Kampong Inggris Pare</title>
    <link rel="shortcut icon" href="{{ asset('assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <style>
        .profile-pic-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
        }
        .profile-pic {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #eee;
        }
        .profile-pic-container label {
            position: absolute;
            bottom: 0;
            right: 10px;
            width: 32px;
            height: 32px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 32px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .profile-pic-container label:hover {
            background-color: #0056b3;
        }
        .profile-pic-container input[type="file"] {
            display: none;
        }
    </style>
</head>
<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
             <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="/dashboard/dashboard-admin"><img src="{{ asset('assets/compiled/png/logo.png') }}" alt="Logo" style="height: 60px; width: auto;"></a>
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

                        <li class="sidebar-item active">
                            <a href="/dashboard/admin" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Overview</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="/dashboard/placement-results" class='sidebar-link'>
                                <i class="bi bi-file-earmark-plus-fill"></i>
                                <span>Add Placement Test</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="/dashboard/add-user" class='sidebar-link'>
                                <i class="bi bi-person-plus-fill"></i>
                                <span>Add User</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="/dashboard/edit-exam" class='sidebar-link'>
                                <i class="bi bi-journal-plus"></i>
                                <span>Add Exam</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/dashboard/exam-list" class='sidebar-link'>
                                <i class="bi bi-journals"></i>
                                <span>Exam List</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="/dashboard/data-admin" class='sidebar-link'>
                                <i class="bi bi-database-fill"></i>
                                <span>Data Accounts</span>
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
                            <h3>Edit User</h3>
                            <p class="text-subtitle text-muted">Update user information</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="/data-admin">Users</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Check if user exists -->
                @if(!$user)
                    <div class="alert alert-danger">
                        User not found. <a href="/data-admin" class="alert-link">Return to user list</a>
                    </div>
                @else
                <!-- Form Section -->
                <section id="multiple-column-form">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">User Details</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" id="editUserForm">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="row">
                                                <!-- Profile Picture -->
                                                <div class="col-12 text-center">
                                                    <div class="profile-pic-container">
                                                        <img id="profile-pic-preview" class="profile-pic" 
                                                             src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('assets/static/images/faces/1.jpg') }}" 
                                                             alt="Profile Picture">
                                                        <label for="upload-photo" title="Upload photo">
                                                            <i class="bi bi-camera-fill"></i>
                                                        </label>
                                                        <input type="file" id="upload-photo" name="profile_photo" accept="image/*">
                                                    </div>
                                                    <p class="text-muted small">Leave empty to keep current photo</p>
                                                </div>

                                                <!-- Full Name -->
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="full-name-column">Full Name <span class="text-danger">*</span></label>
                                                        <input type="text" id="full-name-column" 
                                                               class="form-control @error('name') is-invalid @enderror" 
                                                               placeholder="Enter full name" 
                                                               name="name" 
                                                               value="{{ old('name', $user->name) }}" 
                                                               required>
                                                        @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Email -->
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="email-id-column">Email <span class="text-danger">*</span></label>
                                                        <input type="email" id="email-id-column" 
                                                               class="form-control @error('email') is-invalid @enderror" 
                                                               name="email" 
                                                               placeholder="Enter email address" 
                                                               value="{{ old('email', $user->email) }}" 
                                                               required>
                                                        @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Password -->
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="password-column">Password</label>
                                                        <input type="password" id="password-column" 
                                                               class="form-control @error('password') is-invalid @enderror" 
                                                               placeholder="Leave empty to keep current password" 
                                                               name="password">
                                                        <small class="text-muted">Minimum 8 characters. Leave empty to keep current password.</small>
                                                        @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Confirm Password -->
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="confirm-password-column">Confirm Password</label>
                                                        <input type="password" id="confirm-password-column" 
                                                               class="form-control" 
                                                               placeholder="Confirm new password" 
                                                               name="password_confirmation">
                                                    </div>
                                                </div>

                                                <!-- Role -->
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="role-select">Role <span class="text-danger">*</span></label>
                                                        <select class="form-select @error('role') is-invalid @enderror" 
                                                                id="role-select" 
                                                                name="role" 
                                                                required>
                                                            <option value="">Select Role</option>
                                                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                                            <option value="mentor" {{ old('role', $user->role) == 'mentor' ? 'selected' : '' }}>Mentor</option>
                                                            <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Student</option>
                                                        </select>
                                                        @error('role')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Created Date Info -->
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label>Account Created</label>
                                                        <input type="text" class="form-control" 
                                                               value="{{ $user->created_at->format('d M Y H:i') }}" 
                                                               readonly>
                                                    </div>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="col-12 d-flex justify-content-end mt-4">
                                                    <a href="/data-admin" class="btn btn-light-secondary me-1 mb-1">Cancel</a>
                                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                                        <i class="bi bi-save me-1"></i> Update User
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                @endif
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

    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadPhoto = document.getElementById('upload-photo');
            const preview = document.getElementById('profile-pic-preview');

            // Preview uploaded image
            if (uploadPhoto) {
                uploadPhoto.addEventListener('change', function(e) {
                    if (e.target.files && e.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            preview.src = event.target.result;
                        }
                        reader.readAsDataURL(e.target.files[0]);
                    }
                });
            }

            // Auto-hide alerts after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
</body>
</html>