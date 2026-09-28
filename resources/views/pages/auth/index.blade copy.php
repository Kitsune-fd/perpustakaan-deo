<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>LOGIN</title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="./assets/compiled/css/app.css">
	<link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
	<link rel="stylesheet" href="./assets/compiled/css/auth.css">
</head>

<body>
	<script src="assets/static/js/initTheme.js"></script>
	<div class="container-fluid vh-100 p-0">
    <div class="row g-0 h-100">
        <!-- Left Side - Login Form -->
        <div class="col-lg-5 col-md-6 d-flex align-items-center justify-content-center bg-light">
            <div class="w-100 px-4 px-md-5" style="max-width: 480px;">
                <!-- Logo -->
                <div class="text-center mb-4">
                    <img src="/images/logo.png" alt="Logo" class="mb-3" style="width: 80px; height: auto;">
                    <h3 class="fw-bold text-primary mb-1">SISTEM INFORMASI GURU</h3>
                    <p class="text-muted small">Silahkan login untuk melanjutkan</p>
                </div>

                <!-- Login Card -->
                <div class="card border-0 shadow">
                    <div class="card-body p-4">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label fw-semibold small">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-person text-muted d-flex"></i>
                                    </span>
                                    <input type="text"
                                        name="username"
                                        id="username"
                                        value="{{ old('username') }}"
                                        class="form-control border-start-0 ps-0"
                                        placeholder="Masukkan username"
                                        required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold small">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-shield-lock text-muted d-flex"></i>
                                    </span>
                                    <input type="password"
                                        name="password"
                                        id="password"
                                        class="form-control border-start-0 ps-0"
                                        placeholder="Masukkan password"
                                        required>
                                </div>
                            </div>

                            <!-- Login Button -->
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-4">
                    <p class="small text-muted mb-0">
                        © 2025 Sistem Informasi Guru. All rights reserved.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Background Image -->
        <div class="col-lg-7 col-md-6 d-none d-md-block position-relative">
            <div class="h-100 w-100 position-relative overflow-hidden">
                <!-- Background Image -->
                <div class="position-absolute top-0 start-0 w-100 h-100" 
                     style="background-image: url('/images/login_background.png'); 
                            background-size: cover; 
                            background-position: center;">
                </div>
                
                <!-- Overlay -->
                <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary bg-opacity-75"></div>
                
                <!-- Content on Image -->
                <div class="position-absolute top-50 start-50 translate-middle text-white text-center w-75">
                    <i class="bi bi-file-text display-1 mb-4"></i>
                    <h2 class="fw-bold mb-3">Kelola Informasi Guru dengan Mudah</h2>
                    <p class="lead mb-0">
                        Sistem administrasi guru yang efisien dan terpercaya untuk kemudahan pelayanan instansi pendidikan
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	@if (session('swal'))
	<script>
		Swal.fire(@json(session('swal')));
	</script>
	@endif

</body>

</html>