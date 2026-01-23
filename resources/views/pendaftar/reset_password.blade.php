<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - LP3I Karawang</title>
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
        }

        .form-group input:focus {
            outline: none;
            border-color: #004269;
            box-shadow: 0 0 0 3px rgba(0, 66, 105, 0.1);
        }

        .password-toggle {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 38px;
            cursor: pointer;
            color: #666;
            background: none;
            border: none;
            font-size: 1rem;
            z-index: 10;
        }

        .toggle-password:hover {
            color: #004269;
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

        .btn-primary:hover:not(:disabled) {
            background: #003050;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 66, 105, 0.3);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
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
            line-height: 1.6;
        }

        .info-box i {
            color: #004269;
            margin-right: 0.5rem;
        }

        .requirements {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.5rem;
            padding: 0.75rem;
            background: #f9f9f9;
            border-radius: 6px;
            border-left: 3px solid #ffc107;
        }

        .requirement-item {
            margin: 0.3rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .requirement-item i {
            color: #ccc;
            width: 16px;
        }

        .requirement-item.met i {
            color: #28a745;
        }

        .requirement-item.unmet i {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <i class="fas fa-lock" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <h1>Reset Password</h1>
            <p>Buat password baru yang kuat dan aman</p>
        </div>

        <div class="content">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="info-box">
                <i class="fas fa-shield-alt"></i>
                Pastikan password baru Anda aman dan tidak mudah ditebak.
            </div>

            <form action="{{ route('pendaftar.update-password') }}" method="POST">
                @csrf
                <div class="form-group password-toggle">
                    <label for="password">
                        <i class="fas fa-key"></i> Password Baru
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Minimal 8 karakter"
                        required
                    >
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password')">
                        <i class="fas fa-eye"></i>
                    </button>
                    <div class="requirements">
                        <div class="requirement-item" id="length-check">
                            <i class="fas fa-times-circle"></i>
                            <span>Minimal 8 karakter</span>
                        </div>
                        <div class="requirement-item" id="uppercase-check">
                            <i class="fas fa-times-circle"></i>
                            <span>Mengandung huruf besar (A-Z)</span>
                        </div>
                        <div class="requirement-item" id="number-check">
                            <i class="fas fa-times-circle"></i>
                            <span>Mengandung angka (0-9)</span>
                        </div>
                    </div>
                </div>

                <div class="form-group password-toggle">
                    <label for="password_confirmation">
                        <i class="fas fa-check-circle"></i> Konfirmasi Password
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="Ketik ulang password baru"
                        required
                    >
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password_confirmation')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn-primary" id="submit-btn">
                        <i class="fas fa-save"></i> Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const button = event.target.closest('button');
            
            if (field.type === 'password') {
                field.type = 'text';
                button.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                field.type = 'password';
                button.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }

        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');

        passwordInput.addEventListener('input', function() {
            validatePassword();
        });

        confirmInput.addEventListener('input', function() {
            validateMatch();
        });

        function validatePassword() {
            const password = passwordInput.value;
            
            // Check length
            const lengthOk = password.length >= 8;
            const lengthCheck = document.getElementById('length-check');
            if (lengthOk) {
                lengthCheck.classList.add('met');
                lengthCheck.classList.remove('unmet');
                lengthCheck.querySelector('i').classList.add('fa-check-circle');
                lengthCheck.querySelector('i').classList.remove('fa-times-circle');
            } else {
                lengthCheck.classList.remove('met');
                lengthCheck.classList.add('unmet');
                lengthCheck.querySelector('i').classList.remove('fa-check-circle');
                lengthCheck.querySelector('i').classList.add('fa-times-circle');
            }

            // Check uppercase
            const uppercaseOk = /[A-Z]/.test(password);
            const uppercaseCheck = document.getElementById('uppercase-check');
            if (uppercaseOk) {
                uppercaseCheck.classList.add('met');
                uppercaseCheck.classList.remove('unmet');
                uppercaseCheck.querySelector('i').classList.add('fa-check-circle');
                uppercaseCheck.querySelector('i').classList.remove('fa-times-circle');
            } else {
                uppercaseCheck.classList.remove('met');
                uppercaseCheck.classList.add('unmet');
                uppercaseCheck.querySelector('i').classList.remove('fa-check-circle');
                uppercaseCheck.querySelector('i').classList.add('fa-times-circle');
            }

            // Check number
            const numberOk = /[0-9]/.test(password);
            const numberCheck = document.getElementById('number-check');
            if (numberOk) {
                numberCheck.classList.add('met');
                numberCheck.classList.remove('unmet');
                numberCheck.querySelector('i').classList.add('fa-check-circle');
                numberCheck.querySelector('i').classList.remove('fa-times-circle');
            } else {
                numberCheck.classList.remove('met');
                numberCheck.classList.add('unmet');
                numberCheck.querySelector('i').classList.remove('fa-check-circle');
                numberCheck.querySelector('i').classList.add('fa-times-circle');
            }

            validateMatch();
        }

        function validateMatch() {
            const submitBtn = document.getElementById('submit-btn');
            if (passwordInput.value && confirmInput.value && passwordInput.value === confirmInput.value) {
                submitBtn.disabled = false;
            } else if (!passwordInput.value || !confirmInput.value) {
                submitBtn.disabled = true;
            } else {
                submitBtn.disabled = true;
            }
        }

        // Initial state
        validatePassword();
    </script>
</body>
</html>
