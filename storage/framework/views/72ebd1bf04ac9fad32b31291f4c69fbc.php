<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #f9f9f9;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #004269 0%, #40826D 100%);
            color: white;
            text-align: center;
            padding: 30px;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: white;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .code-box {
            background: #f0f7ff;
            border-left: 4px solid #004269;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            border-radius: 6px;
        }
        .code-box .label {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .code {
            font-size: 36px;
            font-weight: bold;
            color: #004269;
            letter-spacing: 5px;
            font-family: 'Courier New', monospace;
        }
        .info {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 6px;
            font-size: 14px;
            color: #856404;
        }
        .warning {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin: 20px 0;
            border-radius: 6px;
            font-size: 14px;
            color: #721c24;
        }
        .instructions {
            margin: 20px 0;
            color: #555;
        }
        .instructions ol {
            padding-left: 20px;
        }
        .instructions li {
            margin: 10px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
        .contact {
            margin-top: 10px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Kode Reset Password</h1>
        </div>

        <div class="content">
            <div class="greeting">
                Halo <strong><?php echo e($user->nama ?? $user->name); ?></strong>,
            </div>

            <p>
                Kami menerima permintaan untuk mengatur ulang password akun Anda di LP3I College Karawang. 
                Gunakan kode berikut untuk melanjutkan proses reset password.
            </p>

            <div class="code-box">
                <div class="label">Kode Verifikasi Anda</div>
                <div class="code"><?php echo e($code); ?></div>
            </div>

            <div class="info">
                ℹ️ <strong>Informasi Penting:</strong> Kode ini valid selama 30 menit. Jika Anda tidak melakukan permintaan ini, abaikan email ini.
            </div>

            <div class="instructions">
                <strong>Cara menggunakan kode:</strong>
                <ol>
                    <li>Buka halaman verifikasi reset password</li>
                    <li>Masukkan kode di atas: <strong><?php echo e($code); ?></strong></li>
                    <li>Buat password baru yang kuat</li>
                    <li>Selesai! Anda bisa login dengan password baru</li>
                </ol>
            </div>

            <div class="warning">
                ⚠️ <strong>Keamanan:</strong> Jangan bagikan kode ini kepada siapa pun. Dukungan LP3I tidak akan pernah meminta kode ini melalui email.
            </div>

            <div class="footer">
                <p>Email ini dikirim ke <?php echo e($user->email); ?></p>
                <div class="contact">
                    Jika Anda memiliki pertanyaan, hubungi kami di support@lp3ikarawang.ac.id
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/emails/password_reset_code.blade.php ENDPATH**/ ?>