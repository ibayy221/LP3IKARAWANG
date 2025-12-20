<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tambah Pendaftar - Smart Presenter</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body{font-family:'Poppins',sans-serif;background:#f6f9fc;color:#0f172a}
    .wrap{max-width:900px;margin:2rem auto;padding:1rem}
    .card{background:#fff;padding:1.25rem;border-radius:10px;box-shadow:0 6px 24px rgba(15,23,42,0.06)}
    label{display:block;margin-bottom:.4rem;font-weight:600}
    .form-control{width:100%;padding:.6rem;border-radius:8px;border:1px solid #eef2f7;font-size:0.95rem;line-height:1.25}
    /* Polished select */
    select.form-control{ -webkit-appearance:none; -moz-appearance:none; appearance:none; padding-right:2rem; font-size:0.92rem; line-height:1.25; background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='10' viewBox='0 0 14 10'%3E%3Cpath fill='%236B7280' d='M7 10L0 0h14z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position: right 10px center; background-size:12px 8px;}
    select.form-control option{ font-size:0.93rem; padding:6px 8px; }
    .btn-primary{background:linear-gradient(90deg,#004269,#009DA5);color:#fff;padding:.6rem .9rem;border:none;border-radius:8px}
    .bg-hero{height:160px;border-radius:8px;background-size:cover;background-position:center;margin-bottom:1rem}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <div class="bg-hero" style="background-image: url('{{ !empty($registrationImageUrl) ? asset(ltrim($registrationImageUrl,'/')) : asset('storage/illustrations/registration-illustration.svg') }}')"></div>
      <h2>Tambah Calon Mahasiswa (Manual)</h2>
      <form method="POST" action="{{ route('marketing.pendaftar.store') }}">
        @csrf
        <div style="margin-top:.75rem">
          <label>Nama</label>
          <input class="form-control" name="nama_mhs" required>
        </div>
        <div style="margin-top:.75rem">
          <label>Email</label>
          <input class="form-control" name="email" type="email">
        </div>
        <div style="margin-top:.75rem">
          <label>No HP</label>
          <input class="form-control" name="no_hp">
        </div>
        <div style="margin-top:.75rem">
          <label>Jurusan</label>
          <select class="form-control" name="jurusan">
            <option value="">-- Pilih Jurusan --</option>
            <option value="ASE">ASE — Application Software Engineering</option>
            <option value="OAA">OAA — Office Administration Automatization</option>
            <option value="AIS">AIS — Accounting Information System</option>
          </select>
        </div>
        <div style="margin-top:.75rem">
          <label>Sumber Pendaftaran</label>
          <select name="sumber_pendaftaran" class="form-control">
            <option value="offline">Offline</option>
            <option value="online">Online</option>
          </select>
        </div>
        <div style="margin-top:1rem;text-align:right">
          <a href="{{ route('marketing.pendaftar.index') }}" style="margin-right:.5rem">Batal</a>
          <button class="btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>