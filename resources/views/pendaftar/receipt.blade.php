<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Kuitansi Pembayaran</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    @page { size: A4; margin: 20mm }
    body{font-family:'Poppins', Arial, Helvetica, sans-serif;color:#072033;margin:0;padding:0;background:#fff}
    .sheet{width:100%;max-width:800px;margin:0 auto;padding:28px 32px}

    .head{
      display:flex;align-items:flex-start;gap:18px;margin-bottom:28px
    }
    .logo { width:120px; height:auto }
    .org {
      flex:1; color:#0b4a7a; font-weight:700; font-size:18px; line-height:1.05
    }
    .org .name { font-size:20px; color:#0b4a7a }
    .org .sub { font-weight:600; color:#0b6aa0; margin-top:6px; font-size:14px }

    .receipt-title { text-align:right; color:#004269; font-weight:800; font-size:18px }

    .content{margin-top:12px}
    .line{display:flex;align-items:flex-start;gap:12px;padding:14px 0;border-bottom:1px solid rgba(2,6,23,0.04)}
    .label-col{width:220px;color:rgb(0, 20, 119); font-size:16px}
    .colon{width:24px;text-align:center;color:#072033;font-weight:700}
    .value-col{flex:1;font-size:16px;color:#072033}

    .label-small{font-size:14px;color:#0b6aa0;margin-bottom:6px}

    .footer-note{margin-top:28px;color:#556;font-size:13px}

    /* Print friendly */
    @media print {
      body{background:#fff}
      .sheet{padding:0;margin:0}
      @page{margin:15mm}
    }
  </style>
</head>
<body>
  <div class="sheet">
    <div class="head">
      <div><img class="logo" src="{{ public_path('storage/image/LOGO_LP3I.png') }}" alt="LP3I"></div>
      <div class="org">
        <div class="name">Lembaga Pendidikan<br>Dan Pengembangan<br>Profesi Indonesia</div>
        <div class="sub">Kampus LP3I Karawang</div>
      </div>
      {{-- <div class="receipt-title">KUITANSI<br><span style="font-weight:600;font-size:13px;color:#666">No: {{ $receipt_no ?? '-' }}</span></div> --}}
    </div>

    <div class="content">
      <div class="line">
        <div class="label-col">Telah terima dari : {{ $calon->nama_mhs ?? ($calon->user->name ?? '-') }}</div>
        
      

      <div class="line">
        <div class="label-col">Uang sejumlah : {{ isset($amount_words) ? ' ('. $amount_words .')' : '' }} </div>
      </div>

      <div class="line">
        <div class="label-col">Tanggal pembayaran : {{ $date ?? date('d-m-Y') }}</div>
      </div>

      <div class="footer-note">Dokumen ini merupakan bukti pembayaran resmi LP3I Karawang.</div>
    </div>
  </div>
</body>
</html>
