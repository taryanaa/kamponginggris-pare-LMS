<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - Kampong Inggris Pare</title>



    <link rel="shortcut icon" href="{{ asset("templates/backend/")  }}/assets/compiled/svg/fav.jpg" type="image">

  <link rel="stylesheet" href="{{ asset("templates/backend/")  }}/assets/compiled/css/app.css">
  <link rel="stylesheet" href="{{ asset("templates/backend/")  }}/assets/compiled/css/app-dark.css">
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
    #upload-photo {
        display: none;
    }
  </style>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
    <div class="sidebar-header position-relative">
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
                <a href="/dashboard-student><img src="{{ asset("templates/backend/")  }}/assets/compiled/png/logo.png" alt="Logo" style="height: 60px; width: auto;" srcset=""></a>
            </div>
            <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
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
                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
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
            <div class="sidebar-toggler  x">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div>
<div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>

            <li
                class="sidebar-item">
                <a href="/dashboard-student" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Overview</span>
                </a>


            </li>

            <li
                class="sidebar-item ">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Placement Test</span>
                </a>

            </li>

            <li
                class="sidebar-item  ">
                <a href="/learning-student" class='sidebar-link'>
                    <i class="bi bi-book-fill"></i>
                    <span>Learning</span>
                </a>


            </li>
            <li
                class="sidebar-item  ">
                <a href="/talk-mentor" class='sidebar-link'>
                    <i class="bi bi-chat-dots-fill"></i>
                    <span>Mentor Talk</span>
                </a>


            </li>

            <li
                class="sidebar-item ">
                <a href="/report-student" class='sidebar-link'>
                    <i class="bi bi-journal-check"></i>
                    <span>Progress Report</span>
                </a>



            </li>


            <li
                class="sidebar-item ">
                <a href="/exam-student" class='sidebar-link'>
                    <i class="bi bi-link"></i>
                    <span>Exam</span>
                </a>


            </li>

            <li
                class="sidebar-item active ">
                <a href="/update-profile" class='sidebar-link'>
                    <i class="bi bi-pen-fill"></i>
                    <span>Update Profile</span>
                </a>


            </li>

            <li
                class="sidebar-item ">
                <a href="/login" class='sidebar-link'>
                    <i class="bi bi-door-open-fill"></i>
                    <span>Log out</span>
                </a>


            </li>


        </ul>
    </div></div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Update Profile</h4>
                            <nav aria-label="breadcrumb" class="breadcrumb-header">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Update Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" id="profileForm">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <div class="profile-pic-container">
                                            <img id="profile-pic-preview" class="profile-pic" src="{{ asset("templates/backend/")  }}/assets/static/images/faces/2.jpg" alt="Profile Picture">
                                            <label for="upload-photo" title="Change photo"><i class="bi bi-camera-fill"></i></label>
                                            <input type="file" id="upload-photo" accept="image/*">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="full-name-column">Full Name</label>
                                            <input type="text" id="full-name-column" class="form-control" placeholder="Full Name" name="fname-column" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="date-birth-column">Date of Birth</label>
                                            <input type="date" id="date-birth-column" class="form-control" name="dob-column" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="school-column">School</label>
                                            <input type="text" id="school-column" class="form-control" placeholder="School" name="school-column">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="city-column">City</label>
                                            <input type="text" id="city-column" class="form-control" name="city-column" placeholder="City">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="hobby-column">Hobby</label>
                                            <input type="text" id="hobby-column" class="form-control" name="hobby-column" placeholder="Hobby">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Email</label>
                                            <input type="email" id="email-id-column" class="form-control" name="email-id-column" placeholder="Email" required>
                                        </div>
                                    </div>
                                     <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="password-id-column">New Password</label>
                                            <input type="password" id="password-id-column" class="form-control" name="password" placeholder="Enter new password">
                                            <small class="form-text text-muted">Leave blank if you don't want to change it.</small>
                                        </div>
                                    </div>
                                     <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="repeat-password-id-column">Repeat New Password</label>
                                            <input type="password" id="repeat-password-id-column" class="form-control" name="repeat-password" placeholder="Repeat new password">
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
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
    <!-- // Basic multiple Column Form section end -->
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
    <script src="{{ asset("templates/backend/")  }}/assets/static/js/components/dark.js"></script>
    <script src="{{ asset("templates/backend/")  }}/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>


    <script src="{{ asset("templates/backend/")  }}/assets/compiled/js/app.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const uploadPhotoInput = document.getElementById('upload-photo');
            const previewImage = document.getElementById('profile-pic-preview');
            const profileForm = document.getElementById('profileForm');
            const passwordInput = document.getElementById('password-id-column');
            const repeatPasswordInput = document.getElementById('repeat-password-id-column');

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

            // Handle form submission
            profileForm.addEventListener('submit', function(event) {
                event.preventDefault();

                // Password validation
                if (passwordInput.value !== repeatPasswordInput.value) {
                    alert("Passwords do not match. Please re-enter.");
                    repeatPasswordInput.focus();
                    return;
                }

                // Add your form submission logic here
                alert("Profile updated successfully!");
                // e.g., new FormData(profileForm), then send with fetch()
            });

            // Handle form reset
            profileForm.addEventListener('reset', function() {
                // Reset profile picture preview to default
                setTimeout(() => {
                    previewImage.src = './assets/static/images/faces/2.jpg';
                }, 0);
            });
        });
    </script>

</body>

</html>
