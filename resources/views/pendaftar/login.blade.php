<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login Pendaftar</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    :root{--brand-dark:#004269;--brand-accent:#009DA5}
    html,body{height:100%}
    body{font-family:'Poppins';margin:0;padding:2rem;display:flex;align-items:center;justify-content:center;min-height:100vh;background:linear-gradient(135deg,var(--brand-dark),#0b7280);color:#fff}

    .card{width:100%;max-width:420px;padding:2.2rem 2rem;background:rgba(255,255,255,0.98);border-radius:16px;box-shadow:0 18px 45px rgba(2,6,23,0.08);border:1px solid rgba(2,6,23,0.04);text-align:center;color:#072033}
    .logo-wrap{display:flex;justify-content:center;margin-bottom:0.5rem}
    .logo-wrap img{height:48px;object-fit:contain}

    .login-title{font-family:'Poppins'; font-weight:700;letter-spacing:4px;margin:0 0 0.6rem 0;color:var(--brand-dark)}
    .login-title::after{content:'';display:block;height:4px;width:70px;margin:8px auto 0;background:linear-gradient(90deg,var(--brand-dark),var(--brand-accent));border-radius:4px}
    .lead{margin:0 0 1rem 0;color:#6b7880;font-size:0.95rem}

    label.form-label{display:block;margin:1.1rem 0 0.35rem 0;text-align:left;color:#374151;font-weight:600}
    .input-wrap{position:relative}
    .form-control{width:100%;Padding:.55rem 0;border:none;border-bottom:2px solid rgba(4,10,15,0.06);background:transparent;font-size:1rem;color:#072033}
    .form-control::placeholder{color:#9aa6ac}
    .form-control:focus{outline:none;border-bottom-color:transparent;background-image:linear-gradient(90deg,var(--brand-dark),var(--brand-accent));background-repeat:no-repeat;background-position:0 100%;background-size:100% 3px}

    .forgot{font-size:0.9rem;color:var(--brand-accent);text-decoration:none}

    .btn-primary{display:inline-block;margin-top:1.6rem;padding:.85rem 2.4rem;border-radius:999px;background:linear-gradient(90deg,var(--brand-dark),var(--brand-accent));color:#fff;border:none;cursor:pointer;font-weight:700;box-shadow:0 18px 30px rgba(0,157,165,0.12);text-transform:uppercase;letter-spacing:2px}

    .small-note{margin-top:0.8rem;color:var(--brand-accent)}

    @media (max-width:480px){body{padding:1rem}.card{padding:1.25rem;border-radius:12px}}
  </style>
</head>
<body>
  <div class="card">
    <div class="logo-wrap">
      <img src="{{ asset('storage/image/LOGO_LP3I.png') }}" alt="LP3I" onerror="this.onerror=null;this.src='{{ asset('storage/image/landingPage1.png') }}'" />
    </div>
    <h2 class="login-title">LOGIN</h2>
    <p class="lead">Masuk untuk mengelola pendaftaran dan melihat status Anda.</p>

    @if(session('success')) <div class="alert-success">{{ session('success') }}</div> @endif
    @if($errors->any()) <div class="alert-error">{{ $errors->first() }}</div> @endif

    <form action="{{ route('pendaftar.login.post') }}" method="POST">
      @csrf
      <div style="margin:.2rem 0;text-align:left">
        <label class="form-label">Email</label>
        <div class="input-wrap"><input type="email" name="email" required class="form-control" placeholder="email@domain.com"></div>
      </div>
      <div style="margin:.2rem 0;text-align:left">
        <label class="form-label">Password</label>
        <div class="input-wrap"><input type="password" name="password" required class="form-control" placeholder="Masukkan password"></div>
        <div style="display:flex;justify-content:flex-end;margin-top:6px"><a href="#" class="forgot">Lupa password?</a></div>
      </div>
      <div style="text-align:center">
        <button class="btn-primary" type="submit">Login</button>
        <div class="small-note">Belum punya akun? <a href="{{ route('mahasiswa.create') }}" style="color:var(--brand-accent);text-decoration:none">Daftar</a></div>
      </div>
    </form>
  </div>
</body>
</html>