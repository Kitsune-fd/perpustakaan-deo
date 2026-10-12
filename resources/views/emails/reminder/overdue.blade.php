<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Buku Telat Dikembalikan</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 0; color: #333; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .header { background: #ef4444; /* red-500 */ color: white; padding: 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 32px 24px; }
        .content h2 { color: #1f2937; font-size: 20px; margin-top: 0; }
        .details { background: #fee2e2; border: 1px solid #fecaca; border-radius: 6px; padding: 20px; margin: 20px 0; }
        .details p { margin: 8px 0; font-size: 16px; }
        .details strong { color: #991b1b; }
        .warning { color: #dc2626; font-weight: bold; margin: 16px 0; }
        .footer { background: #f3f4f6; padding: 16px; text-align: center; font-size: 14px; color: #6b7280; border-top: 1px solid #e5e7eb; }
        .button { display: inline-block; background: #ef4444; color: white !important; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: 500; margin: 16px 0; }
        .button:hover { background: #dc2626; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Pemberitahuan: Buku Telat Dikembalikan</h1>
    </div>

    <div class="content">
        <h2>Halo, {{ $name }}!</h2>

        <p class="warning">Perhatian: Buku yang Anda pinjam sudah melewati batas waktu pengembalian. Mohon segera kembalikan untuk menghindari denda yang lebih besar.</p>

        <div class="details">
            <p><strong>Judul Buku:</strong> {{ $title }}</p>
            <p><strong>Tanggal Peminjaman:</strong> {{ $loan_date }}</p>
            <p><strong>Batas Pengembalian:</strong> {{ $due_date }}</p>
            <p><strong>Telat:</strong> {{ $overdue_days }} hari</p>
            @if(isset($daily_fine))
            <p><strong>Denda saat ini:</strong> Rp {{ number_format($daily_fine * $overdue_days, 0, ',', '.') }} (Rp {{ number_format($daily_fine, 0, ',', '.') }}/hari)</p>
            @endif
            <p><strong>Peminjam:</strong> {{ $name }}</p>
            @if(isset($code))
            <p><strong>Kode Peminjaman:</strong> {{ $code }}</p>
            @endif
        </div>

        <p>Kami harap Anda segera mengembalikan buku tersebut. Jika ada alasan khusus, silakan hubungi petugas perpustakaan untuk pengaturan lebih lanjut.</p>

        <a href="{{ url('/student/loan') }}" class="button">Lihat Detail & Kembalikan Sekarang</a>

        <p>Terima kasih atas perhatian dan kerjasamanya.</p>
    </div>

    <div class="footer">
        <p>Perpustakaan Digital • Medan, Sumatera Utara</p>
        <p>Email ini dikirim secara otomatis pada {{ now()->format('d F Y') }}. Jangan balas email ini.</p>
    </div>
</div>

</body>
</html>
