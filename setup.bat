@echo off
echo ===================================
echo LP3I KARAWANG - Post Clone Setup
echo ===================================
echo.

REM 1. Buat folder jika belum ada
echo Creating folder structure...
if not exist "public\upload\carousel" mkdir public\upload\carousel
if not exist "public\upload\news" mkdir public\upload\news
if not exist "storage\app\public\logo" mkdir storage\app\public\logo
if not exist "public\data" mkdir public\data

REM 2. Buat CSV template jika belum ada
if not exist "public\data\carousel.csv" (
    echo Creating carousel.csv template...
    (
        echo id,title,subtitle,button_text,image_path,created_at,status
        echo 1,Selamat Datang di LP3I Karawang,Politeknik LP3I Kampus Karawang - Praktik Nyata Lulusan Siap Kerja,Daftar Sekarang,,2025-01-20 10:00:00,active
    ) > public\data\carousel.csv
)

if not exist "public\data\news.csv" (
    echo Creating news.csv template...
    (
        echo id,title,content,excerpt,category,image_path,gallery_images,author,created_at,status
    ) > public\data\news.csv
)

REM 3. Create logo
if not exist "storage\app\public\logo\lp3i-logo.svg" (
    echo Creating logo placeholder...
    php storage\app\public\logo\create-logo.php 2>nul
)

echo.
echo ===================================
echo Setup Complete!
echo ===================================
echo.
echo Next steps:
echo 1. composer install
echo 2. php artisan key:generate
echo 3. php artisan serve
echo.
echo Admin Panel: http://127.0.0.1:8000/admin
echo.
pause
