<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Alumni Job Portal') }} - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#resultsTable').DataTable();
        });
    </script>
    <!-- In the head section or before closing body tag -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Your DataTables script -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

    <div class="sidebar">
        <div class="logo">
            <img src="../assets/img/plp-logo.png" alt="PLP Logo" height="80">
            <h4>PLP Admin Panel</h4>
            <button class="toggle-btn">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
        
        <div class="nav-menu">
            
            <a class="nav-item {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}" href="{{ route('admin.dashboard.index') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            
            <a class="nav-item {{ request()->routeIs('admin.model-upload.index') ? 'active' : '' }}" href="{{ route('admin.model-upload.index') }}">
                <i class="fas fa-cloud-upload-alt"></i>
                <span>Upload Model</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.forecasting.index') ? 'active' : '' }}" href="{{ route('admin.forecasting.index') }}">
                
                <i class="fas fa-robot"></i>
                <span>Forecasting</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.employment-comparison.index') ? 'active' : '' }}" 
               href="{{ route('admin.employment-comparison.index') }}">
                <i class="fas fa-chart-line"></i>
                <span>Employment Comparison</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.student-forecast.index') ? 'active' : '' }}" 
                href="{{ route('admin.student-forecast.index') }}">
                <i class="fas fa-chart-bar"></i>
                <span>Predict & Report</span>
            </a>
            <!-- <a href="analysis.php" class="nav-item">
                <i class="fas fa-chart-bar"></i>
                <span>Employment Analysis</span>
            </a> -->
            {{-- <a class="nav-item {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}" 
                href="{{ route('admin.reports.index') }}">
                <i class="fas fa-file-alt"></i>
                <span>Reports</span>
            </a>
            --}}    

            <a class="nav-item {{ request()->routeIs('admin.companies.index') ? 'active' : '' }}" 
               href="{{ route('admin.companies.index') }}">
                <i class="fas fa-building"></i>
                <span>Companies</span>
            </a>
            
            <a class="nav-item {{ request()->routeIs('admin.jobs.index') ? 'active' : '' }}" 
               href="{{ route('admin.jobs.index') }}">
                <i class="fas fa-briefcase"></i>
                <span>Jobs</span>
            </a>

            <a class="nav-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" 
                href="{{ route('admin.users.index') }}">
                 <i class="fas fa-users"></i>
                 <span>Users</span>
             </a>

             <a class="nav-item {{ request()->routeIs('admin.feedbacks.index') ? 'active' : '' }}" 
                href="{{ route('admin.feedbacks.index') }}">
                 <i class="fas fa-message"></i>
                 <span>Feedbacks</span>
             </a>
            {{-- <a href="settings.php" class="nav-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a> --}}
            <div class="logout-section">
                <form method="POST" action="{{ route('admin.auth.logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="nav-item logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div> 

    {{ $slot }}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.toggle-btn').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            const icon = this.querySelector('i');
            
            sidebar.classList.toggle('collapsed');
            
            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('fa-chevron-left');
                icon.classList.add('fa-chevron-right');
            } else {
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-left');
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        
        .logout-btn {
            width: 100%;
            
        }

    </style>

    

    <!-- Place this where you want your page-specific scripts -->
    @stack('scripts')
</body>
</html> 