<!doctype html>
<html>
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="font-family:Arial, sans-serif;">
  <p>Halo {{ $calon->nama_mhs ?? 'Calon Mahasiswa' }},</p>
  <p>Status pendaftaran Anda telah diubah menjadi <strong>{{ $statusLabel ?? ucfirst($status) }}</strong>.</p>
  <p>Terima kasih telah mendaftar di LP3I Karawang.</p>
  <p>Salam,<br>Tim Marketing LP3I Karawang</p>
</body>
</html>