@extends('pages.layouts.student')

@section('title', 'Pinjam Buku')

@section('description', 'Sistem Perpustakaan - Peminjaman')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Form Peminjaman Buku</h1>
        <a href="{{ route('student.book.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold text-primary">
                <i class="bi bi-book-fill me-2"></i>Informasi Buku
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    @if($book->cover_image)
                        <img src="{{ $book->cover_image }}" 
                             alt="{{ $book->title }}" 
                             class="img-fluid rounded">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                             style="min-height: 300px;">
                            <div class="text-center text-muted">
                                <i class="bi bi-book fs-1"></i>
                                <p class="mt-2 mb-0">Tidak ada cover</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="fw-bold text-muted small">JUDUL BUKU</label>
                        <h5 class="mb-0">{{ $book->title }}</h5>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted small">PENULIS</label>
                            <p class="mb-0">{{ $book->author }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted small">KATEGORI</label>
                            <p class="mb-0">
                                <span class="badge bg-primary">{{ $book->category->name }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted small">RAK</label>
                            <p class="mb-0">{{ $book->shelf->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted small">STOK TERSEDIA</label>
                            <p class="mb-0">
                                <span class="badge bg-success">{{ $book->stock_available ?? 0 }} Buku</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold text-primary">
                <i class="bi bi-calendar-check me-2"></i>Form Peminjaman
            </h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('student.loan.store') }}" method="POST">
                @csrf

                <input type="hidden" name="book_id" value="{{ $book->id }}">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="loaned_date" class="form-label fw-semibold">
                            Tanggal Peminjaman <span class="text-danger">*</span>
                        </label>
                        <input
                            type="date"
                            class="form-control @error('loaned_date') is-invalid @enderror"
                            id="loaned_date"
                            name="loaned_date"
                            value="{{ old('loaned_date') }}"
                            min="{{ date('Y-m-d') }}"
                            required
                        >
                        @error('loaned_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="due_date" class="form-label fw-semibold">
                            Tanggal Pengembalian
                        </label>
                         <input
                            type="date"
                            class="form-control @error('due_date') is-invalid @enderror"
                            id="due_date"
                            name="due_date"
                            value="{{ old('due_date') }}"
                            required
                        >
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-info" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <strong>Perhatian:</strong> Pastikan Anda dapat mengembalikan buku tepat waktu untuk menghindari denda keterlambatan.
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('student.book.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Konfirmasi Peminjaman
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection