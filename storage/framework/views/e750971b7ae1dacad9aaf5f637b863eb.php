<?php
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
    usort($data, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
    return $limit ? array_slice($data, 0, $limit) : $data;
}

function getNewsById($id) {
    $newsData = getNewsData();
    foreach ($newsData as $news) {
        if ($news['id'] == $id) return $news;
    }
    return null;
}

$newsId = isset($_GET['id']) ? $_GET['id'] : null;
$currentNews = null;
$allNews = getNewsData();
if ($newsId) $currentNews = getNewsById($newsId);
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
        :root {
            --primary: #1e3c72;
            --secondary: #2a5298;
            --accent: #4a90e2;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --bg-body: #f8fafc;
            --white: #ffffff;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            line-height: 1.7;
            padding-top: 80px;
        }        
        header {
            background: #043158;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 12px 0;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo { display: flex; align-items: center; gap: 10px; }
        .logo img { height: 40px; width: auto; }
        
        .nav-links { display: flex; list-style: none; gap: 2rem; }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            opacity: 0.85;
            transition: 0.3s;
        }
        .nav-links a:hover { opacity: 1; color: var(--accent); }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* --- NEWS LIST VIEW --- */
        .news-list-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        .news-list-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        .news-list-header p { color: var(--text-light); }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2.5rem;
        }

        .news-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 1px solid rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
        }

        .news-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
        }

        .news-image-wrapper {
            position: relative;
            overflow: hidden;
            height: 220px;
        }

        .news-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }

        .news-card:hover .news-image { transform: scale(1.1); }

        .news-content { padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; }
        
        .news-category {
            background: #e0f2fe;
            color: #0369a1;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            display: inline-block;
            width: fit-content;
        }

        .news-card h3 {
            font-size: 1.25rem;
            line-height: 1.4;
            color: var(--text-dark);
            margin-bottom: 0.8rem;
            font-weight: 700;
        }

        .news-excerpt {
            color: var(--text-light);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .news-meta {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--text-light);
        }

        /* --- NEWS DETAIL VIEW --- */
        .breadcrumb { margin-bottom: 1.5rem; font-size: 0.9rem; color: var(--text-light); }
        .breadcrumb a { color: var(--accent); text-decoration: none; }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-light);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 2rem;
            transition: 0.3s;
        }
        .back-button:hover { color: var(--primary); transform: translateX(-5px); }

        .news-detail-wrapper {
            max-width: 900px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .news-hero-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        .news-detail-body { padding: 3rem; }

        .news-title-detail {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.2;
            margin: 1rem 0 1.5rem;
        }

        .meta-info {
            display: flex;
            gap: 2rem;
            margin-bottom: 2.5rem;
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .news-content-detail {
            font-size: 1.15rem;
            color: #334155;
            line-height: 1.8;
        }

        .news-content-detail p { margin-bottom: 1.5rem; }

        /* --- GALLERY GRID --- */
        .news-gallery { margin-top: 4rem; padding-top: 2rem; border-top: 2px solid #f1f5f9; }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .gallery-item {
            height: 150px;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
        }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: 0.3s; }
        .gallery-item:hover img { transform: scale(1.1); }

        /* --- MODAL --- */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.95);
            z-index: 2000;
            padding: 2rem;
            backdrop-filter: blur(5px);
        }
        .modal-content {
            max-width: 80%;
            max-height: 80vh;
            margin: auto;
            display: block;
            border-radius: 10px;
        }
        .close-modal {
            position: absolute;
            top: 2rem;
            right: 2rem;
            color: white;
            font-size: 2rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .news-grid { grid-template-columns: 1fr; }
            .news-hero-image { height: 300px; }
            .news-detail-body { padding: 1.5rem; }
            .news-title-detail { font-size: 1.8rem; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    <header>
        <nav>
            <div class="logo">
                <img src="<?= asset('storage/image/LOGO_LP3I.png') ?>" alt="Logo">
                <img src="<?= asset('storage/image/global.png') ?>" alt="Logo">
            </div>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="/news">Berita</a></li>
                <li><a href="#">Program</a></li>
                <li><a href="#">Kontak</a></li>
            </ul>
            <button class="mobile-menu-toggle" style="background:none; border:none; color:white; font-size:1.5rem; display:none;">☰</button>
        </nav>
    </header>

    <div class="container">
        <?php if ($showDetail): ?>
            <div class="breadcrumb">
                <a href="/">Home</a> / <a href="/news">Berita</a> / Detail
            </div>

            <a href="/news" class="back-button">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <article class="news-detail-wrapper">
                <?php 
                    $newsImagePath = !empty($currentNews['image_path']) && file_exists(public_path($currentNews['image_path'])) 
                        ? asset($currentNews['image_path']) 
                        : null;
                ?>
                
                <?php if ($newsImagePath): ?>
                    <img src="<?= $newsImagePath ?>" class="news-hero-image" alt="Hero">
                <?php else: ?>
                    <div class="news-hero-image" style="background:var(--primary); display:grid; place-items:center; color:white; font-size:5rem;">
                        <i class="fas fa-newspaper"></i>
                    </div>
                <?php endif; ?>

                <div class="news-detail-body">
                    <span class="news-category"><?= htmlspecialchars($currentNews['category']) ?></span>
                    <h1 class="news-title-detail"><?= htmlspecialchars($currentNews['title']) ?></h1>
                    
                    <div class="meta-info">
                        <span><i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($currentNews['created_at'])) ?></span>
                        <span><i class="far fa-user"></i> <?= htmlspecialchars($currentNews['author']) ?></span>
                    </div>

                    <div class="news-content-detail">
                        <?= nl2br(htmlspecialchars($currentNews['content'])) ?>
                    </div>

                    <?php if (!empty($currentNews['gallery_images'])): ?>
                        <div class="news-gallery">
                            <h3><i class="fas fa-images"></i> Galeri Foto</h3>
                            <div class="gallery-grid">
                                <?php 
                                    $gallery = explode(',', $currentNews['gallery_images']);
                                    foreach ($gallery as $img): 
                                        $img = trim($img);
                                        if(!empty($img)):
                                ?>
                                    <div class="gallery-item" onclick="openModal('<?= asset($img) ?>')">
                                        <img src="<?= asset($img) ?>" alt="Gallery">
                                    </div>
                                <?php endif; endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </article>

        <?php else: ?>
            <div class="news-list-header">
                <h1 class="news-list-title">Berita Terkini</h1>
                <p>Informasi terbaru seputar kegiatan dan prestasi LP3I Karawang</p>
            </div>

            <div class="news-grid">
                <?php foreach ($allNews as $news): ?>
                    <div class="news-card" onclick="location.href='/news?id=<?= $news['id'] ?>'">
                        <div class="news-image-wrapper">
                            <?php 
                                $img = !empty($news['image_path']) && file_exists(public_path($news['image_path'])) 
                                    ? asset($news['image_path']) 
                                    : null;
                            ?>
                            <?php if($img): ?>
                                <img src="<?= $img ?>" class="news-image" alt="News">
                            <?php else: ?>
                                <div class="news-image" style="background:#f1f5f9; display:grid; place-items:center; color:#cbd5e1; font-size:3rem;">
                                    <i class="fas fa-image"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="news-content">
                            <span class="news-category"><?= htmlspecialchars($news['category']) ?></span>
                            <h3><?= htmlspecialchars($news['title']) ?></h3>
                            <p class="news-excerpt">
                                <?= htmlspecialchars($news['excerpt'] ?: substr($news['content'], 0, 120) . '...') ?>
                            </p>
                            <div class="news-meta">
                                <span><i class="far fa-calendar"></i> <?= date('d M Y', strtotime($news['created_at'])) ?></span>
                                <span><i class="far fa-user"></i> Admin</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div id="imageModal" class="modal" onclick="closeModal()">
        <span class="close-modal">&times;</span>
        <img id="modalImage" class="modal-content" src="">
    </div>

    <script>
        function openModal(src) {
            document.getElementById('imageModal').style.display = 'flex';
            document.getElementById('modalImage').src = src;
        }
        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
        }
        // ESC key to close
        document.addEventListener('keydown', (e) => { if(e.key === "Escape") closeModal(); });
    </script>
</body>
</html><?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/news.blade.php ENDPATH**/ ?>