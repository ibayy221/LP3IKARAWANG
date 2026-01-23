<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Edit Penempatan</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>body{font-family:'Poppins',sans-serif;padding:1.25rem;background:#f4f6f8} .wrap{max-width:800px;margin:0 auto} label{display:block;margin-top:.5rem} img{max-width:200px;display:block;margin-top:.5rem}</style>
</head>
<body>
  <div class="wrap">
    <h1>Edit Penempatan</h1>
    <form action="{{ route('admin.penempatan.update', $penempatan) }}" method="post" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <label>Judul<br><input type="text" name="title" value="{{ old('title', $penempatan->title) }}" style="width:100%"></label>
      <label>Deskripsi<br><textarea name="description" style="width:100%" rows="4">{{ old('description', $penempatan->description) }}</textarea></label>
      <label>URL Sumber (opsional)<br><input type="text" name="source_url" value="{{ old('source_url', $penempatan->source_url) }}" style="width:100%"></label>
      <label>Gambar (jpg,png, max 2MB)<br><input type="file" name="image"></label>
      @if($penempatan->image_path)
        <img src="{{ asset(str_replace('storage/','',$penempatan->image_path)) }}" alt="preview">
      @endif
      <div style="margin-top:.75rem"><button type="submit">Simpan</button> <a href="{{ route('admin.penempatan.index') }}">Batal</a></div>
    </form>
  </div>
</body>
</html>
