<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>applicant detail - Smart Presenter</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    :root{--basic:#004269;--accent:#009DA5;--muted:#6b7280}
    body{font-family:'Poppins',sans-serif;background:linear-gradient(180deg,var(--basic) 0%, rgba(0,66,105,0.06) 30%, #f6f9fc 100%);color:#0f172a}
    .wrap{max-width:1000px;margin:2rem auto;padding:1rem}
    .card{background:#fff;padding:1.25rem;border-radius:12px;box-shadow:0 10px 30px rgba(15,23,42,0.06);border:1px solid #e6eef6}
    .grid-2{display:grid;grid-template-columns:1fr 320px;gap:1.25rem}
    .meta{color:var(--muted);font-size:0.95rem;margin-bottom:0.5rem}
    .bg-hero{height:120px;border-radius:8px;background-size:cover;background-position:center;margin-bottom:1rem}
    .label{font-weight:700;color:#12263a;margin-bottom:6px}
    .doc-list{display:flex;flex-direction:column;gap:.6rem}
    .doc-btn{display:inline-flex;align-items:center;gap:.6rem;padding:.5rem .75rem;border-radius:8px;background:linear-gradient(90deg,var(--basic),var(--accent));color:#fff;text-decoration:none;border:none}
    .doc-file{display:flex;align-items:center;gap:.6rem;padding:.6rem;border-radius:8px;background:#fbfeff;border:1px solid #eef6fb}
    .notes{width:100%;min-height:120px;padding:.6rem;border-radius:8px;border:1px solid #eef2f7}
    .btn-save{background:linear-gradient(90deg,var(--basic),var(--accent));color:#fff;padding:.6rem .9rem;border-radius:8px;border:none}
    @media (max-width:900px){ .grid-2{grid-template-columns:1fr; } .bg-hero{height:160px} }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <div class="bg-hero" style="background-image: url('{{ !empty($registrationImageUrl) ? asset(ltrim($registrationImageUrl,'/')) : asset('storage/illustrations/registration-illustration.svg') }}')"></div>
      <h2 style="margin:0 0 .5rem">Student detail</h2>
      @if(session('success')) <div style="color:green;margin-bottom:.75rem">{{ session('success') }}</div> @endif

      <div class="grid-2">
        <div>
          <p class="meta">Tanggal Daftar: {{ $m->created_at->format('d M Y') }}</p>
          <div style="display:grid;grid-template-columns:140px 1fr;gap:.5rem .75rem;align-items:start">
            <div class="label">Nama</div><div>{{ $m->nama_mhs }}</div>
            <div class="label">Email</div><div>{{ $m->email ?? '-' }}</div>
            <div class="label">No HP</div><div>{{ $m->no_hp ?? '-' }}</div>
            <div class="label">Bidang Keahlian</div><div>{{ $m->jurusan ?? '-' }}</div>
            <div class="label">Jenis Kelas</div><div>{{ $m->jenis_kelas ?? '-' }}</div>
            <div class="label">Asal Sekolah</div><div>{{ $m->asal_sekolah ?? '-' }}</div>
            <div class="label">Status Verifikasi</div>
            <div><strong style="color:{{ $m->status_verifikasi === 'verified' ? 'green' : ($m->status_verifikasi === 'rejected' ? 'red' : '#f59e0b') }}">{{ $m->status_verifikasi === 'verified' ? 'Sudah terverifikasi' : ($m->status_verifikasi === 'rejected' ? 'Ditolak' : 'Menunggu verifikasi') }}</strong></div>
          </div>

          <hr style="margin:1rem 0">

          <h4 style="margin:0 0 .5rem">Marketing notes</h4>
          <form method="POST" action="{{ route('marketing.pendaftar.note', $m->id) }}">
            @csrf
            <textarea name="marketing_notes" class="notes">{{ old('marketing_notes', $m->marketing_notes) }}</textarea>
            <div style="margin-top:.75rem;text-align:right">
              <button class="btn-save">Save notes</button>
            </div>
          </form>
          <div style="margin-top:1rem"><a href="{{ route('marketing.pendaftar.index') }}">← Kembali ke daftar</a></div>
        </div>

        <aside>
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.6rem">
            <div style="font-weight:700">Document</div>
            <div style="font-size:.85rem;color:var(--muted)">ID: {{ $m->id }}</div>
          </div>

          <div class="doc-list">
            @if(!empty($m->ktp_path))
              <div class="doc-file"><div style="flex:1">KTP / Kartu Pelajar</div><a href="{{ route('marketing.pendaftar.ktp', $m->id) }}" class="doc-btn">Download</a></div>
            @endif
            @if(!empty($m->ijazah_path))
              <div class="doc-file"><div style="flex:1">Ijazah</div><a href="{{ route('marketing.pendaftar.ijazah', $m->id) }}" class="doc-btn">Download</a></div>
            @endif
            @if(!empty($m->akte_kelahiran_path))
              <div class="doc-file"><div style="flex:1">Akte Kelahiran</div><a href="{{ route('marketing.pendaftar.akte', $m->id) }}" class="doc-btn">Download</a></div>
            @endif
            @if(!empty($m->surat_sudah_bekerja_path))
              <div class="doc-file"><div style="flex:1">Surat Keterangan Bekerja</div><a href="{{ route('marketing.pendaftar.surat_bekerja', $m->id) }}" class="doc-btn">Download</a></div>
            @endif
            @if(empty($m->ktp_path) && empty($m->ijazah_path) && empty($m->akte_kelahiran_path) && empty($m->surat_sudah_bekerja_path))
              <div style="color:#64748b">No document uploaded</div>
            @endif
          </div>
        </aside>
      </div>
    </div>
  </div>
</body>
</html>