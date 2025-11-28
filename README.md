<h1 align="center">LP3IKARAWANG</h1>

Sebuah aplikasi web berbasis Laravel untuk menampilkan dan mengelola carousel (konten gambar), dengan halaman admin sederhana dan beberapa view publik.

**Ringkasan singkat**: proyek ini berisi fitur utama berupa pengelolaan carousel (data CSV di `public/data/carousel.csv` dan folder upload di `public/upload/carousel`), routing pada `routes/web.php`, model `app/Models/User.php`, serta beberapa view di `resources/views/` seperti `carousel.blade.php`, `admin.blade.php`, dan `index.blade.php`.

**Status:** Development

**Bahasa / Teknologi:** PHP, Laravel, Blade, Composer, Vite/Node

**Prasyarat**
- **PHP** >= 8.x (sesuaikan dengan `composer.json`)
- **Composer**
- **Node.js & npm** (untuk assets / Vite)
- **Database**: MySQL / MariaDB / SQLite (konfigurasi `.env`)

**Instalasi & Konfigurasi Lokal**

1. Clone repository dan masuk ke folder proyek:

	```powershell
	cd 'c:\Users\PC BILLGATES 14\Documents\Laravel\LP3IKARAWANG\LP3IKARAWANG'
	```

2. Install dependensi PHP dan Node:

	```powershell
	composer install
	npm install
	```

3. Salin file environment dan atur variabel lingkungan:

	```powershell
	copy .env.example .env
	# lalu edit .env sesuai konfigurasi database dan APP_URL
	```

4. Buat key aplikasi dan migrasi database:

	```powershell
	php artisan key:generate; php artisan migrate
	# jika ada seeder: php artisan db:seed
	```

5. Jalankan Vite (development assets) dan server lokal:

	```powershell
	npm run dev
	php artisan serve --host=127.0.0.1 --port=8000
	```

## 🚀 Setup Setelah Clone (Important!)

Saat Anda clone project di device lain, folder `public/upload/` mungkin kosong atau tidak ada file gambar. Jalankan script setup berikut:

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
- ✓ Membuat folder struktur (`public/upload/carousel`, `public/upload/news`, dll)
- ✓ Membuat file CSV template jika belum ada
- ✓ Membuat logo placeholder SVG
- ✓ Menyiapkan project untuk dijalankan

Setelah setup, jalankan:
```powershell
php artisan serve
```

## 📁 Struktur File Penting

| Path | Keterangan |
|------|-----------|
| `public/data/carousel.csv` | Database carousel (CSV format) |
| `public/data/news.csv` | Database berita (CSV format) |
| `public/upload/carousel/` | Folder upload gambar carousel |
| `public/upload/news/` | Folder upload gambar berita |
| `storage/app/public/logo/` | Folder logo (symlink ke `public/storage/`) |
| `resources/views/index.blade.php` | Landing page |
| `resources/views/admin.blade.php` | Admin panel |
| `app/Http/Controllers/AdminController.php` | Controller CRUD admin |

## 🔒 Git & Upload Files

**Catatan penting:**
- File gambar di `public/upload/` **AKAN di-track oleh git** (tidak di-exclude)
- Jika Anda commit perubahan dengan gambar baru, gambar akan ter-include di repository
- Setelah clone, jalankan `setup.bat` atau `setup.sh` untuk memastikan folder struktur siap


6. Buka `http://127.0.0.1:8000` di browser.

**Data khusus proyek**
- File CSV untuk carousel: `public/data/carousel.csv`.
- Folder upload carousel: `public/upload/carousel/`.

Jika ingin mengimpor data dari CSV, periksa controller yang menangani carousel (cari di `app/Http/Controllers/`) dan sesuaikan jika diperlukan.

**Menjalankan Test**

```powershell
./vendor/bin/phpunit
```

atau (Windows)

```powershell
vendor\bin\phpunit.bat
```

**Membangun untuk Produksi**

```powershell
npm run build
```

Kemudian konfigurasi server (Nginx/Apache) untuk menunjuk ke folder `public/`.

**Struktur Proyek (ringkasan file penting)**
- `routes/web.php`: definisi rute web publik dan admin.
- `app/Models/User.php`: model User default (sesuaikan jika menambah field).
- `app/Http/Controllers/`: tempat controller; cari controller carousel/admin di folder ini.
- `resources/views/`: view Blade. File penting: `admin.blade.php`, `carousel.blade.php`, `index.blade.php`, `get_carousel.blade.php`.
- `public/data/carousel.csv`: sumber data carousel.
- `public/upload/carousel/`: tempat file gambar carousel diupload.
- `database/migrations/`: migration untuk tabel users, jobs, cache, dll.
- `database/factories/` dan `database/seeders/`: untuk pembuatan data uji.

**Fitur Utama & Catatan Implementasi**
- Carousel: tampilan carousel menggunakan data CSV dan gambar di `public/upload/carousel`.
- Admin Panel: akses di `http://localhost:8000/admin` untuk mengelola carousel dan berita.
- Admin view: `resources/views/admin.blade.php` menyediakan UI pengelolaan (upload/CRUD—powered oleh `AdminController`).

Jika Anda menambahkan file upload baru, pastikan folder `public/upload/carousel` dan `public/upload/news` memiliki permission yang sesuai agar webserver dapat menulis.

**Akses Admin Panel**
Halaman admin tersedia di: `http://localhost:8000/admin` (saat development)
- Kelola Carousel: tambah/edit/hapus slide carousel dengan gambar.
- Kelola Berita: tambah/edit/hapus artikel berita dengan galeri foto.

**Panduan Debug & Troubleshooting**
- Periksa log aplikasi di `storage/logs/laravel.log` untuk error runtime.
- Pastikan variabel DB di `.env` benar dan database sudah dimigrasi.
- Jika assets tidak muncul, jalankan `npm run dev` untuk mode development atau `npm run build` untuk produksi.

**Kontribusi**
- Fork repo dan buat branch fitur: `git checkout -b feature/nama-fitur`.
- Buat PR dengan deskripsi perubahan dan langkah reproduksi jika perlu.

**Kontak / Maintainer**
- Pemilik repo: `ibayy221` (lihat informasi repo untuk kontak lebih lanjut).

--
Dokumentasi ini adalah ringkasan teknis untuk pengembangan lokal dan pemahaman struktur proyek. Jika Anda ingin, saya dapat menambahkan halaman dokumentasi terpisah di folder `docs/` (deploy, API endpoints, contoh CSV import), atau memperluas dokumentasi untuk fitur tertentu—sebutkan bagian mana yang ingin diperinci.
