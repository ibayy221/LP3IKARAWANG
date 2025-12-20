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
          background: #f8fafc; /* match input background */
        min-height: 100vh;
        color: #111827;
        font-family: 'Poppins', sans-serif;
      }

      .registration-card {
        background: #ffffff; /* card matching input background */
        border: 1px solid rgba(30,60,114,0.06);
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
        border: 1px solid rgba(30,60,114,0.08);
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
        height:44px; padding: .56rem .75rem; border-radius:10px; border:1px solid rgba(30,60,114,0.10); box-shadow:none; background: #fff; transition: box-shadow .12s ease, border-color .12s ease; font-size:0.95rem;
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
      header { background: rgba(30, 60, 114, 0.06); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.06); padding: 0.5rem 0; position: sticky; top:0; z-index: 1200; width:100%; }
      nav { display:flex; align-items:center; justify-content:space-between; max-width:1400px; margin:0 auto; padding:0 1rem; }
      .logo img { height:48px; filter: drop-shadow(0 2px 8px rgba(0,0,0,0.08)); }
      .nav-links { list-style: none; display:flex; gap: 0; align-items:center; }
      .nav-links li { position: relative; }
      .nav-links a { color: #0f1724; text-decoration:none; padding: 0.6rem 1.2rem; font-weight:500; border-radius: 8px; display:block; }
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
        border: 1px solid rgba(30,60,114,0.12);
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
      .elegant-form .btn { border-radius: 999px; padding: .68rem 1.2rem; transition: transform .08s ease, box-shadow .08s ease; }
      .elegant-form .btn-primary { background: linear-gradient(90deg,var(--brand-dark),var(--brand-accent)); border:none; color:#fff; }
      .elegant-form .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(30,60,114,0.14); }
      .ts-dropdown, .ts-control .dropdown-content { max-height: 240px; overflow: auto; }
    </style>
  </head>
  <body class="registration-bg">
    <!-- Header (simple variant to match site nav) -->
    <header>
      <nav>
        <div class="logo">
          <a href="/">
            <img src="{{ asset('storage/logo/lp3i-logo.png') }}" alt="LP3I Logo">
          </a>
        </div>
        <button class="mobile-menu-toggle">☰</button>
        <ul class="nav-links">
          <li><a href="/">Home</a></li>
          <li><a href="/news">Berita</a></li>
          <li><a href="/admin">Admin</a></li>
          <li><a href="#contact">Kontak</a></li>
          <li><a href="{{ route('mahasiswa.create') }}" class="register-btn"><i class="fas fa-clipboard-check"></i> Daftar</a></li>
        </ul>
      </nav>
    </header>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="card registration-card shadow-sm">
            <div class="card-body p-4">
              
                <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data" novalidate class="elegant-form">
                  @csrf
                  <div class="registration-grid">
                    <div class="registration-illustration">
                      <div class="illustration-wrapper">
                        <img loading="lazy" src="{{ !empty($registrationImageUrl) ? asset(ltrim($registrationImageUrl, '/')) : asset('storage/illustrations/registration-illustration.svg') }}" alt="Registration Illustration" onerror="this.style.display='none'" />
                      </div>
                    </div>
                    <div>
                      <div class="registration-header">
                    <!-- logo removed — keeping layout minimal and colorful -->
                    <div>
                      <h2 class="mb-0">Form Pendaftaran Mahasiswa</h2>
                      <p class="registration-subtext small mb-0">Isi data diri sesuai dokumen resmi</p>
                    </div>
                  </div>

              {{-- Flash / validation messages --}}
              @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
              @endif

              @if($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach($errors->all() as $err)
                      <li>{{ $err }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="nama_mhs" value="{{ old('nama_mhs') }}" class="form-control" required>
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="form-label">Email (Kontak)</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">No. HP *</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control" required>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Jurusan / Program Studi</label>
                    <select name="jurusan" class="form-control">
                      <option value="">Pilih Jurusan</option>
                      <option value="ASE" {{ old('jurusan') == 'ASE' ? 'selected' : '' }}>Application Software Engineering</option>
                      <option value="OAA" {{ old('jurusan') == 'OAA' ? 'selected' : '' }}>Office Administration Automatization</option>
                      <option value="AIS" {{ old('jurusan') == 'AIS' ? 'selected' : '' }}>AAccounting Information System</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-4">
                    <label class="form-label">Tahun Lulus</label>
                    <input type="number" min="1900" max="2100" name="tahun_lulus" value="{{ old('tahun_lulus') }}" class="form-control">
                  </div>
                  <div class="mb-3 col-md-4">
                    <label class="form-label">Kecamatan</label>
                    <select id="kecamatan" name="kecamatan" class="form-select">
                      <option value=""> Pilih Kecamatan </option>
                      @foreach($kecamatans as $k)
                        <option value="{{ $k->id }}" {{ (old('kecamatan') == $k->id || old('kecamatan') == $k->name) ? 'selected' : '' }}>{{ $k->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-3 col-md-4">
                    <label class="form-label">Desa</label>
                    <select id="desa" name="desa" class="form-select" disabled>
                      <option value="">Pilih Desa</option>
                    </select>
                  </div>
                </div>

                <!-- Address (moved to bottom) - removed duplicate kecamatan block -->

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-control">
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="text" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}" class="form-control" placeholder="YYYY-MM-DD">
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
                      <option value="">-- Pilih --</option>
                      <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                      <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="form-label">Kode Pos</label>
                    <input id="kode_pos" type="text" name="kode_pos" value="{{ old('kode_pos') }}" class="form-control">
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" class="form-control">
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-4">
                    <label class="form-label">Jenis Sekolah</label>
                    <select id="jenis_sekolah" name="jenis_sekolah" class="form-select">
                      <option value="">-- Pilih --</option>
                      <option value="SMA/SMK" {{ old('jenis_sekolah') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                    </select>
                  </div>

                  <div class="mb-3 col-md-4">
                    <label class="form-label">Kategori Sekolah</label>
                    <select id="kategori_sekolah" name="kategori_sekolah" class="form-select">
                      <option value="">-- Pilih --</option>
                      <option value="Negeri" {{ old('kategori_sekolah') == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                      <option value="Swasta" {{ old('kategori_sekolah') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-12">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat" rows="4" class="form-control">{{ old('alamat') }}</textarea>
                  </div>
                </div>

                <hr />
                <div class="row mt-3">
                  <div class="col-12">
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="form-label">Email Akun</label>
                    <input type="email" name="account_email" value="{{ old('account_email') }}" class="form-control">
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
    <!-- Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Tom Select (Bootstrap 5 theme) -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
      // initialize flatpickr for date field
      flatpickr('#tgl_lahir', {
        dateFormat: 'Y-m-d',
        maxDate: 'today',
        altInput: true,
        altFormat: 'd F Y'
      });

      // initialize Tom Select for selects
      const kecamatanSelect = new TomSelect('#kecamatan', { maxOptions: 100, plugins: ['dropdown_input'] });
      const desaSelect = new TomSelect('#desa', { maxOptions: 100, plugins: ['dropdown_input'], create: false });
      // duplicates removed - Tom Select already initialized above

      // desas grouped passed by controller as a JSON object
      const desasGrouped = {!! json_encode($desas ?? []) !!};
      const kecamatanList = {!! json_encode($kecamatans->mapWithKeys(fn($k)=>[$k->id=>$k->name])) !!};
      const oldKecamatan = {!! json_encode(old('kecamatan')) !!};
      const oldDesa = {!! json_encode(old('desa')) !!};
      const oldKodePos = {!! json_encode(old('kode_pos')) !!};

      // On kecamatan change, populate desa
      kecamatanSelect.on('change', function(value) {
        const data = desasGrouped[value] || [];
        desaSelect.clearOptions();
        if (data.length) {
          desaSelect.enable();
          desaSelect.addOption(data.map(function(d){ return {value: d.name, text: d.name, kode_pos: d.kode_pos}; }));
          desaSelect.refreshOptions(false);
        } else {
          desaSelect.disable();
        }
        // also clear kode pos
        document.getElementById('kode_pos').value = '';
      });

      // After page load: if old kecamatan is set, initialize selection and desa
      (function initialOldSelection(){
        let selectedKec = oldKecamatan || null;
        if (selectedKec) {
          // if old is name, find ID
          if (isNaN(selectedKec)) {
            for (const id in kecamatanList) {
              if (kecamatanList[id] === selectedKec) { selectedKec = id; break; }
            }
          }
          if (selectedKec) {
            kecamatanSelect.setValue(String(selectedKec));
            // populate desa via change handler
            // after a short delay allow desa options to be added
            setTimeout(function(){
              if (oldDesa) {
                desaSelect.setValue(oldDesa);
                document.getElementById('kode_pos').value = oldKodePos || '';
              }
            }, 200);
          }
        }
      })();

      // on desa change, set kode pos from options
      desaSelect.on('change', function(value) {
        const opt = desaSelect.getOption(value);
        let kode = '';
        if (opt) {
          // Tom Select stores data in option attrs; try read 'data-kode_pos' or from JSON
          // The Tom Select api doesn't expose custom attributes, so find by value in desasGrouped
          for (const key in desasGrouped) {
            const list = desasGrouped[key];
            const found = list.find(function(d){ return d.name === value; });
            if (found) { kode = found.kode_pos; break; }
          }
        }
        document.getElementById('kode_pos').value = kode || '';
      });
      new TomSelect('#jenis_kelamin', { create: false, placeholder: 'Pilih jenis kelamin...' });
      new TomSelect('#jenis_sekolah', { create: false, placeholder: 'Pilih jenis sekolah...' });
      new TomSelect('#kategori_sekolah', { create: false, placeholder: 'Pilih kategori sekolah...' });

        // Mobile menu toggle
        document.querySelector('.mobile-menu-toggle').addEventListener('click', function() {
          const navLinks = document.querySelector('.nav-links');
          navLinks.classList.toggle('active');
        });

    </script>
  </body>
</html>
