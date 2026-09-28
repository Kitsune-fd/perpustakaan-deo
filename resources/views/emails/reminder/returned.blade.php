<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Pengembalian Buku</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 0; color: #333; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .header { background: #f59e0b; /* amber-500 */ color: white; padding: 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 32px 24px; }
        .content h2 { color: #1f2937; font-size: 20px; margin-top: 0; }
        .details { background: #fefce8; border: 1px solid #fef08a; border-radius: 6px; padding: 20px; margin: 20px 0; }
        .details p { margin: 8px 0; font-size: 16px; }
        .details strong { color: #92400e; }
        .footer { background: #f3f4f6; padding: 16px; text-align: center; font-size: 14px; color: #6b7280; border-top: 1px solid #e5e7eb; }
        .button { display: inline-block; background: #f59e0b; color: white !important; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: 500; margin: 16px 0; }
        .button:hover { background: #d97706; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Pengingat: Buku Segera Jatuh Tempo</h1>
    </div>

    <div class="content">
        <h2>Halo, {{ $name }}!</h2>

        <p>Kami ingin mengingatkan bahwa buku yang Anda pinjam akan segera jatuh tempo. Silakan kembalikan tepat waktu agar terhindar dari denda.</p>

        <div class="details">
            <p><strong>Judul Buku:</strong> {{ $title }}</p>
            <p><strong>Tanggal Peminjaman:</strong> {{ $loan_date }}</p>
            <p><strong>Batas Pengembalian:</strong> {{ $due_date }} <strong>(sisa {{ $remaining_days }} hari)</strong></p>
            <p><strong>Peminjam:</strong> {{ $name }}</p>
            @if(isset($code))
            <p><strong>Kode Peminjaman:</strong> {{ $code }}</p>
            @endif
        </div>

        <p>Terima kasih atas kerjasamanya dalam menjaga ketersediaan buku untuk anggota perpustakaan lainnya.</p>

        <a href="{{ url('/peminjaman/saya') }}" class="button">Cek Status & Kembalikan Buku</a>

        <p>Jika Anda sudah mengembalikan buku ini, abaikan email ini. Jika ada kendala, hubungi petugas perpustakaan segera.</p>

        <p>Selamat membaca dan semoga bermanfaat!</p>
    </div>

    <div class="footer">
        <p>Perpustakaan Digital • Medan, Sumatera Utara</p>
        <p>Email ini dikirim secara otomatis pada {{ now()->format('d F Y') }}. Jangan balas email ini.</p>
    </div>
</div>

</body>
</html>