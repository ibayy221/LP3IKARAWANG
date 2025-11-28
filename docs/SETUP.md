# Setup Guide untuk LP3I Karawang

## Daftar Isi
1. [Setup Pertama Kali (Fresh Clone)](#setup-pertama-kali)
2. [Setup di Device Lain](#setup-di-device-lain)
3. [Struktur Folder & File](#struktur-folder)
4. [Troubleshooting](#troubleshooting)

## Setup Pertama Kali

Jika ini adalah pertama kali Anda clone project:

### 1. Clone Repository
```powershell
git clone https://github.com/ibayy221/LP3IKARAWANG.git
cd LP3IKARAWANG
```

### 2. Jalankan Setup Script
**Windows:**
```powershell
.\setup.bat
```

**Linux/Mac:**
```bash
chmod +x setup.sh
./setup.sh
```

Script ini akan:
- ✅ Membuat folder struktur yang diperlukan
- ✅ Membuat file CSV template (carousel.csv, news.csv)
- ✅ Membuat logo placeholder

### 3. Install Dependencies
```powershell
composer install
npm install
```

### 4. Generate Key & Setup Environment
```powershell
copy .env.example .env
php artisan key:generate
```

### 5. Jalankan Development Server
**Terminal 1 - Run Vite (Assets):**
```powershell
npm run dev
```

**Terminal 2 - Run Laravel Server:**
```powershell
php artisan serve
```

Buka: `http://127.0.0.1:8000`

---

## Setup di Device Lain

Saat Anda clone project di device/laptop lain:

### 1. Clone & Setup Script
```powershell
git clone https://github.com/ibayy221/LP3IKARAWANG.git
cd LP3IKARAWANG
.\setup.bat  # Windows
# atau
./setup.sh   # Linux/Mac
```

### 2. Install Dependencies
```powershell
composer install
npm install
```

### 3. Run Development Server
```powershell
npm run dev    # Terminal 1
php artisan serve   # Terminal 2
```

### ⚠️ File Gambar
- **Upload gambar carousel** akan ter-track di git jika sudah di-commit
- **File gambar** di `public/upload/carousel/` dan `public/upload/news/` adalah bagian dari repository
- Saat clone, file gambar akan otomatis ter-download jika sudah ada di git history

---

## Struktur Folder

```
public/
├── data/
│   ├── carousel.csv      # Database carousel (CSV format)
│   └── news.csv          # Database berita (CSV format)
├── upload/
│   ├── carousel/         # Gambar carousel yang di-upload
│   └── news/             # Gambar berita yang di-upload
└── storage/
    └── logo/             # Logo assets (symlink ke storage/app/public)

resources/views/
├── index.blade.php       # Landing page
├── admin.blade.php       # Admin panel
└── ...

app/Http/Controllers/
├── CarouselController.php    # Handle carousel display
├── AdminController.php       # Handle CRUD admin
└── ...
```

---

## File CSV

### carousel.csv
```csv
id,title,subtitle,button_text,image_path,created_at,status
1,Title Slide,Subtitle text,Button Text,upload/carousel/image.jpg,2025-01-20 10:00:00,active
```

**Columns:**
- `id`: Unique identifier
- `title`: Judul slide
- `subtitle`: Subtitle/deskripsi
- `button_text`: Teks tombol CTA
- `image_path`: Path ke gambar (relative to `public/`)
- `created_at`: Timestamp
- `status`: `active` atau `inactive`

### news.csv
```csv
id,title,content,excerpt,category,image_path,gallery_images,author,created_at,status
1,Title,Full content,Short excerpt,Category,upload/news/img.jpg,,Admin LP3I,2025-01-20 10:00:00,active
```

---

## Admin Panel

**URL:** `http://127.0.0.1:8000/admin`

### Features
- ✅ **Kelola Carousel**: Tambah/Edit/Hapus slide
- ✅ **Kelola Berita**: Tambah/Edit/Hapus artikel
- ✅ **Upload Gambar**: Support JPG, PNG, GIF, WebP
- ✅ **Real-time Preview**: Lihat perubahan langsung

### Endpoints
- `GET /admin` - Admin panel page
- `POST /admin/action` - AJAX handler untuk CRUD

---

## Git & Workflow

### Commit Changes
```powershell
git add .
git commit -m "Update carousel slides"
git push origin main
```

### File yang di-track
- ✅ CSV files (`public/data/*.csv`)
- ✅ Gambar uploaded (`public/upload/**/*.{jpg,png,gif}`)
- ✅ Source code & config

### File yang NOT di-track
- ❌ `/vendor/` (PHP dependencies)
- ❌ `/node_modules/` (NPM dependencies)
- ❌ `.env` (Local environment)
- ❌ `/storage/*.key` (App keys)
- ❌ `/public/storage` (Symlink)

---

## Troubleshooting

### ❌ Error: "Folder `public/upload/` tidak ada"
**Solusi:** Jalankan setup script
```powershell
.\setup.bat
```

### ❌ Error: "No such file: carousel.csv"
**Solusi:** Script akan membuat template CSV. Jika gagal, buat manual:
```powershell
# Buka notepad, copy content di bawah, save sebagai `public/data/carousel.csv`
id,title,subtitle,button_text,image_path,created_at,status
1,Welcome,Subtitle,Register,,2025-01-20 10:00:00,active
```

### ❌ Error: "image not found" di admin panel
**Kemungkinan penyebab:**
1. File gambar belum di-commit ke git
2. Path di CSV salah (harus relative dari `public/`)
3. File belum ter-upload

**Solusi:**
- Upload ulang gambar melalui admin panel
- Atau copy manual ke `public/upload/carousel/`

### ❌ Asset (CSS/JS) tidak dimuat
**Solusi:** Jalankan Vite dev server
```powershell
npm run dev
```

---

## Quick Commands

```powershell
# Setup everything
.\setup.bat

# Install dependencies
composer install && npm install

# Generate key
php artisan key:generate

# Run development servers
npm run dev              # Terminal 1
php artisan serve       # Terminal 2

# Build for production
npm run build

# Run tests
./vendor/bin/phpunit

# View logs
Get-Content storage/logs/laravel.log -Tail 50
```

---

## Lebih Lanjut

Lihat `README.md` untuk dokumentasi lengkap project.
