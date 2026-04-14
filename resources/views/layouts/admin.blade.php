<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - {{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        #sidebar {
            width: 250px;
            min-height: 100vh;
            background: #fff;
            transition: all 0.3s;
            border-right: 1px solid #dee2e6;
        }
        #sidebar.collapsed {
            margin-left: -250px;
        }
        #sidebar .nav-link {
            color: #495057;
            padding: 12px 20px;
            font-weight: 500;
        }
        #sidebar .nav-link:hover {
            color: #0d6efd;
            background: #f8f9fa;
        }
        #sidebar .nav-link.active {
            color: #fff;
            background: #0d6efd;
        }
        #sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .main-content {
            width: 100%;
            background: #f8f9fa;
        }
        .navbar {
            background: #fff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.75rem;
        }
        /* Fix pagination SVG icons */
        .pagination svg {
            width: 1em;
            height: 1em;
        }
        .pagination .flex.justify-between.flex-1 {
            display: none; /* Ẩn dòng "Showing X to Y" nếu nó làm rối giao diện admin */
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="flex-shrink-0 p-3">
            <a href="/" class="d-flex align-items-center pb-3 mb-3 link-body-emphasis text-decoration-none border-bottom justify-content-center">
                <span class="fs-5 fw-bold text-dark"></i><img src="{{ asset('images/logo debaek-04.png') }}" alt="Logo" class="img-fluid" style="max-height: 60px; width: 150px; object-fit: cover;"></span>
            </a>
            <ul class="nav nav-pills flex-column mb-auto">
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-gauge"></i> Dashboard
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i> Quản lý User
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-box"></i> Quản lý Sản phẩm
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-cart-shopping"></i> Quản lý Đơn hàng
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-star"></i> Quản lý Đánh giá
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.slides.index') }}" class="nav-link {{ request()->routeIs('admin.slides.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-image"></i> Quản lý Slide
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.qr_codes.index') }}" class="nav-link {{ request()->routeIs('admin.qr_codes.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-qrcode"></i> Quản lý QR Code
                    </a>    
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-layer-group"></i> Quản lý Danh mục
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <nav class="navbar navbar-expand-lg navbar-light p-3">
                <div class="container-fluid">
                    <button class="btn btn-link text-dark me-3" id="sidebarToggle">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h4 class="mb-0">@yield('page_title', 'Dashboard')</h4>
                    <div class="ms-auto">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fa-solid fa-right-from-bracket me-1"></i> Đăng xuất
                            </button>
                        </form>
                    </div>
                </ul>
            </nav>

            <div class="p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
                </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('collapsed');
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html>