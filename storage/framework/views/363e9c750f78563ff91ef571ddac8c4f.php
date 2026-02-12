<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Edit Biodata</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>

    :root{--basic:#004269;--adv:#40826D}
    body{background:var(--basic);}
    .card-adv{border:1px solid var(--adv);box-shadow:0 6px 18px rgba(11, 3, 249, 0.618);background:#fff;color:#0e025a}
    .card-adv .field-box{background:#fff;color:#0000ff}
    .card-adv label{color:#023c8e}
    .btn-basic{background:linear-gradient(90deg,var(--basic),#009DA5);box-shadow:0 6px 12px rgba(0,0,0,0.12)}
    input, select, textarea { border-width: 2px !important; border-color: rgba(3, 51, 164, 0.481) !important; }
  </style>
</head>
<body class="text-slate-800">
  
  <div class="max-w-6xl mx-auto p-6 lg:p-8">
    <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6 items-start">
      <aside class="bg-white rounded-xl border p-5 shadow-sm sticky top-6" >
        <div class="flex items-center gap-3 mb-4">
          <svg class="w-8 h-8 text-[#004269]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 11c2.761 0 5-2.239 5-5S14.761 1 12 1 7 3.239 7 6s2.239 5 5 5zM3 21a9 9 0 0118 0"/></svg>
          <div>
            <div class="text-sm text-slate-400">Halo</div>
            <div class="font-semibold"><?php echo e(Auth::user()->name ?? 'Pendaftar'); ?></div>
          </div>
        </div>

        <nav class="space-y-2 text-sm">
          <a class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-50" href="<?php echo e(route('pendaftar.dashboard')); ?>">
            <span class="text-slate-600">Dashboard</span>
          </a>
          
          <a class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-50" href="<?php echo e(route('pendaftar.biodata.show')); ?>">
            <span class="text-slate-600">Biodata</span>
          </a>

          <details class="group">
            <summary class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-600/10 cursor-pointer">Akun Saya</summary>
            <div class="pl-4 mt-2 space-y-1">
              <a href="<?php echo e(route('pendaftar.akun.email')); ?>" class="block px-3 py-1 rounded hover:bg-white/10">Email</a>
              <a href="<?php echo e(route('pendaftar.akun.password')); ?>" class="block px-3 py-1 rounded hover:bg-white/10">Password</a>
              <a href="<?php echo e(route('pendaftar.akun.phone')); ?>" class="block px-3 py-1 rounded hover:bg-white/10">No Handphone</a>
              <a href="<?php echo e(route('pendaftar.akun.whatsapp')); ?>" class="block px-3 py-1 rounded hover:bg-white/10">No Whats App</a>
            </div>
          </details>
        </nav>
      </aside>

      <main>
        <div class="bg-white rounded-xl card-adv p-6">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-2xl font-bold text-[#004269]">Ubah Biodata</h2>
              <p class="text-sm text-slate-500">Perbarui informasi Anda dan unggah foto profil yang jelas.</p>
            </div>
            <div class="text-sm text-slate-500">Nomor: <strong class="text-slate-700"><?php echo e($pendaftar->nipd ?? ($pendaftar->id ?? '-')); ?></strong></div>
          </div>

          <?php if(session('success')): ?>
            <div class="p-3 mt-4 rounded bg-green-50 text-green-700"><?php echo e(session('success')); ?></div>
          <?php endif; ?>
          <?php if(session('error')): ?>
            <div class="p-3 mt-4 rounded bg-red-50 text-red-700"><?php echo e(session('error')); ?></div>
          <?php endif; ?>
          <?php if($errors->any()): ?>
            <div class="p-3 mt-4 rounded bg-yellow-50 text-yellow-800">
              <div class="font-semibold">Periksa kembali form:</div>
              <ul class="list-disc pl-5 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><?php echo e($err); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
          <?php endif; ?>

          <form action="<?php echo e(route('pendaftar.biodata.update')); ?>" method="POST" enctype="multipart/form-data" class="mt-5">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm text-slate-600 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_mhs" class="w-full border rounded px-3 py-2" value="<?php echo e(old('nama_mhs', $pendaftar->nama_mhs ?? '')); ?>">
              </div>
              <div>
                <label class="block text-sm text-slate-600 mb-1">No. HP</label>
                <input type="text" name="no_hp" class="w-full border rounded px-3 py-2" value="<?php echo e(old('no_hp', $pendaftar->no_hp ?? '')); ?>">
              </div>

              <div>
                <label class="block text-sm text-slate-600 mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" value="<?php echo e(old('email', $pendaftar->email ?? '')); ?>">
              </div>
              <div>
                <label class="block text-sm text-slate-600 mb-1">Jenis Kelas</label>
                <select name="jenis_kelas" class="w-full border rounded px-3 py-2">
                  <option value="">-- Pilih --</option>
                  <option value="Regular" <?php echo e((old('jenis_kelas', $pendaftar->jenis_kelas ?? '') == 'Regular') ? 'selected' : ''); ?>>Regular</option>
                  <option value="Karyawan" <?php echo e((old('jenis_kelas', $pendaftar->jenis_kelas ?? '') == 'Karyawan') ? 'selected' : ''); ?>>Karyawan</option>
                </select>
              </div>

              <div>
                <label class="block text-sm text-slate-600 mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border rounded px-3 py-2">
                  <option value="">-- Pilih --</option>
                  <option value="Laki-laki" <?php echo e((old('jenis_kelamin', $pendaftar->jenis_kelamin ?? '') == 'Laki-laki') ? 'selected' : ''); ?>>Laki-laki</option>
                  <option value="Perempuan" <?php echo e((old('jenis_kelamin', $pendaftar->jenis_kelamin ?? '') == 'Perempuan') ? 'selected' : ''); ?>>Perempuan</option>
                </select>
              </div>

              <div>
                <label class="block text-sm text-slate-600 mb-1">Agama</label>
                <select name="agama" class="w-full border rounded px-3 py-2">
                  <option value="">-- Pilih --</option>
                  <option value="Islam" <?php echo e((old('agama', $pendaftar->agama ?? '') == 'Islam') ? 'selected' : ''); ?>>Islam</option>
                  <option value="Kristen" <?php echo e((old('agama', $pendaftar->agama ?? '') == 'Kristen') ? 'selected' : ''); ?>>Kristen</option>
                  <option value="Katolik" <?php echo e((old('agama', $pendaftar->agama ?? '') == 'Katolik') ? 'selected' : ''); ?>>Katolik</option>
                  <option value="Hindu" <?php echo e((old('agama', $pendaftar->agama ?? '') == 'Hindu') ? 'selected' : ''); ?>>Hindu</option>
                  <option value="Buddha" <?php echo e((old('agama', $pendaftar->agama ?? '') == 'Buddha') ? 'selected' : ''); ?>>Buddha</option>
                  <option value="Konghucu" <?php echo e((old('agama', $pendaftar->agama ?? '') == 'Konghucu') ? 'selected' : ''); ?>>Konghucu</option>
                  <option value="Lainnya" <?php echo e((old('agama', $pendaftar->agama ?? '') == 'Lainnya') ? 'selected' : ''); ?>>Lainnya</option>
                </select>
              </div>

              <div>
                <label class="block text-sm text-slate-600 mb-1">Program Studi</label>
                <select name="jurusan" class="w-full border rounded px-3 py-2">
                  <option value="">-- Pilih --</option>
                  <option value="AIS" <?php echo e((old('jurusan', $pendaftar->jurusan ?? '') == 'AIS') ? 'selected' : ''); ?>>Accounting Information System</option>
                  <option value="ASE" <?php echo e((old('jurusan', $pendaftar->jurusan ?? '') == 'ASE') ? 'selected' : ''); ?>>Application Software Engineering</option>
                  <option value="OAA" <?php echo e((old('jurusan', $pendaftar->jurusan ?? '') == 'OAA') ? 'selected' : ''); ?>>Office Administration Automatization</option>
                </select>
              </div>

              <div>
                <label class="block text-sm text-slate-600 mb-1">Asal Sekolah</label>
                <input type="text" name="asal_sekolah" class="w-full border rounded px-3 py-2" value="<?php echo e(old('asal_sekolah', $pendaftar->asal_sekolah ?? '')); ?>">
              </div>
              <div>
                <label class="block text-sm text-slate-600 mb-1">Alamat</label>
                <input type="text" name="alamat" class="w-full border rounded px-3 py-2" value="<?php echo e(old('alamat', $pendaftar->alamat ?? '')); ?>">
              </div>

              <div>
                <label class="block text-sm text-slate-600 mb-1">Kecamatan</label>
                <input type="text" name="kecamatan" class="w-full border rounded px-3 py-2" value="<?php echo e(old('kecamatan', $pendaftar->kecamatan ?? '')); ?>">
              </div>
              <div>
                <label class="block text-sm text-slate-600 mb-1">Desa</label>
                <input type="text" name="desa" class="w-full border rounded px-3 py-2" value="<?php echo e(old('desa', $pendaftar->desa ?? '')); ?>">
              </div>

              <div>
                <label class="block text-sm text-slate-600 mb-1">Kode Pos</label>
                <input type="text" name="kode_pos" class="w-full border rounded px-3 py-2" value="<?php echo e(old('kode_pos', $pendaftar->kode_pos ?? '')); ?>">
              </div>

              <div>
                <label class="block text-sm text-slate-600 mb-1">Tahun Lulus</label>
                <input type="number" name="tahun_lulus" class="w-full border rounded px-3 py-2" value="<?php echo e(old('tahun_lulus', $pendaftar->tahun_lulus ?? '')); ?>">
              </div>

              <div>
                <label class="block text-sm text-slate-600 mb-1">Akun Instagram</label>
                <input type="text" name="instagram" class="w-full border rounded px-3 py-2" placeholder="@username" value="<?php echo e(old('instagram', $pendaftar->instagram ?? '')); ?>">
              </div>

              <div>
                <label class="block text-sm text-slate-600 mb-1">Nama Orang Tua / Wali</label>
                <input type="text" name="nama_wali" class="w-full border rounded px-3 py-2" value="<?php echo e(old('nama_wali', $pendaftar->nama_wali ?? '')); ?>">
              </div>

              <div>
                <label class="block text-sm text-slate-600 mb-1">Nomor Telp Orang Tua / Wali</label>
                <input type="tel" name="telp_wali" class="w-full border rounded px-3 py-2" value="<?php echo e(old('telp_wali', $pendaftar->telp_wali ?? '')); ?>">
              </div>

              <div>
                <label class="block text-sm text-slate-600 mb-1">Pekerjaan Orang Tua / Wali</label>
                <input type="text" name="pekerjaan_wali" class="w-full border rounded px-3 py-2" value="<?php echo e(old('pekerjaan_wali', $pendaftar->pekerjaan_wali ?? '')); ?>">
              </div>

              <div class="md:col-span-2">
                <label class="block text-sm text-slate-600 mb-1">Foto Profil MAX 2MB</label>
                <input type="file" name="photo" class="w-full">
                <?php if(!empty($pendaftar->photo_url) || !empty($pendaftar->file_path)): ?>
                  <div class="mt-2"><img src="<?php echo e(asset(ltrim($pendaftar->photo_url ?? $pendaftar->file_path,'/'))); ?>" alt="Preview" class="w-32 h-32 object-cover rounded-md border"></div>
                <?php endif; ?>
              </div>

              <div class="md:col-span-2">
                <label class="block text-sm text-slate-600 mb-1">Upload Ptotcopy KTP / Kartu Pelajar (jpg,png,pdf) MAX 2MB</label>
                <input type="file" name="ktp_file" accept=".jpg,.jpeg,.png,.pdf" class="w-full">
                <?php if(!empty($pendaftar->ktp_path)): ?>
                  <div class="mt-2">
                    <?php $ext = strtolower(pathinfo($pendaftar->ktp_path, PATHINFO_EXTENSION)); ?>
                    <?php if(in_array($ext, ['jpg','jpeg','png'])): ?>
                      <img src="<?php echo e(asset(ltrim($pendaftar->ktp_path,'/'))); ?>" alt="KTP" class="w-32 h-32 object-cover rounded-md border">
                    <?php else: ?>
                      
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              </div>
              
              <div class="md:col-span-2">
                <label class="block text-sm text-slate-600 mb-1">Upload Ijazah (jpg,png,pdf) MAX 2MB</label>
                <input type="file" name="ijazah_file" accept=".jpg,.jpeg,.png,.pdf" class="w-full">
                <?php if(!empty($pendaftar->ijazah_path)): ?>
                  <div class="mt-2">
                    <?php $ext = strtolower(pathinfo($pendaftar->ijazah_path, PATHINFO_EXTENSION)); ?>
                    <?php if(in_array($ext, ['jpg','jpeg','png'])): ?>
                      <img src="<?php echo e(asset(ltrim($pendaftar->ijazah_path,'/'))); ?>" alt="Ijazah" class="w-32 h-32 object-cover rounded-md border">
                    <?php else: ?>
                      <a href="<?php echo e(asset(ltrim($pendaftar->ijazah_path,'/'))); ?>" target="_blank" class="text-sm text-blue-600 underline">Lihat dokumen Ijazah</a>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              </div>

              <div class="md:col-span-2">
                <label class="block text-sm text-slate-600 mb-1">Upload Akte Kelahiran (jpg,png,pdf) MAX 2MB</label>
                <input type="file" name="akte_kelahiran_file" accept=".jpg,.jpeg,.png,.pdf" class="w-full">
                <?php if(!empty($pendaftar->akte_kelahiran_path)): ?>
                  <div class="mt-2">
                    <?php $ext = strtolower(pathinfo($pendaftar->akte_kelahiran_path, PATHINFO_EXTENSION)); ?>
                    <?php if(in_array($ext, ['jpg','jpeg','png'])): ?>
                      <img src="<?php echo e(asset(ltrim($pendaftar->akte_kelahiran_path,'/'))); ?>" alt="Akte Kelahiran" class="w-32 h-32 object-cover rounded-md border">
                    <?php else: ?>
                      <a href="<?php echo e(asset(ltrim($pendaftar->akte_kelahiran_path,'/'))); ?>" target="_blank" class="text-sm text-blue-600 underline">Lihat dokumen Akte Kelahiran</a>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              </div>

              <div class="md:col-span-2">
                <label class="block text-sm text-slate-600 mb-1">Upload Surat Keterangan Sudah Bekerja (jpg,png,pdf) MAX 2MB</label>
                <input type="file" name="surat_sudah_bekerja_file" accept=".jpg,.jpeg,.png,.pdf" class="w-full">
                <?php if(!empty($pendaftar->surat_sudah_bekerja_path)): ?>
                  <div class="mt-2">
                    <?php $ext = strtolower(pathinfo($pendaftar->surat_sudah_bekerja_path, PATHINFO_EXTENSION)); ?>
                    <?php if(in_array($ext, ['jpg','jpeg','png'])): ?>
                      <img src="<?php echo e(asset(ltrim($pendaftar->surat_sudah_bekerja_path,'/'))); ?>" alt="Surat Bekerja" class="w-32 h-32 object-cover rounded-md border">
                    <?php else: ?>
                      <a href="<?php echo e(asset(ltrim($pendaftar->surat_sudah_bekerja_path,'/'))); ?>" target="_blank" class="text-sm text-blue-600 underline">Lihat dokumen Surat Bekerja</a>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              </div>
              
            </div>

            <div class="mt-6 flex items-center gap-3">
              <a href="<?php echo e(route('pendaftar.biodata.show')); ?>" class="px-4 py-2 rounded-md border-2 border-[#004269] text-[#004269]">Batal</a>
              <button type="submit" class="px-4 py-2 rounded-md text-white font-semibold btn-basic">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
<?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/pendaftar/biodata_edit.blade.php ENDPATH**/ ?>