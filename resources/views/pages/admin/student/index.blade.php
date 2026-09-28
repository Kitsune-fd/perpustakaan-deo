@extends('pages.layouts.admin')

@section('title', 'Siswa')
@section('description', 'Sistem Perpustakaan - Daftar Siswa')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold">Daftar Siswa</h4>
            <a href="{{ route('admin.student.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Siswa
            </a>
        </div>

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
                                <th>Nama Siswa</th>
                                <th>Email</th>
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
        var route = "{{ route('admin.student.index') }}";
        var selector = ".data-table";
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'w-8 text-center text-sm',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name',
                orderable: true,
                searchable: true
            },
            {
                data: 'email',
                name: 'email',
                orderable: true,
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
                className: 'w-20 text-center',
                orderable: false,
                searchable: false
            }
        ];
        var table = initializeDataTable(selector, route, columns);

        $(document).on('click', '#delete', function() {
            var id = $(this).data('id');
            var route = "{{ route('admin.student.destroy', ':id') }}";
            route = route.replace(':id', id);
            deleteDataAjaxV2(route, table);
        });
    })
</script>
@endpush
@endsection