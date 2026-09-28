@extends('pages.layouts.student')
@section('title', 'Dashboard')
@section('description', 'Sistem Perpustakaan - Dashboard Siswa')
@section('content')

<div class="container-fluid">

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <div class="fs-3 fw-bold text-primary mb-1">{{ $totalLoanedBooks }}</div>
                    <div class="text-muted small">Total Buku Dipinjam</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <div class="fs-3 fw-bold text-success mb-1">{{ $totalReturnedBooks }}</div>
                    <div class="text-muted small">Buku Sudah Dikembalikan</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <div class="fs-3 fw-bold text-danger mb-1">{{ $totalLateBooks }}</div>
                    <div class="text-muted small">Buku Terlambat</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold mb-0">Peminjaman Aktif</h6>
        </div>
        <div class="card-body">
            @if ($activeLoans->isEmpty())
                <div class="alert alert-info mb-0" role="alert">
                    Anda tidak memiliki peminjaman aktif saat ini.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeLoans as $index => $loan)
                            <tr>
                                <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                                <td>{{ $loan->book->title ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($loan->loaned_date)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</td>
                                <td>
                                    @if ($loan->status === 'terlambat')
                                        <span class="badge bg-danger">Terlambat</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Dipinjam</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold mb-0">Riwayat Peminjaman Terbaru</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentLoans as $index => $loan)
                        <tr>
                            <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                            <td>{{ $loan->book->title ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                            <td>
                                {{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d M Y') : '-' }}
                            </td>
                            <td>
                                @if ($loan->status === 'dikembalikan')
                                    <span class="badge bg-success">Dikembalikan</span>
                                @elseif ($loan->status === 'terlambat')
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat peminjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection