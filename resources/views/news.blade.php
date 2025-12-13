<?php
// Load news data from CSV
function getNewsData($limit = null) {
    $csvFile = 'data/news.csv';
    $data = [];
    
    if (file_exists($csvFile) && ($handle = fopen($csvFile, "r")) !== FALSE) {
        $header = fgetcsv($handle);
        while (($row = fgetcsv($handle)) !== FALSE) {
            if (count($row) === count($header)) {
                $newsData = array_combine($header, $row);
                if ($newsData['status'] === 'active') {
                    $data[] = [
                        'id' => $newsData['id'],
                        'title' => $newsData['title'],
                        'content' => $newsData['content'],
                        'excerpt' => $newsData['excerpt'],
                        'category' => $newsData['category'],
                        'image_path' => $newsData['image_path'],
                        'gallery_images' => isset($newsData['gallery_images']) ? $newsData['gallery_images'] : '',
                        'author' => $newsData['author'],
                        'created_at' => $newsData['created_at']
                    ];
                }
            }
        }
        fclose($handle);
    }
    
    // Sort by created_at descending (newest first)
    usort($data, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
    
    // Return limited number of news items if limit specified
    return $limit ? array_slice($data, 0, $limit) : $data;
}

function getNewsById($id) {
    $newsData = getNewsData();
    foreach ($newsData as $news) {
        if ($news['id'] == $id) {
            return $news;
        }
    }
    return null;
}

// Get news ID from URL parameter
$newsId = isset($_GET['id']) ? $_GET['id'] : null;
$currentNews = null;
$allNews = getNewsData();

if ($newsId) {
    $currentNews = getNewsById($newsId);
}

// If specific news not found, show all news
$showDetail = $currentNews !== null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $showDetail ? htmlspecialchars($currentNews['title']) . ' - ' : '' ?>Berita - LP3I Karawang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
        }


        /* Header */
        header {
            background: #1e3c72;
            color: white;
            padding: 0.5rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        header.scrolled {
            background: #1e3c72;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo {
            height: 50px;
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 100%;
            width: auto;
            max-width: 200px;
            object-fit: contain;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.1));
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 0;
            align-items: center;
        }

        .nav-links li {
            position: relative;
        }

        .nav-links a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            padding: 0.6rem 1.2rem; /* Adjusted padding */
            display: block;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border-radius: 0;
            font-size: 0.95rem;
            font-weight: 500;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
            /* background: rgba(255, 255, 255, 0.05); */ /* Removed for mobile */
            border: none;
            /* backdrop-filter: blur(10px); */ /* Removed for mobile */
        }

        /* .nav-links a::before { */ /* Removed for mobile */
        /*     content: ''; */
        /*     position: absolute; */
        /*     top: 0; */
        /*     left: -100%; */
        /*     width: 100%; */
        /*     height: 100%; */
        /*     background: linear-gradient(90deg, transparent, rgba(74, 144, 226, 0.3), transparent); */
        /*     transition: left 0.5s; */
        /* } */

        .nav-links a:hover::before {
            left: 100%;
        }

        .nav-links a:hover {
            /* background: rgba(74, 144, 226, 0.2); */
            /* color: #74b9ff; */
            /* transform: none; */
            box-shadow: none;
        }
        /* Mobile specific adjustments for nav-links a */
        @media (max-width: 768px) {
            .nav-links a {
                width: 100%;
                padding: 0.8rem 2rem; /* Adjusted padding for better mobile touch targets */
                text-align: left;
                background: transparent; /* Ensure no background on mobile */
                backdrop-filter: none; /* Ensure no backdrop-filter on mobile */
            }
        }

        /* Dropdown */
        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background: rgba(30, 60, 114, 0.98);
            backdrop-filter: blur(20px);
            min-width: 200px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.4);
            z-index: 1001;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            top: 100%;
            left: 0;
        }

        .dropdown-content a {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            text-decoration: none;
            display: block;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            background: transparent;
        }

        .dropdown-content a:last-child {
            border-bottom: none;
        }

        .dropdown-content a:hover {
            background: rgba(74, 144, 226, 0.4);
            color: #fff;
            transform: translateX(5px);
        }

        .dropdown:hover .dropdown-content {
            display: block;
            animation: dropdownSlide 0.3s ease-out;
        }

        @keyframes dropdownSlide {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .mobile-menu-toggle:hover {
            background: rgba(255,255,255,0.1);
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: rgba(30, 60, 114, 0.98);
                backdrop-filter: blur(20px);
                flex-direction: column;
                padding: 1rem 0;
                box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            }

            .nav-links.active {
                display: flex;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .dropdown-content {
                position: static;
                display: block;
                box-shadow: none;
                background: rgba(255,255,255,0.1);
                margin-left: 20px;
            }

            .dropdown-content a {
                color: #ccc;
                padding: 8px 20px;
            }
        }

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            margin-top: 80px; /* Add space for fixed header */
        }

        .breadcrumb {
            margin-bottom: 2rem;
            color: #666;
        }

        .breadcrumb a {
            color: #4a90e2;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* News Detail */
        .news-detail {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 3rem;
        }

        .news-hero-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
        }

        .news-detail-content {
            padding: 3rem;
        }

        .news-category-detail {
            display: inline-block;
            background: #4a90e2;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .news-title-detail {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: #1e3c72;
            line-height: 1.3;
        }

        .news-meta-detail {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #f0f0f0;
            color: #666;
        }

        .news-meta-detail i {
            margin-right: 0.5rem;
            color: #4a90e2;
        }

        .news-content-detail {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #444;
            margin-bottom: 3rem;
        }

        .news-content-detail p {
            margin-bottom: 1.5rem;
        }

        /* Gallery */
        .news-gallery {
            margin: 3rem 0;
        }

        .news-gallery h3 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #1e3c72;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .gallery-item {
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .gallery-item:hover {
            transform: scale(1.05);
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        /* News List */
        .news-list-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .news-list-title {
            font-size: 2.5rem;
            color: #1e3c72;
            margin-bottom: 1rem;
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .news-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .news-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
        }

        .news-content {
            padding: 1.5rem;
        }

        .news-category {
            display: inline-block;
            background: #4a90e2;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .news-card h3 {
            font-size: 1.3rem;
            margin-bottom: 0.8rem;
            color: #1e3c72;
            line-height: 1.4;
        }

        .news-excerpt {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .news-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 1rem;
        }

        .news-date, .news-author {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* Back Button */
        .back-button {
            display: inline-block;
            background: #4a90e2;
            color: white;
            padding: 0.8rem 1.5rem;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: background 0.3s;
            margin-bottom: 2rem;
        }

        .back-button:hover {
            background: #357abd;
        }

        .back-button i {
            margin-right: 0.5rem;
        }

        /* Modal for Gallery */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.9);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 90%;
            max-height: 90%;
        }

        .modal-content img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-modal:hover {
            color: #bbb;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .news-title-detail {
                font-size: 2rem;
            }

            .news-detail-content {
                padding: 2rem;
            }

            .news-meta-detail {
                flex-direction: column;
                gap: 1rem;
            }

            .container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav>
            <div class="logo">
                <img src="{{ asset('storage/logo/logo white.png') }}" alt="LP3I Karawang Logo" />
            </div>
            <button class="mobile-menu-toggle">☰</button>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li class="dropdown">
                    <a href="#profil">Profil</a>
                    <div class="dropdown-content">
                        <a href="#sejarah">Sejarah</a>
                        <a href="#visi-misi">Visi & Misi</a>
                        <a href="#struktur">Struktur Organisasi</a>
                        <a href="#fasilitas">Fasilitas</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#programs">Program Studi</a>
                    <div class="dropdown-content">
                        <a href="#teknik-informatika">Teknik Informatika</a>
                        <a href="#manajemen-bisnis">Manajemen Bisnis</a>
                        <a href="#akuntansi">Akuntansi</a>
                        <a href="#marketing-digital">Marketing Digital</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="{{ route('mahasiswa.create') }}">Pendaftaran</a>
                    <div class="dropdown-content">
                        <a href="{{ route('mahasiswa.create') }}">Form Pendaftaran</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#akademik">Akademik</a>
                    <div class="dropdown-content">
                        <a href="#kalender-akademik">Kalender Akademik</a>
                        <a href="#kurikulum">Kurikulum</a>
                        <a href="#sistem-pembelajaran">Sistem Pembelajaran</a>
                        <a href="#evaluasi">Evaluasi</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#dosen">Dosen</a>
                    <div class="dropdown-content">
                        <a href="#profil-dosen">Profil Dosen</a>
                        <a href="#penelitian">Penelitian</a>
                        <a href="#publikasi">Publikasi</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#pusat-karir">Pusat Karir</a>
                    <div class="dropdown-content">
                        <a href="#lowongan-kerja">Lowongan Kerja</a>
                        <a href="#magang">Program Magang</a>
                        <a href="#alumni">Alumni</a>
                        <a href="#kerjasama-industri">Kerjasama Industri</a>
                    </div>
                </li>
                <li><a href="/news">Berita</a></li>
                <li><a href="/index.php#contact">Kontak</a></li>
                <li><a href="/admin">Admin</a></li>
                <li><a href="#kegiatan">Kegiatan</a></li>
                <li><a href="/mahasiswa/create" class="register-btn"><i class="fas fa-clipboard-check"></i> Daftar Sekarang</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <?php if ($showDetail): ?>
            <!-- News Detail View -->
            <div class="breadcrumb">
                <a href="/">Home</a> > <a href="/news">Berita</a> > <?= htmlspecialchars($currentNews['title']) ?>
            </div>

            <a href="/news" class="back-button">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Berita
            </a>

            <article class="news-detail">
                <?php
                    $newsImagePath = null;
                    if (!empty($currentNews['image_path'])) {
                        $candidates = [
                            $currentNews['image_path'],
                            'storage/' . ltrim($currentNews['image_path'], '/'),
                            'storage/' . ltrim($currentNews['image_path'], '/'),
                        ];
                        foreach ($candidates as $p) {
                            if (!empty($p) && file_exists(public_path($p))) {
                                $newsImagePath = asset($p);
                                break;
                            }
                        }
                    }
                ?>
                <?php if (!empty($newsImagePath)): ?>
                    <img src="<?= htmlspecialchars($newsImagePath) ?>" alt="<?= htmlspecialchars($currentNews['title']) ?>" class="news-hero-image">
                <?php else: ?>
                    <div class="news-hero-image" style="display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem;">
                        <i class="fas fa-newspaper"></i>
                    </div>
                <?php endif; ?>

                <div class="news-detail-content">
                    <span class="news-category-detail"><?= htmlspecialchars($currentNews['category']) ?></span>
                    <h1 class="news-title-detail"><?= htmlspecialchars($currentNews['title']) ?></h1>
                    
                    <div class="news-meta-detail">
                        <div class="news-date">
                            <i class="fas fa-calendar-alt"></i>
                            <?= date('d F Y', strtotime($currentNews['created_at'])) ?>
                        </div>
                        <div class="news-author">
                            <i class="fas fa-user"></i>
                            <?= htmlspecialchars($currentNews['author']) ?>
                        </div>
                    </div>

                    <div class="news-content-detail">
                        <?= nl2br(htmlspecialchars($currentNews['content'])) ?>
                    </div>

                    <?php if (!empty($currentNews['gallery_images'])): ?>
                        <div class="news-gallery">
                            <h3><i class="fas fa-images"></i> Galeri Foto</h3>
                            <div class="gallery-grid">
                                <?php 
                                $galleryImages = explode(',', $currentNews['gallery_images']);
                                foreach ($galleryImages as $image): 
                                    $image = trim($image);
                                    if (!empty($image) && file_exists(public_path($image))):
                                ?>
                                    <div class="gallery-item" onclick="openModal('<?= htmlspecialchars(asset($image)) ?>')">
                                        <img src="<?= htmlspecialchars(asset($image)) ?>" alt="Gallery Image">
                                    </div>
                                <?php endif; endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </article>

                <?php else: ?>
            <!-- News List View -->
            <div class="news-list-header">
                <h1 class="news-list-title">Semua Berita</h1>
                <p>Ikuti perkembangan terbaru dari LP3I Karawang</p>
            </div>

            <?php if (empty($allNews)): ?>
                <div style="text-align: center; padding: 3rem; color: #666;">
                    <i class="fas fa-newspaper" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <h3>Belum Ada Berita</h3>
                    <p>Berita terbaru akan ditampilkan di sini.</p>
                </div>
            <?php else: ?>
                <div class="news-grid">
                    <?php foreach ($allNews as $news): ?>
                        <div class="news-card" onclick="location.href='/news/<?= $news['id'] ?>'">
                            <?php
                                $newsImage = null;
                                if (!empty($news['image_path'])) {
                                    $candidates = [
                                        $news['image_path'],
                                        'storage/' . ltrim($news['image_path'], '/'),
                                        'storage/' . ltrim($news['image_path'], '/'),
                                    ];
                                    foreach ($candidates as $p) {
                                        if (!empty($p) && file_exists(public_path($p))) {
                                            $newsImage = asset($p);
                                            break;
                                        }
                                    }
                                }
                            ?>
                            <?php if (!empty($newsImage)): ?>
                                <img src="<?= htmlspecialchars($newsImage) ?>" alt="<?= htmlspecialchars($news['title']) ?>" class="news-image">
                            <?php else: ?>
                                <div class="news-image" style="display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="news-content">
                                <span class="news-category"><?= htmlspecialchars($news['category']) ?></span>
                                <h3><?= htmlspecialchars($news['title']) ?></h3>
                                <p class="news-excerpt">
                                    <?= htmlspecialchars($news['excerpt'] ?: (strlen($news['content']) > 150 ? substr($news['content'], 0, 150) . '...' : $news['content'])) ?>
                                </p>
                                <div class="news-meta">
                                    <div class="news-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        <?= date('d M Y', strtotime($news['created_at'])) ?>
                                    </div>
                                    <div class="news-author">
                                        <i class="fas fa-user"></i>
                                        <?= htmlspecialchars($news['author']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Modal for Gallery -->
    <div id="imageModal" class="modal">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <div class="modal-content">
            <img id="modalImage" src="" alt="Gallery Image">
        </div>
    </div>

    <script>
        function openModal(imageSrc) {
            document.getElementById('imageModal').style.display = 'block';
            document.getElementById('modalImage').src = imageSrc;
        }

        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('imageModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            const navLinks = document.querySelector('.nav-links');

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function() {
                    navLinks.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>
