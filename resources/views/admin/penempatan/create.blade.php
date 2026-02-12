<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tambah Penempatan</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body{font-family:'Poppins',sans-serif;padding:1.25rem;background:#f4f6f8}
    .wrap{max-width:800px;margin:0 auto}
    label{display:block;margin-top:.5rem}
    @media (max-width:640px){body{padding:.75rem}}
  </style>
</head>
<body>
  <div class="wrap">
    <h1>Tambah Penempatan</h1>
    <form action="{{ route('admin.penempatan.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <label>Judul<br><input type="text" name="title" value="{{ old('title') }}" style="width:100%"></label>
      <label>Deskripsi<br><textarea name="description" style="width:100%" rows="4">{{ old('description') }}</textarea></label>
      <label>URL Sumber (opsional)<br><input type="text" name="source_url" value="{{ old('source_url') }}" style="width:100%"></label>
      <label>Gambar (jpg,png, max 2MB)<br><input type="file" name="image"></label>
      <div style="margin-top:.75rem"><button type="submit">Simpan</button> <a href="{{ route('admin.penempatan.index') }}">Batal</a></div>
    </form>
  </div>
</body>
</html>
