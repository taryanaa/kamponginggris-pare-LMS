<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Exam Builder - Kampong Inggris Pare</title>

    <link rel="shortcut icon" href="{{ asset('') }}/assets/compiled/svg/fav.jpg" type="image">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="{{ asset('') }}/assets/extensions/choices.js/public/assets/styles/choices.css">
    <!-- Toastify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        .question-form {
            display: none;
        }
        
        .question-form.active {
            display: block;
        }
        
        .question-item {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #f9fafb;
            transition: all 0.3s ease;
        }
        
        .question-item:hover {
            background: #f3f4f6;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .option-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            background: white;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }
        
        .matching-pair {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.5rem;
            align-items: center;
        }
        
        .matching-pair input {
            flex: 1;
        }
        
        .ordering-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            gap: 1rem;
        }
        
        .badge-type {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }
        
        .skill-badge {
            font-size: 0.65rem;
            padding: 0.2rem 0.4rem;
            margin-right: 0.3rem;
        }
        
        .toeic-badge { background: #e3f2fd; color: #1976d2; }
        .ielts-badge { background: #e8f5e9; color: #388e3c; }
        .practical-badge { background: #fff3e0; color: #f57c00; }
        .business-badge { background: #f3e5f5; color: #7b1fa2; }
        .basic-badge { background: #e0f2f1; color: #00796b; }
        .toefl-badge { background: #fff8e1; color: #ff8f00; }
        .academic-badge { background: #fce4ec; color: #c2185b; }
        
        .listening-badge { background: #e3f2fd; color: #1976d2; }
        .reading-badge { background: #e8f5e9; color: #388e3c; }
        .writing-badge { background: #fff3e0; color: #f57c00; }
        .speaking-badge { background: #f3e5f5; color: #7b1fa2; }
        .grammar-badge { background: #e0f2f1; color: #00796b; }
        .vocabulary-badge { background: #fff8e1; color: #ff8f00; }
        .pronunciation-badge { background: #fce4ec; color: #c2185b; }
        
        .question-preview {
            border-left: 4px solid #4f46e5;
            background: #f8fafc;
        }
        
        .correct-answer-indicator {
            color: #10b981;
            font-weight: bold;
        }

        .audio-preview {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
        }

        .audio-preview audio {
            width: 100%;
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
                <p class="mt-2">Saving Exam...</p>
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
                        <li class="sidebar-item active">
                            <a href="/edit-exam" class='sidebar-link'>
                                <i class="bi bi-journal-plus"></i>
                                <span>Add Exam</span>
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
                            <h3>Exam Builder</h3>
                            <p class="text-subtitle text-muted">Create and manage placement tests and exams.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/dashboard-admin">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Exam Builder</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <!-- Exam Details Card -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Exam Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exam-title">Exam / Test Title *</label>
                                        <input type="text" class="form-control" id="exam-title" placeholder="e.g., TOEFL Preparation Test Vol. 3" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exam-type">Test Type *</label>
                                        <select class="form-select" id="exam-type" required>
                                            <option value="TOEFL Preparation">TOEFL Preparation</option>
                                            <option value="IELTS A2">IELTS A2</option>
                                            <option value="IELTS B1">IELTS B1</option>
                                            <option value="Business Speaking">Business Speaking</option>
                                            <option value="Practical English">Practical English</option>
                                            <option value="Basic English">Basic English</option>
                                            <option value="TOEIC">TOEIC</option>
                                            <option value="Academic English">Academic English</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="existing-exam">Select Existing Exam</label>
                                        <select class="form-select" id="existing-exam">
                                            <option value="">Start a new exam</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exam-duration">Duration (minutes) *</label>
                                        <input type="number" class="form-control" id="exam-duration" placeholder="e.g., 120" value="120" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="exam-category">Exam Category / Description *</label>
                                        <input type="text" class="form-control" id="exam-category" placeholder="e.g., Placement Test, Practice Test, Final Exam" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Question Builder -->
                        <div class="col-12 col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Question Builder</h4>
                                    <div class="d-flex justify-content-end">
                                        <label for="import-file" class="btn btn-sm btn-outline-primary icon icon-left">
                                            <i class="bi bi-upload"></i> Import from CSV
                                        </label>
                                        <input type="file" id="import-file" class="d-none" accept=".csv">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="question-type">Question Type</label>
                                                <select class="form-select" id="question-type">
                                                    <option value="multiple-choice">Multiple Choice</option>
                                                    <option value="true-false">True/False</option>
                                                    <option value="fill-blank">Fill in the Blank</option>
                                                    <option value="essay">Essay / Long Answer</option>
                                                    <option value="matching">Matching</option>
                                                    <option value="listening">Listening Comprehension</option>
                                                    <option value="ordering">Ordering / Sequence</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="question-points">Question Points</label>
                                                <input type="number" class="form-control" id="question-points" value="10" min="1">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="skill-category">Skill Category</label>
                                                <select class="form-select" id="skill-category">
                                                    <option value="listening">Listening</option>
                                                    <option value="reading">Reading</option>
                                                    <option value="writing">Writing</option>
                                                    <option value="speaking">Speaking</option>
                                                    <option value="grammar">Grammar</option>
                                                    <option value="vocabulary">Vocabulary</option>
                                                    <option value="pronunciation">Pronunciation</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    
                                    <!-- Dynamic Question Forms Container -->
                                    <div id="question-forms-container">
                                        <!-- Multiple Choice Form -->
                                        <div id="form-multiple-choice" class="question-form active">
                                            <div class="form-group">
                                                <label>Question Text *</label>
                                                <textarea class="form-control question-text" rows="3" placeholder="Enter your question here..." required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Options *</label>
                                                <div id="multiple-choice-options">
                                                    <div class="option-item">
                                                        <div class="form-check me-2">
                                                            <input class="form-check-input correct-answer" type="radio" name="correct-answer" value="0" required>
                                                        </div>
                                                        <input type="text" class="form-control option-text" placeholder="Option 1" required>
                                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-option" style="display: none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="option-item">
                                                        <div class="form-check me-2">
                                                            <input class="form-check-input correct-answer" type="radio" name="correct-answer" value="1">
                                                        </div>
                                                        <input type="text" class="form-control option-text" placeholder="Option 2" required>
                                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-option" style="display: none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="option-item">
                                                        <div class="form-check me-2">
                                                            <input class="form-check-input correct-answer" type="radio" name="correct-answer" value="2">
                                                        </div>
                                                        <input type="text" class="form-control option-text" placeholder="Option 3" required>
                                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-option" style="display: none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="option-item">
                                                        <div class="form-check me-2">
                                                            <input class="form-check-input correct-answer" type="radio" name="correct-answer" value="3">
                                                        </div>
                                                        <input type="text" class="form-control option-text" placeholder="Option 4" required>
                                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-option" style="display: none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-option">
                                                    <i class="bi bi-plus"></i> Add Option
                                                </button>
                                            </div>
                                        </div>

                                        <!-- True/False Form -->
                                        <div id="form-true-false" class="question-form">
                                            <div class="form-group">
                                                <label>Statement *</label>
                                                <textarea class="form-control question-text" rows="2" placeholder="Enter the statement..." required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Correct Answer *</label>
                                                <div class="form-check">
                                                    <input class="form-check-input correct-answer" type="radio" name="true-false-answer" id="true-answer" value="true" required>
                                                    <label class="form-check-label" for="true-answer">True</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input correct-answer" type="radio" name="true-false-answer" id="false-answer" value="false">
                                                    <label class="form-check-label" for="false-answer">False</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Fill in the Blank Form -->
                                        <div id="form-fill-blank" class="question-form">
                                            <div class="form-group">
                                                <label>Sentence with Blank *</label>
                                                <textarea class="form-control question-text" rows="2" placeholder="Use ___ for the blank. e.g., The quick brown fox ___ over the lazy dog." required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Correct Answer *</label>
                                                <input type="text" class="form-control correct-answer" placeholder="Enter the correct answer" required>
                                            </div>
                                        </div>

                                        <!-- Essay Form -->
                                        <div id="form-essay" class="question-form">
                                            <div class="form-group">
                                                <label>Question / Prompt *</label>
                                                <textarea class="form-control question-text" rows="4" placeholder="Enter the essay prompt..." required></textarea>
                                            </div>
                                        </div>

                                        <!-- Matching Form -->
                                        <div id="form-matching" class="question-form">
                                            <div class="form-group">
                                                <label>Matching Pairs *</label>
                                                <div id="matching-pairs">
                                                    <div class="matching-pair">
                                                        <input type="text" class="form-control match-item" placeholder="Item 1" required>
                                                        <input type="text" class="form-control match-answer" placeholder="Match 1" required>
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-pair" style="display: none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="matching-pair">
                                                        <input type="text" class="form-control match-item" placeholder="Item 2" required>
                                                        <input type="text" class="form-control match-answer" placeholder="Match 2" required>
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-pair" style="display: none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-pair">
                                                    <i class="bi bi-plus"></i> Add Pair
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Listening Form -->
                                        <div id="form-listening" class="question-form">
                                            <div class="form-group">
                                                <label for="audio-file">Upload Audio File</label>
                                                <input type="file" class="form-control" id="audio-file" accept="audio/*">
                                                <small class="form-text text-muted">Supported formats: MP3, WAV, OGG (Max: 10MB)</small>
                                                <div id="audio-preview" class="mt-2" style="display: none;">
                                                    <div class="audio-preview">
                                                        <audio controls></audio>
                                                        <small class="text-muted d-block mt-1">Audio Preview</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Question related to audio *</label>
                                                <textarea class="form-control question-text" rows="3" placeholder="Enter the listening comprehension question..." required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Answer Options *</label>
                                                <div id="listening-options">
                                                    <div class="option-item">
                                                        <div class="form-check me-2">
                                                            <input class="form-check-input correct-answer" type="radio" name="listening-answer" value="0" required>
                                                        </div>
                                                        <input type="text" class="form-control option-text" placeholder="Option 1" required>
                                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-option" style="display: none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="option-item">
                                                        <div class="form-check me-2">
                                                            <input class="form-check-input correct-answer" type="radio" name="listening-answer" value="1">
                                                        </div>
                                                        <input type="text" class="form-control option-text" placeholder="Option 2" required>
                                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-option" style="display: none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-listening-option">
                                                    <i class="bi bi-plus"></i> Add Option
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Ordering Form -->
                                        <div id="form-ordering" class="question-form">
                                            <div class="form-group">
                                                <label>Items to Order (in correct sequence) *</label>
                                                <div id="ordering-items">
                                                    <div class="ordering-item">
                                                        <span class="badge bg-primary">1</span>
                                                        <input type="text" class="form-control order-item" placeholder="First step" required>
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-order" style="display: none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="ordering-item">
                                                        <span class="badge bg-primary">2</span>
                                                        <input type="text" class="form-control order-item" placeholder="Second step" required>
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-order" style="display: none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-order">
                                                    <i class="bi bi-plus"></i> Add Item
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary" id="add-question-btn">
                                            <i class="bi bi-plus-circle"></i> Add Question to List
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Question List -->
                        <div class="col-12 col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Question List</h4>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted" id="question-list-summary">Total Questions: 0 | Total Points: 0</p>
                                    <div id="question-list-container" style="max-height: 400px; overflow-y: auto;">
                                        <!-- Questions will be added here dynamically -->
                                    </div>
                                    <hr>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-outline-secondary" id="preview-exam-btn" data-bs-toggle="modal" data-bs-target="#previewExamModal">
                                            <i class="bi bi-eye"></i> Preview Exam
                                        </button>
                                        <button class="btn btn-info" id="save-draft-btn">
                                            <i class="bi bi-save"></i> Save as Draft
                                        </button>
                                        <button class="btn btn-success" id="save-add-another-btn">
                                            <i class="bi bi-plus-square"></i> Save & Add Another
                                        </button>
                                        <button class="btn btn-primary" id="save-back-btn">
                                            <i class="bi bi-check-lg"></i> Save & Back to List
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Preview Exam Modal -->
            <div class="modal fade" id="previewExamModal" tabindex="-1" aria-labelledby="previewExamModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="previewExamModalLabel">Exam Preview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="exam-preview-content">
                            <!-- Exam preview will be generated here -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
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
        $(document).ready(function() {
            let questions = [];
            let optionCounter = 4;
            let pairCounter = 2;
            let orderCounter = 2;

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

            // Initialize question type switching
            $('#question-type').on('change', function() {
                $('.question-form').removeClass('active');
                $('#form-' + $(this).val()).addClass('active');
                
                // Reset audio preview when switching to non-listening type
                if ($(this).val() !== 'listening') {
                    $('#audio-preview').hide();
                    $('#audio-file').val('');
                }
            }).trigger('change');

            // Audio file preview
            $('#audio-file').on('change', function(e) {
                const file = e.target.files[0];
                const preview = $('#audio-preview');
                const audio = preview.find('audio');
                
                if (file) {
                    // Validate file size (10MB max)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('Audio file size must be less than 10MB');
                        $(this).val('');
                        preview.hide();
                        return;
                    }
                    
                    const url = URL.createObjectURL(file);
                    audio.attr('src', url);
                    preview.show();
                } else {
                    preview.hide();
                }
            });

            // Get badge class functions
            function getTestTypeBadgeClass(testType) {
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
                return map[testType] || 'toeic-badge';
            }

            function getSkillBadgeClass(skill) {
                const map = {
                    'listening': 'listening-badge',
                    'reading': 'reading-badge',
                    'writing': 'writing-badge',
                    'speaking': 'speaking-badge',
                    'grammar': 'grammar-badge',
                    'vocabulary': 'vocabulary-badge',
                    'pronunciation': 'pronunciation-badge'
                };
                return map[skill] || 'listening-badge';
            }

            // Add question to list
$('#add-question-btn').on('click', function() {
    const type = $('#question-type').val();
    const points = $('#question-points').val() || 10;
    const skill = $('#skill-category').val();
    const form = $('#form-' + type);
    const questionText = form.find('.question-text').val().trim();

    // Validasi
    if (!questionText) {
        alert('Question text cannot be empty!');
        return;
    }

    let questionData = {
        type: type,
        question: questionText,
        points: parseInt(points),
        skill: skill,
        options: [],
        correctAnswer: null,
        audioFile: null // Initialize
    };

    // **FIX: Handle audio file untuk listening questions**
    if (type === 'listening') {
        const audioFileInput = document.getElementById('audio-file');
        console.log('Audio file input:', audioFileInput);
        console.log('Audio files:', audioFileInput?.files);
        
        if (audioFileInput && audioFileInput.files.length > 0) {
            questionData.audioFile = audioFileInput.files[0];
            questionData.audioFileName = audioFileInput.files[0].name;
            console.log('✅ Audio file attached:', questionData.audioFileName);
        } else {
            console.warn('❌ No audio file selected for listening question');
            alert('Please select an audio file for listening question!');
            return; // Stop jika tidak ada audio file
        }
        
        // Force skill to listening
        questionData.skill = 'listening';
    }

    // Collect data berdasarkan question type
    switch(type) {
        case 'multiple-choice':
        case 'listening':
            let hasCorrectAnswer = false;
            const optionsContainer = type === 'listening' ? '#listening-options' : '#multiple-choice-options';
            
            $(optionsContainer + ' .option-item').each(function(index) {
                const optionText = $(this).find('.option-text').val().trim();
                const isCorrect = $(this).find('.correct-answer').is(':checked');
                
                if (optionText) {
                    questionData.options.push({
                        text: optionText,
                        isCorrect: isCorrect
                    });
                    if (isCorrect) {
                        questionData.correctAnswer = index;
                        hasCorrectAnswer = true;
                    }
                }
            });
            
            if (!hasCorrectAnswer && questionData.options.length > 0) {
                alert('Please select a correct answer!');
                return;
            }
            break;

        case 'true-false':
            const tfAnswer = form.find('.correct-answer:checked').val();
            if (!tfAnswer) {
                alert('Please select True or False!');
                return;
            }
            questionData.correctAnswer = tfAnswer;
            break;

        case 'fill-blank':
            const blankAnswer = form.find('.correct-answer').val();
            if (!blankAnswer) {
                alert('Please enter the correct answer!');
                return;
            }
            questionData.correctAnswer = blankAnswer;
            break;

        case 'matching':
            const pairs = [];
            form.find('.matching-pair').each(function() {
                const item = $(this).find('.match-item').val().trim();
                const answer = $(this).find('.match-answer').val().trim();
                if (item && answer) {
                    pairs.push({ item: item, answer: answer });
                }
            });
            if (pairs.length < 2) {
                alert('Please add at least 2 matching pairs!');
                return;
            }
            questionData.pairs = pairs;
            break;

        case 'ordering':
            const items = [];
            form.find('.order-item').each(function() {
                const item = $(this).val().trim();
                if (item) {
                    items.push(item);
                }
            });
            if (items.length < 2) {
                alert('Please add at least 2 items to order!');
                return;
            }
            questionData.items = items;
            break;
    }

    // **DEBUG: Log question data sebelum ditambahkan**
    console.log('📝 Question data to be added:', {
        type: questionData.type,
        skill: questionData.skill,
        question: questionData.question,
        hasAudio: !!questionData.audioFile,
        audioFile: questionData.audioFile ? questionData.audioFile.name : 'None',
        options: questionData.options.length
    });

    questions.push(questionData);
    updateQuestionList();
    clearQuestionForm();
    
    Toastify({
        text: "Question added successfully!",
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        style: { background: "#4f46e5" }
    }).showToast();
});

            // Update question list display
function updateQuestionList() {
    const container = $('#question-list-container');
    container.empty();
    let totalPoints = 0;

    questions.forEach((q, index) => {
        const testType = $('#exam-type').val();
        const testTypeBadge = getTestTypeBadgeClass(testType);
        const skillBadge = getSkillBadgeClass(q.skill);
        
        const questionText = q.question.length > 50 ? q.question.substring(0, 50) + '...' : q.question;

        const li = `
            <div class="question-item" data-index="${index}">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge ${testTypeBadge} badge-type me-2">${q.type.toUpperCase()}</span>
                            <span class="badge ${skillBadge} skill-badge">${q.skill}</span>
                            <span class="badge bg-secondary">${q.points} pts</span>
                            ${q.fromCSV ? '<span class="badge bg-warning ms-1">CSV</span>' : ''}
                            ${q.audioFile ? '<span class="badge bg-success ms-1"><i class="bi bi-file-earmark-music"></i></span>' : ''}
                        </div>
                        <p class="mb-1">${questionText}</p>
                        ${q.options && q.options.length > 0 ? `<small class="text-muted">Options: ${q.options.length}</small>` : ''}
                        ${q.fromCSV ? `<small class="text-info d-block"><i class="bi bi-file-earmark-text"></i> Imported from CSV</small>` : ''}
                    </div>
                    <div class="ms-3">
                        <button type="button" class="btn btn-sm btn-outline-danger delete-question" data-index="${index}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.append(li);
        totalPoints += q.points;
    });

    $('#question-list-summary').text(`Total Questions: ${questions.length} | Total Points: ${totalPoints}`);
}

            // Clear question form
            function clearQuestionForm() {
                $('.question-text').val('');
                $('.correct-answer').prop('checked', false);
                $('.option-text').val('');
                $('.match-item, .match-answer').val('');
                $('.order-item').val('');
                // $('#audio-file').val('');
                // $('#audio-preview').hide();
                
                // Reset to default options for multiple choice
                $('#multiple-choice-options .option-item').slice(4).remove();
                optionCounter = 4;
                
                // Reset to default pairs for matching
                $('#matching-pairs .matching-pair').slice(2).remove();
                pairCounter = 2;
                
                // Reset to default items for ordering
                $('#ordering-items .ordering-item').slice(2).remove();
                orderCounter = 2;
            }

            // Delete question
            $(document).on('click', '.delete-question', function() {
                const index = $(this).data('index');
                if (confirm('Are you sure you want to delete this question?')) {
                    questions.splice(index, 1);
                    updateQuestionList();
                    
                    Toastify({
                        text: "Question deleted!",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#ef4444",
                    }).showToast();
                }
            });

            // Add option for multiple choice
            $('#add-option').on('click', function() {
                const newOption = `
                    <div class="option-item">
                        <div class="form-check me-2">
                            <input class="form-check-input correct-answer" type="radio" name="correct-answer" value="${optionCounter}">
                        </div>
                        <input type="text" class="form-control option-text" placeholder="Option ${optionCounter + 1}">
                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-option">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                $('#multiple-choice-options').append(newOption);
                optionCounter++;
            });

            // Add option for listening
            $('#add-listening-option').on('click', function() {
                const newOption = `
                    <div class="option-item">
                        <div class="form-check me-2">
                            <input class="form-check-input correct-answer" type="radio" name="listening-answer" value="${optionCounter}">
                        </div>
                        <input type="text" class="form-control option-text" placeholder="Option ${optionCounter + 1}">
                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-option">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                $('#listening-options').append(newOption);
                optionCounter++;
            });

            // Add matching pair
            $('#add-pair').on('click', function() {
                const newPair = `
                    <div class="matching-pair">
                        <input type="text" class="form-control match-item" placeholder="Item ${pairCounter + 1}">
                        <input type="text" class="form-control match-answer" placeholder="Match ${pairCounter + 1}">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-pair">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                $('#matching-pairs').append(newPair);
                pairCounter++;
            });

            // Add ordering item
            $('#add-order').on('click', function() {
                const newOrder = `
                    <div class="ordering-item">
                        <span class="badge bg-primary">${orderCounter + 1}</span>
                        <input type="text" class="form-control order-item" placeholder="Step ${orderCounter + 1}">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-order">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                $('#ordering-items').append(newOrder);
                orderCounter++;
            });

            // Remove elements
            $(document).on('click', '.remove-option, .remove-pair, .remove-order', function() {
                $(this).closest('.option-item, .matching-pair, .ordering-item').remove();
            });

            // Preview exam
            $('#preview-exam-btn').on('click', function() {
                const previewContainer = $('#exam-preview-content');
                const examTitle = $('#exam-title').val() || 'Untitled Exam';
                const examType = $('#exam-type').val();
                const duration = $('#exam-duration').val();
                
                previewContainer.empty();
                
                if (questions.length === 0) {
                    previewContainer.html('<p class="text-center text-muted">No questions added yet.</p>');
                    return;
                }

                let previewHtml = `
                    <div class="text-center mb-4">
                        <h4>${examTitle}</h4>
                        <p class="text-muted">${examType} | Duration: ${duration} minutes | Total Questions: ${questions.length}</p>
                        <hr>
                    </div>
                `;

                questions.forEach((q, index) => {
                    previewHtml += `
                        <div class="mb-4 p-3 border rounded question-preview">
                            <h6>Q${index + 1}: (${q.points} points) - ${q.skill.toUpperCase()}</h6>
                            <p class="mb-3"><strong>${q.question}</strong></p>
                    `;

                    // Show audio for listening questions
                    if (q.type === 'listening' && q.audioFileName) {
                        previewHtml += `
                            <div class="audio-preview mb-3">
                                <p class="text-muted mb-2"><i class="bi bi-headphones"></i> Listening Audio: ${q.audioFileName}</p>
                                <div class="alert alert-info">
                                    <small><i class="bi bi-info-circle"></i> Audio file will be available during the actual test</small>
                                </div>
                            </div>
                        `;
                    }

                    switch(q.type) {
                        case 'multiple-choice':
                        case 'listening':
                            q.options.forEach((opt, optIndex) => {
                                const correctIndicator = opt.isCorrect ? '<span class="correct-answer-indicator"> ✓ Correct</span>' : '';
                                previewHtml += `
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="preview-q${index}" id="preview-q${index}-opt${optIndex}">
                                        <label class="form-check-label" for="preview-q${index}-opt${optIndex}">
                                            ${opt.text} ${correctIndicator}
                                        </label>
                                    </div>
                                `;
                            });
                            break;
                        case 'true-false':
                            previewHtml += `
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="preview-q${index}" id="preview-q${index}-true">
                                    <label class="form-check-label" for="preview-q${index}-true">True</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="preview-q${index}" id="preview-q${index}-false">
                                    <label class="form-check-label" for="preview-q${index}-false">False</label>
                                </div>
                                <small class="text-muted">Correct answer: ${q.correctAnswer}</small>
                            `;
                            break;
                        case 'fill-blank':
                            previewHtml += `
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your answer...">
                                </div>
                                <small class="text-muted">Correct answer: ${q.correctAnswer}</small>
                            `;
                            break;
                        case 'essay':
                            previewHtml += `
                                <div class="form-group">
                                    <textarea class="form-control" rows="4" placeholder="Write your answer here..."></textarea>
                                </div>
                            `;
                            break;
                        case 'matching':
                            previewHtml += `<div class="matching-preview">`;
                            q.pairs.forEach((pair, pairIndex) => {
                                previewHtml += `
                                    <div class="d-flex gap-2 mb-2">
                                        <div class="flex-fill p-2 border rounded">${pair.item}</div>
                                        <div class="flex-fill p-2 border rounded bg-light">${pair.answer}</div>
                                    </div>
                                `;
                            });
                            previewHtml += `</div>`;
                            break;
                        case 'ordering':
                            previewHtml += `<div class="ordering-preview">`;
                            q.items.forEach((item, itemIndex) => {
                                previewHtml += `
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="badge bg-secondary">${itemIndex + 1}</span>
                                        <div class="flex-fill p-2 border rounded">${item}</div>
                                    </div>
                                `;
                            });
                            previewHtml += `</div>`;
                            break;
                    }

                    previewHtml += `</div>`;
                });

                previewContainer.html(previewHtml);
            });

            // Save exam functions
            $('#save-draft-btn').on('click', function() {
                saveExam('draft');
            });

            $('#save-add-another-btn').on('click', function() {
                saveExam('published', true);
            });

            $('#save-back-btn').on('click', function() {
                saveExam('published', false);
            });

function saveExam(status, addAnother = false) {
    const examData = {
        title: $('#exam-title').val(),
        type: $('#exam-type').val(),
        category: $('#exam-category').val(),
        duration: $('#exam-duration').val(),
        status: status
    };

    // Validation
    if (!examData.title || !examData.category || questions.length === 0) {
        alert('Please fill all required fields and add at least one question!');
        return;
    }

    showLoading();

    // Create FormData
    const formData = new FormData();
    formData.append('title', examData.title);
    formData.append('type', examData.type);
    formData.append('category', examData.category);
    formData.append('duration', examData.duration);
    formData.append('status', examData.status);

    console.log('=== SENDING QUESTIONS DATA ===');
    
    // Process questions dengan format yang benar untuk file audio
    questions.forEach((question, index) => {
        // Create clean question object
        const questionData = { 
            type: question.type || 'multiple-choice',
            question: question.question || '',
            points: question.points || 10,
            skill: question.skill || 'reading'
        };

        // Add type-specific data
        if (question.options && question.options.length > 0) {
            questionData.options = question.options.map(opt => ({
                text: opt.text || '',
                isCorrect: opt.isCorrect || false
            }));
        }
        
        if (question.correctAnswer !== null && question.correctAnswer !== undefined) {
            questionData.correctAnswer = question.correctAnswer;
        }

        // Debug setiap question
        console.log(`Question ${index}:`, {
            type: questionData.type,
            skill: questionData.skill,
            question: questionData.question,
            points: questionData.points,
            hasAudio: !!question.audioFile,
            audioFile: question.audioFile ? question.audioFile.name : 'No file'
        });

        // Append question data sebagai JSON string
        formData.append(`questions[${index}]`, JSON.stringify(questionData));
        
        // **FIX: Append audio file dengan key yang sederhana**
        if (question.audioFile) {
            // Gunakan key yang sederhana tanpa nested array
            formData.append(`audio_${index}`, question.audioFile);
            console.log(`✓ Added audio file for question ${index}:`, question.audioFile.name);
        }
    });

    console.log('Total questions to send:', questions.length);
    console.log('FormData entries:');
    for (let pair of formData.entries()) {
        if (typeof pair[1] === 'string') {
            console.log(pair[0] + ': ', pair[1].substring(0, 100) + '...');
        } else {
            console.log(pair[0] + ': ', pair[1].name || 'File');
        }
    }

    // Send request
    $.ajax({
        url: '/dashboard/exams',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            hideLoading();
            
            if (data.success) {
                Toastify({
                    text: `Exam "${examData.title}" saved successfully!`,
                    duration: 5000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    style: { background: "#10b981" }
                }).showToast();
                
                if (!addAnother) {
                    setTimeout(() => {
                        window.location.href = '/exam-list';
                    }, 2000);
                } else {
                    questions = [];
                    updateQuestionList();
                }
            } else {
                throw new Error(data.message || 'Unknown error occurred');
            }
        },
        error: function(xhr, status, error) {
            hideLoading();
            console.error('Error saving exam:', error);
            console.log('Response:', xhr.responseText);
            
            Toastify({
                text: 'Failed to save exam: ' + error,
                duration: 5000,
                close: true,
                gravity: "top",
                position: "right", 
                style: { background: "#ef4444" }
            }).showToast();
        }
    });
}
            // Load existing exams
            function loadExistingExams() {
                fetch('/dashboard/exams')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const select = $('#existing-exam');
                            select.empty();
                            select.append('<option value="">Start a new exam</option>');
                            
                            data.exams.forEach(exam => {
                                const statusBadge = exam.status === 'published' ? ' (Published)' : ' (Draft)';
                                select.append(`<option value="${exam.id}">${exam.exam_title}${statusBadge}</option>`);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error loading exams:', error);
                    });
            }

            // Load existing exam when selected
            $('#existing-exam').on('change', function() {
                const examId = $(this).val();
                if (examId) {
                    showLoading();
                    fetch(`/dashboard/exams/${examId}`)
                        .then(response => response.json())
                        .then(data => {
                            hideLoading();
                            if (data.success) {
                                // Populate form with existing exam data
                                $('#exam-title').val(data.exam.exam_title);
                                $('#exam-type').val(data.exam.exam_type);
                                $('#exam-category').val(data.exam.exam_category);
                                $('#exam-duration').val(data.exam.duration_minutes);
                                
                                // Load questions
                                questions = data.questions;
                                updateQuestionList();
                                
                                Toastify({
                                    text: "Exam loaded successfully!",
                                    duration: 3000,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "#10b981",
                                }).showToast();
                            }
                        })
                        .catch(error => {
                            hideLoading();
                            console.error('Error loading exam:', error);
                        });
                } else {
                    // Clear form if "Start new exam" is selected
                    $('#exam-title').val('');
                    $('#exam-category').val('');
                    questions = [];
                    updateQuestionList();
                }
            });

            // CSV Import
// CSV Import - COMPLETE FIXED VERSION
$('#import-file').on('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    // Confirm sebelum replace questions
    if (questions.length > 0) {
        if (!confirm(`You have ${questions.length} existing questions. Replace with CSV import?`)) {
            $(this).val('');
            return;
        }
        questions = [];
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        try {
            const csvData = e.target.result;
            const lines = csvData.split('\n').filter(line => line.trim());
            
            if (lines.length < 2) {
                throw new Error('CSV file is empty or has no data');
            }

            const headers = lines[0].split(',').map(h => h.trim().toLowerCase());
            const importedQuestions = [];
            
            console.log('CSV Headers:', headers);

            for (let i = 1; i < lines.length; i++) {
                if (lines[i].trim()) {
                    const values = lines[i].split(',').map(v => v.trim());
                    
                    if (values.length >= 4) {
                        const questionData = {
                            type: values[0] || 'multiple-choice',
                            question: values[1] || '',
                            points: parseInt(values[2]) || 10,
                            skill: values[3] || 'reading',
                            options: [],
                            correctAnswer: null,
                            fromCSV: true // Flag untuk menandai dari CSV
                        };

                        console.log(`Processing row ${i}:`, questionData);

                        // Process options untuk multiple choice & listening
                        if (questionData.type === 'multiple-choice' || questionData.type === 'listening') {
                            // Process options dari kolom 4-7 (option1-option4)
                            for (let j = 4; j <= 7; j++) {
                                if (values[j] && values[j].trim() !== '') {
                                    const isCorrect = (values[8] && parseInt(values[8]) === (j - 3));
                                    questionData.options.push({
                                        text: values[j],
                                        isCorrect: isCorrect
                                    });
                                    
                                    if (isCorrect) {
                                        questionData.correctAnswer = questionData.options.length - 1;
                                    }
                                }
                            }
                            console.log(`Added ${questionData.options.length} options`);
                        }
                        
                        // Process correct answer untuk true/false & fill-blank
                        else if (questionData.type === 'true-false' || questionData.type === 'fill-blank') {
                            if (values[9] && values[9].trim() !== '') {
                                questionData.correctAnswer = values[9];
                            }
                        }
                        
                        // Process matching pairs
                        else if (questionData.type === 'matching') {
                            questionData.pairs = [];
                            for (let j = 4; j <= 7; j++) {
                                if (values[j] && values[j].includes(':')) {
                                    const [item, answer] = values[j].split(':').map(v => v.trim());
                                    if (item && answer) {
                                        questionData.pairs.push({ item, answer });
                                    }
                                }
                            }
                        }
                        
                        // Process ordering items
                        else if (questionData.type === 'ordering') {
                            questionData.items = [];
                            for (let j = 4; j <= 7; j++) {
                                if (values[j] && values[j].trim() !== '') {
                                    questionData.items.push(values[j]);
                                }
                            }
                        }

                        // Auto-correct skill category berdasarkan type
                        if (questionData.type === 'listening') {
                            questionData.skill = 'listening';
                        } else if (questionData.type === 'essay') {
                            questionData.skill = 'writing';
                        }

                        importedQuestions.push(questionData);
                    }
                }
            }

            if (importedQuestions.length > 0) {
                importedQuestions.forEach(q => questions.push(q));
                updateQuestionList();
                
                Toastify({
                    text: `✅ ${importedQuestions.length} questions imported successfully!`,
                    duration: 5000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    style: { background: "#10b981" }
                }).showToast();
                
                console.log('Imported questions:', importedQuestions);
                
            } else {
                Toastify({
                    text: "❌ No valid questions found in CSV file",
                    duration: 5000,
                    close: true,
                    gravity: "top", 
                    position: "right",
                    style: { background: "#ef4444" }
                }).showToast();
            }
            
        } catch (error) {
            console.error('Error parsing CSV:', error);
            Toastify({
                text: `❌ Failed to parse CSV: ${error.message}`,
                duration: 5000,
                close: true,
                gravity: "top",
                position: "right",
                style: { background: "#ef4444" }
            }).showToast();
        }
    };
    reader.readAsText(file);
    $(this).val('');
});
            // Load existing exams when page loads
            loadExistingExams();
        });
    </script>
</body>
</html>