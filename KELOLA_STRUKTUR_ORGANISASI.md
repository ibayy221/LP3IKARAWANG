# Fitur Kelola Struktur Organisasi - Admin

## Deskripsi
Fitur ini memungkinkan admin untuk mengelola struktur organisasi LP3I Karawang dengan mudah. Admin dapat menambah, mengubah, dan menghapus data anggota organisasi beserta foto, nama, dan role mereka.

## Cara Akses

1. **Login ke Admin Panel**
   - Buka URL: `http://localhost/admin`
   - Atau `http://localhost/admin.php` (legacy link)

2. **Akses Menu Struktur Organisasi**
   - Klik menu "Kelola Struktur Organisasi" di dashboard admin
   - Atau buka URL langsung: `http://localhost/admin/struktur-organisasi`

## Fitur-Fitur

### 1. Daftar Struktur Organisasi (List)
**Route:** `GET /admin/struktur-organisasi`

Menampilkan tabel daftar semua anggota organisasi dengan informasi:
- Foto anggota
- Nama lengkap
- Role/Jabatan
- Posisi (Director, Corporate Secretary, Staff)
- Urutan tampilan
- Status (Aktif/Tidak Aktif)
- Tombol Edit dan Hapus

### 2. Tambah Data Struktur Organisasi (Create)
**Route:** `GET /admin/struktur-organisasi/create` (Form)
**Route:** `POST /admin/struktur-organisasi` (Submit)

Form untuk menambah anggota organisasi baru:
- **Nama Lengkap** (required): Nama anggota organisasi
- **Role/Jabatan** (required): Posisi/jabatan dalam organisasi
- **Posisi** (required): Pilihan kategori posisi:
  - Director (Direktur)
  - Corporate Secretary (Sekretaris Korporat)
  - Staff (Staf)
- **Urutan**: Nomor urut untuk pengurutan tampilan (default: 0)
- **Foto**: Upload foto anggota (JPEG, PNG, GIF - max 2MB)
- Preview foto sebelum disimpan

**Validasi:**
- Nama dan Role wajib diisi
- Posisi harus dipilih
- Foto harus format gambar, max 2MB

### 3. Edit Data Struktur Organisasi (Update)
**Route:** `GET /admin/struktur-organisasi/{strukturOrganisasi}/edit` (Form)
**Route:** `PUT /admin/struktur-organisasi/{strukturOrganisasi}` (Submit)

Form untuk mengubah data anggota organisasi:
- Edit Nama Lengkap
- Edit Role/Jabatan
- Edit Posisi
- Edit Urutan
- Lihat foto saat ini
- Ganti foto dengan yang baru
- Toggle status Aktif/Tidak Aktif

**Fitur:**
- Foto lama akan dihapus otomatis jika mengganti dengan foto baru
- Jika tidak mengganti foto, foto lama tetap dipertahankan
- Status aktif/tidak aktif untuk mengontrol tampilan di halaman publik

### 4. Hapus Data Struktur Organisasi (Delete)
**Route:** `DELETE /admin/struktur-organisasi/{strukturOrganisasi}`

Menghapus anggota organisasi dari database:
- Foto terkait akan dihapus otomatis dari storage
- Konfirmasi sebelum penghapusan
- Data yang dihapus tidak dapat dikembalikan

## Struktur Database

Tabel: `struktur_organisasis`

Kolom:
- `id`: Primary key
- `nama`: Nama anggota organisasi (string, 255 chars)
- `role`: Jabatan/posisi detail (string, 255 chars)
- `foto`: Path foto di storage (nullable)
- `posisi`: Kategori posisi - director|secretary|staff
- `urutan`: Nomor urut untuk pengurutan (integer, default: 0)
- `is_active`: Status aktif/tidak aktif (boolean, default: true)
- `created_at`: Waktu pembuatan record
- `updated_at`: Waktu perubahan terakhir

## Penggunaan di Frontend

### Get Data dari Controller
```php
use App\Http\Controllers\StrukturOrganisasiController;

$orgData = StrukturOrganisasiController::getOrgData();

// Hasil:
// $orgData['director'] - Object direktur
// $orgData['secretary'] - Object sekretaris korporat
// $orgData['staff'] - Collection staff (sorted by urutan)
```

### Di View Frontend
```blade
@php
    use App\Http\Controllers\StrukturOrganisasiController;
    $orgData = StrukturOrganisasiController::getOrgData();
@endphp

<!-- Direktur -->
@if($orgData['director'])
    <div class="director">
        <img src="{{ Storage::url($orgData['director']->foto) }}" alt="{{ $orgData['director']->nama }}">
        <h3>{{ $orgData['director']->nama }}</h3>
        <p>{{ $orgData['director']->role }}</p>
    </div>
@endif

<!-- Sekretaris -->
@if($orgData['secretary'])
    <div class="secretary">
        <img src="{{ Storage::url($orgData['secretary']->foto) }}" alt="{{ $orgData['secretary']->nama }}">
        <h3>{{ $orgData['secretary']->nama }}</h3>
        <p>{{ $orgData['secretary']->role }}</p>
    </div>
@endif

<!-- Staff -->
@foreach($orgData['staff'] as $staff)
    <div class="staff">
        <img src="{{ Storage::url($staff->foto) }}" alt="{{ $staff->nama }}">
        <h3>{{ $staff->nama }}</h3>
        <p>{{ $staff->role }}</p>
    </div>
@endforeach
```

## Routes Summary

| Method | Route | Controller Method | Deskripsi |
|--------|-------|------------------|-----------|
| GET | `/admin/struktur-organisasi` | index | Tampilkan daftar |
| GET | `/admin/struktur-organisasi/create` | create | Form tambah |
| POST | `/admin/struktur-organisasi` | store | Simpan data baru |
| GET | `/admin/struktur-organisasi/{id}/edit` | edit | Form edit |
| PUT | `/admin/struktur-organisasi/{id}` | update | Simpan perubahan |
| DELETE | `/admin/struktur-organisasi/{id}` | destroy | Hapus data |

## Middleware
Semua route dilindungi oleh `EnsureAdmin` middleware, hanya admin terautentikasi yang bisa mengakses.

## File Storage
Foto disimpan di:
- **Disk**: public
- **Path**: `struktur_organisasi/`
- **URL**: `/storage/struktur_organisasi/{filename}`

## Keterangan Teknologi

- **Framework**: Laravel
- **Controller**: `App\Http\Controllers\StrukturOrganisasiController`
- **Model**: `App\Models\StrukturOrganisasi`
- **Views**: 
  - `resources/views/admin/struktur_organisasi/index.blade.php`
  - `resources/views/admin/struktur_organisasi/create.blade.php`
  - `resources/views/admin/struktur_organisasi/edit.blade.php`

---

**Dibuat pada:** 19 Januari 2026
