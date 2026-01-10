<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Mahasiswa - LP3I Karawang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Flatpickr for better date input -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Tom Select for nicer selects -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <style>
      :root { --brand-dark: #004269; --brand-accent: #009DA5; --brand-pink: #F15B67; --brand-red: #FF0000; }
      /* Color theme — match admin/dashboard vibe */
      body.registration-bg {
        background: #004269; /* match input background */
        min-height: 100vh;
        padding-top: 72px; /* avoid fixed header overlap */
        color: #111827;
        font-family: 'Poppins', sans-serif;
      }

      /* Limit the registration container width so it doesn't reach the navbar edges */
      .registration-container { max-width: 1100px; margin: 0 auto; }

      .registration-card {
        background: #ffffff; /* card matching input background */
        border: 2px solid rgba(30,60,114,0.12);
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(16,24,40,0.06);
        overflow: hidden;
      }

      .registration-card .card-body {
        padding: 2.25rem;
      }

      .registration-header {
        display:flex;
        align-items:center;
        gap:1rem;
        margin-bottom:1rem;
      }

      /* Remove logo box — keep only color/gradient accents */

      .registration-card h2 {
        color: var(--brand-dark); /* heading should be brand color */
        text-shadow: 0 6px 20px rgb(178, 173, 173);
      }

      .registration-card p.text-muted { color: #6b7280; }
      /* header subtext — white; show required note (asterisk + text) in red */
      .registration-subtext { color: #6b7280; }
      .registration-subtext .required { color: var(--brand-pink); font-weight:700; }

      /* Inputs */
      .registration-card .form-control,
      .registration-card .form-select {
        background: #f8fafc; /* input lightly contrasted with page */
        border: 1.5px solid rgba(30,60,114,0.12);
        color: #111827;
        text-align: left;
        border-radius: 10px;
        box-shadow: 0 6px 18px rgba(30,60,114,0.04);
      }

      .registration-card .form-control:focus,
      .registration-card .form-select:focus {
        border-color: var(--brand-accent);
        box-shadow: 0 6px 20px rgba(0,157,165,0.08) !important;
        background: #ffffff;
        color: #111827;
      }

      /* Labels should be dark because card uses light inputs */
      .registration-card .form-label { color: var(--brand-dark); font-weight:600; }

      .btn-primary {
        background: linear-gradient(90deg,var(--brand-dark),var(--brand-accent));
        border: none;
        box-shadow: 0 8px 24px rgba(0,66,105,0.12);
      }

      .btn-outline-secondary {
        color: var(--brand-dark);
        border-color: rgba(0,66,105,0.12);
      }

      .register-btn {
            display: inline-flex !important;
            align-items: center;
            gap: 0.5rem;
            background: var(--brand-dark) !important;
            color: white !important;
            padding: 0.5rem 1rem !important;
            text-decoration: none !important;
            border-radius: 20px !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            box-shadow: 0 4px 15px rgba(0, 66, 105, 0.3) !important;
            border: none !important;
            cursor: pointer !important;
        }
        .register-btn:hover { background: #003352 !important; transform: translateY(-2px); }

      /* Keep single-column layout that fits the container */
      .registration-layout { display:block; }

      /* New layout: left illustration column + right form (responsive) */
      .registration-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; align-items: start; }
      .registration-illustration { background: linear-gradient(180deg, rgba(0,157,165,0.03), #f8fafc); border-radius: 12px; padding: 1rem; display:flex; align-items:center; justify-content:center; flex-direction: column; }
      .registration-illustration img { max-width: 100%; height: auto; display:block; }
      /* illustration wrapper: controlled height and light overlay to reduce dominance */
      .illustration-wrapper { width:100%; height:300px; max-height:300px; border-radius:10px; background: linear-gradient(180deg,#fff,#f8fafc); border:1px solid rgba(0,157,165,0.06); display:flex; align-items:center; justify-content:center; overflow:hidden; position:relative; background-size:cover; background-position:center center; }
      .illustration-wrapper::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0.02), rgba(255,255,255,0.45)); pointer-events: none; }
      .illustration-wrapper img { width: 100%; height: 100%; object-fit: cover; object-position: center center; display:block; opacity:0.98; }
      /* Make object-position slightly higher on smaller screens to keep focal points visible */
      @media (max-width: 576px) {
        .illustration-wrapper { height: 180px; aspect-ratio: auto; }
        .illustration-wrapper img { object-position: center 40%; }
      }
      @media (max-width: 768px) {
        .illustration-wrapper { height: 220px; }
        .illustration-wrapper img { object-position: center 45%; }
      }

      /* Mobile-friendly layout: stack illustration and form */
      @media (max-width: 992px) {
        .registration-grid { grid-template-columns: 1fr; gap: 1rem; }
        .registration-illustration { order: -1; padding: 0; background: transparent; }
        .illustration-wrapper { height: 220px; margin: 0; border:none; background: transparent; width: calc(100% + 2.5rem); margin-left: -1.25rem; margin-right: -1.25rem; }
        .illustration-wrapper::after { display: none; }
        .illustration-wrapper img { width: 100%; height: 100%; object-fit: cover; object-position: center 45%; border-radius: 12px; display:block; }
        .registration-card .card-body { padding: 1.25rem; }
        .registration-card h2 { font-size: 1.5rem; }
        .registration-subtext { font-size: 0.95rem; }
        .registration-illustration { padding: 0; }
        .registration-illustration img { max-height: 160px; }
      }

      @media (max-width: 480px) {
        .illustration-wrapper { height: 160px; }
        .illustration-wrapper img { object-position: center 35%; }
      }
/* Login Button Styling (adjacent to register) */
        .login-btn {
            display: inline-flex !important;
            align-items: center;
            gap: 0.5rem;
            background: #004269 !important;
            color: white !important;
            padding: 0.55rem 1rem !important;
            text-decoration: none !important;
            border-radius: 18px !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            transition: all 0.25s ease;
            border: 1px solid rgba(255,255,255,0.12) !important;
            cursor: pointer !important;
            white-space: nowrap;
        }

        .login-btn:hover {
            background: rgba(255,255,255,0.06) !important;
            transform: translateY(-1px);
            box-shadow: none !important;
        }
      /* Form actions and spacing */
      .form-actions { display:flex; gap: 1rem; align-items:center; justify-content:center; margin-top: 1.25rem; }
      .form-actions .btn { min-width: 150px; border-radius: 28px; padding: 0.6rem 1.25rem; font-weight:600; }
      .form-actions .btn-cancel { background: transparent; color: var(--brand-pink); border: 1.5px solid var(--brand-pink); box-shadow:none; }
      .form-actions .btn-cancel:hover { background: rgba(241,91,103,0.04); }
      .form-actions .btn-submit { background: linear-gradient(90deg,var(--brand-dark),var(--brand-accent)); color: white; border: none; box-shadow: 0 8px 24px rgba(0,66,105,0.12); }

      @media (max-width: 576px) {
        .form-actions { flex-direction: column; gap: 0.75rem; align-items: stretch; }
        .form-actions .btn { width: 100%; min-width: 0; }
      }
    </style>
    <style>
      /* Form field sizing, labels and consistent spacing */
      .registration-card h2 { font-size: 1.9rem; font-weight:700; color: var(--brand-dark); text-shadow: none; margin-bottom: 0.25rem; }
      .registration-subtext { color: #6b7280; font-size: 0.95rem; margin-bottom: 0.6rem; }
      .registration-subtext .required { color: var(--brand-pink); font-weight:600; opacity:0.9; font-size:0.95rem; }

      /* Normalize spacing between fields */
      .mb-3 { margin-bottom: 16px !important; }

      /* Labels: consistent alignment and size */
      .elegant-form .form-label { display:block; margin-bottom:6px; font-size:0.95rem; color:var(--brand-dark); font-weight:600; }

      /* Inputs and selects: uniform height, padding and border */
      .elegant-form .form-control,
      .elegant-form .form-select {
        height:44px; padding: .56rem .75rem; border-radius:10px; border:1.5px solid rgba(30,60,114,0.12); box-shadow:none; background: #fff; transition: box-shadow .12s ease, border-color .12s ease; font-size:0.95rem;
      }
      .elegant-form textarea.form-control { min-height:110px; height:auto; padding:.75rem .9rem; }
      .elegant-form .form-control:focus, .elegant-form .form-select:focus { border-color: var(--brand-accent); box-shadow: 0 6px 18px rgba(0,157,165,0.06); }

      /* Polished select appearance (match input height, smaller font, balanced padding, modern radius) */
      .elegant-form select.form-control,
      .elegant-form .form-select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding-right: 2rem; /* make room for custom caret */
        font-size: 0.92rem;
        line-height: 1.25;
        display: inline-block;
        vertical-align: middle;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='10' viewBox='0 0 14 10'%3E%3Cpath fill='%236B7280' d='M7 10L0 0h14z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 12px 8px;
      }

      /* Option readability */
      .elegant-form select.form-control option {
        font-size: 0.93rem;
        padding: 6px 8px;
      }

      /* Tom Select adjustments so placeholder and options aren't truncated */
      .ts-control { min-height:44px; border-radius:10px; }
      .ts-control .ts-input, .ts-control .item { line-height:1.2; height:44px; padding: .35rem .4rem; }
      .ts-control .ts-placeholder { white-space: normal; color: #6b7280; }
      .ts-dropdown, .ts-control .dropdown-content { max-height: 260px; overflow:auto; }

      /* Make dropdowns fill their column and not appear cramped */
      .form-select, .ts-control { width:100% !important; }

      /* Responsive: reduce gaps slightly on small screens */
      @media (max-width: 576px) {
        .registration-card .card-body { padding: 1rem; }
        .elegant-form .form-control, .elegant-form .form-select { height:44px; }
      }
    </style>
    <style>
      /* Header — match landing styles */
      header { background: rgba(30, 60, 114, 0.12); -webkit-backdrop-filter: blur(6px); border-bottom: 1px solid rgba(255,255,255,0.06); padding: 0.5rem 0; position: fixed; top:0; z-index: 1000; width:100%; }
      nav { display:flex; align-items:center; justify-content:space-between; max-width:1400px; margin:0 auto; padding:0 1rem; }
      .logo img { height:48px; filter: drop-shadow(0 2px 8px rgba(0,0,0,0.08)); }
      .nav-links { list-style: none; display:flex; gap: 0; align-items:center; }
      .nav-links li { position: relative; }
      .nav-links a { color: #ffffff; text-decoration:none; padding: 0.6rem 1.2rem; font-weight:500; border-radius: 8px; display:block; }
      .nav-links a:hover { background: rgba(0,0,0,0.03); }
      .mobile-menu-toggle { display:none; }
      @media (max-width:768px){ .mobile-menu-toggle { display:block; } .nav-links { display:none; } .nav-links.active{ display:flex; flex-direction:column; gap:0; width:100%; }
      }
    </style>
    <!-- Alerts style moved inside a proper style block above -->
    <style>
      /* Inline elegant form styles for registration page */
      .elegant-form .form-control,
      .elegant-form .form-select,
      .elegant-form textarea.form-control {
        border-radius: 12px;
        padding: .75rem .9rem;
        border: 3px solid rgba(17, 0, 255, 0.12);
        background: linear-gradient(180deg, #ffffff, #fbfbff);
        box-shadow: 0 6px 18px rgba(30, 60, 114, 0.06);
        transition: all .18s ease-in-out;
      }
      .elegant-form .form-control:focus,
      .elegant-form .form-select:focus,
      .elegant-form textarea.form-control:focus {
        border-color: rgba(30,60,114,0.35);
        box-shadow: 0 10px 26px rgba(30,60,114,0.12), 0 0 0 4px rgba(116,185,255,0.06);
        outline: none;
      }
      .elegant-form .form-label { color: var(--brand-dark); font-weight:600; }
      .elegant-form .btn { border-radius: 900px; padding: .68rem 1.2rem; transition: transform .08s ease, box-shadow .08s ease; }
      .elegant-form .btn-primary { background: linear-gradient(90deg,var(--brand-dark),var(--brand-accent)); border:none; color:#fff; }
      .elegant-form .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(30,60,114,0.14); }
      .ts-dropdown, .ts-control .dropdown-content { max-height: 240px; overflow: auto; }
    </style>
  </head>
  <body class="registration-bg">
    <!-- Header (simple variant to match site nav) -->
    <header>
      <nav>
        <div class="logo" style="display:flex;align-items:center;gap:8px;">
          <a href="/">
            <img src="<?php echo e(asset('storage/image/LOGO_LP3I.png')); ?>" alt="LP3I Karawang" style="height:48px;filter:drop-shadow(0 2px 8px rgba(0,0,0,0.08));">
          </a>
          <img src="<?php echo e(asset('storage/image/global.png')); ?>" alt="Global Mandiri" style="height:36px;opacity:0.95;margin-left:6px;">
        </div>
        <button class="mobile-menu-toggle">☰</button>
        <ul class="nav-links">
          <li><a href="/">Home</a></li>
          <li><a href="#contact">Kontak</a></li>
         <li><a href="/pendaftar/login" class="login-btn"><i class="fas fa-sign-in-alt"></i> Login</a></li>

        </ul>
      </nav>
    </header>
    <div class="container registration-container py-5">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="card registration-card shadow-sm">
            <div class="card-body p-4">
              
                <form action="<?php echo e(route('mahasiswa.store')); ?>" method="POST" enctype="multipart/form-data" novalidate class="elegant-form">
                  <?php echo csrf_field(); ?>
                  <div class="registration-grid">
                    <div class="registration-illustration">
                      <div class="illustration-wrapper">
                        <iframe
                          loading="lazy"
                          src="https://www.google.com/maps?q=Jalan+Tarumanegara+Blok+B+No.+4-6,+Kelurahan+Purwadana,+Kecamatan+Teluk+Jambe+Timur,+Kabupaten+Karawang,+Jawa+Barat&output=embed"
                          style="width:100%;height:100%;border:0;display:block;border-radius:10px;"
                          allowfullscreen="" referrerpolicy="no-referrer-when-downgrade"></iframe>
                      </div>
                    </div>
                    <div>
                      <div class="registration-header">
                    <!-- logo removed — keeping layout minimal and colorful -->
                    <div>
                      <h2 class="mb-0">Form Pendaftaran Mahasiswa</h2>
                      <p class="registration-subtext small mb-0">Silahakan Isi data diri dengan benar</p>
                    </div>
                  </div>

              
              <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
              <?php endif; ?>

              <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li><?php echo e($err); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                </div>
              <?php endif; ?>

              

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="nama_mhs" value="<?php echo e(old('nama_mhs')); ?>" class="form-control" required>
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="form-label">Jenis Kelas</label>
                    <select id="jenis_kelas" name="jenis_kelas" class="form-select">
                      <option value="">-- Pilih Jenis Kelas --</option>
                      <option value="Regular" <?php echo e(old('jenis_kelas') == 'Regular' ? 'selected' : ''); ?>>Regular</option>
                      <option value="Karyawan" <?php echo e(old('jenis_kelas') == 'Karyawan' ? 'selected' : ''); ?>>Karyawan</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">No. HP *</label>
                    <input type="text" name="no_hp" value="<?php echo e(old('no_hp')); ?>" class="form-control" required>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Bidang Keahlian</label>
                    <select name="jurusan" class="form-control">
                      <option value="">--Pilih--</option>
                      <option value="AIS" <?php echo e(old('jurusan') == 'AIS' ? 'selected' : ''); ?>>Accounting Information System</option>
                      <option value="ASE" <?php echo e(old('jurusan') == 'ASE' ? 'selected' : ''); ?>>Application Software Engineering</option>
                      <option value="OAA" <?php echo e(old('jurusan') == 'OAA' ? 'selected' : ''); ?>>Office Administration Automatization</option>
                    </select>
                  </div>
                </div>

                

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" value="<?php echo e(old('asal_sekolah')); ?>" class="form-control">
                  </div>
                </div>



                <hr />
                <div class="row mt-3">
                  <div class="col-12">
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="form-label">Email Akun</label>
                    <input type="email" name="account_email" value="<?php echo e(old('account_email')); ?>" class="form-control">
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="form-label">Password Akun</label>
                    <input type="password" name="password" class="form-control" autocomplete="new-password">
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                  </div>
                </div>

                <div class="form-actions w-100">
                    <a href="/" class="btn btn-cancel btn-lg">Batal</a>
                    <button type="submit" class="btn btn-primary btn-lg btn-submit">Daftar Sekarang</button>
                  </div>
                </div>
              </form>

                    </div>
                  </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tom Select (Bootstrap 5 theme) -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
      // initialize Tom Select for the new Jenis Kelas dropdown
      new TomSelect('#jenis_kelas', { create: false, placeholder: 'Pilih jenis kelas...' });

        // Mobile menu toggle
        document.querySelector('.mobile-menu-toggle').addEventListener('click', function() {
          const navLinks = document.querySelector('.nav-links');
          navLinks.classList.toggle('active');
        });

    </script>
  </body>
</html><?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/mahasiswa/create.blade.php ENDPATH**/ ?>