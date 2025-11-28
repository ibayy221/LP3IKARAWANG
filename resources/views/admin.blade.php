<?php
// Admin functions for carousel management
function getCarouselData() {
    $csvFile = 'data/carousel.csv';
    $data = [];
    
    if (file_exists($csvFile) && ($handle = fopen($csvFile, "r")) !== FALSE) {
        $header = fgetcsv($handle);
        while (($row = fgetcsv($handle)) !== FALSE) {
            if (count($row) === count($header)) {
                $slideData = array_combine($header, $row);
                $data[] = $slideData;
            }
        }
        fclose($handle);
    }
    
    return $data;
}

// News management functions
function getNewsData() {
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
                        'created_at' => $newsData['created_at'],
                        'status' => $newsData['status']
                    ];
                }
            }
        }
        fclose($handle);
    }
    
    return $data;
}

function getAllNewsData() {
    $csvFile = 'data/news.csv';
    $data = [];
    
    if (file_exists($csvFile) && ($handle = fopen($csvFile, "r")) !== FALSE) {
        $header = fgetcsv($handle);
        while (($row = fgetcsv($handle)) !== FALSE) {
            if (count($row) === count($header)) {
                $newsData = array_combine($header, $row);
                $data[] = [
                    'id' => $newsData['id'],
                    'title' => $newsData['title'],
                    'content' => $newsData['content'],
                    'excerpt' => $newsData['excerpt'],
                    'category' => $newsData['category'],
                    'image_path' => $newsData['image_path'],
                    'gallery_images' => isset($newsData['gallery_images']) ? $newsData['gallery_images'] : '',
                    'author' => $newsData['author'],
                    'created_at' => $newsData['created_at'],
                    'status' => $newsData['status']
                ];
            }
        }
        fclose($handle);
    }
    
    return $data;
}

function saveNewsData($data) {
    $csvFile = 'data/news.csv';
    $handle = fopen($csvFile, 'w');
    
    if ($handle) {
        // Write header
        $header = ['id', 'title', 'content', 'excerpt', 'category', 'image_path', 'gallery_images', 'author', 'created_at', 'status'];
        fputcsv($handle, $header);
        
        // Write data
        foreach ($data as $row) {
            fputcsv($handle, [
                $row['id'],
                $row['title'],
                $row['content'],
                $row['excerpt'],
                $row['category'],
                $row['image_path'],
                $row['gallery_images'],
                $row['author'],
                $row['created_at'],
                $row['status']
            ]);
        }
        
        fclose($handle);
        return true;
    }
    
    return false;
}

function deleteNews($id) {
    $data = getAllNewsData();
    $newData = [];
    $deletedImage = '';
    
    foreach ($data as $news) {
        if ($news['id'] != $id) {
            $newData[] = $news;
        } else {
            $deletedImage = $news['image_path'];
        }
    }
    
    // Delete image file if exists
    if (!empty($deletedImage) && file_exists($deletedImage)) {
        unlink($deletedImage);
    }
    
    return saveNewsData($newData);
}

function saveCarouselData($data) {
    $csvFile = 'data/carousel.csv';
    $handle = fopen($csvFile, 'w');
    
    if ($handle) {
        // Write header
        $header = ['id', 'title', 'subtitle', 'button_text', 'image_path', 'created_at', 'status'];
        fputcsv($handle, $header);
        
        // Write data
        foreach ($data as $row) {
            fputcsv($handle, $row);
        }
        
        fclose($handle);
        return true;
    }
    
    return false;
}

