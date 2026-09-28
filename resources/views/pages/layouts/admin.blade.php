<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/images/logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/compiled/css/app.css">
    <link rel="stylesheet" href="/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="/assets/static/css/custom.css">
    <link rel="stylesheet" href="/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/assets/compiled/css/table-datatable-jquery.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet"> -->
    @stack('styles')
    @stack('scripts')
    @routes
</head>

<body>
    <script src="/assets/static/js/initTheme.js"></script>
    
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container-fluid px-4">
            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                <img src="/images/logo.png" alt="Logo" height="40" class="me-2">
                <div class="d-flex flex-column lh-sm">
                    <span class="fw-bold">Admin Portal - SIPUS</span>
                    <small class="opacity-75 d-none d-md-block" style="font-size: 0.7rem;">Sistem Perpustakaan</small>
                </div>
            </a>

            <!-- Toggler Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Main Menu -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-grid-fill me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('admin/book*') ? 'active' : '' }}" 
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-book-fill me-1"></i>Data Buku
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.book.index') ?? '#' }}">
                                <i class="bi bi-list-ul me-2"></i>Semua Buku</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('admin.book.create') ?? '#' }}">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Buku</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/category*') ? 'active' : '' }}" 
                           href="{{ route('admin.category.index') ?? '#' }}">
                            <i class="bi bi-tag-fill me-1"></i>Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/shelf*') ? 'active' : '' }}" 
                           href="{{ route('admin.shelf.index') ?? '#' }}">
                            <i class="bi bi-bookshelf me-1"></i>Rak
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/loan*') ? 'active' : '' }}" 
                           href="{{ route('admin.loan.index') ?? '#' }}">
                            <i class="bi bi-arrow-left-right me-1"></i>Peminjaman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/student*') ? 'active' : '' }}" 
                           href="{{ route('admin.student.index') ?? '#' }}">
                            <i class="bi bi-people-fill me-1"></i>Data Siswa
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/report*') ? 'active' : '' }}" 
                           href="{{ route('admin.report.index') ?? '#' }}">
                            <i class="bi bi-file-earmark-text-fill me-1"></i>Laporan
                        </a>
                    </li> -->
                </ul>

                <!-- User Profile Dropdown -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                 style="width: 32px; height: 32px; font-weight: 600;">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <h6 class="dropdown-header">
                                    <i class="bi bi-person-circle me-2"></i>{{ Auth::user()->name ?? 'Admin' }}
                                </h6>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.profile.index') ?? '#' }}">
                                    <i class="bi bi-person-badge me-2"></i>Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.password.index') }}">
                                    <i class="bi bi-gear-fill me-2"></i>Ganti Password
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button type="button" id="logout" class="dropdown-item text-danger">
                                    <i class="bi bi-power me-2"></i>Keluar
                                </button>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <!-- <div class="container" style="margin-top: 80px; min-height: calc(100vh - 200px);"> -->
    <div class="container-fluid p-4">
        <div class="row" >
            <div class="col-12">
                <!-- Page Header -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body py-3">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h3 class="mb-1 fw-bold">@yield('title')</h3>
                                <p class="text-muted mb-0 small">@yield('description')</p>
                            </div>
                            <div class="col-md-6">
                                <nav aria-label="breadcrumb" class="d-flex justify-content-md-end">
                                    {{ Breadcrumbs::render() }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                <div class="mb-5 main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-white border-top mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="py-3 text-center">
                        <p class="text-muted mb-0 small">
                            &copy; {{ date('Y') }} Sistem Informasi Perpustakaan Sekolah. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="/assets/static/js/components/dark.js"></script>
    <script src="/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/assets/compiled/js/app.js"></script>
    <script src="/assets/static/js/pages/dashboard.js"></script>
    <script src="/assets/static/js/custom.js"></script>
    <script src="/assets/extensions/jquery/jquery.min.js"></script>
    <script src="/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/assets/static/js/pages/datatables.js"></script>
    <script src="/assets/extensions/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment-with-locales.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- <script src="/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script src="/assets/static/js/pages/form-element-select.js"></script> -->
    <script>
        $(document).ready(function() {
            // Logout functionality
            $('#logout').click(function() {
                logoutUser();
            });

            // Auto-close navbar on mobile after clicking a link
            $('.navbar-nav .nav-link:not(.dropdown-toggle)').on('click', function() {
                if (window.innerWidth < 992) {
                    $('.navbar-collapse').collapse('hide');
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>