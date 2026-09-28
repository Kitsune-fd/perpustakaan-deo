@extends('pages.layouts.admin')

@section('title', 'Akun Pengguna')
@section('description', 'Kelola informasi akun dan keamanan Anda.')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-4 col-12 mb-4">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="avatar bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                        <i class="bi bi-person-fill d-flex align-items-center justify-content-center" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    <span class="badge bg-success">
                        <i class="bi bi-shield-check"></i> Akun Aktif
                    </span>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3"><i class="bi bi-info-circle-fill text-primary"></i> Informasi Akun</h6>
                    <div class="mb-3">
                        <small class="text-muted d-block">Username</small>
                        <strong>{{ $user->username ?? $user->email }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Role</small>
                        <span class="badge bg-primary">{{ ucfirst($user->role?->name ?? 'Admin') }}</span>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted d-block">Bergabung Sejak</small>
                        <strong>{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-shield-lock-fill"></i> Ubah Password
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0 d-flex align-items-start mb-4 mt-4">
                        <i class="bi bi-info-circle-fill me-3 d-flex align-items-center justify-content-center" style="font-size: 1.5rem;"></i>
                        <div>
                            <h6 class="mb-1">Tips Keamanan Password</h6>
                            <ul class="mb-0 ps-3">
                                <li>Gunakan minimal 8 karakter</li>
                                <li>Kombinasikan huruf besar, huruf kecil, angka, dan simbol</li>
                                <li>Jangan gunakan informasi pribadi yang mudah ditebak</li>
                                <li>Ubah password secara berkala</li>
                            </ul>
                        </div>
                    </div>

                    <form id="updateForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-key-fill text-primary"></i> Password Baru
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-lock-fill d-flex"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Masukkan password baru">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-shield-check"></i> Minimal 8 karakter
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    <i class="bi bi-key-fill text-primary"></i> Konfirmasi Password Baru
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-lock-fill d-flex"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-lg" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi password baru">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-arrow-repeat"></i> Harus sama dengan password baru
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-light" onclick="document.getElementById('updateForm').reset()">
                                        <i class="bi bi-arrow-counterclockwise "></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-lg px-5" id="update">
                                        <i class="bi bi-check-circle-fill"></i> Ubah Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-exclamation-triangle-fill text-warning me-3 d-flex" style="font-size: 2rem;"></i>
                        <div>
                            <h6 class="mb-2">Perhatian Keamanan</h6>
                            <p class="mb-0 text-muted">Setelah mengubah password, Anda akan tetap login di perangkat ini. Namun, pastikan untuk logout dari perangkat lain jika diperlukan untuk keamanan akun Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script type="text/javascript">
    $(function() {
        // Toggle password visibility
        $('#togglePassword').click(function() {
            const passwordField = $('#password');
            const icon = $(this).find('i');
            
            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
            }
        });

        $('#togglePasswordConfirm').click(function() {
            const passwordField = $('#password_confirmation');
            const icon = $(this).find('i');
            
            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
            }
        });

        // Password strength indicator
        $('#password').on('keyup', function() {
            const password = $(this).val();
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            // Remove existing strength indicator
            $('.password-strength').remove();
            
            if (password.length > 0) {
                let strengthText = '';
                let strengthClass = '';
                
                if (strength <= 2) {
                    strengthText = 'Lemah';
                    strengthClass = 'text-danger';
                } else if (strength <= 3) {
                    strengthText = 'Sedang';
                    strengthClass = 'text-warning';
                } else {
                    strengthText = 'Kuat';
                    strengthClass = 'text-success';
                }
                
                $(this).parent().after('<small class="password-strength ' + strengthClass + '"><i class="bi bi-shield-fill"></i> Kekuatan: ' + strengthText + '</small>');
            }
        });

        // Form submission
        let formSelector = '#updateForm';
        let actionUrl = "{{ route('admin.user.update', $user->id) }}";
        let successMessage = 'Password berhasil diubah!';
        submitFormAjaxModal(formSelector, actionUrl, successMessage);
    });
</script>
@endpush
@endsection