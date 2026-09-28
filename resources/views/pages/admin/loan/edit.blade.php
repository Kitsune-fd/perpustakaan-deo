@extends('pages.layouts.admin')

@section('title', 'Ubah Buku')
@section('description', 'Sistem Perpustakaan - Buku')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold">Ubah Buku</h4>
            <a href="{{ route('admin.book.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.book.update', $book->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Judul Buku -->
                        <div class="col-md-6 mb-3 pe-2">
                            <label for="title" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $book->title) }}" 
                                   placeholder="Masukkan judul buku"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Penulis -->
                        <div class="col-md-6 mb-3 ps-2">
                            <label for="author" class="form-label">Penulis <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('author') is-invalid @enderror" 
                                   id="author" 
                                   name="author" 
                                   value="{{ old('author', $book->author) }}" 
                                   placeholder="Masukkan nama penulis"
                                   required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Penerbit -->
                        <div class="col-md-6 mb-3 pe-2">
                            <label for="publisher" class="form-label">Penerbit</label>
                            <input type="text" 
                                   class="form-control @error('publisher') is-invalid @enderror" 
                                   id="publisher" 
                                   name="publisher" 
                                   value="{{ old('publisher', $book->publisher) }}" 
                                   placeholder="Masukkan nama penerbit">
                            @error('publisher')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tahun Terbit -->
                        <div class="col-md-6 mb-3 ps-2">
                            <label for="year" class="form-label">Tahun Terbit <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('year') is-invalid @enderror" 
                                   id="year" 
                                   name="year" 
                                   value="{{ old('year', $book->year) }}" 
                                   placeholder="Contoh: 2024"
                                   min="1900"
                                   max="{{ date('Y') }}">
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-4 mb-3 pe-2">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" 
                                    name="category_id" 
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Rak -->
                        <div class="col-md-4 mb-3">
                            <label for="shelf_id" class="form-label">Rak <span class="text-danger">*</span></label>
                            <select class="form-select @error('shelf_id') is-invalid @enderror" 
                                    id="shelf_id" 
                                    name="shelf_id" 
                                    required>
                                <option value="">Pilih Rak</option>
                                @foreach($shelves as $shelf)
                                    <option value="{{ $shelf->id }}" {{ old('shelf_id', $book->shelf_id) == $shelf->id ? 'selected' : '' }}>
                                        {{ $shelf->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('shelf_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Total Stok -->
                        <div class="col-md-4 mb-3 ps-2">
                            <label for="stock_total" class="form-label">Total Stok <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('stock_total') is-invalid @enderror" 
                                   id="stock_total" 
                                   name="stock_total" 
                                   value="{{ old('stock_total', $book->stock_total) }}" 
                                   placeholder="Masukkan total stok"
                                   min="0"
                                   required>
                            @error('stock_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cover Image -->
                        <div class="col-md-12 mb-3">
                            <label for="cover_image" class="form-label">Cover Buku</label>
                            <input type="file" 
                                   class="form-control @error('cover_image') is-invalid @enderror" 
                                   id="cover_image" 
                                   name="cover_image"
                                   accept="image/*">
                            <div class="form-text">Format: JPG, PNG, JPEG. Maksimal 2MB</div>
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Masukkan deskripsi buku">{{ old('description', $book->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.book.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection