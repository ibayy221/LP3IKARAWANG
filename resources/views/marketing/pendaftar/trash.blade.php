<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Trash Pendaftar</title>
  <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f6f9fc;color:#0f172a}
    .wrap{max-width:900px;margin:2rem auto;padding:1rem}
    .card{background:#fff;padding:1rem;border-radius:8px;box-shadow:0 8px 24px rgba(15,23,42,0.06)}
    .muted{color:#667085}
  </style>
</head>
<body>
  <div class="wrap">
    <a href="{{ route('marketing.pendaftar.index') }}">← Kembali ke daftar</a>
    <h2>Trash Pendaftar</h2>
    <div class="card">
      <p class="muted">Belum ada data trash karena model `Mahasiswa` tidak menggunakan SoftDeletes. Jika Anda menambahkan SoftDeletes, daftar entri yang dihapus akan tampil di sini.</p>
      <ul>
        @forelse($trashed as $t)
          <li>{{ $t->nama_mhs ?? '(tanpa nama)' }} — {{ $t->email ?? '-' }}</li>
        @empty
          <li>Tidak ada data di trash.</li>
        @endforelse
      </ul>
    </div>
  </div>
</body>
</html>