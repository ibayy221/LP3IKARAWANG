<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Struktur Organisasi - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
        }

        .back-link {
            margin-bottom: 1rem;
        }

        .back-link a {
            color: #004269;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .form-container h1 {
            color: #004269;
            margin-bottom: 1.5rem;
            font-size: 1.6rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #004269;
            box-shadow: 0 0 0 3px rgba(0, 66, 105, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .file-input-wrapper {
            position: relative;
        }

        .file-input-wrapper input[type="file"] {
            display: none;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            background: #f8f9fa;
            border: 2px dashed #ddd;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-input-label:hover {
            border-color: #004269;
            background: #f0f4f9;
        }

        .file-name {
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: #666;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.95rem;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
            flex: 1;
            justify-content: center;
        }

        .btn-primary {
            background: #004269;
            color: white;
        }

        .btn-primary:hover {
            background: #003050;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .error-list {
            list-style: none;
            padding-left: 0;
        }

        .error-list li {
            padding: 0.25rem 0;
        }

        .error-list li:before {
            content: "• ";
            margin-right: 0.5rem;
        }

        .preview-image {
            max-width: 150px;
            max-height: 150px;
            border-radius: 6px;
            margin-top: 0.5rem;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
            padding: 0;
        }

        @media (max-width: 600px) {
            .container {
                padding: 1rem;
            }

            .form-container {
                padding: 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="back-link">
            <a href="<?php echo e(route('struktur-organisasi.index')); ?>"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>

        <div class="form-container">
            <h1><i class="fas fa-user-plus"></i> Tambah Anggota Organisasi</h1>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <strong><i class="fas fa-exclamation-circle"></i> Ada kesalahan:</strong>
                    <ul class="error-list">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('struktur-organisasi.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="nama"><i class="fas fa-user"></i> Nama Lengkap *</label>
                    <input type="text" id="nama" name="nama" value="<?php echo e(old('nama')); ?>" required>
                </div>

                <div class="form-group">
                    <label for="role"><i class="fas fa-briefcase"></i> Role/Jabatan *</label>
                    <input type="text" id="role" name="role" placeholder="Contoh: Branch Manager" value="<?php echo e(old('role')); ?>" required>
                </div>

                <div class="form-group">
                    <label for="posisi"><i class="fas fa-layer-group"></i> Posisi *</label>
                    <select id="posisi" name="posisi" required onchange="updateParentOptions()">
                        <option value="">-- Pilih Posisi --</option>
                        <?php $__currentLoopData = $posisiOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e(old('posisi') == $value ? 'selected' : ''); ?>>
                                <?php echo e($label); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group" id="parent-group" style="display: none;">
                    <label for="parent_id"><i class="fas fa-user-tie"></i> Atasan/Role Head (untuk Staff)</label>
                    <select id="parent_id" name="parent_id">
                        <option value="">-- Belum Ditentukan --</option>
                    </select>
                    <small style="color: #666; margin-top: 0.5rem; display: block;">Pilih role head sebagai atasan langsung anggota ini</small>
                </div>

                

                <div class="form-group">
                    <label for="foto"><i class="fas fa-image"></i> Foto</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="foto" name="foto" accept="image/*" onchange="previewImage(event)">
                        <label for="foto" class="file-input-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Klik untuk memilih foto</span>
                        </label>
                    </div>
                    <div id="preview" class="file-name"></div>
                </div>

                <div class="form-actions">
                    <a href="<?php echo e(route('struktur-organisasi.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Data untuk parent options (akan diisi dari controller)
        let headList = [
            <?php $__currentLoopData = \App\Models\StrukturOrganisasi::active()->where(function($q){ $q->where('posisi', 'head')->orWhere('role','like','%Head%')->orWhere('role','like','%Kepala%'); })->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $head): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                { id: '<?php echo e($head->id); ?>', name: '<?php echo e(addslashes($head->nama)); ?>', role: '<?php echo e(addslashes($head->role)); ?>' },
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ];

        function updateParentOptions() {
            const posisi = document.getElementById('posisi').value;
            const parentGroup = document.getElementById('parent-group');
            const parentSelect = document.getElementById('parent_id');

            if (posisi === 'staff') {
                parentGroup.style.display = 'block';
                // Populate dengan head options
                parentSelect.innerHTML = '<option value="">-- Belum Ditentukan --</option>';
                headList.forEach(h => {
                    if (!h || !h.id) return;
                    const nama = h.name;
                    if (nama === null || nama === undefined) return;
                    if (String(nama).trim() === '' || String(nama) === '0') return;
                    const option = document.createElement('option');
                    option.value = h.id;
                    option.textContent = nama;
                    parentSelect.appendChild(option);
                });

                // attempt to auto-assign parent based on role text if parent not selected
                const roleInput = document.getElementById('role');
                if (roleInput) {
                    const roleText = roleInput.value || '';
                    if (roleText && !parentSelect.value) {
                        const found = headList.find(h => {
                            const combined = (h.name + ' ' + h.role).toLowerCase();
                            return roleText.toLowerCase().split(/\s+/).some(tok => tok && combined.includes(tok));
                        });
                        if (found) parentSelect.value = found.id;
                    }

                    // attach input listener once to try auto-assign while typing
                    if (!roleInput.dataset.hasListener) {
                        roleInput.addEventListener('input', function() {
                            if (document.getElementById('posisi').value !== 'staff') return;
                            if (parentSelect.value) return;
                            const text = this.value || '';
                            if (!text) return;
                            const found = headList.find(h => {
                                const combined = (h.name + ' ' + h.role).toLowerCase();
                                return text.toLowerCase().split(/\s+/).some(tok => tok && combined.includes(tok));
                            });
                            if (found) parentSelect.value = found.id;
                        });
                        roleInput.dataset.hasListener = '1';
                    }
                }
            } else {
                parentGroup.style.display = 'none';
                parentSelect.value = '';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateParentOptions();
        });

        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="preview-image">`;
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        }
    </script>
</body>
</html>
<?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/admin/struktur_organisasi/create.blade.php ENDPATH**/ ?>