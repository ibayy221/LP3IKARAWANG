<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Mahasiswa - LP3I Karawang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      /* Color theme — match admin/dashboard vibe */
      body.registration-bg {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        min-height: 100vh;
        color: #fff;
        font-family: 'Poppins', sans-serif;
      }

      .registration-card {
        background: rgba(255,255,255,0.06); /* translucent card */
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 14px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.35);
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
        color: #fff; /* heading should be white */
        text-shadow: 0 6px 20px rgb(178, 173, 173);
      }

      .registration-card p.text-muted { color: #f4f0f0; }
      /* header subtext — white; show required note (asterisk + text) in red */
      .registration-subtext { color: #ffffff; }
      .registration-subtext .required { color: #ff4d4f; font-weight:700; }

      /* Inputs */
      .registration-card .form-control,
      .registration-card .form-select {
        background: #fff;
        border: 1px solid rgba(30,60,114,0.08);
        color: #000000;
        text-align: center;
      }

      .registration-card .form-control:focus,
      .registration-card .form-select:focus {
        border-color: rgba(116,185,255,0.9);
        box-shadow: 0 6px 20px rgba(116,185,255,0.06) !important;
        background: #fff;
        color: #333;
      }

      /* Labels should be dark because card uses light inputs */
      .registration-card .form-label { color: #ffffff; font-weight:600; }

      .btn-primary {
        background: linear-gradient(135deg,#1e3c72,#2a5298);
        border: none;
        box-shadow: 0 10px 24px rgba(30,60,114,0.28);
      }

      .btn-outline-secondary {
        color: #1e54b8;
        border-color: rgba(30,60,114,0.12);
      }

      /* Keep single-column layout that fits the container */
      .registration-layout { display:block; }

      /* Alerts: make message visible on colored background */
      .alert { background: rgba(255,255,255,0.06); color: #fff; border: 1px solid rgba(255,255,255,0.08); }
    </style>
  </head>
  <body class="registration-bg">
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card registration-card shadow-sm">
            <div class="card-body p-4">
                  <div class="registration-header">
                    <!-- logo removed — keeping layout minimal and colorful -->
                    <div>
                      <h2 class="mb-0">Form Pendaftaran Mahasiswa</h2>
                      <p class="registration-subtext small mb-0">Isi data diri sesuai dokumen resmi. Semua field yang diberi tanda <span class="required">* wajib diisi</span>.</p>
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

              <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="nama_mhs" value="{{ old('nama_mhs') }}" class="form-control" required>
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="form-label">NIK / Nomor Identitas *</label>
                    <input type="text" name="NIK_mahasiswa" value="{{ old('NIK_mahasiswa') }}" class="form-control" required>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">No. HP *</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control" required>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Jurusan / Program Studi</label>
                    <input type="text" name="jurusan" value="{{ old('jurusan') }}" class="form-control">
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="form-label">Tahun Lulus</label>
                    <input type="number" min="1900" max="2100" name="tahun_lulus" value="{{ old('tahun_lulus') }}" class="form-control">
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Alamat</label>
                  <textarea name="alamat" rows="3" class="form-control">{{ old('alamat') }}</textarea>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-control">
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}" class="form-control">
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                      <option value="">-- Pilih --</option>
                      <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                      <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                  </div>

                  <div class="mb-3 col-md-6">
                    <label class="form-label">Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" class="form-control">
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-4">
                    <label class="form-label">Jenis Sekolah</label>
                    <select name="jenis_sekolah" class="form-select">
                      <option value="">-- Pilih --</option>
                      <option value="SMA/SMK" {{ old('jenis_sekolah') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                    </select>
                  </div>

                  <div class="mb-3 col-md-4">
                    <label class="form-label">Kategori Sekolah</label>
                    <select name="kategori_sekolah" class="form-select">
                      <option value="">-- Pilih --</option>
                      <option value="Negeri" {{ old('kategori_sekolah') == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                      <option value="Swasta" {{ old('kategori_sekolah') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                    </select>
                  </div>
                  
                <div class="d-flex justify-content-between align-items-center mt-4">
                  <a href="/" class="btn btn-outline-secondary">Batal</a>
                  <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
