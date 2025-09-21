<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - {{ config('app.name', 'E-Commerce') }} - @yield('title', 'Dashboard')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom Admin CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        
        .container-fluid {
            margin: 0 !important;
            padding: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
        }
        
        .row {
            margin: 0 !important;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            padding: 1rem; /* Internal padding for content */
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 0.5rem;
        }
        
        .main-content {
            min-height: 100vh;
            padding: 1rem; /* Internal padding for content */
        }
        
        .navbar-brand {
            font-weight: 600;
            color: #495057;
        }
        
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
            border-radius: 0.5rem;
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .table th {
            border-top: none;
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
        }
        
        .badge {
            font-size: 0.75em;
        }
        
        .stats-card {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2">
                <div class="sidebar">
                    <!-- Logo -->
                    <div class="text-center mb-4">
                        <h4 class="text-white mb-0">
                            <i class="fas fa-cogs me-2"></i>
                            Admin Panel
                        </h4>
                        <small class="text-white-50">{{ config('app.name') }}</small>
                    </div>

                    <!-- Navigation -->
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                        
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                            <i class="fas fa-cube"></i>
                            Quản lý sản phẩm
                        </a>
                        
                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                            <i class="fas fa-tags"></i>
                            Quản lý danh mục
                        </a>
                        
                        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            Quản lý đơn hàng
                        </a>
                        
                        <a class="nav-link" href="#">
                            <i class="fas fa-users"></i>
                            Quản lý khách hàng
                        </a>
                        
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-bar"></i>
                            Báo cáo
                        </a>
                        
                        <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
                        
                        <a class="nav-link" href="{{ route('home') }}" target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                            Xem website
                        </a>
                        
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            Đăng xuất
                        </a>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    <!-- Top Navbar -->
                    <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4">
                        <div class="container-fluid">
                            <span class="navbar-brand mb-0 h1">
                                @yield('page-title', 'Dashboard')
                            </span>
                            
                            <div class="navbar-nav ms-auto">
                                <div class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle fa-lg me-2"></i>
                                        {{ Auth::user()->full_name ?? Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('user.profile') }}">Hồ sơ cá nhân</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Đăng xuất
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>

                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Auto dismiss alerts after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
        
        // Confirm delete actions
        function confirmDelete(message = 'Bạn có chắc chắn muốn xóa?') {
            return confirm(message);
        }
        
        // Show loading spinner on form submit
        $('form').on('submit', function() {
            $(this).find('button[type="submit"]').prop('disabled', true).append(' <i class="fas fa-spinner fa-spin"></i>');
        });
    </script>

    @stack('scripts')
</body>
</html>
