@extends('pages.layouts.student')

@section('title', 'Riwayat')
@section('description', 'Sistem Perpustakaan - Riwayat Peminjaman Buku')

@section('content')
<div class="row">
    <div class="col-12">

        <!-- Table Card -->
        @session('success')
            <div class="alert alert-light-success color-success mb-3" id="alert-static-custom"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
        @endsession
        @session('error')
            <div class="alert alert-light-danger color-danger mb-3" id="alert-static-custom"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
        @endsession
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover data-table" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Peminjaman</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    $(function() {
        var route = "{{ route('student.history.index') }}";
        var selector = ".data-table";
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'w-8 text-center text-sm',
                orderable: false,
                searchable: false
            },
            {
                data: 'code',
                name: 'code',
                orderable: true,
                searchable: true
            },
            {
                data: 'title',
                name: 'title',
                orderable: true,
                searchable: true
            },
            {
                data: 'loaned_date',
                name: 'loaned_date',
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return moment(data).locale('id').format('ll') ?? '-';
                }
            },
            {
                data: 'returned_date',
                name: 'returned_date',
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return moment(data).locale('id').format('ll') ?? '-';
                }
            },
            {
                data: 'status',
                name: 'status',
                orderable: true,
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center w-20'
            }
        ];
        var table = initializeDataTable(selector, route, columns);
    })
</script>
@endpush
@endsection