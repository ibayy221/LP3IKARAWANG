<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin - Penempatan</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body{font-family:'Poppins',sans-serif;padding:1.25rem;background:#f4f6f8}
    .wrap{max-width:1100px;margin:0 auto}
    .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem}
    .card{background:#fff;padding:0.75rem;border-radius:8px;border:1px solid #e6eef2}
    img{max-width:100%;height:auto;border-radius:6px}
    .actions{display:flex;gap:.5rem;margin-top:.5rem;flex-wrap:wrap}
    @media (max-width:900px){.grid{grid-template-columns:repeat(2,1fr)}}
    @media (max-width:640px){body{padding:.75rem}.grid{grid-template-columns:1fr}}
  </style>
</head>
<body>
  <div class="wrap">
    <h1>Penempatan - Admin</h1>
    @if(session('success'))<div style="background:#ecfdf5;padding:.5rem;border:1px solid #bbf7d0">{{ session('success') }}</div>@endif
    <p><a href="{{ route('admin.penempatan.create') }}">Tambah Item</a></p>
    <div class="grid">
      @forelse($items as $it)
        <div class="card">
          <div>
            @if($it->image_path)
              <img src="{{ asset(str_replace('storage/','',$it->image_path)) }}" alt="{{ $it->title }}">
            @else
              <div style="height:120px;display:flex;align-items:center;justify-content:center;background:#f0f3f5;border-radius:6px">No image</div>
            @endif
          </div>
          <h3 style="margin:.5rem 0 0">{{ $it->title }}</h3>
          <div style="color:#556">{{ \\Illuminate\\Support\\Str::limit($it->description,120) }}</div>
          <div class="actions">
            <a href="{{ route('admin.penempatan.edit', $it) }}">Edit</a>
            <form method="POST" action="{{ route('admin.penempatan.destroy', $it) }}" onsubmit="return confirm('Hapus item ini?');">
              @csrf
              @method('DELETE')
              <button type="submit">Hapus</button>
            </form>
          </div>
        </div>
      @empty
        <div>Tidak ada item. Tambah item baru.</div>
      @endforelse
    </div>
  </div>
</body>
</html>
