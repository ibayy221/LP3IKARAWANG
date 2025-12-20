<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Marketing Login - Smart Presenter</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body{font-family:'Poppins',sans-serif;background:linear-gradient(135deg,#0f172a,#1f2937);min-height:100vh;display:flex;align-items:center;justify-content:center;color:#fff}
        .card{background:rgba(255,255,255,0.03);color:#fff;padding:2rem;border-radius:12px;max-width:420px;width:100%;box-shadow:0 8px 30px rgba(2,6,23,0.8)}
        .card h2{margin-bottom:1rem}
        .form-group{margin-bottom:1rem}
        .form-control{width:100%;padding:.8rem;border-radius:8px;border:1px solid rgba(255,255,255,0.06);background:rgba(255,255,255,0.02);color:#fff}
        .btn{display:inline-block;padding:.7rem 1.2rem;border-radius:999px;background:#06b6d4;color:#042029;border:none;cursor:pointer}
        .help{color:#9ca3af;font-size:.9rem;margin-top:.5rem}
        .error{background:#fee2e2;color:#991b1b;padding:.6rem;border-radius:6px;margin-bottom:1rem;color:#991b1b}
    </style>
</head>
<body>
<div class="card">
    <h2>Smart Presenter - Marketing Login</h2>
    @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ url('/marketing/login') }}">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input id="username" name="username" type="text" class="form-control" required autofocus placeholder="Masukkan username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" class="form-control" required>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center">
            <small class="help">Login khusus untuk tim marketing</small>
            <button class="btn">Masuk</button>
        </div>
    </form>
</div>
</body>
</html>