function deleteSlide($id) {
    $data = getCarouselData();
    $newData = [];
    $deletedImage = '';
    
    foreach ($data as $slide) {
        if ($slide['id'] != $id) {
            $newData[] = $slide;
        } else {
            $deletedImage = $slide['image_path'];
        }
    }
    
    // Delete image file if exists
    if (!empty($deletedImage) && file_exists($deletedImage)) {
        unlink($deletedImage);
    }
    
    return saveCarouselData($newData);
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    try {
        switch ($_POST['action']) {
            case 'get_slides':
                echo json_encode(['success' => true, 'data' => getCarouselData()]);
                exit;
                
            case 'delete_slide':
                $id = $_POST['id'];
                $success = deleteSlide($id);
                echo json_encode(['success' => $success]);
                exit;
                
            case 'save_slide':
                // Validate required fields
                if (empty($_POST['title']) || empty($_POST['subtitle']) || empty($_POST['button_text'])) {
                    echo json_encode(['success' => false, 'error' => 'Semua field harus diisi']);
                    exit;
                }
                
                $data = getCarouselData();
                $slideId = !empty($_POST['id']) ? $_POST['id'] : (count($data) + 1);
                
                $newSlide = [
                    'id' => $slideId,
                    'title' => trim($_POST['title']),
                    'subtitle' => trim($_POST['subtitle']),
                    'button_text' => trim($_POST['button_text']),
                    'image_path' => '',
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => $_POST['status'] ?: 'active'
                ];
                
                // Handle image upload
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'upload/carousel/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                        echo json_encode(['success' => false, 'error' => 'Format gambar tidak didukung. Gunakan JPG, PNG, atau GIF']);
                        exit;
                    }
                    
                    if ($_FILES['image']['size'] > 5 * 1024 * 1024) { // 5MB limit
                        echo json_encode(['success' => false, 'error' => 'Ukuran gambar terlalu besar. Maksimal 5MB']);
                        exit;
                    }
                    
                    $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['image']['name']);
                    $uploadPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                        $newSlide['image_path'] = $uploadPath;
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Gagal upload gambar']);
                        exit;
                    }
                } else if (!empty($_POST['existing_image'])) {
                    $newSlide['image_path'] = $_POST['existing_image'];
                }
                
                // Update existing or add new
                $found = false;
                foreach ($data as $key => $slide) {
                    if ($slide['id'] == $newSlide['id']) {
                        // Keep existing image if no new image uploaded
                        if (empty($newSlide['image_path']) && !empty($slide['image_path'])) {
                            $newSlide['image_path'] = $slide['image_path'];
                        }
                        $data[$key] = $newSlide;
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $data[] = $newSlide;
                }
                
                $success = saveCarouselData($data);
                echo json_encode(['success' => $success, 'message' => 'Slide berhasil disimpan']);
                exit;

            // News management cases
            case 'get_news':
                echo json_encode(['success' => true, 'data' => getNewsData()]);
                exit;
                
            case 'delete_news':
                $id = $_POST['id'];
                $success = deleteNews($id);
                echo json_encode(['success' => $success]);
                exit;
                
            case 'save_news':
                // Validate required fields
                if (empty($_POST['title']) || empty($_POST['content']) || empty($_POST['category'])) {
                    echo json_encode(['success' => false, 'error' => 'Title, content, dan category harus diisi']);
                    exit;
                }
                
                $data = getAllNewsData();
                
                // Generate unique ID for new news
                if (!empty($_POST['id'])) {
                    $newsId = $_POST['id'];
                } else {
                    // Find the highest existing ID and add 1
                    $maxId = 0;
                    foreach ($data as $news) {
                        if (intval($news['id']) > $maxId) {
                            $maxId = intval($news['id']);
                        }
                    }
                    $newsId = $maxId + 1;
                }
                
                $newNews = [
                    'id' => $newsId,
                    'title' => trim($_POST['title']),
                    'content' => trim($_POST['content']),
                    'excerpt' => trim($_POST['excerpt']) ?: substr(strip_tags($_POST['content']), 0, 150) . '...',
                    'category' => trim($_POST['category']),
                    'image_path' => '',
                    'gallery_images' => '',
                    'author' => trim($_POST['author']) ?: 'Admin LP3I',
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => $_POST['status'] ?: 'active'
                ];
                
                // Handle image upload
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'upload/news/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                        echo json_encode(['success' => false, 'error' => 'Format gambar tidak didukung. Gunakan JPG, PNG, atau GIF']);
                        exit;
                    }
                    
                    if ($_FILES['image']['size'] > 5 * 1024 * 1024) { // 5MB limit
                        echo json_encode(['success' => false, 'error' => 'Ukuran gambar terlalu besar. Maksimal 5MB']);
                        exit;
                    }
                    
                    $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['image']['name']);
                    $uploadPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                        $newNews['image_path'] = $uploadPath;
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Gagal upload gambar']);
                        exit;
                    }
                } else if (!empty($_POST['existing_image'])) {
                    $newNews['image_path'] = $_POST['existing_image'];
                }
                
                // Handle gallery images upload
                $galleryImages = [];
                if (isset($_FILES['gallery_images'])) {
                    $uploadDir = 'upload/news/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    
                    foreach ($_FILES['gallery_images']['tmp_name'] as $key => $tmpName) {
                        if ($_FILES['gallery_images']['error'][$key] === UPLOAD_ERR_OK) {
                            if (!in_array($_FILES['gallery_images']['type'][$key], $allowedTypes)) {
                                continue; // Skip invalid file types
                            }
                            
                            if ($_FILES['gallery_images']['size'][$key] > 5 * 1024 * 1024) {
                                continue; // Skip files larger than 5MB
                            }
                            
                            $fileName = time() . '_' . $key . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['gallery_images']['name'][$key]);
                            $uploadPath = $uploadDir . $fileName;
                            
                            if (move_uploaded_file($tmpName, $uploadPath)) {
                                $galleryImages[] = $uploadPath;
                            }
                        }
                    }
                }
                
                // Add existing gallery images if editing
                if (!empty($_POST['existing_gallery'])) {
                    $existingGallery = explode(',', $_POST['existing_gallery']);
                    $galleryImages = array_merge($galleryImages, array_filter($existingGallery));
                }
                
                $newNews['gallery_images'] = implode(',', $galleryImages);
                
                // Update existing or add new
                $found = false;
                foreach ($data as $key => $news) {
                    if ($news['id'] == $newNews['id']) {
                        // Keep existing image if no new image uploaded
                        if (empty($newNews['image_path']) && !empty($news['image_path'])) {
                            $newNews['image_path'] = $news['image_path'];
                        }
                        $data[$key] = $newNews;
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $data[] = $newNews;
                }
                
                $success = saveNewsData($data);
                echo json_encode(['success' => $success, 'message' => 'Berita berhasil disimpan']);
                exit;
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Server error: ' . $e->getMessage()]);
        exit;
    }
}

