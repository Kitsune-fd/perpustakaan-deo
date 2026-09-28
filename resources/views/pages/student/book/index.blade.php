@extends('pages.layouts.student')

@section('title', 'Buku')

@section('description', 'Sistem Perpustakaan - Buku')

@section('content')
<div class="container-fluid">

    @session('success')
        <div class="alert alert-light-success color-success mb-3" id="alert-static-custom"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
    @endsession
    @session('error')
        <div class="alert alert-light-danger color-danger mb-3" id="alert-static-custom"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
    @endsession

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold text-primary">
                <i class="bi bi-funnel me-2"></i>Filter Buku
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('student.book.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label fw-semibold">Pencarian</label>
                        <input
                            type="text"
                            class="form-control"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari judul atau penulis..."
                        >
                    </div>

                    <div class="col-md-3">
                        <label for="category" class="form-label fw-semibold">Kategori</label>
                        <select class="form-select" id="category" name="category_id">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="shelf" class="form-label fw-semibold">Rak</label>
                        <select class="form-select" id="shelf" name="shelf_id">
                            <option value="">Semua Rak</option>
                            @foreach($shelves as $shelf)
                                <option value="{{ $shelf->id }}" {{ request('shelf') == $shelf->id ? 'selected' : '' }}>
                                    {{ $shelf->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="available"
                                name="available"
                                value="1"
                                {{ request('available') ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="available">
                                Stok tersedia saja
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('student.book.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if($books->isEmpty())
        <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle me-2"></i>
            Tidak ada buku yang ditemukan.
        </div>
    @else
        <div class="row g-4">
            @foreach($books as $book)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        @if($book->cover_image)
                            <img src="{{ $book->cover_image }}" 
                                 class="card-img-top" 
                                 alt="{{ $book->title }}"
                                 style="height: 250px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 250px;">
                                <div class="text-center text-muted">
                                    <i class="bi bi-book fs-1"></i>
                                    <p class="mt-2 mb-0 small">Tidak ada cover</p>
                                </div>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold mb-2">{{ $book->title }}</h6>
                            
                            <div class="mb-2">
                                <small class="text-muted d-block">
                                    <i class="bi bi-person me-1"></i>{{ $book->author }}
                                </small>
                                <small class="text-muted d-block">
                                    <i class="bi bi-tag me-1"></i>{{ $book->category->name }}
                                </small>
                                <small class="text-muted d-block">
                                    <i class="bi bi-bookshelf me-1"></i>{{ $book->shelf->name }}
                                </small>
                            </div>

                            @if($book->description)
                                <p class="card-text small text-muted mb-2">
                                    {{ Str::limit($book->description, 100) }}
                                </p>
                            @endif

                            <div class="mb-3">
                                @if(isset($book->stock_available) && $book->stock_available > 0)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Tersedia: {{ $book->stock_available }}
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle me-1"></i>Stok Habis
                                    </span>
                                @endif
                            </div>

                            <div class="mt-auto">
                                @if(isset($book->stock_available) && $book->stock_available > 0)
                                    <a href="{{ route('student.loan.create', ['book' => $book->id]) }}" 
                                       class="btn btn-primary btn-sm w-100">
                                        <i class="bi bi-cart-plus me-1"></i>Pinjam Buku
                                    </a>
                                @else
                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                        <i class="bi bi-x-circle me-1"></i>Tidak Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $books->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection