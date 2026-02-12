<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kode - LP3I Karawang</title>
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
            background: linear-gradient(135deg, #004269 0%, #40826D 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .container {
            max-width: 450px;
            width: 100%;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #004269 0%, #40826D 100%);
            padding: 2rem;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .header p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .content {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: all 0.3s;
            letter-spacing: 0.1rem;
            text-align: center;
            font-weight: 600;
        }

        .form-group input:focus {
            outline: none;
            border-color: #004269;
            box-shadow: 0 0 0 3px rgba(0, 66, 105, 0.1);
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .alert i {
            flex-shrink: 0;
            margin-top: 0.1rem;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        button, .btn {
            flex: 1;
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: #004269;
            color: white;
        }

        .btn-primary:hover {
            background: #003050;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 66, 105, 0.3);
        }

        .btn-secondary {
            background: #ddd;
            color: #333;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #ccc;
        }

        .info-box {
            background: #f0f7ff;
            border-left: 4px solid #004269;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #333;
            line-height: 1.5;
        }

        .info-box i {
            color: #004269;
            margin-right: 0.5rem;
        }

        .email-info {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #856404;
        }

        .email-info i {
            color: #ffc107;
            margin-right: 0.5rem;
        }

        .timer {
            text-align: center;
            color: #dc3545;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .resend-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .resend-link a {
            color: #004269;
            text-decoration: none;
            font-weight: 600;
        }

        .resend-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <i class="fas fa-shield-alt" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <h1>Verifikasi Kode</h1>
            <p>Masukkan kode yang telah dikirim ke email Anda</p>
        </div>

        <div class="content">
            <?php if($errors->any()): ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo e($error); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo e(session('error')); ?></span>
                </div>
            <?php endif; ?>

            <div class="email-info">
                <i class="fas fa-envelope"></i>
                Kode telah dikirim ke <strong><?php echo e($email); ?></strong>
            </div>

            <div class="info-box">
                <i class="fas fa-clock"></i>
                Kode valid selama 30 menit. Jika tidak masukkan dalam waktu tersebut, silakan minta kode baru.
            </div>

            <form action="<?php echo e(route('pendaftar.verify-code-submit')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="code">
                        <i class="fas fa-hashtag"></i> Kode Verifikasi (6 Angka)
                    </label>
                    <input 
                        type="text" 
                        id="code" 
                        name="code" 
                        placeholder="000000"
                        maxlength="6"
                        inputmode="numeric"
                        pattern="[0-9]{6}"
                        value="<?php echo e(old('code')); ?>"
                        required
                        autofocus
                    >
                </div>

                <div class="button-group">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-check"></i> Verifikasi
                    </button>
                    <a href="<?php echo e(route('pendaftar.forgot-password')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>

            <div class="resend-link">
                Tidak menerima kode? <a href="<?php echo e(route('pendaftar.forgot-password')); ?>">Minta kode baru</a>
            </div>
        </div>
    </div>

    <script>
        // Auto format input to accept only numbers
        document.getElementById('code').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>
<?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/pendaftar/verify_code.blade.php ENDPATH**/ ?>