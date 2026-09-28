@extends('pages.layouts.student')

@section('title', 'Detail Peminjaman')

@section('description', 'Sistem Perpustakaan - Peminjaman')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detail Peminjaman</h1>
        <div>
            <a href="{{ route('student.loan.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            @if($loan->status == 'dipinjam')
                <form action="{{ route('student.loan.return', $loan->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Tandai Dikembalikan
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-book-fill me-2"></i>Informasi Buku
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($loan->book->cover_image)
                            <img src="{{ $loan->book->cover_image }}" 
                                 alt="{{ $loan->book->title }}" 
                                 class="img-fluid rounded"
                                 style="max-height: 300px;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center mx-auto" 
                                 style="max-width: 300px; min-height: 300px;">
                                <div class="text-center text-muted">
                                    <i class="bi bi-book fs-1"></i>
                                    <p class="mt-2 mb-0">Tidak ada cover</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold text-muted small">JUDUL BUKU</label>
                        <h5 class="mb-0">{{ $loan->book->title }}</h5>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold text-muted small">PENULIS</label>
                        <p class="mb-0">{{ $loan->book->author }}</p>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="fw-bold text-muted small">KATEGORI</label>
                            <p class="mb-0">
                                <span class="badge bg-primary">{{ $loan->book->category->name }}</span>
                            </p>
                        </div>
                        <div class="col-6">
                            <label class="fw-bold text-muted small">RAK</label>
                            <p class="mb-0">{{ $loan->book->shelf->name }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold text-muted small">TOTAL STOK</label>
                        <p class="mb-0">
                            <span class="badge bg-info">{{ $loan->book->stock_total }} Buku</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-person-fill me-2"></i>Informasi Peminjam
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold text-muted small">NAMA LENGKAP</label>
                        <p class="mb-0">{{ $loan->user->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold text-muted small">EMAIL</label>
                        <p class="mb-0">
                            <a href="mailto:{{ $loan->user->email }}" class="text-decoration-none">
                                {{ $loan->user->email }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-calendar-check me-2"></i>Informasi Peminjaman
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold text-muted small">STATUS</label>
                        <p class="mb-0">
                            @if($loan->status == 'dipinjam')
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-clock me-1"></i>Dipinjam
                                </span>
                            @elseif($loan->status == 'dikembalikan')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Dikembalikan
                                </span>
                            @elseif($loan->status == 'terlambat')
                                <span class="badge bg-danger">
                                    <i class="bi bi-exclamation-circle me-1"></i>Terlambat
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold text-muted small">TANGGAL PINJAM</label>
                        <p class="mb-0">
                            <i class="bi bi-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold text-muted small">TANGGAL JATUH TEMPO</label>
                        <p class="mb-0">
                            <i class="bi bi-calendar-x me-1"></i>
                            {{ \Carbon\Carbon::parse($loan->due_date)->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold text-muted small">TANGGAL DIKEMBALIKAN</label>
                        <p class="mb-0">
                            @if($loan->return_date)
                                <i class="bi bi-calendar-check me-1"></i>
                                {{ \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </p>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <small class="text-muted">
                                <i class="bi bi-calendar-plus me-1"></i>
                                Dibuat: {{ $loan->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                        <div class="col-12 mt-1">
                            <small class="text-muted">
                                <i class="bi bi-calendar-event me-1"></i>
                                Diperbarui: {{ $loan->updated_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection