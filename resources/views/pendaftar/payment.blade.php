<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Pembayaran Pendaftaran</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body{font-family:'Poppins',Arial,sans-serif;padding:2rem;background:#f6f9fc;color:#0f172a}
    .container{max-width:900px;margin:0 auto}
    .card{padding:1.2rem;background:#fff;border-radius:12px;box-shadow:0 8px 24px rgba(15,23,42,0.06)}
    .heading{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem}
    .btn-primary{background:linear-gradient(90deg,#00f6ec,#00b8ff);color:#003049;border:none;padding:.5rem .9rem;border-radius:999px;font-weight:700}
    .btn-plain{background:transparent;border:1px solid rgba(15,23,42,0.06);padding:.4rem .7rem;border-radius:8px}
    .method{padding:.8rem;border-radius:8px;border:1px dashed rgba(2,6,23,0.06);margin-bottom:.8rem}
    @media (max-width:800px){body{padding:1rem}}
  </style>
</head>
<body>
  <div class="container">
    <div class="heading">
      <div>
        <h2 style="margin:0">Pembayaran Pendaftaran</h2>
        <div style="color:#586d7a;font-size:.95rem">Untuk: <strong>{{ $calon->nama_mhs }}</strong></div>
      </div>
      <div><a class="btn-plain" href="{{ route('pendaftar.dashboard') }}">Kembali</a></div>
    </div>

    <div class="card">
      <div style="margin-bottom:.8rem;color:#475569">Silakan pilih metode pembayaran. Ini adalah halaman simulasi — klik tombol "Selesaikan Pembayaran" untuk menandai pembayaran sebagai terselesaikan.</div>

      <div class="method">• Transfer Bank / GoPay / ShopeePay<br>Nominal: <strong>Rp {{ number_format($calon->payment_amount ?? 350000,0,',','.') }}</strong><br>Kode Bayar: <strong>{{ $calon->nipd ?? $calon->id }}</strong></div>

      <form method="POST" action="{{ route('pendaftar.payment.markPaid') }}">
        @csrf
        <button class="btn-primary" type="submit">Selesaikan Pembayaran (Simulasi)</button>
      </form>

      <div style="margin-top:1rem;color:#586d7a;font-size:.92rem">Jika Anda membutuhkan bantuan pembayaran, hubungi admin: <a href="mailto:admissions@lp3i.ac.id">admissions@lp3i.ac.id</a></div>
    </div>
  </div>
</body>
</html>