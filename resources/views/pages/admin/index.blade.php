@extends('pages.layouts.admin')
@section('title', 'Dashboard')
@section('description', 'Sistem Perpustakaan - Dashboard')
@section('content')

<div class="container-fluid">
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <div class="fs-3 fw-bold text-primary mb-1">{{ $totalBooks }}</div>
                    <div class="text-muted small">Total Buku</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <div class="fs-3 fw-bold text-success mb-1">{{ $totalStudents }}</div>
                    <div class="text-muted small">Total Siswa</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <div class="fs-3 fw-bold text-warning mb-1">{{ $totalLoansActive }}</div>
                    <div class="text-muted small">Peminjaman Aktif</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <div class="fs-3 fw-bold text-danger mb-1">{{ $totalLoansLate }}</div>
                    <div class="text-muted small">Peminjaman Terlambat</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold mb-0">Peminjaman Terbaru</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Nama Siswa</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestLoans as $index => $loan)
                        <tr>
                            <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                            <td>{{ $loan->user->name ?? '-' }}</td>
                            <td>{{ $loan->book->title ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->loaned_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</td>
                            <td>
                                @if ($loan->status === 'terlambat')
                                    <span class="badge bg-danger">Terlambat</span>
                                @elseif ($loan->status === 'dikembalikan')
                                    <span class="badge bg-success">Dikembalikan</span>
                                @else
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data peminjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold mb-0">Buku dengan Stok Menipis</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Rak</th>
                            <th>Stok Tersedia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lowStockBooks as $index => $book)
                        <tr>
                            <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->category?->name ?? '-' }}</td>
                            <td>{{ $book->shelf?->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-danger">{{ $book->stock_available }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Semua stok buku masih aman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection