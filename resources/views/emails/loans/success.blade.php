<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Peminjaman Buku</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .header {
            background: #4f46e5; /* indigo-600 */
            color: white;
            padding: 24px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 32px 24px;
        }
        .content h2 {
            color: #1f2937;
            font-size: 20px;
            margin-top: 0;
        }
        .details {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .details p {
            margin: 8px 0;
            font-size: 16px;
        }
        .details strong {
            color: #111827;
        }
        .footer {
            background: #f3f4f6;
            padding: 16px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
        .button {
            display: inline-block;
            background: #4f46e5;
            color: white !important;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            margin: 16px 0;
        }
        .button:hover {
            background: #4338ca;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Konfirmasi Peminjaman Buku</h1>
    </div>

    <div class="content">
        <h2>Halo, {{ $name }}!</h2>

        <p>Terima kasih telah meminjam buku di perpustakaan kami. Berikut detail peminjaman Anda:</p>

        <div class="details">
            <p><strong>Judul Buku:</strong> {{ $title }}</p>
            <p><strong>Tanggal Peminjaman:</strong> {{ $loan_date }}</p>
            <p><strong>Batas Pengembalian:</strong> {{ $due_date }}</p>
            <p><strong>Peminjam:</strong> {{ $name }}</p>
            @if(isset($code))
            <p><strong>Kode Peminjaman:</strong> {{ $code }}</p>
            @endif
        </div>

        <p>Mohon kembalikan buku tepat waktu agar tidak dikenakan denda keterlambatan. Anda bisa cek status peminjaman kapan saja di akun Anda.</p>

        <a href="{{ url('/student/loan/'.$id) }}" class="button">Lihat Status Peminjaman</a>

        <p>Terima kasih dan selamat membaca!</p>
    </div>

    <div class="footer">
        <p>Perpustakaan Digital • Medan, Sumatera Utara</p>
        <p>Email ini dikirim secara otomatis, jangan balas email ini.</p>
    </div>
</div>

</body>
</html>