$carouselData = getCarouselData();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - LP3I Karawang</title>
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
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            color: #333;
        }

        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .admin-header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
            text-align: center;
        }

        .admin-header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .admin-header p {
            opacity: 0.9;
        }

        .admin-content {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
        }

        .sidebar {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2rem;
            height: fit-content;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .sidebar h3 {
            color: #1e3c72;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: block;
            padding: 1rem;
            color: #666;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #4a90e2;
            color: white;
        }

        .main-content {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .section-title {
            color: #1e3c72;
            font-size: 2rem;
            margin-bottom: 2rem;
            border-bottom: 3px solid #4a90e2;
            padding-bottom: 0.5rem;
        }

        .carousel-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .carousel-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            border-left: 4px solid #4a90e2;
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .carousel-item-info h4 {
            color: #1e3c72;
            margin-bottom: 0.5rem;
        }

        .carousel-item-info p {
            color: #666;
            font-size: 0.9rem;
        }

        .carousel-item-actions {
            display: flex;
            gap: 0.5rem;
        }

        .news-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .news-item {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            justify-content: space-between;
        }

        .news-item-info h4 {
            margin: 0 0 0.5rem 0;
            color: #1e3c72;
        }

        .news-item-info p {
            margin: 0 0 0.5rem 0;
            color: #666;
        }

        .category-badge {
            background: #4a90e2;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
        }

        .news-item-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #4a90e2;
            color: white;
        }

        .btn-primary:hover {
            background: #357abd;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background: #219a52;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #1e3c72;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #4a90e2;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .image-upload {
            border: 2px dashed #4a90e2;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .image-upload:hover {
            background: rgba(74, 144, 226, 0.1);
        }

        .image-upload i {
            font-size: 3rem;
            color: #4a90e2;
            margin-bottom: 1rem;
        }

        .image-preview {
            max-width: 200px;
            max-height: 150px;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .image-preview img {
            max-width: 200px;
            max-height: 150px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .gallery-preview {
            margin-top: 1rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .gallery-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .gallery-item img {
            width: 100%;
            height: 80px;
            object-fit: cover;
        }

        .gallery-item .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-item .remove-btn:hover {
            background: rgba(255, 0, 0, 1);
        }

        .form-help {
            color: #666;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: block;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 15px;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 1rem;
        }

        .modal-header h3 {
            color: #1e3c72;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
        }

        @media (max-width: 768px) {
            .admin-content {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                order: 2;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1><i class="fas fa-cogs"></i> Admin Panel</h1>
            <p>Kelola Carousel & Konten Website LP3I Karawang</p>
        </div>

        <div class="admin-content">
            <div class="sidebar">
                <h3>Menu Admin</h3>
                <ul class="sidebar-menu">
                    <li><a href="#" class="menu-link active" data-section="carousel">
                        <i class="fas fa-images"></i> Kelola Carousel
                    </a></li>
                    <li><a href="#" class="menu-link" data-section="news">
                        <i class="fas fa-newspaper"></i> Kelola Berita
                    </a></li>
                    <li><a href="#" class="menu-link" data-section="settings">
                        <i class="fas fa-cog"></i> Pengaturan
                    </a></li>
                    <li><a href="index.php" class="menu-link">
                        <i class="fas fa-home"></i> Kembali ke Website
                    </a></li>
                </ul>
            </div>

            <div class="main-content">
                <!-- Carousel Management Section -->
                <div class="content-section active" id="carousel-section">
                    <h2 class="section-title">Kelola Carousel</h2>
                    
                    <button class="btn btn-success" onclick="openAddModal()">
                        <i class="fas fa-plus"></i> Tambah Slide Baru
                    </button>

                    <div class="carousel-list" id="carousel-list">
                        <?php foreach ($carouselData as $slide): ?>
                        <div class="carousel-item" data-id="<?= $slide['id'] ?>">
                            <div class="carousel-info">
                                <h3><?= htmlspecialchars($slide['title']) ?></h3>
                                <p><?= htmlspecialchars($slide['subtitle']) ?></p>
                                <span class="status <?= $slide['status'] ?>"><?= ucfirst($slide['status']) ?></span>
                                <?php if (!empty($slide['image_path'])):
                                    // normalize slide image URL (public path -> storage link)
                                    $imgUrl = '';
                                    $p = $slide['image_path'];
                                    if (file_exists(public_path($p))) {
                                        $imgUrl = asset($p);
                                    } elseif (file_exists(public_path('storage/' . ltrim($p, '/')))) {
                                        $imgUrl = asset('storage/' . ltrim($p, '/'));
                                    } elseif (file_exists(storage_path('app/public/' . ltrim($p, '/')))) {
                                        $imgUrl = asset('storage/' . ltrim($p, '/'));
                                    }
                                    if ($imgUrl): ?>
                                    <div class="image-preview">
                                        <img src="<?= $imgUrl ?>" alt="Slide Image" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                    </div>
                                <?php endif; endif; ?>
                            </div>
                            <div class="carousel-actions">
                                <button class="btn-edit" onclick="editSlide(<?= $slide['id'] ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn-delete" onclick="deleteSlide(<?= $slide['id'] ?>)">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- News Management Section -->
                <div class="content-section" id="news-section">
                    <h2 class="section-title">Kelola Berita</h2>
                    
                    <button class="btn btn-success" onclick="openAddNewsModal()">
                        <i class="fas fa-plus"></i> Tambah Berita Baru
                    </button>

                    <div class="news-list" id="news-list">
                        <!-- News items will be loaded here -->
                    </div>
                </div>

                <!-- Settings Section -->
                <div class="content-section" id="settings-section">
                    <h2 class="section-title">Pengaturan</h2>
                    <p>Fitur pengaturan akan ditambahkan di sini.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Carousel Modal -->
    <div class="modal" id="carousel-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title">Tambah Slide Baru</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            
            <form id="slide-form" enctype="multipart/form-data" onsubmit="handleFormSubmit(event)">
                <input type="hidden" id="slide-id" name="id">
                <input type="hidden" id="existing-image" name="existing_image">
                
                <div class="form-group">
                    <label for="slide-title">Judul Slide:</label>
                    <input type="text" id="slide-title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="slide-subtitle">Subtitle:</label>
                    <textarea id="slide-subtitle" name="subtitle" rows="3" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="slide-button">Teks Tombol:</label>
                    <input type="text" id="slide-button" name="button_text" required>
                </div>
                
                <div class="form-group">
                    <label for="slide-image">Gambar Slide:</label>
                    <input type="file" id="slide-image" name="image" accept="image/*" onchange="previewImage(this)">
                    <div id="image-preview" class="image-preview"></div>
                </div>
                
                <div class="form-group">
                    <label for="slide-status">Status:</label>
                    <select id="slide-status" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" class="btn btn-danger" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add/Edit News Modal -->
    <div class="modal" id="news-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="news-modal-title">Tambah Berita Baru</h3>
                <button class="close-modal" onclick="closeNewsModal()">&times;</button>
            </div>
            
            <form id="news-form" enctype="multipart/form-data" onsubmit="handleNewsFormSubmit(event)">
                <input type="hidden" id="news-id" name="id">
                <input type="hidden" id="news-existing-image" name="existing_image">
                
                <div class="form-group">
                    <label for="news-title">Judul Berita:</label>
                    <input type="text" id="news-title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="news-category">Kategori:</label>
                    <select id="news-category" name="category" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Prestasi">Prestasi</option>
                        <option value="Kerjasama">Kerjasama</option>
                        <option value="Workshop">Workshop</option>
                        <option value="Fasilitas">Fasilitas</option>
                        <option value="Seminar">Seminar</option>
                        <option value="Kegiatan">Kegiatan</option>
                        <option value="Pengumuman">Pengumuman</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="news-excerpt">Ringkasan:</label>
                    <textarea id="news-excerpt" name="excerpt" rows="2" placeholder="Ringkasan singkat berita (opsional)"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="news-content">Konten Berita:</label>
                    <textarea id="news-content" name="content" rows="6" required placeholder="Tulis konten berita lengkap di sini..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="news-author">Penulis:</label>
                    <input type="text" id="news-author" name="author" placeholder="Admin LP3I">
                </div>
                
                <div class="form-group">
                    <label for="news-image">Gambar Utama Berita:</label>
                    <input type="file" id="news-image" name="image" accept="image/*" onchange="previewNewsImage(this)">
                    <div id="news-image-preview" class="image-preview"></div>
                </div>
                
                <div class="form-group">
                    <label for="news-gallery">Galeri Foto (Multiple):</label>
                    <input type="file" id="news-gallery" name="gallery_images[]" accept="image/*" multiple onchange="previewGalleryImages(this)">
                    <input type="hidden" id="existing-gallery" name="existing_gallery">
                    <div id="gallery-preview" class="gallery-preview">
                        <div class="gallery-grid" id="gallery-grid"></div>
                    </div>
                    <small class="form-help">Pilih beberapa gambar untuk galeri berita. Format: JPG, PNG, GIF. Maksimal 5MB per gambar.</small>
                </div>
                
                <div class="form-group">
                    <label for="news-status">Status:</label>
                    <select id="news-status" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" class="btn btn-danger" onclick="closeNewsModal()">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Global variables
        let carouselData = <?= json_encode($carouselData) ?>;
        let newsData = [];
        let editingId = null;

        // Carousel management functions
        async function fetchCarouselData() {
            try {
                const formData = new FormData();
                formData.append('action', 'get_slides');
                
                const response = await fetch('admin.php', {
                    method: 'POST',
                    body: formData
                });
                const responseText = await response.text();
                const result = JSON.parse(responseText);
                if (result.success) {
                    carouselData = result.data;
                    loadCarouselList();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        async function saveCarouselSlide(formData) {
            try {
                formData.append('action', 'save_slide');
                const response = await fetch('admin.php', {
                    method: 'POST',
                    body: formData
                });
                
                const responseText = await response.text();
                let result;
                try {
                    result = JSON.parse(responseText);
                } catch (e) {
                    console.error('JSON parse error:', e);
                    alert('Server error: Invalid response format');
                    return false;
                }
                
                if (result.success) {
                    alert(result.message || 'Slide berhasil disimpan');
                    location.reload();
                    return true;
                } else {
                    alert('Error: ' + (result.error || 'Unknown error'));
                    return false;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error saving slide: ' + error.message);
                return false;
            }
        }

        async function deleteCarouselSlide(id) {
            try {
                const formData = new FormData();
                formData.append('action', 'delete_slide');
                formData.append('id', id);
                
                const response = await fetch('admin.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                if (result.success) {
                    location.reload();
                    return true;
                } else {
                    alert('Error: ' + result.error);
                    return false;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error deleting slide');
                return false;
            }
        }

        // News management functions
        async function fetchNewsData() {
            try {
                const formData = new FormData();
                formData.append('action', 'get_news');
                
                const response = await fetch('admin.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                if (result.success) {
                    newsData = result.data;
                    loadNewsList();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function loadNewsList() {
            const newsList = document.getElementById('news-list');
            newsList.innerHTML = '';
            
            if (newsData.length === 0) {
                newsList.innerHTML = '<p style="text-align: center; color: #666; padding: 2rem;">Belum ada berita.</p>';
                return;
            }
            
            newsData.forEach(news => {
                // normalize image path for news items (if it's a relative path saved in storage/app/public)
                let imgSrc = '';
                if (news.image_path) {
                    imgSrc = news.image_path.trim();
                    // if path is not absolute (no leading / or protocol), assume it's stored in public storage
                    if (!imgSrc.startsWith('http') && !imgSrc.startsWith('/') && !imgSrc.startsWith('data:')) {
                        imgSrc = '/storage/' + imgSrc.replace(/^\/+/, '');
                    }
                }
                const newsItem = document.createElement('div');
                newsItem.className = 'news-item';
                newsItem.innerHTML = `
                    <div class="news-info">
                        <h3>${news.title}</h3>
                        <p class="news-category">${news.category}</p>
                        <p class="news-excerpt">${news.excerpt || news.content.substring(0, 100) + '...'}</p>
                        <span class="news-meta">
                            <i class="fas fa-user"></i> ${news.author} | 
                            <i class="fas fa-calendar"></i> ${new Date(news.created_at).toLocaleDateString('id-ID')}
                        </span>
                        ${imgSrc ? `<div class="image-preview"><img src="${imgSrc}" alt="News Image" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;"></div>` : ''}
                    </div>
                    <div class="news-actions">
                        <button class="btn-edit" onclick="editNews(${news.id})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn-delete" onclick="deleteNews(${news.id})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                `;
                newsList.appendChild(newsItem);
            });
        }

        async function saveNews(formData) {
            try {
                formData.append('action', 'save_news');
                const response = await fetch('admin.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                if (result.success) {
                    alert(result.message || 'Berita berhasil disimpan');
                    closeNewsModal();
                    fetchNewsData();
                    return true;
                } else {
                    alert('Error: ' + (result.error || 'Unknown error'));
                    return false;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error saving news: ' + error.message);
                return false;
            }
        }

        async function deleteNewsItem(id) {
            try {
                const formData = new FormData();
                formData.append('action', 'delete_news');
                formData.append('id', id);
                
                const response = await fetch('admin.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                if (result.success) {
                    fetchNewsData();
                    return true;
                } else {
                    alert('Error: ' + result.error);
                    return false;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error deleting news');
                return false;
            }
        }

        // Gallery management functions
        function previewGalleryImages(input) {
            const galleryGrid = document.getElementById('gallery-grid');
            
            if (input.files && input.files.length > 0) {
                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const galleryItem = document.createElement('div');
                        galleryItem.className = 'gallery-item';
                        galleryItem.innerHTML = `
                            <img src="${e.target.result}" alt="Gallery Image">
                            <button type="button" class="remove-btn" onclick="removeGalleryItem(this)" data-index="${index}">×</button>
                        `;
                        galleryGrid.appendChild(galleryItem);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        function removeGalleryItem(button) {
            button.parentElement.remove();
        }

        function loadExistingGallery(galleryImages) {
            const galleryGrid = document.getElementById('gallery-grid');
            galleryGrid.innerHTML = '';
            
            if (galleryImages) {
                const images = galleryImages.split(',').filter(img => img.trim());
                images.forEach((imagePath, index) => {
                    let imgSrc = imagePath.trim();
                    if (imgSrc && !imgSrc.startsWith('http') && !imgSrc.startsWith('/') && !imgSrc.startsWith('data:')) {
                        imgSrc = '/storage/' + imgSrc.replace(/^\/+/, '');
                    }
                    const galleryItem = document.createElement('div');
                    galleryItem.className = 'gallery-item';
                    galleryItem.innerHTML = `
                        <img src="${imgSrc}" alt="Gallery Image">
                        <button type="button" class="remove-btn" onclick="removeExistingGalleryItem(this, '${imagePath.trim()}')" data-path="${imagePath.trim()}">×</button>
                    `;
                    galleryGrid.appendChild(galleryItem);
                });
            }
        }

        function removeExistingGalleryItem(button, imagePath) {
            button.parentElement.remove();
            
            // Update existing gallery hidden field
            const existingGallery = document.getElementById('existing-gallery');
            const currentImages = existingGallery.value.split(',').filter(img => img.trim());
            const updatedImages = currentImages.filter(img => img.trim() !== imagePath);
            existingGallery.value = updatedImages.join(',');
        }

        // Global modal functions
        function openAddModal() {
            editingId = null;
            document.getElementById('modal-title').textContent = 'Tambah Slide Baru';
            document.getElementById('slide-form').reset();
            document.getElementById('slide-id').value = '';
            document.getElementById('existing-image').value = '';
            document.getElementById('image-preview').innerHTML = '';
            document.getElementById('carousel-modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('carousel-modal').style.display = 'none';
        }

        function editSlide(id) {
            const slide = carouselData.find(item => item.id == id);
            if (slide) {
                editingId = id;
                document.getElementById('modal-title').textContent = 'Edit Slide';
                document.getElementById('slide-id').value = slide.id;
                document.getElementById('slide-title').value = slide.title;
                document.getElementById('slide-subtitle').value = slide.subtitle;
                document.getElementById('slide-button').value = slide.button_text;
                document.getElementById('slide-status').value = slide.status;
                document.getElementById('existing-image').value = slide.image_path || '';
                
                const preview = document.getElementById('image-preview');
                if (slide.image_path) {
                    let imgSrc = slide.image_path.trim();
                    if (!imgSrc.startsWith('http') && !imgSrc.startsWith('/') && !imgSrc.startsWith('data:')) {
                        imgSrc = '/storage/' + imgSrc.replace(/^\/+/, '');
                    }
                    preview.innerHTML = `<img src="${imgSrc}" alt="Current image" style="max-width: 200px; max-height: 150px; object-fit: cover; border-radius: 8px;">`;
                } else {
                    preview.innerHTML = '';
                }
                
                document.getElementById('carousel-modal').style.display = 'block';
            }
        }

        function deleteSlide(id) {
            if (confirm('Apakah Anda yakin ingin menghapus slide ini?')) {
                deleteCarouselSlide(id);
            }
        }

        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 150px; object-fit: cover; border-radius: 8px;">`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        async function handleFormSubmit(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const success = await saveCarouselSlide(formData);
            if (success) {
                closeModal();
            }
        }

        // News management functions
        function openAddNewsModal() {
            document.getElementById('news-modal-title').textContent = 'Tambah Berita Baru';
            document.getElementById('news-form').reset();
            document.getElementById('news-id').value = '';
            document.getElementById('news-existing-image').value = '';
            document.getElementById('news-image-preview').innerHTML = '';
            document.getElementById('news-modal').style.display = 'block';
        }

        function closeNewsModal() {
            document.getElementById('news-modal').style.display = 'none';
        }

        function editNews(id) {
            const news = newsData.find(item => item.id == id);
            if (news) {
                document.getElementById('news-modal-title').textContent = 'Edit Berita';
                document.getElementById('news-id').value = news.id;
                document.getElementById('news-title').value = news.title;
                document.getElementById('news-category').value = news.category;
                document.getElementById('news-excerpt').value = news.excerpt || '';
                document.getElementById('news-content').value = news.content;
                document.getElementById('news-author').value = news.author;
                document.getElementById('news-status').value = news.status;
                document.getElementById('news-existing-image').value = news.image_path || '';
                
                const preview = document.getElementById('news-image-preview');
                if (news.image_path) {
                    let imgSrc = news.image_path.trim();
                    if (!imgSrc.startsWith('http') && !imgSrc.startsWith('/') && !imgSrc.startsWith('data:')) {
                        imgSrc = '/storage/' + imgSrc.replace(/^\/+/, '');
                    }
                    preview.innerHTML = `<img src="${imgSrc}" alt="Current image" style="max-width: 200px; max-height: 150px; object-fit: cover; border-radius: 8px;">`;
                } else {
                    preview.innerHTML = '';
                }
                
                // Load existing gallery
                loadExistingGallery(news.gallery_images);
                document.getElementById('existing-gallery').value = news.gallery_images || '';
                
                document.getElementById('news-modal').style.display = 'block';
            }
        }

        function deleteNews(id) {
            if (confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
                deleteNewsItem(id);
            }
        }

        function previewNewsImage(input) {
            const preview = document.getElementById('news-image-preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 150px; object-fit: cover; border-radius: 8px;">`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        async function handleNewsFormSubmit(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            
            // Get current gallery images from the preview
            const galleryItems = document.querySelectorAll('#gallery-grid .gallery-item');
            const existingImages = [];
            galleryItems.forEach(item => {
                const img = item.querySelector('img');
                if (img && img.src.startsWith('http')) {
                    // This is an existing image
                    const path = img.src.replace(window.location.origin + '/', '');
                    existingImages.push(path);
                }
            });
            
            if (existingImages.length > 0) {
                formData.set('existing_gallery', existingImages.join(','));
            }
            
            const success = await saveNews(formData);
        }

        async function fetchNewsData() {
            try {
                const formData = new FormData();
                formData.append('action', 'get_news');
                
                const response = await fetch('admin.php', {
                    method: 'POST',
                    body: formData
                });
                const responseText = await response.text();
                const result = JSON.parse(responseText);
                if (result.success) {
                    newsData = result.data;
                    loadNewsList();
                }
            } catch (error) {
                console.error('Error fetching news:', error);
            }
        }

        function loadNewsList() {
            const listContainer = document.getElementById('news-list');
            listContainer.innerHTML = '';

            if (newsData.length === 0) {
                listContainer.innerHTML = '<p style="text-align: center; color: #666; padding: 2rem;">Belum ada berita. Klik "Tambah Berita Baru" untuk menambahkan berita pertama.</p>';
                return;
            }

            newsData.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.className = 'news-item';
                itemElement.innerHTML = `
                    <div class="news-item-info">
                        <h4>${item.title}</h4>
                        <p>${item.excerpt || item.content.substring(0, 100) + '...'}</p>
                        <div style="margin-top: 0.5rem;">
                            <span class="category-badge">${item.category}</span>
                            <small style="color: #666; margin-left: 1rem;">📅 ${item.created_at}</small>
                            <small style="color: #666; margin-left: 1rem;">✍️ ${item.author}</small>
                        </div>
                    </div>
                    <div class="news-item-actions">
                        <button class="btn btn-primary" onclick="editNews(${item.id})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-danger" onclick="deleteNewsItem(${item.id})">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                `;
                listContainer.appendChild(itemElement);
            });
        }

        async function deleteNews(id) {
            try {
                const formData = new FormData();
                formData.append('action', 'delete_news');
                formData.append('id', id);
                
                const response = await fetch('admin.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                if (result.success) {
                    fetchNewsData();
                    alert('Berita berhasil dihapus');
                } else {
                    alert('Error: ' + result.error);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error deleting news');
            }
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            fetchCarouselData();
            fetchNewsData();
            
            // Menu switching
            document.querySelectorAll('.menu-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all links and sections
                    document.querySelectorAll('.menu-link').forEach(l => l.classList.remove('active'));
                    document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
                    
                    // Add active class to clicked link
                    this.classList.add('active');
                    
                    // Show corresponding section
                    const section = this.getAttribute('data-section');
                    if (section) {
                        document.getElementById(section + '-section').classList.add('active');
                        
                        // Load data for the section
                        if (section === 'news') {
                            fetchNewsData();
                        }
                    }
                });
            });
        });

        window.addEventListener('click', function(e) {
            const carouselModal = document.getElementById('carousel-modal');
            const newsModal = document.getElementById('news-modal');
            if (e.target === carouselModal) {
                closeModal();
            }
            if (e.target === newsModal) {
                closeNewsModal();
            }
        });
    </script>
</body>
</html>
