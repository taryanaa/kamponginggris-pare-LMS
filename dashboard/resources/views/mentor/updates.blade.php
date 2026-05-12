<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - Kampong Inggris Pare</title>

    <link rel="shortcut icon" href="{{ asset('') }}/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/app-dark.css">
    
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
            border: 4px solid #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .profile-pic-container label {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 36px;
            height: 36px;
            background-color: var(--bs-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .profile-pic-container label:hover {
            transform: scale(1.1);
        }
        #profile_photo {
            display: none;
        }
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .alert-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }
    </style>
</head>

<body>
    <script src="{{ asset('') }}/assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <!-- Sidebar content remains the same -->
            <div class="sidebar-wrapper active">
                <!-- Your existing sidebar code -->
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <section id="multiple-column-form">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Update Profile</h4>
                                    <nav aria-label="breadcrumb" class="breadcrumb-header">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Update Profile</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <form class="form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <div class="profile-pic-container">
                                                    <img id="profile-pic-preview" class="profile-pic" 
                                                         src="{{ $user->profile_photo ? asset('storage/profile_photos/' . $user->profile_photo) : asset('assets/static/images/faces/2.jpg') }}" 
                                                         alt="Profile Picture">
                                                    <label for="profile_photo" title="Change photo">
                                                        <i class="bi bi-camera-fill"></i>
                                                    </label>
                                                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="name">Full Name</label>
                                                    <input type="text" id="name" class="form-control" 
                                                           name="name" value="{{ old('name', $user->name) }}" required>
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" id="email" class="form-control" 
                                                           name="email" value="{{ old('email', $user->email) }}" required>
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="date_of_birth">Date of Birth</label>
                                                    <input type="date" id="date_of_birth" class="form-control" 
                                                           name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                                    @error('date_of_birth')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="gender">Gender</label>
                                                    <select class="form-select" id="gender" name="gender">
                                                        <option value="">Select Gender</option>
                                                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                    @error('gender')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="school">School</label>
                                                    <input type="text" id="school" class="form-control" 
                                                           name="school" value="{{ old('school', $user->school) }}" placeholder="School">
                                                    @error('school')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="city">City</label>
                                                    <input type="text" id="city" class="form-control" 
                                                           name="city" value="{{ old('city', $user->city) }}" placeholder="City">
                                                    @error('city')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="hobby">Hobby</label>
                                                    <input type="text" id="hobby" class="form-control" 
                                                           name="hobby" value="{{ old('hobby', $user->hobby) }}" placeholder="Hobby">
                                                    @error('hobby')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="phone">Phone Number</label>
                                                    <input type="text" id="phone" class="form-control" 
                                                           name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Phone Number">
                                                    @error('phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="password">New Password</label>
                                                    <input type="password" id="password" class="form-control" 
                                                           name="password" placeholder="Enter new password">
                                                    <small class="form-text text-muted">Leave blank if you don't want to change it.</small>
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirm New Password</label>
                                                    <input type="password" id="password_confirmation" class="form-control" 
                                                           name="password_confirmation" placeholder="Confirm new password">
                                                </div>
                                            </div>

                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-1 mb-1">Update Profile</button>
                                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

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
        document.addEventListener('DOMContentLoaded', function () {
            const uploadPhotoInput = document.getElementById('profile_photo');
            const previewImage = document.getElementById('profile-pic-preview');

            // Handle photo preview
            uploadPhotoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Handle form reset
            document.querySelector('form').addEventListener('reset', function() {
                // Reset profile picture preview to original
                setTimeout(() => {
                    previewImage.src = '{{ $user->profile_photo ? asset("storage/profile_photos/" . $user->profile_photo) : asset("assets/static/images/faces/2.jpg") }}';
                }, 0);
            });
        });
    </script>
</body>
</html>