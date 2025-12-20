<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login Pendaftar</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    :root{--brand-dark:#004269;--brand-accent:#009DA5}
    body{font-family:'Poppins',Arial,Helvetica,sans-serif;padding:2rem;background:#f6f9fc;color:#0f172a}
    .card{max-width:420px;margin:2rem auto;padding:1.5rem;background:#fff;border-radius:12px;box-shadow:0 8px 24px rgba(15,23,42,0.06)}
    .card h2{margin-top:0;color:var(--brand-dark)}
    .form-control{width:100%;padding:.6rem;border-radius:8px;border:1px solid rgba(15,23,42,0.06);box-shadow:none}
    .btn-primary{background:linear-gradient(90deg,var(--brand-dark),var(--brand-accent));color:#fff;border:none;padding:.6rem .9rem;border-radius:10px}
    .alert-success{color:#065f46;background:#ecfdf5;padding:.5rem .75rem;border-radius:6px}
    .alert-error{color:#7f1d1d;background:#fff1f2;padding:.5rem .75rem;border-radius:6px}
  </style>
</head>
<body>
  <div class="card">
    <h2>Login Pendaftar</h2>
    @if(session('success')) <div class="alert-success">{{ session('success') }}</div> @endif
    @if($errors->any()) <div class="alert-error">{{ $errors->first() }}</div> @endif

    <form action="{{ route('pendaftar.login.post') }}" method="POST">
      @csrf
      <div style="margin:.6rem 0">
        <label class="form-label">Email</label>
        <input type="email" name="email" required class="form-control">
      </div>
      <div style="margin:.6rem 0">
        <label class="form-label">Password</label>
        <input type="password" name="password" required class="form-control">
      </div>
      <div style="margin-top:.6rem;display:flex;justify-content:flex-end;align-items:center">
        <button class="btn-primary">Login</button>
      </div>
    </form>
  </div>
</body>
</html>