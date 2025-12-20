#!/bin/bash
# Setup script untuk LP3IKARAWANG setelah clone

echo "==================================="
echo "LP3I KARAWANG - Post Clone Setup"
echo "==================================="
echo ""

# 1. Buat folder jika belum ada
echo "✓ Membuat folder struktur..."
mkdir -p public/upload/carousel
mkdir -p public/upload/news
mkdir -p storage/app/public/logo
mkdir -p public/data

# 2. Buat sample CSV jika belum ada
if [ ! -f public/data/carousel.csv ] || [ ! -s public/data/carousel.csv ]; then
    echo "✓ Membuat carousel.csv template..."
    cat > public/data/carousel.csv << 'EOF'
id,title,subtitle,button_text,image_path,created_at,status
1,Selamat Datang di LP3I Karawang,Politeknik LP3I Kampus Karawang - Praktik Nyata Lulusan Siap Kerja,Daftar Sekarang,,2025-01-20 10:00:00,active
EOF
fi

if [ ! -f public/data/news.csv ] || [ ! -s public/data/news.csv ]; then
    echo "✓ Membuat news.csv template..."
    cat > public/data/news.csv << 'EOF'
id,title,content,excerpt,category,image_path,gallery_images,author,created_at,status
EOF
fi

# 3. Copy logo jika belum ada
if [ ! -f storage/app/public/logo/lp3i-logo.svg ]; then
    echo "✓ Membuat logo placeholder..."
    php storage/app/public/logo/create-logo.php 2>/dev/null || echo "  (Logo akan dibuat via PHP command)"
fi

echo ""
echo "==================================="
echo "Setup Selesai!"
echo "==================================="
echo ""
echo "Langkah selanjutnya:"
echo "1. composer install"
echo "2. php artisan key:generate"
echo "3. php artisan serve"
echo ""
echo "Admin Panel: http://127.0.0.1:8000/admin"
echo ""
