<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placement Test Results - Admin Dashboard</title>
    <link rel="shortcut icon" href="{{ asset('assets/compiled/svg/fav.jpg') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #7c3aed;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .page-heading {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: none;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 1rem;
        }

        .test-type-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .test-type-badge:hover {
            transform: scale(1.05);
        }
        
        .toeic-badge { background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); color: #1976d2; }
        .ielts-badge { background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); color: #388e3c; }
        .practical-badge { background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); color: #f57c00; }
        .business-badge { background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%); color: #7b1fa2; }
        .basic-badge { background: linear-gradient(135deg, #e0f2f1 0%, #b2dfdb 100%); color: #00796b; }
        .toefl-badge { background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%); color: #ff8f00; }
        .academic-badge { background: linear-gradient(135deg, #fce4ec 0%, #f8bbd9 100%); color: #c2185b; }
        
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            position: relative;
            z-index: 1;
        }
        
        #resultsTable {
            margin-bottom: 0;
            font-size: 13px;
            pointer-events: auto !important;
        }
        
        #resultsTable thead {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        #resultsTable th {
            color: white !important;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
            border: none;
            white-space: nowrap;
            padding: 16px 12px;
            pointer-events: auto !important;
        }
        
        #resultsTable td {
            vertical-align: middle;
            padding: 14px 12px;
            white-space: nowrap;
            border-bottom: 1px solid #f3f4f6;
            pointer-events: auto !important;
        }
        
        #resultsTable tbody {
            position: relative;
            z-index: auto;
        }
        
        #resultsTable tbody tr {
            transition: all 0.2s ease;
            pointer-events: auto !important;
        }

        #resultsTable tbody tr:hover {
            background: linear-gradient(90deg, rgba(79, 70, 229, 0.05) 0%, rgba(124, 58, 237, 0.05) 100%);
        }

        /* CRITICAL: Action buttons styles */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            position: relative;
            z-index: 100 !important;
            pointer-events: auto !important;
        }

        .btn-action {
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer !important;
            pointer-events: auto !important;
            position: relative;
            z-index: 101 !important;
            min-width: 40px;
            min-height: 40px;
        }

        .btn-action:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .btn-action:active {
            transform: translateY(0) scale(0.98);
        }

        .btn-action i {
            pointer-events: none;
            font-size: 16px;
        }

        .btn-view { 
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); 
            color: white !important; 
        }
        
        .btn-view:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        .btn-certificate { 
            background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
            color: white !important; 
        }
        
        .btn-certificate:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }

        .btn-edit { 
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); 
            color: white !important; 
        }
        
        .btn-edit:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        }

        .btn-delete { 
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); 
            color: white !important; 
        }
        
        .btn-delete:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        }

        #resultsTable tbody tr:hover .action-buttons {
            z-index: 102 !important;
        }

        #resultsTable tbody tr td:last-child {
            position: relative;
            z-index: 50;
        }

        .filter-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .filter-card .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .filter-card .form-control, .filter-card .form-select {
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .filter-card .form-control:focus, .filter-card .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 1.5rem 2rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .detail-section {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 2px solid #e5e7eb;
        }

        .detail-section h6 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--primary-color);
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #4b5563;
            flex: 0 0 40%;
        }

        .detail-value {
            color: #1f2937;
            text-align: right;
            flex: 0 0 60%;
            word-break: break-word;
        }
        
        .score-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            color: white;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        }

        .score-box .score-value {
            font-size: 3rem;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
        }

        .status-online {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding-left: 2.5rem;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .page-content {
            position: relative;
            z-index: auto;
        }

        @media (max-width: 768px) {
            .btn-action {
                padding: 6px 10px;
                min-width: 36px;
                min-height: 36px;
                font-size: 12px;
            }
            
            .btn-action i {
                font-size: 14px;
            }
            
            .action-buttons {
                gap: 4px;
            }
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
                            <a href="/dashboard-admin">
                                <img src="{{ asset('assets/compiled/png/logo.png') }}" alt="Logo" style="height: 60px; width: auto;">
                            </a>
                        </div>
                        <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"></path>
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
                            <a href="/dashboard/admin" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Overview</span>
                            </a>
                        </li>

                        <li class="sidebar-item active">
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
            
            <div class="page-heading animate-fade-in">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h3><i class="bi bi-award-fill me-2"></i>Placement Test Results</h3>
                        <p class="text-muted mb-0">Complete management system for all test results</p>
                    </div>
                    <div class="status-badge status-online mt-2">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        System Online
                    </div>
                </div>
            </div>
            
            <div class="page-content">
                <!-- Statistics Cards -->
                <div class="row mb-4 animate-fade-in">
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="bi bi-file-text text-white"></i>
                            </div>
                            <h6 class="text-muted mb-1">Total Results</h6>
                            <h3 class="mb-0" style="color: var(--primary-color);">{{ $resultsCount }}</h3>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                <i class="bi bi-calendar-check text-white"></i>
                            </div>
                            <h6 class="text-muted mb-1">This Month</h6>
                            <h3 class="mb-0" style="color: var(--success-color);">{{ collect($results)->where('test_date', '>=', now()->startOfMonth())->count() }}</h3>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                <i class="bi bi-graph-up text-white"></i>
                            </div>
                            <h6 class="text-muted mb-1">This Week</h6>
                            <h3 class="mb-0" style="color: var(--warning-color);">{{ collect($results)->where('test_date', '>=', now()->startOfWeek())->count() }}</h3>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                                <i class="bi bi-people text-white"></i>
                            </div>
                            <h6 class="text-muted mb-1">Test Types</h6>
                            <h3 class="mb-0" style="color: var(--info-color);">8</h3>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="filter-card animate-fade-in">
                    <h5 class="mb-4"><i class="bi bi-funnel-fill me-2"></i>Filter & Search</h5>
                    <form method="GET" action="{{ url('/placement-results') }}">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="testType" class="form-label">Test Type</label>
                                <select class="form-select" id="testType" name="test_type">
                                    @foreach($testTypes as $key => $value)
                                        <option value="{{ $key }}" {{ $testType == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="dateFrom" class="form-label">Date From</label>
                                <input type="date" class="form-control" id="dateFrom" name="date_from" value="{{ $dateFrom }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="dateTo" class="form-label">Date To</label>
                                <input type="date" class="form-control" id="dateTo" name="date_to" value="{{ $dateTo }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Actions</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-grow-1">
                                        <i class="bi bi-search me-1"></i> Apply
                                    </button>
                                    <a href="{{ url('/placement-results') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-3">
                        <div class="col-md-6 mb-2">
                            <button type="button" class="btn btn-success" onclick="exportToCSV()">
                                <i class="bi bi-file-earmark-excel me-1"></i> Export to CSV
                            </button>
                            <button type="button" class="btn btn-info ms-2" onclick="printTable()">
                                <i class="bi bi-printer me-1"></i> Print Table
                            </button>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="search-box">
                                <i class="bi bi-search"></i>
                                <input type="text" class="form-control" id="searchInput" placeholder="Search by name, email, or phone...">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 text-end">
                            <span class="text-muted">
                                <i class="bi bi-clock-history me-1"></i>
                                Last updated: {{ now()->format('M d, Y H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Results Table -->
                <div class="table-container animate-fade-in">
                    <div class="p-4 border-bottom" style="background: linear-gradient(90deg, rgba(79, 70, 229, 0.05) 0%, rgba(124, 58, 237, 0.05) 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-table me-2"></i>Test Results
                            </h5>
                            <span class="badge bg-primary" style="font-size: 14px; padding: 8px 16px;">
                                {{ $resultsCount }} results
                            </span>
                        </div>
                    </div>
                    
                    @if($resultsCount > 0)
                    <div style="overflow-x: auto;">
                        <table class="table table-hover mb-0" id="resultsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone/WhatsApp</th>
                                    <th>Test Type</th>
                                    <th>Overall Score</th>
                                    <th>Level</th>
                                    <th>Band/Percentage</th>
                                    <th>Listening</th>
                                    <th>Reading</th>
                                    <th>Writing</th>
                                    <th>Speaking</th>
                                    <th>Grammar</th>
                                    <th>Vocabulary</th>
                                    <th>Pronunciation</th>
                                    <th>Test Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="resultsTableBody">
                             @foreach($results as $result)
                                    <tr>
                                        <td><strong>#{{ $result['id'] }}</strong></td>
                                        <td>{{ $result['name'] }}</td>
                                        <td>{{ $result['email'] }}</td>
                                        <td>{{ $result['phone'] }}</td>
                                        <td>
                                            <span class="test-type-badge {{ getBadgeClass($result['test_type']) }}">
                                                {{ strtoupper($result['test_type']) }}
                                            </span>
                                        </td>
                                        <td><strong>{{ $result['overall_score'] }}</strong></td>
                                        <td>{{ $result['level'] }}</td>
                                        <td>{{ formatScoreDisplay($result) }}</td>
                                        <td>{{ getSkillScore($result, 'listening') }}</td>
                                        <td>{{ getSkillScore($result, 'reading') }}</td>
                                        <td>{{ getSkillScore($result, 'writing') }}</td>
                                        <td>{{ getSkillScore($result, 'speaking') }}</td>
                                        <td>{{ getSkillScore($result, 'grammar') }}</td>
                                        <td>{{ getSkillScore($result, 'vocab') }}</td>
                                        <td>{{ getSkillScore($result, 'pronoun') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($result['test_date'])->format('M d, Y') }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button type="button" class="btn-action btn-view btn-view-detail" 
                                                        data-id="{{ $result['id'] }}"
                                                        data-test-type="{{ $result['test_type'] }}"
                                                        title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                
                                                <button type="button" class="btn-action btn-certificate btn-generate-cert" 
                                                        data-id="{{ $result['id'] }}"
                                                        data-test-type="{{ $result['test_type'] }}"
                                                        title="Download Certificate">
                                                    <i class="bi bi-award"></i>
                                                </button>
                                                
                                                <button type="button" class="btn-action btn-edit btn-edit-result" 
                                                        data-id="{{ $result['id'] }}"
                                                        data-test-type="{{ $result['test_type'] }}"
                                                        title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                
                                                <button type="button" class="btn-action btn-delete btn-delete-result" 
                                                        data-id="{{ $result['id'] }}"
                                                        data-test-type="{{ $result['test_type'] }}"
                                                        title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 64px; color: #d1d5db;"></i>
                        <p class="text-muted mt-3">No results found</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <footer class="mt-5">
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2025 @Kampong Inggris Pare</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-info-circle me-2"></i>Test Result Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printDetails()">
                        <i class="bi bi-printer me-1"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Test Result</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="editModalBody">
                    <form id="editForm">
                        <input type="hidden" id="edit_id">
                        <input type="hidden" id="edit_test_type">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="edit_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit_email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone/WhatsApp</label>
                                <input type="text" class="form-control" id="edit_phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Overall Score</label>
                                <input type="text" class="form-control" id="edit_overall_score">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Level</label>
                                <input type="text" class="form-control" id="edit_level">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Test Date</label>
                                <input type="date" class="form-control" id="edit_test_date">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveEdit()">
                        <i class="bi bi-check-lg me-1"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
     <script>
        let allResults = @json($results);
        let currentResult = null;

        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Placement Results System Initialized');
            console.log('📊 Total results loaded:', allResults.length);
            
            // Initialize
            initializeDateInputs();
            initializeSearch();
            initializeButtons();
            
            console.log('✅ All systems ready!');
        });

        function initializeDateInputs() {
            const today = new Date();
            const thirtyDaysAgo = new Date();
            thirtyDaysAgo.setDate(today.getDate() - 30);
            
            const dateFromInput = document.getElementById('dateFrom');
            const dateToInput = document.getElementById('dateTo');
            
            if (dateFromInput && !dateFromInput.value) {
                dateFromInput.value = thirtyDaysAgo.toISOString().split('T')[0];
            }
            if (dateToInput && !dateToInput.value) {
                dateToInput.value = today.toISOString().split('T')[0];
            }
        }

        function initializeSearch() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', filterTable);
            }
        }

        function initializeButtons() {
            console.log('🔧 Initializing buttons...');
            
            // Get all buttons
            const viewButtons = document.querySelectorAll('.btn-view-detail');
            const certButtons = document.querySelectorAll('.btn-generate-cert');
            const editButtons = document.querySelectorAll('.btn-edit-result');
            const deleteButtons = document.querySelectorAll('.btn-delete-result');
            
            console.log('Found buttons:', {
                view: viewButtons.length,
                cert: certButtons.length,
                edit: editButtons.length,
                delete: deleteButtons.length
            });
            
            // Attach direct listeners - FIXED VERSION
            viewButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('👁️ View clicked');
                    try {
                        const id = this.getAttribute('data-id');
                        const testType = this.getAttribute('data-test-type');
                        viewDetails(id, testType);
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error loading details');
                    }
                });
            });
            
            certButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('🏆 Certificate clicked');
                    try {
                        const id = this.getAttribute('data-id');
                        const testType = this.getAttribute('data-test-type');
                        generateCertificate(id, testType);
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error generating certificate');
                    }
                });
            });
            
            editButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('✏️ Edit clicked');
                    const id = this.getAttribute('data-id');
                    const testType = this.getAttribute('data-test-type');
                    editResult(id, testType);
                });
            });
            
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('🗑️ Delete clicked');
                    const id = this.getAttribute('data-id');
                    const testType = this.getAttribute('data-test-type');
                    deleteResult(id, testType);
                });
            });
            
            console.log('✅ Buttons initialized successfully');
        }

        function filterTable() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#resultsTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        }

        // FIXED: Find result by ID and test type instead of parsing JSON
        function findResult(id, testType) {
            const result = allResults.find(r => 
                String(r.id) === String(id) && r.test_type === testType
            );
            
            if (!result) {
                console.error('Result not found:', { id, testType, allResults });
                throw new Error(`Result not found: ID ${id}, Type ${testType}`);
            }
            
            return result;
        }

        // UPDATED: View details function
        function viewDetails(id, testType) {
            console.log('📋 Opening details for:', id, testType);
            
            try {
                const result = findResult(id, testType);
                currentResult = result;
                
                const modalBody = document.getElementById('detailModalBody');
                if (!modalBody) {
                    console.error('Modal body not found');
                    return;
                }
                
                let html = '<div class="row">';
                
                // Student Information
                html += '<div class="col-md-6 mb-3">';
                html += '<div class="detail-section">';
                html += '<h6><i class="bi bi-person-fill me-2"></i>Student Information</h6>';
                html += '<div class="detail-row"><span class="detail-label">ID:</span><span class="detail-value">' + result.id + '</span></div>';
                html += '<div class="detail-row"><span class="detail-label">Name:</span><span class="detail-value">' + (result.name || 'N/A') + '</span></div>';
                html += '<div class="detail-row"><span class="detail-label">Email:</span><span class="detail-value">' + (result.email || 'N/A') + '</span></div>';
                html += '<div class="detail-row"><span class="detail-label">Phone/WhatsApp:</span><span class="detail-value">' + (result.phone || 'N/A') + '</span></div>';
                html += '<div class="detail-row"><span class="detail-label">Test Date:</span><span class="detail-value">' + formatDate(result.test_date) + '</span></div>';
                html += '<div class="detail-row"><span class="detail-label">Test Type:</span><span class="detail-value"><span class="test-type-badge ' + getBadgeClass(result.test_type) + '">' + result.test_type.toUpperCase() + '</span></span></div>';
                html += '</div></div>';
                
                // Overall Score
                html += '<div class="col-md-6 mb-3">';
                html += '<div class="score-box">';
                html += '<div class="score-value">' + (result.overall_score || 'N/A') + '</div>';
                html += '<div class="score-label">' + (result.level || 'Overall Score') + '</div>';
                if (result.overall_band) {
                    html += '<div class="mt-2">Band: ' + result.overall_band + '</div>';
                }
                if (result.percentage || result.total_percentage) {
                    html += '<div class="mt-2">Percentage: ' + (result.percentage || result.total_percentage) + '%</div>';
                }
                html += '</div></div></div>';
                
                // Skills Breakdown
                html += '<div class="row mt-3">';
                html += '<div class="col-12"><h5 class="mb-3"><i class="bi bi-bar-chart-fill me-2"></i>Skills Breakdown</h5></div>';
                
                const skills = [
                    { key: 'listening', label: 'Listening', icon: 'headphones' },
                    { key: 'reading', label: 'Reading', icon: 'book' },
                    { key: 'writing', label: 'Writing', icon: 'pencil' },
                    { key: 'speaking', label: 'Speaking', icon: 'mic' },
                    { key: 'grammar', label: 'Grammar', icon: 'check2-square' },
                    { key: 'vocab', label: 'Vocabulary', icon: 'chat-quote' },
                    { key: 'pronoun', label: 'Pronunciation', icon: 'volume-up' }
                ];
                
                let hasSkills = false;
                
                skills.forEach(skill => {
                    const score = getSkillScore(result, skill.key);
                    let percentage = null;
                    let level = null;
                    
                    if (skill.key === 'pronoun') {
                        percentage = result.pronoun_percentage || result.pronunciation_percentage;
                        level = result.pronoun_level || result.pronunciation_level;
                    } else {
                        percentage = result[skill.key + '_percentage'] || result[skill.key + '_percent'];
                        level = result[skill.key + '_level'];
                    }
                    
                    if (score !== '-' || percentage || level) {
                        hasSkills = true;
                        html += '<div class="col-md-3 mb-3"><div class="detail-section">';
                        html += '<h6><i class="bi bi-' + skill.icon + ' me-2"></i>' + skill.label + '</h6>';
                        html += '<div class="detail-row"><span class="detail-label">Score:</span><span class="detail-value"><strong>' + score + '</strong></span></div>';
                        
                        if (percentage) {
                            html += '<div class="detail-row"><span class="detail-label">Accuracy:</span><span class="detail-value">' + percentage + '%</span></div>';
                        }
                        if (level) {
                            html += '<div class="detail-row"><span class="detail-label">Level:</span><span class="detail-value">' + level + '</span></div>';
                        }
                        html += '</div></div>';
                    }
                });
                
                if (!hasSkills) {
                    html += '<div class="col-12"><p class="text-muted">No skill breakdown available</p></div>';
                }
                
                html += '</div>';
                
                modalBody.innerHTML = html;
                
                const modal = new bootstrap.Modal(document.getElementById('detailModal'));
                modal.show();
                
            } catch (error) {
                console.error('Error in viewDetails:', error);
                alert('Error loading details: ' + error.message);
            }
        }

        // UPDATED: Generate certificate function
        async function generateCertificate(id, testType) {
            console.log('🏆 Generating certificate for:', id, testType);
            
            try {
                const result = findResult(id, testType);
                
                // Check if jsPDF is available
                if (typeof window.jspdf === 'undefined') {
                    console.error('jsPDF not found, loading from CDN');
                    await loadJSPDF();
                }
                
                console.log('📦 jsPDF loaded successfully');
                
                // Generate certificate
                await generatePDFCertificate(result);
                
                console.log('✅ Certificate generated successfully!');
                
            } catch (error) {
                console.error('❌ Error generating certificate:', error);
                alert('❌ Error generating certificate: ' + error.message);
            }
        }

        function loadJSPDF() {
            return new Promise((resolve, reject) => {
                if (typeof window.jspdf !== 'undefined') {
                    resolve();
                    return;
                }
                
                const script = document.createElement('script');
                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
                script.onload = () => {
                    console.log('✅ jsPDF loaded from CDN');
                    resolve();
                };
                script.onerror = () => {
                    reject(new Error('Failed to load jsPDF from CDN'));
                };
                document.head.appendChild(script);
            });
        }

        function generatePDFCertificate(result) {
            return new Promise((resolve, reject) => {
                try {
                    console.log('📄 Starting PDF generation...');
                    
                    // Check jsPDF
                    if (typeof window.jspdf === 'undefined') {
                        throw new Error('jsPDF not available');
                    }
                    
                    const { jsPDF } = window.jspdf;
                    
                    // Create new PDF
                    const doc = new jsPDF({
                        orientation: 'portrait',
                        unit: 'mm',
                        format: 'a4'
                    });
                    
                    console.log('📋 PDF document created');
                    
                    const pageWidth = doc.internal.pageSize.getWidth();
                    const pageHeight = doc.internal.pageSize.getHeight();
                    const margin = 15;
                    
                    console.log('📏 Page dimensions:', pageWidth, 'x', pageHeight);

                    // Background
                    doc.setFillColor(248, 250, 252);
                    doc.rect(0, 0, pageWidth, pageHeight, 'F');

                    // Border
                    doc.setDrawColor(59, 130, 246);
                    doc.setLineWidth(2);
                    doc.rect(margin, margin, pageWidth - 2*margin, pageHeight - 2*margin);

                    doc.setDrawColor(99, 102, 241);
                    doc.setLineWidth(0.5);
                    doc.rect(margin + 3, margin + 3, pageWidth - 2*(margin + 3), pageHeight - 2*(margin + 3));

                    let yPos = margin + 25;

                    // Header background
                    doc.setFillColor(30, 58, 138);
                    doc.rect(margin + 5, yPos - 15, pageWidth - 2*(margin + 5), 40, 'F');

                    // Title
                    doc.setFontSize(22);
                    doc.setTextColor(255, 255, 255);
                    doc.setFont('helvetica', 'bold');
                    doc.text('CERTIFICATE OF ACHIEVEMENT', pageWidth / 2, yPos, { align: 'center' });
                    
                    // Subtitle
                    doc.setFontSize(14);
                    doc.setTextColor(200, 220, 255);
                    doc.setFont('helvetica', 'normal');
                    const testTypeUpper = (result.test_type || 'ENGLISH').toUpperCase();
                    doc.text(testTypeUpper + ' PROFICIENCY ASSESSMENT', pageWidth / 2, yPos + 8, { align: 'center' });
                    
                    // Golden line
                    doc.setDrawColor(255, 215, 0);
                    doc.setLineWidth(1.5);
                    doc.line(margin + 20, yPos + 15, pageWidth - (margin + 20), yPos + 15);
                    
                    yPos += 35;

                    // Presented to
                    doc.setFontSize(14);
                    doc.setTextColor(51, 65, 85);
                    doc.setFont('helvetica', 'bold');
                    doc.text('This certificate is proudly presented to:', pageWidth / 2, yPos, { align: 'center' });
                    yPos += 15;

                    // Name
                    doc.setFontSize(24);
                    doc.setTextColor(30, 58, 138);
                    doc.setFont('helvetica', 'bold');
                    const nameUpper = (result.name || 'Test Taker').toUpperCase();
                    doc.text(nameUpper, pageWidth / 2, yPos, { align: 'center' });
                    yPos += 20;

                    // Achievement description
                    doc.setFontSize(11);
                    doc.setTextColor(71, 85, 105);
                    doc.setFont('helvetica', 'normal');
                    const achievementDesc = 'for successfully completing the ' + testTypeUpper + 
                                          ' Test with proficiency at ' + (result.level || result.overall_score || 'Intermediate') + ' level';
                    const lines = doc.splitTextToSize(achievementDesc, pageWidth - 60);
                    doc.text(lines, pageWidth / 2, yPos, { align: 'center' });
                    yPos += lines.length * 7 + 10;

                    // Divider line
                    doc.setDrawColor(99, 102, 241);
                    doc.setLineWidth(0.5);
                    doc.line(margin + 15, yPos, pageWidth - (margin + 15), yPos);
                    yPos += 12;

                    // Test Results Section
                    doc.setFontSize(12);
                    doc.setTextColor(30, 58, 138);
                    doc.setFont('helvetica', 'bold');
                    doc.text('TEST RESULTS', pageWidth / 2, yPos, { align: 'center' });
                    yPos += 10;

                    // Results box
                    doc.setDrawColor(99, 102, 241);
                    doc.setLineWidth(0.3);
                    doc.setFillColor(249, 250, 251);
                    doc.rect(margin + 20, yPos - 5, pageWidth - 2*(margin + 20), 45, 'FD');

                    doc.setFontSize(10);
                    doc.setTextColor(51, 65, 85);

                    let resultY = yPos + 2;
                    
                    // Test Date
                    doc.setFont('helvetica', 'bold');
                    doc.text('Test Date:', margin + 25, resultY);
                    doc.setFont('helvetica', 'normal');
                    doc.text(formatCertificateDate(result.test_date), margin + 55, resultY);
                    resultY += 8;

                    // Overall Score
                    doc.setFont('helvetica', 'bold');
                    doc.text('Overall Score:', margin + 25, resultY);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(30, 58, 138);
                    doc.text(String(result.overall_score || 'N/A'), margin + 55, resultY);
                    doc.setTextColor(51, 65, 85);
                    resultY += 8;

                    // Level
                    if (result.level) {
                        doc.setFont('helvetica', 'bold');
                        doc.text('Level:', margin + 25, resultY);
                        doc.setFont('helvetica', 'normal');
                        doc.text(String(result.level), margin + 55, resultY);
                        resultY += 8;
                    }

                    // Band or Percentage
                    if (result.overall_band) {
                        doc.setFont('helvetica', 'bold');
                        doc.text('Band Score:', margin + 25, resultY);
                        doc.setFont('helvetica', 'normal');
                        doc.text(String(result.overall_band), margin + 55, resultY);
                    } else if (result.percentage || result.total_percentage) {
                        doc.setFont('helvetica', 'bold');
                        doc.text('Percentage:', margin + 25, resultY);
                        doc.setFont('helvetica', 'normal');
                        doc.text((result.percentage || result.total_percentage) + '%', margin + 55, resultY);
                    }

                    yPos += 50;

                    // Skills breakdown
                    const skills = [
                        { key: 'listening', label: 'Listening' },
                        { key: 'reading', label: 'Reading' },
                        { key: 'writing', label: 'Writing' },
                        { key: 'speaking', label: 'Speaking' }
                    ];

                    let skillsText = [];
                    skills.forEach(skill => {
                        const score = getSkillScore(result, skill.key);
                        if (score !== '-') {
                            skillsText.push(skill.label + ': ' + score);
                        }
                    });

                    if (skillsText.length > 0) {
                        doc.setFontSize(9);
                        doc.setTextColor(71, 85, 105);
                        doc.text(skillsText.join(' | '), pageWidth / 2, yPos, { align: 'center' });
                        yPos += 8;
                    }

                    // Bottom section
                    const bottomY = pageHeight - margin - 40;
                    
                    // Divider line
                    doc.setDrawColor(59, 130, 246);
                    doc.setLineWidth(1);
                    doc.line(margin + 5, bottomY, pageWidth - (margin + 5), bottomY);

                    // Signature area
                    let signY = bottomY + 15;

                    // Signature line
                    doc.setDrawColor(100, 100, 100);
                    doc.setLineWidth(0.3);
                    doc.line(pageWidth/2 - 30, signY + 5, pageWidth/2 + 30, signY + 5);
                    
                    // Signature label
                    doc.setFontSize(10);
                    doc.setTextColor(107, 114, 128);
                    doc.setFont('helvetica', 'italic');
                    doc.text('Director Signature', pageWidth / 2, signY + 12, { align: 'center' });

                    // Organization name
                    doc.setFontSize(11);
                    doc.setTextColor(30, 58, 138);
                    doc.setFont('helvetica', 'bold');
                    doc.text('Kampong Inggris Pare', pageWidth / 2, signY + 25, { align: 'center' });
                    
                    doc.setFontSize(8);
                    doc.setTextColor(100, 100, 100);
                    doc.setFont('helvetica', 'normal');
                    doc.text('English Language Center', pageWidth / 2, signY + 30, { align: 'center' });

                    // Certificate ID
                    doc.setFontSize(7);
                    doc.setTextColor(150, 150, 150);
                    doc.text('Certificate ID: ' + (result.test_type || 'test').toUpperCase() + '-' + (result.id || '000') + '-' + new Date().getFullYear(), 
                             pageWidth - margin - 5, pageHeight - margin - 5, { align: 'right' });

                    // Save PDF
                    const sanitizedName = (result.name || 'Test_Taker').replace(/[^a-zA-Z0-9]/g, '_');
                    const fileName = (result.test_type || 'test').toUpperCase() + '-Certificate-' + sanitizedName + '.pdf';
                    
                    console.log('💾 Saving PDF:', fileName);
                    doc.save(fileName);
                    
                    console.log('✅ PDF saved successfully!');
                    resolve(true);
                    
                } catch (error) {
                    console.error('❌ Error in PDF generation:', error);
                    reject(error);
                }
            });
        }

        // Helper functions
        function formatDate(dateStr) {
            if (!dateStr) return 'N/A';
            try {
                return new Date(dateStr).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
            } catch (e) {
                return dateStr;
            }
        }

        function formatCertificateDate(dateStr) {
            if (!dateStr) return 'N/A';
            try {
                const date = new Date(dateStr);
                return date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            } catch (e) {
                return dateStr;
            }
        }

        function getSkillScore(result, skill) {
            if (skill === 'pronoun') {
                const pronounKeys = [
                    'pronoun_score', 'pronoun_correct', 'pronoun_percentage',
                    'pronunciation_correct', 'pronunciation_score', 'pronunciation_percentage'
                ];
                
                for (let key of pronounKeys) {
                    if (result[key] !== undefined && result[key] !== null && result[key] !== '') {
                        return result[key];
                    }
                }
                return '-';
            }
            
            const keys = [
                skill + '_score', skill + '_correct', skill + '_percentage',
                skill + '_percent', skill + '_ielts', skill + '_toeic', skill + '_level'
            ];
            
            for (let key of keys) {
                if (result[key] !== undefined && result[key] !== null && result[key] !== '') {
                    return result[key];
                }
            }
            
            return '-';
        }

        function getBadgeClass(testType) {
            const map = {
                'toeic': 'toeic-badge',
                'ielts-a2': 'ielts-badge',
                'ielts-b1': 'ielts-badge',
                'practical': 'practical-badge',
                'business': 'business-badge',
                'basic-english': 'basic-badge',
                'toefl': 'toefl-badge',
                'academic': 'academic-badge'
            };
            return map[testType] || 'toeic-badge';
        }

        function printDetails() {
            window.print();
        }

        function exportToCSV() {
            const testType = document.getElementById('testType').value;
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;
            
            const params = new URLSearchParams();
            if (testType !== 'all') params.append('test_type', testType);
            if (dateFrom) params.append('date_from', dateFrom);
            if (dateTo) params.append('date_to', dateTo);
            
            window.location.href = '/placement-results/export?' + params.toString();
        }

        function printTable() {
            const printWindow = window.open('', '_blank');
            const table = document.getElementById('resultsTable').outerHTML;
            
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Placement Test Results - Print</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; }
                        h1 { color: #4f46e5; margin-bottom: 20px; }
                        table { width: 100%; border-collapse: collapse; font-size: 12px; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #4f46e5; color: white; }
                        tr:nth-child(even) { background-color: #f9fafb; }
                        .test-type-badge { padding: 4px 8px; border-radius: 12px; font-size: 10px; font-weight: bold; }
                        .action-buttons { display: none; }
                        @media print {
                            body { margin: 0; }
                            button { display: none; }
                        }
                    </style>
                </head>
                <body>
                    <h1>Placement Test Results</h1>
                    <p>Generated on: ${new Date().toLocaleString()}</p>
                    ${table}
                    <script>
                        window.onload = function() {
                            window.print();
                            window.onafterprint = function() {
                                window.close();
                            };
                        };
                    <\/script>
                </body>
                </html>
            `);
            printWindow.document.close();
        }
    </script>
</body>
</html>

<?php
// Helper functions
function getBadgeClass($testType) {
    $map = [
        'toeic' => 'toeic-badge',
        'ielts-a2' => 'ielts-badge',
        'ielts-b1' => 'ielts-badge',
        'practical' => 'practical-badge',
        'business' => 'business-badge',
        'basic-english' => 'basic-badge',
        'toefl' => 'toefl-badge',
        'academic' => 'academic-badge'
    ];
    return $map[$testType] ?? 'toeic-badge';
}

function formatScoreDisplay($result) {
    if (isset($result['overall_band'])) return 'Band ' . $result['overall_band'];
    if (isset($result['percentage'])) return $result['percentage'] . '%';
    if (isset($result['total_percentage'])) return $result['total_percentage'] . '%';
    if (isset($result['overall_percent'])) return $result['overall_percent'] . '%';
    return 'N/A';
}

function getSkillScore($result, $skill) {
    if ($skill === 'pronoun') {
        $pronounKeys = [
            'pronoun_score', 'pronoun_correct', 'pronoun_percentage',
            'pronunciation_correct', 'pronunciation_score', 'pronunciation_percentage'
        ];
        
        foreach ($pronounKeys as $key) {
            if (isset($result[$key]) && $result[$key] !== '' && $result[$key] !== null) {
                return $result[$key];
            }
        }
        return '-';
    }
    
    $keys = [
        $skill . '_score', $skill . '_correct', $skill . '_percentage',
        $skill . '_percent', $skill . '_ielts', $skill . '_toeic', $skill . '_level'
    ];
    
    foreach ($keys as $key) {
        if (isset($result[$key]) && $result[$key] !== '' && $result[$key] !== null) {
            return $result[$key];
        }
    }
    
    return '-';
}
?>