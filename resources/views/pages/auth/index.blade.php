<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Perpustakaan Sekolah</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/auth.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* ========== ROOT VARIABLES ========== */
        :root {
            --primary: #1e3a8a;
            --primary-dark: #1e40af;
            --primary-light: #3b82f6;
            --primary-soft: #eff6ff;
            --accent: #f59e0b;
            --accent-dark: #d97706;
            --accent-light: #fbbf24;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
        }

        /* ========== GLOBAL STYLES ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif !important;
            background: linear-gradient(135deg, #eff6ff 0%, #ffffff 50%, #fef3c7 100%) !important;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ========== BACKGROUND DECORATION ========== */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(30, 58, 138, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveBackground 60s linear infinite;
            z-index: 0;
        }

        @keyframes moveBackground {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* ========== FLOATING SHAPES ========== */
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s ease-in-out infinite;
            z-index: 0;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            background: var(--primary);
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            background: var(--accent);
            top: 60%;
            right: 10%;
            animation-delay: 5s;
        }

        .shape-3 {
            width: 150px;
            height: 150px;
            background: var(--primary-light);
            bottom: 20%;
            left: 15%;
            animation-delay: 10s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            25% { transform: translateY(-30px) translateX(20px); }
            50% { transform: translateY(-50px) translateX(-20px); }
            75% { transform: translateY(-30px) translateX(20px); }
        }

        /* ========== CONTAINER ========== */
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ========== LOGIN CARD ========== */
        .login-card {
            background: var(--white);
            border-radius: var(--radius-2xl) !important;
            box-shadow: var(--shadow-xl) !important;
            overflow: hidden;
            border: none !important;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .login-card:hover {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15) !important;
        }

        /* ========== LEFT SIDE (FORM) ========== */
        .login-form-section {
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 600px;
        }

        /* ========== HEADER ========== */
        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-lg);
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .login-logo i {
            font-size: 2.5rem;
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .login-subtitle {
            font-size: 0.95rem;
            color: var(--gray-500);
            font-weight: 400;
        }

        /* ========== FORM STYLES ========== */
        .form-label {
            font-weight: 600 !important;
            color: var(--gray-700) !important;
            margin-bottom: 0.625rem !important;
            font-size: 0.875rem !important;
        }

        .input-group {
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg) !important;
            overflow: hidden;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .input-group:focus-within {
            border-color: var(--primary-light) !important;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.15) !important;
        }

        .input-group-text {
            background: transparent !important;
            border: none !important;
            padding: 0.75rem 1rem;
        }

        .input-group-text i {
            font-size: 1.125rem;
            color: var(--gray-500);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-control {
            border: none !important;
            padding: 0.75rem 1rem !important;
            font-size: 0.9375rem !important;
            background: transparent !important;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: none !important;
            background: transparent !important;
        }

        .form-control::placeholder {
            color: var(--gray-500) !important;
            opacity: 0.7;
        }

        /* ========== BUTTON ========== */
        .btn-login {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%) !important;
            border: none !important;
            padding: 0.875rem 2rem !important;
            font-size: 1rem !important;
            font-weight: 600 !important;
            border-radius: var(--radius-lg) !important;
            color: var(--white) !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3) !important;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--accent-dark) 0%, #b45309 100%) !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4) !important;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login i {
            margin-right: 0.5rem;
            font-size: 1.125rem;
        }

        /* ========== RIGHT SIDE (ILLUSTRATION) ========== */
        .login-illustration-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .login-illustration-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            animation: movePattern 40s linear infinite;
        }

        @keyframes movePattern {
            0% { transform: translate(0, 0); }
            100% { transform: translate(30px, 30px); }
        }

        .illustration-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: var(--white);
        }

        .illustration-icon {
            width: 200px;
            height: 200px;
            margin: 0 auto 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            animation: iconPulse 3s ease-in-out infinite;
        }

        @keyframes iconPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .illustration-icon i {
            font-size: 5rem;
            color: var(--white);
            opacity: 0.9;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .illustration-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.3;
            color: #fff;
        }

        .illustration-description {
            font-size: 1.125rem;
            opacity: 0.9;
            line-height: 1.6;
            max-width: 400px;
            margin: 0 auto;
        }

        /* Floating Books Animation */
        .floating-book {
            position: absolute;
            opacity: 0.15;
            animation: floatBook 15s ease-in-out infinite;
            color: #fff;
        }

        .book-1 {
            font-size: 3rem;
            top: 15%;
            left: 10%;
            animation-delay: 0s;
        }

        .book-2 {
            font-size: 2.5rem;
            top: 65%;
            right: 15%;
            animation-delay: 5s;
        }

        .book-3 {
            font-size: 2rem;
            bottom: 20%;
            left: 20%;
            animation-delay: 10s;
        }

        @keyframes floatBook {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(5deg); }
            50% { transform: translateY(-40px) rotate(-5deg); }
            75% { transform: translateY(-20px) rotate(5deg); }
        }

        /* ========== FOOTER ========== */
        .login-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-200);
        }

        .login-footer p {
            font-size: 0.875rem;
            color: var(--gray-500);
            margin: 0;
        }

        /* ========== ALERT STYLES ========== */
        .alert {
            border-radius: var(--radius-lg) !important;
            border: none !important;
            padding: 1rem 1.25rem !important;
            margin-bottom: 1.5rem !important;
        }

        .alert-danger {
            background-color: #fee2e2 !important;
            color: #991b1b !important;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 991px) {
            .login-illustration-section {
                display: none;
            }

            .login-form-section {
                padding: 2rem 1.5rem;
            }

            .login-title {
                font-size: 1.5rem;
            }

            .illustration-content {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 0 0.5rem;
            }

            .login-form-section {
                padding: 2rem 1.25rem;
                min-height: auto;
            }

            .login-logo {
                width: 70px;
                height: 70px;
            }

            .login-logo i {
                font-size: 2rem;
            }

            .login-title {
                font-size: 1.375rem;
            }

            .login-subtitle {
                font-size: 0.875rem;
            }

            .btn-login {
                padding: 0.75rem 1.5rem !important;
                font-size: 0.9375rem !important;
            }
        }

        /* ========== ADDITIONAL ENHANCEMENTS ========== */
        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .w-100 {
            width: 100% !important;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Selection color */
        ::selection {
            background-color: var(--primary-light);
            color: var(--white);
        }

        ::-moz-selection {
            background-color: var(--primary-light);
            color: var(--white);
        }
    </style>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    
    <!-- Floating Shapes Background -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>

    <!-- Login Container -->
    <div class="login-container">
        <div class="row g-0">
            <div class="col-12">
                <div class="card login-card">
                    <div class="row g-0">
                        <!-- Left Side - Login Form -->
                        <div class="col-lg-6 col-md-6">
                            <div class="login-form-section">
                                <!-- Header -->
                                <div class="login-header">
                                    <div class="login-logo">
                                        <i class="bi bi-book"></i>
                                    </div>
                                    <h1 class="login-title">Sistem Informasi<br>Perpustakaan Sekolah</h1>
                                    <p class="login-subtitle">Silakan masuk untuk mengakses sistem</p>
                                </div>

                                <!-- Login Form -->
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf

                                    <!-- Email Input -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-envelope-fill"></i>
                                            </span>
                                            <input type="email"
                                                name="email"
                                                id="email"
                                                value="{{ old('email') }}"
                                                class="form-control"
                                                placeholder="Masukkan email Anda"
                                                required
                                                autofocus>
                                        </div>
                                    </div>

                                    <!-- Password Input -->
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-lock-fill"></i>
                                            </span>
                                            <input type="password"
                                                name="password"
                                                id="password"
                                                class="form-control"
                                                placeholder="Masukkan password Anda"
                                                required>
                                        </div>
                                    </div>

                                    <!-- Login Button -->
                                    <button type="submit" class="btn btn-login w-100">
                                        <i class="bi bi-box-arrow-in-right"></i>
                                        Masuk ke Sistem
                                    </button>
                                </form>

                                <!-- Footer -->
                                <div class="login-footer">
                                    <p>© 2025 Sistem Perpustakaan Sekolah. All rights reserved.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side - Illustration -->
                        <div class="col-lg-6 col-md-6 d-none d-md-block">
                            <div class="login-illustration-section">
                                <!-- Floating Books -->
                                <i class="bi bi-book floating-book book-1"></i>
                                <i class="bi bi-journals floating-book book-2"></i>
                                <i class="bi bi-bookmark-star floating-book book-3"></i>

                                <div class="illustration-content">
                                    <div class="illustration-icon">
                                        <i class="bi bi-collection"></i>
                                    </div>
                                    <h2 class="illustration-title">Kelola Perpustakaan<br>dengan Mudah</h2>
                                    <p class="illustration-description">
                                        Platform digital untuk manajemen koleksi buku, peminjaman, 
                                        dan administrasi perpustakaan sekolah yang efisien.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('swal'))
    <script>
        Swal.fire(@json(session('swal')));
    </script>
    @endif
</body>

</html>