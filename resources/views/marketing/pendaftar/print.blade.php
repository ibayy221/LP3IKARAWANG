<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Print Pendaftar</title>
  <style>
    body{font-family:Arial, Helvetica, sans-serif;color:#0f172a}
    table{width:100%;border-collapse:collapse}
    th,td{border:1px solid #ddd;padding:.4rem;text-align:left}
    h1{font-size:18px}
    @media print{ .no-print{display:none} }
  </style>
</head>
<body>
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
    <h1>Daftar Pendaftar</h1>
    <div class="no-print"><button onclick="window.print()">Print</button></div>
  </div>
  <table>
    <thead>
      <tr><th>Nama</th><th>Email</th><th>No HP</th><th>Jurusan</th><th>Sumber</th><th>Status</th><th>Tanggal</th></tr>
    </thead>
    <tbody>
      @foreach($rows as $r)
        <tr>
          <td>{{ $r->nama_mhs }}</td>
          <td>{{ $r->email }}</td>
          <td>{{ $r->no_hp }}</td>
          <td>{{ $r->jurusan }}</td>
          <td>{{ $r->sumber_pendaftaran }}</td>
          <td>{{ $r->status_verifikasi }}</td>
          <td>{{ $r->created_at->format('d M Y') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>