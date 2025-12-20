<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Detail Pendaftar - Smart Presenter</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body{font-family:'Poppins',sans-serif;background:#f6f9fc;color:#0f172a}
    .wrap{max-width:900px;margin:2rem auto;padding:1rem}
    .card{background:#fff;padding:1.25rem;border-radius:10px;box-shadow:0 6px 24px rgba(15,23,42,0.06)}
    .form-control{width:100%;padding:.6rem;border-radius:8px;border:1px solid #eef2f7}
    .btn-primary{background:linear-gradient(90deg,#004269,#009DA5);color:#fff;padding:.6rem .9rem;border:none;border-radius:8px}
    .meta{color:#6b7280;font-size:.95rem}
    .bg-hero{height:120px;border-radius:8px;background-size:cover;background-position:center;margin-bottom:1rem}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <div class="bg-hero" style="background-image: url('{{ !empty($registrationImageUrl) ? asset(ltrim($registrationImageUrl,'/')) : asset('storage/illustrations/registration-illustration.svg') }}')"></div>
      <h2>Detail Calon Mahasiswa</h2>
      @if(session('success')) <div style="color:green">{{ session('success') }}</div> @endif
      <div style="margin-top:.5rem">
        <p class="meta">Tanggal Daftar: {{ $m->created_at->format('d M Y') }}</p>
        <p><strong>Nama:</strong> {{ $m->nama_mhs }}</p>
        <p><strong>Email:</strong> {{ $m->email }}</p>
        <p><strong>No HP:</strong> {{ $m->no_hp }}</p>
        <p><strong>Jurusan:</strong> {{ $m->jurusan }}</p>
        <p><strong>Sumber:</strong> {{ ucfirst($m->sumber_pendaftaran ?? 'offline') }}</p>
        @php
          $verif = $m->status_verifikasi ?? 'pending';
          $verifLabel = $verif === 'verified' ? 'Sudah terverifikasi' : ($verif === 'rejected' ? 'Ditolak' : 'Menunggu verifikasi');
          $pay = $m->payment_status ?? 'unpaid';
          $payLabel = $pay === 'paid' ? 'Sudah dibayar' : 'Belum dibayar';
        @endphp
        <p><strong>Status Verifikasi:</strong> <span style="color:{{ $verif === 'verified' ? 'green' : ($verif === 'rejected' ? 'red' : '#f59e0b') }}">{{ $verifLabel }}</span></p>
        <p><strong>Status Pembayaran:</strong> <span style="color:{{ $pay === 'paid' ? 'green' : '#ef4444' }}">{{ $payLabel }}</span></p>
        <hr />
        <h4>Catatan Marketing</h4>
        <form method="POST" action="{{ route('marketing.pendaftar.note', $m->id) }}">
          @csrf
          <textarea class="form-control" name="marketing_notes" rows="4">{{ old('marketing_notes', $m->marketing_notes) }}</textarea>
          <div style="margin-top:.5rem;text-align:right"><button class="btn-primary">Simpan Catatan</button></div>
        </form>
        <div style="margin-top:1rem"><a href="{{ route('marketing.pendaftar.index') }}">Kembali ke daftar</a></div>
      </div>
    </div>
  </div>
</body>
</html>