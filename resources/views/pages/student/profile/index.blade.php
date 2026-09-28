@extends('pages.layouts.student')

@section('title', 'Profile')
@section('description', 'Sistem Perpustakaan - Profile')

@section('content')
<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-4">

                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width:72px;height:72px;font-size:1.75rem;font-weight:600;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-4">{{ $user->email }}</p>

                    <hr class="my-3">

                    <div class="text-start mb-3">
                        <p class="text-muted small mb-1">Nama Lengkap</p>
                        <p class="fw-semibold fs-5 mb-0">{{ $user->name }}</p>
                    </div>

                    <div class="text-start mb-4">
                        <p class="text-muted small mb-1">Email</p>
                        <p class="fw-semibold fs-5 mb-0">{{ $user->email }}</p>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('student.profile.edit', $user) }}" class="btn btn-primary">Edit Profile</a>
                        <a href="{{ route('student.password.edit', $user) }}" class="btn btn-outline-secondary">Ganti Password</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection