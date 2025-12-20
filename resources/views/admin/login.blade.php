<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Login - LP3I Karawang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body{font-family:'Poppins',sans-serif;background:linear-gradient(135deg,#1e3c72,#2a5298);min-height:100vh;display:flex;align-items:center;justify-content:center;color:#fff}
        .card{background:rgba(255,255,255,0.95);color:#1e3c72;padding:2rem;border-radius:12px;max-width:420px;width:100%;box-shadow:0 10px 30px rgba(0,0,0,0.2)}
        .card h2{margin-bottom:1rem}
        .form-group{margin-bottom:1rem}
        .form-control{width:100%;padding:.8rem;border-radius:8px;border:1px solid rgba(30,60,114,0.12)}
        .btn{display:inline-block;padding:.7rem 1.2rem;border-radius:999px;background:#1e3c72;color:#fff;border:none;cursor:pointer}
        .help{color:#666;font-size:.9rem;margin-top:.5rem}
        .error{background:#ffe6e6;color:#c0392b;padding:.6rem;border-radius:6px;margin-bottom:1rem}
    </style>
</head>
<body>
<div class="card">
    <h2>Admin Login</h2>
    @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ url('/admin/login') }}">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input id="username" name="username" type="text" class="form-control" required autofocus placeholder="Masukkan username (contoh: lp3ikarawang)">
            <small class="help">Gunakan username yang diberikan (bukan email).</small>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" class="form-control" required>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center">
            <small class="help">Login sebagai admin untuk mengelola konten.</small>
            <button class="btn">Masuk</button>
        </div>
    </form>
</div>
</body>
</html>