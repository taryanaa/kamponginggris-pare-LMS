<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Exam List - Kampong Inggris Pare</title>

    <link rel="shortcut icon" href="{{ asset('') }}/assets/compiled/svg/fav.jpg" type="image">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/extensions/choices.js/public/assets/styles/choices.css">
    <!-- Toastify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    
    <style>
        .exam-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: white;
        }
        
        .exam-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .status-badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }
        
        .type-badge {
            font-size: 0.65rem;
            padding: 0.2rem 0.4rem;
        }
        
        .published-badge { background: #d1fae5; color: #065f46; }
        .draft-badge { background: #fef3c7; color: #92400e; }
        .archived-badge { background: #fee2e2; color: #991b1b; }
        
        .toefl-badge { background: #e3f2fd; color: #1976d2; }
        .ielts-badge { background: #e8f5e9; color: #388e3c; }
        .practical-badge { background: #fff3e0; color: #f57c00; }
        .business-badge { background: #f3e5f5; color: #7b1fa2; }
        .basic-badge { background: #e0f2f1; color: #00796b; }
        .toeic-badge { background: #fff8e1; color: #ff8f00; }
        .academic-badge { background: #fce4ec; color: #c2185b; }
        
        .action-buttons .btn {
            margin-right: 0.25rem;
        }
        
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .loading-spinner {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }

        .stats-card .card-body {
            padding: 1.5rem;
        }

        .exam-details {
            font-size: 0.9rem;
            color: #6b7280;
        }
    </style>
</head>

<body>
    <script src="{{ asset('') }}/assets/static/js/initTheme.js"></script>
    <div id="app">
        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading Exams...</p>
            </div>
        </div>

        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="/dashboard-admin"><img src="{{ asset('') }}/assets/compiled/png/logo.png" alt="Logo" style="height: 60px; width: auto;"></a>
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
                            <a href="/dashboard-admin" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Overview</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/placement-results" class='sidebar-link'>
                                <i class="bi bi-file-earmark-plus-fill"></i>
                                <span>Placement Results</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/add-user" class='sidebar-link'>
                                <i class="bi bi-person-plus-fill"></i>
                                <span>Add User</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/edit-exam" class='sidebar-link'>
                                <i class="bi bi-journal-plus"></i>
                                <span>Add Exam</span>
                            </a>
                        </li>
                        <li class="sidebar-item active">
                            <a href="/dashboard/exam-list" class='sidebar-link'>
                                <i class="bi bi-journals"></i>
                                <span>Exam List</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/data-admin" class='sidebar-link'>
                                <i class="bi bi-database-fill"></i>
                                <span>Data Accounts</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/logout" class='sidebar-link'>
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
                            <h3>Exam Management</h3>
                            <p class="text-subtitle text-muted">Manage and view all created exams and tests.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/dashboard-admin">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Exam List</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <!-- Statistics Cards -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card stats-card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 col-6 text-center">
                                            <h3 id="total-exams">0</h3>
                                            <p class="mb-0">Total Exams</p>
                                        </div>
                                        <div class="col-md-3 col-6 text-center">
                                            <h3 id="published-exams">0</h3>
                                            <p class="mb-0">Published</p>
                                        </div>
                                        <div class="col-md-3 col-6 text-center">
                                            <h3 id="draft-exams">0</h3>
                                            <p class="mb-0">Drafts</p>
                                        </div>
                                        <div class="col-md-3 col-6 text-center">
                                            <h3 id="total-questions">0</h3>
                                            <p class="mb-0">Total Questions</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button class="btn btn-primary" onclick="loadExams()">
                                        <i class="bi bi-arrow-clockwise"></i> Refresh
                                    </button>
                                </div>
                                <div>
                                    <a href="/edit-exam" class="btn btn-success">
                                        <i class="bi bi-plus-circle"></i> Create New Exam
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Exams List -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">All Exams</h4>
                                </div>
                                <div class="card-body">
                                    <div id="exams-container">
                                        <!-- Exams will be loaded here dynamically -->
                                        <div class="text-center py-5">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p class="mt-2">Loading exams...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteExamModal" tabindex="-1" aria-labelledby="deleteExamModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteExamModalLabel">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this exam? This action cannot be undone.</p>
                            <p><strong id="exam-to-delete-title"></strong></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirm-delete-btn">Delete Exam</button>
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
    <script src="{{ asset('') }}/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script src="{{ asset('') }}/assets/static/js/pages/form-element-select.js"></script>
    <script src="{{ asset('') }}/assets/extensions/jquery/jquery.min.js"></script>
    
    <script>
        let currentDeleteExamId = null;

        // Setup CSRF Token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Show/hide loading
        function showLoading() {
            $('#loadingOverlay').fadeIn();
        }

        function hideLoading() {
            $('#loadingOverlay').fadeOut();
        }

        // Get badge class for exam type
        function getExamTypeBadgeClass(examType) {
            const map = {
                'TOEFL Preparation': 'toefl-badge',
                'IELTS A2': 'ielts-badge',
                'IELTS B1': 'ielts-badge',
                'Business Speaking': 'business-badge',
                'Practical English': 'practical-badge',
                'Basic English': 'basic-badge',
                'TOEIC': 'toeic-badge',
                'Academic English': 'academic-badge'
            };
            return map[examType] || 'toeic-badge';
        }

        // Get badge class for status
        function getStatusBadgeClass(status) {
            const map = {
                'published': 'published-badge',
                'draft': 'draft-badge',
                'archived': 'archived-badge'
            };
            return map[status] || 'draft-badge';
        }

        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        }

        // Load exams from server
        function loadExams() {
            showLoading();
            
            $.ajax({
                url: '/dashboard/exams',
                method: 'GET',
                success: function(response) {
                    hideLoading();
                    
                    if (response.success) {
                        displayExams(response.exams);
                        updateStatistics(response.exams);
                    } else {
                        Toastify({
                            text: 'Failed to load exams: ' + response.message,
                            duration: 5000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            style: { background: "#ef4444" }
                        }).showToast();
                    }
                },
                error: function(xhr, status, error) {
                    hideLoading();
                    console.error('Error loading exams:', error);
                    
                    Toastify({
                        text: 'Failed to load exams. Please try again.',
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: { background: "#ef4444" }
                    }).showToast();
                }
            });
        }

        // Display exams in the container
        function displayExams(exams) {
            const container = $('#exams-container');
            
            if (exams.length === 0) {
                container.html(`
                    <div class="text-center py-5">
                        <i class="bi bi-journal-x" style="font-size: 3rem; color: #6b7280;"></i>
                        <h5 class="mt-3 text-muted">No Exams Found</h5>
                        <p class="text-muted">Create your first exam to get started.</p>
                        <a href="/edit-exam" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-circle"></i> Create Exam
                        </a>
                    </div>
                `);
                return;
            }

            let html = '<div class="row">';
            
            exams.forEach(exam => {
                const typeBadge = getExamTypeBadgeClass(exam.exam_type);
                const statusBadge = getStatusBadgeClass(exam.status);
                const createdDate = formatDate(exam.created_at);
                
                html += `
                    <div class="col-12 col-lg-6 mb-4">
                        <div class="exam-card p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-1">${exam.exam_title}</h5>
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        <span class="badge ${typeBadge} type-badge">${exam.exam_type}</span>
                                        <span class="badge ${statusBadge} status-badge">${exam.status}</span>
                                    </div>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-outline-primary edit-exam" data-id="${exam.id}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-exam" data-id="${exam.id}" data-title="${exam.exam_title}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="exam-details">
                                <div class="row">
                                    <div class="col-6">
                                        <small><strong>Category:</strong> ${exam.exam_category}</small>
                                    </div>
                                    <div class="col-6">
                                        <small><strong>Duration:</strong> ${exam.duration_minutes} min</small>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <small><strong>Questions:</strong> ${exam.total_questions}</small>
                                    </div>
                                    <div class="col-6">
                                        <small><strong>Points:</strong> ${exam.total_points}</small>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <small><strong>Created:</strong> ${createdDate}</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-secondary preview-exam" data-id="${exam.id}">
                                        <i class="bi bi-eye"></i> Preview
                                    </button>
                                    <button class="btn btn-sm btn-outline-info copy-exam" data-id="${exam.id}">
                                        <i class="bi bi-copy"></i> Duplicate
                                    </button>
                                    ${exam.status === 'draft' ? 
                                        `<button class="btn btn-sm btn-outline-success publish-exam" data-id="${exam.id}">
                                            <i class="bi bi-check-lg"></i> Publish
                                        </button>` : ''
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            html += '</div>';
            container.html(html);
        }

        // Update statistics
        function updateStatistics(exams) {
            const totalExams = exams.length;
            const publishedExams = exams.filter(exam => exam.status === 'published').length;
            const draftExams = exams.filter(exam => exam.status === 'draft').length;
            const totalQuestions = exams.reduce((sum, exam) => sum + (exam.total_questions || 0), 0);

            $('#total-exams').text(totalExams);
            $('#published-exams').text(publishedExams);
            $('#draft-exams').text(draftExams);
            $('#total-questions').text(totalQuestions);
        }

        // Delete exam
        function deleteExam(examId) {
            showLoading();
            
            $.ajax({
                url: `/dashboard/exams/${examId}`,
                method: 'DELETE',
                success: function(response) {
                    hideLoading();
                    
                    if (response.success) {
                        Toastify({
                            text: 'Exam deleted successfully!',
                            duration: 5000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            style: { background: "#10b981" }
                        }).showToast();
                        
                        // Reload exams list
                        loadExams();
                        
                        // Close modal
                        $('#deleteExamModal').modal('hide');
                    } else {
                        Toastify({
                            text: 'Failed to delete exam: ' + response.message,
                            duration: 5000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            style: { background: "#ef4444" }
                        }).showToast();
                    }
                },
                error: function(xhr, status, error) {
                    hideLoading();
                    console.error('Error deleting exam:', error);
                    
                    Toastify({
                        text: 'Failed to delete exam. Please try again.',
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: { background: "#ef4444" }
                    }).showToast();
                }
            });
        }

        // Event handlers
        $(document).ready(function() {
            // Load exams on page load
            loadExams();

            // Delete exam modal
            $(document).on('click', '.delete-exam', function() {
                const examId = $(this).data('id');
                const examTitle = $(this).data('title');
                
                currentDeleteExamId = examId;
                $('#exam-to-delete-title').text(examTitle);
                $('#deleteExamModal').modal('show');
            });

            // Confirm delete
            $('#confirm-delete-btn').on('click', function() {
                if (currentDeleteExamId) {
                    deleteExam(currentDeleteExamId);
                }
            });

            // Edit exam
            $(document).on('click', '.edit-exam', function() {
                const examId = $(this).data('id');
                window.location.href = `/edit-exam?exam=${examId}`;
            });

            // Preview exam
            $(document).on('click', '.preview-exam', function() {
                const examId = $(this).data('id');
                // Implement preview functionality
                Toastify({
                    text: 'Preview feature coming soon!',
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    style: { background: "#3b82f6" }
                }).showToast();
            });

            // Copy exam
            $(document).on('click', '.copy-exam', function() {
                const examId = $(this).data('id');
                // Implement copy functionality
                Toastify({
                    text: 'Duplicate feature coming soon!',
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    style: { background: "#3b82f6" }
                }).showToast();
            });

            // Publish exam
            $(document).on('click', '.publish-exam', function() {
                const examId = $(this).data('id');
                // Implement publish functionality
                Toastify({
                    text: 'Publish feature coming soon!',
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    style: { background: "#3b82f6" }
                }).showToast();
            });
        });
    </script>
</body>
</html>