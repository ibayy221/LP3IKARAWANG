<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login Pendaftar</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    :root{--brand-dark:#004269;--brand-accent:#009DA5;--bg-start:#eef6fb;--bg-end:#f4fbfd}
    html,body{height:100%}
    body{font-family:'Poppins',Arial,Helvetica,sans-serif;margin:0;padding:2rem;display:flex;align-items:center;justify-content:center;min-height:100vh;background:linear-gradient(180deg,var(--bg-start),var(--bg-end));color:#072033}

    .card{width:100%;max-width:520px;padding:2rem;background:#ffffff;border-radius:16px;box-shadow:0 18px 45px rgba(2,6,23,0.08);border:1px solid rgba(2,6,23,0.04)}
    .card .logo-wrap{display:flex;justify-content:center;margin-bottom:0.6rem}
    .card .logo-wrap img{height:56px;object-fit:contain}
    .card h2{margin:0 0 0.5rem 0;color:var(--brand-dark);font-size:1.6rem}
    .card p.lead{margin:0 0 1rem 0;color:#4b6b7a}

    label.form-label{display:block;margin-bottom:0.45rem;color:var(--brand-dark);font-weight:600}
    .form-control{width:100%;padding:0.9rem;border-radius:10px;border:1px solid rgba(2,6,23,0.06);background:#f3fbfd;box-shadow:inset 0 3px 10px rgba(2,6,23,0.02);font-size:0.95rem}
    .form-control:focus{outline:none;border-color:var(--brand-accent);box-shadow:0 6px 18px rgba(0,157,165,0.08)}

    .actions{display:flex;gap:0.75rem;justify-content:flex-end;align-items:center;margin-top:0.6rem}
    .btn-primary{background:linear-gradient(90deg,var(--brand-dark),var(--brand-accent));color:#fff;border:none;padding:0.65rem 1.05rem;border-radius:999px;font-weight:700;box-shadow:0 10px 30px rgba(0,77,110,0.12);cursor:pointer}
    .btn-primary:hover{transform:translateY(-2px)}

    .alert-success{color:#054d3a;background:#ecfdf5;padding:.5rem .75rem;border-radius:8px;margin-bottom:0.75rem}
    .alert-error{color:#7f1d1d;background:#fff1f2;padding:.5rem .75rem;border-radius:8px;margin-bottom:0.75rem}

    @media (max-width:480px){
      body{padding:1rem}
      .card{padding:1.25rem;border-radius:12px}
      .card h2{font-size:1.25rem}
      .actions{justify-content:stretch}
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="logo-wrap">
      <img src="<?php echo e(asset('storage/image/LOGO_LP3I.png')); ?>" alt="LP3I" onerror="this.onerror=null;this.src='<?php echo e(asset('storage/image/landingPage1.png')); ?>'" />
    </div>
    <h2>Login Pendaftar</h2>
    <p class="lead">Masuk untuk mengelola pendaftaran dan melihat status Anda.</p>

    <?php if(session('success')): ?> <div class="alert-success"><?php echo e(session('success')); ?></div> <?php endif; ?>
    <?php if($errors->any()): ?> <div class="alert-error"><?php echo e($errors->first()); ?></div> <?php endif; ?>

    <form action="<?php echo e(route('pendaftar.login.post')); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <div style="margin:.6rem 0">
        <label class="form-label">Email</label>
        <input type="email" name="email" required class="form-control" placeholder="email@domain.com">
      </div>
      <div style="margin:.6rem 0">
        <label class="form-label">Password</label>
        <input type="password" name="password" required class="form-control" placeholder="Masukkan password">
      </div>
      <div class="actions">
        <a href="<?php echo e(url('/')); ?>" style="color:var(--brand-dark);text-decoration:none;font-weight:600;margin-right:auto">Kembali</a>
        <button class="btn-primary" type="submit">Login</button>
      </div>
    </form>
  </div>
</body>
</html><?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/pendaftar/login.blade.php ENDPATH**/ ?>