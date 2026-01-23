# Fitur Lupa Password - Setup Instructions

## 📋 Ringkasan Fitur

Fitur lupa password dengan alur:
1. User input email → sistem kirim kode OTP (6 digit) ke email
2. User verifikasi kode yang diterima di email
3. Kode valid selama **30 menit** dan unik untuk setiap user
4. Setelah verifikasi, user dapat membuat password baru
5. Code otomatis expired/hangus setelah 30 menit jika tidak digunakan

---

## 🔧 Setup Steps

### 1. Jalankan Migration
```bash
php artisan migrate
```

Ini akan membuat tabel `password_resets` dengan kolom:
- `id` - Primary key
- `user_id` - FK ke users table
- `email` - Email user
- `code` - Kode OTP 6 digit (unique)
- `expires_at` - Waktu expire (30 menit dari dibuat)
- `used` - Status apakah kode sudah digunakan
- `created_at`, `updated_at`

### 2. Setup Email Configuration

Edit `.env` file dan pastikan email config sudah benar:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com  # atau SMTP provider lainnya
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password  # Untuk Gmail, gunakan App Password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@lp3ikarawang.ac.id
MAIL_FROM_NAME="LP3I Karawang"
```

**Catatan untuk Gmail:**
- Aktifkan 2-Step Verification di akun Gmail
- Generate "App Password" di https://myaccount.google.com/apppasswords
- Gunakan App Password di `.env` file

### 3. Test Email Configuration

```bash
php artisan tinker
# Kemudian jalankan:
Mail::to('test@example.com')->send(new \App\Mail\PasswordResetCode(new \App\Models\User(), '123456'));
```

---

## 📁 File yang Dibuat

### Models
- `app/Models/PasswordReset.php` - Model untuk password reset

### Controllers
- `app/Http/Controllers/ForgotPasswordController.php` - Controller untuk forgot password flow

### Migrations
- `database/migrations/2026_01_20_000000_create_password_resets_table.php`

### Views
- `resources/views/pendaftar/forgot_password.blade.php` - Form input email
- `resources/views/pendaftar/verify_code.blade.php` - Form verifikasi kode
- `resources/views/pendaftar/reset_password.blade.php` - Form reset password baru
- `resources/views/emails/password_reset_code.blade.php` - Email template

### Routes
- Di `routes/web.php` dalam group `pendaftar`:
  - `GET /pendaftar/forgot-password` - Tampil form lupa password
  - `POST /pendaftar/forgot-password` - Kirim kode ke email
  - `GET /pendaftar/verify-code` - Tampil form verifikasi kode
  - `POST /pendaftar/verify-code` - Verifikasi kode
  - `GET /pendaftar/reset-password` - Tampil form reset password
  - `POST /pendaftar/reset-password` - Update password

---

## 🔐 Security Features

✅ Kode OTP unik 6 digit random setiap kali
✅ Kode expire dalam 30 menit (auto hangus)
✅ Kode tidak bisa digunakan 2x (marked as `used`)
✅ Old codes auto-delete saat user request kode baru
✅ Password requirements:
   - Minimal 8 karakter
   - Harus ada huruf besar (A-Z)
   - Harus ada angka (0-9)
✅ Session-based validation untuk prevent manipulasi
✅ Email validation (must exist in users table)

---

## 🧪 Testing Flow

1. **Akses halaman lupa password:**
   ```
   http://localhost:8000/pendaftar/forgot-password
   ```

2. **Input email yang terdaftar**
   - Sistem cek apakah email exist di database
   - Jika valid, generate kode 6 digit
   - Kirim email dengan kode

3. **Lihat kode di database (untuk testing):**
   ```bash
   php artisan tinker
   \App\Models\PasswordReset::latest()->first();
   ```

4. **Verifikasi kode**
   - User redirect ke form verifikasi
   - Input kode yang diterima di email
   - Sistem cek: kode valid? tidak expired? belum dipakai?

5. **Reset password**
   - Form validasi password:
     - Min 8 char
     - Ada uppercase
     - Ada number
   - Konfirmasi password match
   - Update password di database
   - Mark code as used

6. **Login dengan password baru**
   ```
   http://localhost:8000/pendaftar/login
   ```

---

## 🐛 Troubleshooting

### Email tidak terkirim
- Cek `.env` MAIL_* configuration
- Cek SMTP credentials
- Untuk Gmail: pastikan App Password sudah di-generate
- Check `storage/logs/laravel.log` untuk error

### Kode tidak terkirim tapi form redirect
- Lihat error di `storage/logs/laravel.log`
- Pastikan View `resources/views/emails/password_reset_code.blade.php` exist

### Session expired message
- Session default 2 jam, jika user buka langsung tanpa reset flow
- User harus mulai dari `forgot-password` page lagi

### Kode tetap valid setelah 30 menit
- Cek timezone di `.env`
- Pastikan database timezone sama dengan Laravel timezone

---

## 📱 User Journey Diagram

```
Login Page
    ↓
Click "Lupa Password?"
    ↓
Forgot Password Form (Input Email)
    ↓ Submit
Send Reset Code Email
    ↓ Check Email
Verify Code Form (Input 6 digit code)
    ↓ Submit Valid Code
Reset Password Form (Create new password)
    ↓ Submit
Password Updated
    ↓
Back to Login with new password
```

---

## ✨ Features Ready

✅ Automatic code generation (6 digits)
✅ Email sending with formatted template
✅ 30-minute expiration (configurable in PasswordReset::createReset)
✅ One-time use codes
✅ Session-based verification flow
✅ Password strength validation
✅ Responsive mobile-friendly UI
✅ Error handling dan user feedback
✅ Link di login page untuk akses mudah

---

**Selesai! Fitur lupa password sudah siap digunakan.** 🎉
