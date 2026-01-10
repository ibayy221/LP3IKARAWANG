<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Marketing Login - Smart Presenter</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root{--brand-dark:#004269;--brand-accent:#009DA5}
        html,body{height:100%}
        body{font-family:'Poppins',sans-serif;margin:0;padding:2rem;display:flex;align-items:center;justify-content:center;min-height:100vh;background:linear-gradient(135deg,var(--brand-dark),#0b7280);color:#fff}

        .card{width:100%;max-width:420px;padding:2.2rem 2rem;background:rgba(255,255,255,0.98);border-radius:12px;box-shadow:0 18px 45px rgba(2,6,23,0.08);border:1px solid rgba(2,6,23,0.04);text-align:center;color:#072033}
        .card h2{margin:0 0 0.6rem;color:var(--brand-dark);font-weight:700;letter-spacing:4px}
        .card h2::after{content:'';display:block;height:4px;width:70px;margin:8px auto 0;background:linear-gradient(90deg,var(--brand-dark),var(--brand-accent));border-radius:4px}
        .form-group{margin-bottom:0.6rem;text-align:left}
        .form-control{width:100%;padding:.55rem 0;border:none;border-bottom:2px solid rgba(4,10,15,0.06);background:transparent;color:#072033}
        .form-control::placeholder{color:#9aa6ac}
        .form-control:focus{outline:none;border-bottom-color:transparent;background-image:linear-gradient(90deg,var(--brand-dark),var(--brand-accent));background-repeat:no-repeat;background-position:0 100%;background-size:100% 3px}
        .btn-primary{display:inline-block;padding:.85rem 2.4rem;border-radius:999px;background:linear-gradient(90deg,var(--brand-dark),var(--brand-accent));color:#fff;border:none;cursor:pointer;font-weight:700;box-shadow:0 18px 30px rgba(0,157,165,0.12);text-transform:uppercase;letter-spacing:2px}
        .help{color:#6b7880;font-size:.9rem;margin-top:.5rem}
        .error{background:#fff1f2;color:#7f1d1d;padding:.6rem;border-radius:6px;margin-bottom:1rem}
        @media (max-width:480px){body{padding:1rem}.card{padding:1.25rem;border-radius:12px}}
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