@extends('pages.layouts.admin')

@section('title', 'Edit Rak Buku')
@section('description', 'Sistem Perpustakaan - Rak Buku')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold">Edit Rak</h4>
            <a href="{{ route('admin.shelf.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.shelf.update', $shelf->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Nama Rak -->
                        <div class="col-md-6 mb-3 pe-2">
                            <label for="name" class="form-label">Nama Rak <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $shelf->name) }}" 
                                   placeholder="Masukkan nama rak"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-md-6 mb-3 ps-2">
                            <label for="location_description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('location_description') is-invalid @enderror" 
                                      id="location_description" 
                                      name="location_description" 
                                      rows="4" 
                                      placeholder="Masukkan deskripsi rak">{{ old('location_description', $shelf->location_description) }}</textarea>
                            @error('location_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.shelf.index') }}" class="btn btn-outline-secondary">
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