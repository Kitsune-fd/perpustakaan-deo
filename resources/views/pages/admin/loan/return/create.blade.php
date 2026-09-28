@extends('pages.layouts.admin')
@section('title', 'Pengembalian Buku')
@section('description', 'Sistem Perpustakaan - Pengembalian Buku')
@section('content')
<div class="container mt-4">
    @if($loan->status !== \App\Enums\Status::LOANED)
        <div class="alert alert-light-info color-info mb-3">
            <i class="bi bi-info-circle"></i>
            Status peminjaman saat ini: <strong>{{ ucfirst($loan->status->label()) }}</strong>. Pengembalian tidak dapat diproses.
        </div>
    @else
        <div class="alert alert-light-warning color-warning mb-3">
            <i class="bi bi-exclamation-triangle"></i>
            Pastikan untuk mengisi tanggal pengembalian dengan benar. Denda akan dihitung otomatis jika terlambat.
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Form Pengembalian Buku</h4>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-light fw-semibold">
                    Informasi Buku
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($loan->book->cover_image)
                            <img src="{{ $loan->book->cover_image }}"
                                 alt="Cover Buku"
                                 class="img-fluid rounded"
                                 style="max-height:180px;">
                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded"
                                 style="height:180px;">
                                <span>Tidak ada cover</span>
                            </div>
                        @endif
                    </div>
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th class="text-muted" style="width:40%">Judul</th>
                            <td>{{ $loan->book->title }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Penulis</th>
                            <td>{{ $loan->book->author }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tahun</th>
                            <td>{{ $loan->book->year }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Kategori</th>
                            <td>{{ $loan->book->category->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Rak</th>
                            <td>{{ $loan->book?->shelf?->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-info text-white fw-semibold">
                    Informasi Peminjaman
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th class="text-muted" style="width:50%">Tanggal Pinjam</th>
                            <td>{{ \Carbon\Carbon::parse($loan->loaned_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tanggal Jatuh Tempo</th>
                            <td>
                                {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">Status</th>
                            <td>
                                <span class="badge {{ $loan->status->badgeClass() }}">{{ ucfirst($loan->status->label()) }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>

        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white fw-semibold">
                    Form Pengembalian
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.loan.return', $loan->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="returned_date" class="form-label fw-semibold">
                                Tanggal Pengembalian <span class="text-danger">*</span>
                            </label>
                            <input
                                type="date"
                                class="form-control @error('returned_date') is-invalid @enderror"
                                id="returned_date"
                                name="returned_date"
                                value="{{ old('returned_date') }}"
                                required
                                {{ $loan->status !== \App\Enums\Status::LOANED ? 'disabled' : '' }}
                            >
                            @error('returned_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fine_amount" class="form-label fw-semibold">
                                Denda Keterlambatan
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="fine_amount"
                                    name="fine_amount"
                                    value="{{ old('fine_amount', 0) }}"
                                    readonly
                                    {{ $loan->status !== \App\Enums\Status::LOANED ? 'disabled' : '' }}
                                >
                            </div>
                            <div class="form-text" id="fine_info">
                                Denda akan dihitung otomatis: Rp 1.000 per hari keterlambatan.
                            </div>
                        </div>

                        <div id="late_alert" class="alert alert-danger d-none" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <span id="late_message"></span>
                        </div>
                        <div id="ok_alert" class="alert alert-success d-none" role="alert">
                            <i class="bi bi-check-circle-fill"></i>
                            Pengembalian tepat waktu. Tidak ada denda.
                        </div>

                        <hr>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary" {{ $loan->status !== \App\Enums\Status::LOANED ? 'disabled' : '' }}>
                                <i class="bi bi-check2-circle"></i> Konfirmasi Pengembalian
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
(function () {
    const dueDate    = '{{ $loan->due_date }}';
    const returnInput = document.getElementById('returned_date');
    const fineInput   = document.getElementById('fine_amount');
    const lateAlert   = document.getElementById('late_alert');
    const lateMsg     = document.getElementById('late_message');
    const okAlert     = document.getElementById('ok_alert');

    function calculate() {
        const returnVal = returnInput.value;
        if (!returnVal) {
            fineInput.value = 0;
            lateAlert.classList.add('d-none');
            okAlert.classList.add('d-none');
            return;
        }

        const due = new Date(dueDate);
        const ret = new Date(returnVal);

        // Normalisasi ke tengah malam agar tidak terpengaruh timezone/jam
        due.setHours(0, 0, 0, 0);
        ret.setHours(0, 0, 0, 0);

        const diffMs   = ret - due;
        const diffDays = Math.round(diffMs / (1000 * 60 * 60 * 24)); // <-- ganti Math.ceil → Math.round

        if (diffDays > 0) {
            const fine = diffDays * 1000;
            fineInput.value = fine;
            lateMsg.textContent = 'Terlambat ' + diffDays + ' hari. Denda: Rp ' + fine.toLocaleString('id-ID');
            lateAlert.classList.remove('d-none');
            okAlert.classList.add('d-none');
        } else {
            fineInput.value = 0;
            lateAlert.classList.add('d-none');
            okAlert.classList.remove('d-none');
        }
    }

    returnInput.addEventListener('change', calculate);
    calculate();
})();
</script>
@endsection