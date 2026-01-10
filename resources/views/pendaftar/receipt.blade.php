<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Kuitansi Pembayaran</title>
  <style>
    body{font-family:,Arial,Helvetica,sans-serif;color:#04088d}
    .header{display:flex;align-items:center;gap:12px;margin-bottom:18px}
    .logo{width:120px}
    .title{flex:1;text-align:center}
    .title h3{;font-size:20px;color:#004269}
    .meta{margin-top:12px;font-size:14px}
    .box{border:1px solid #ddd;padding:12px;border-radius:6px;margin-top:12px}
    .field{margin-bottom:8px}
    .label{color:#555;font-size:12px}
    .value{font-weight:700}
  </style>
</head>
<body>
  <div class="header">
    <div><img class="logo" src="{{ public_path('storage/image/LOGO_LP3I_BLUE.png') }}" alt="LP3I"></div>
    <div class="title"><h3>Lembaga Pendidikan Dan Pengembangan Profesi Indonesia</h3></div>
    <div style="width:90px"></div>
  </div>

  <div class="box">
    <div class="field"><div class="label">Nama Pembayar</div><div class="value">{{ $calon->nama_mhs ?? ($calon->user->name ?? ' - ') }}</div></div>
    <div class="field"><div class="label">Nomor Pendaftaran</div><div class="value">{{ $calon->nipd ?? ($calon->id ?? '-') }}</div></div>
    <div class="field"><div class="label">Jumlah</div><div class="value">Rp {{ number_format($amount,0,',','.') }}</div></div>
    <div class="field"><div class="label">Tanggal</div><div class="value">{{ $date }}</div></div>
  </div>

  <div style="margin-top:26px;font-size:12px;color:#666">Dokumen ini adalah bukti pembayaran resmi LP3I Karawang.</div>
</body>
</html>
