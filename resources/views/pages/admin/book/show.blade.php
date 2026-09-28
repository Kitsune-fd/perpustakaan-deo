@extends('pages.layouts.admin')

@section('title', 'Buku')

@section('description', 'Sistem Perpustakaan - Buku')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detail Buku</h1>
        <div>
            <a href="{{ route('admin.book.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.book.edit', $book->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    @if($book->cover_image)
                        <img src="{{$book->cover_image}}" alt="{{ $book->title }}" class="img-fluid rounded">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="min-height: 400px;">
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
                        <h4 class="mb-0">{{ $book->title }}</h4>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted small">PENULIS</label>
                            <p class="mb-0">{{ $book->author }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted small">PENERBIT</label>
                            <p class="mb-0">{{ $book->publisher ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted small">TAHUN TERBIT</label>
                            <p class="mb-0">{{ $book->year ?? '-' }}</p>
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
                            <label class="fw-bold text-muted small">TOTAL STOK</label>
                            <p class="mb-0">
                                <span class="badge bg-success">{{ $book->stock_total }} Buku</span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold text-muted small">DESKRIPSI</label>
                        <p class="text-muted mb-0">
                            {{ $book->description ?? 'Tidak ada deskripsi.' }}
                        </p>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="bi bi-calendar-plus"></i> Dibuat: {{ $book->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="bi bi-calendar-check"></i> Diperbarui: {{ $book->updated_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection