<?php
    $carouselData = isset($carouselData) ? $carouselData : (isset($carousel) ? $carousel : []);
    $newsData = isset($newsData) ? $newsData : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LP3I Karawang - Politeknik LP3I Kampus Karawang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* CSS DASAR DARI KODE ASLI KAMU */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; line-height: 1.6; color: #333; }

        /* --- MODIFIKASI HEADER 3 LAYER (PERMINTAAN DOSEN) --- */
        header { width: 100%; z-index: 1200; position: fixed; top: 0; left: 0; right: 0; }
        body { padding-top: 190px; }
        @media (max-width: 768px) { body { padding-top: 210px; } }

        /* Site header (assistant navbar) - minimal rules to preserve your layout but keep assistant look */
        .site-header { width: 100%; position: relative; z-index: 1100; }
        .site-header .topbar { background: #ff7a18; color: white; padding: 6px 0; font-size: 0.9rem; font-weight: 600; }
        .site-header .topbar .container { max-width: 1400px; margin: 0 auto; padding: 0 2rem; display:flex; justify-content:space-between; align-items:center; }

        /* Ensure standalone .topbar (used in this view) is styled consistently */
        .topbar { background: #009da5; color: white; padding: 6px 0; font-size: 0.95rem; font-weight: 600; }
        .topbar .container { max-width: 1400px; margin: 0 auto; padding: 0 2rem; display:flex; justify-content:space-between; align-items:center; gap:1rem; }
        .topbar-left, .topbar-right { display:flex; align-items:center; gap:1rem; }
        .topbar a { color: white; text-decoration: none; display:inline-flex; align-items:center; gap:0.5rem; padding:4px 8px; border-radius:6px; }
        .topbar a:hover { background: rgba(255,255,255,0.08); }
        .topbar a i { font-size:0.95rem; }
        @media (max-width: 768px) {
            .topbar .container { flex-direction: column; align-items: flex-start; gap:8px; }
            .topbar-right { justify-content: flex-start; }
        }
        .site-header .brandbar { background: #213C72; color: white; padding: 12px 0; }
        .site-header .brandbar .container { max-width: 1400px; margin: 0 auto; padding: 0 2rem; display:flex; justify-content:space-between; align-items:center; }
        .site-header .brandbar .logo img { max-height: 55px; }
        .site-header .menubar { background: #ffffff; border-bottom: 1px solid #eee; }
        .site-header .menubar .nav-container { max-width: 1400px; margin: 0 auto; padding: 0 1.5rem; display:flex; justify-content:space-between; align-items:center; }
        .site-header .menubar .nav-links { display:flex; gap:0; list-style:none; align-items:center; }
        .site-header .menubar .nav-links a { color:#213C72; text-decoration:none; padding:1rem 1.2rem; font-weight:600; }
        .site-header .menubar .nav-links a:hover { color:#0b2a59; background:#f6f8fb; }
        .site-header .menubar .dropdown-content { background:#ffffff; border:1px solid #eee; box-shadow:0 8px 22px rgba(0,0,0,0.06); }

        /* keep your dropdown item appearance when inside assistant menubar */
        .site-header .menubar .dropdown-content a { color:#213C72 !important; }

        /* Layer 1: Top Bar (legacy names kept for compatibility) */
        .top-bar { background: #00a8e8; padding: 6px 0; color: white; font-size: 0.8rem; font-weight: 500; }
        .top-bar .container { display: flex; justify-content: flex-end; gap: 20px; max-width: 1400px; margin: 0 auto; padding: 0 2rem; }
        .top-bar a { color: white; text-decoration: none; }

        /* Layer 2: Mid Header (Logo & Kontak) */
        .mid-header { background: #1e3c72; padding: 15px 0; color: white; }
        .mid-header .container { display: flex; justify-content: space-between; align-items: center; max-width: 1400px; margin: 0 auto; padding: 0 2rem; }
        .logo img { max-height: 55px; width: auto; object-fit: contain; }
        .header-contact { display: flex; gap: 30px; }
        .contact-item { display: flex; align-items: center; gap: 10px; }
        .contact-item i { font-size: 1.9rem; color: #00a8e8; }
        .contact-text strong { display: block; font-size: 0.85rem; margin-bottom: 2px; }
        .contact-text span { font-size: 0.75rem; opacity: 0.8; display: block; }

        /* Layer 3: Nav Utama (Putih & Sticky saat scroll) */
        nav { 
            background: white; 
            border-bottom: 1px solid #eee; 
            position: relative; 
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            z-index: 1200;
        }
        nav.scrolled { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
        .nav-container { display: flex; justify-content: space-between; align-items: center; max-width: 1400px; margin: 0 auto; padding: 0 1.5rem; position: relative; }
        .nav-menu { display: flex; align-items: center; gap: 12px; }
        .nav-toggle { display: none; border: 0; background: transparent; padding: 10px; cursor: pointer; align-items: center; gap: 10px; }
        .nav-toggle .bar { display: block; width: 22px; height: 2px; background: #1e3c72; margin: 4px 0; border-radius: 2px; transition: transform 0.2s ease; }
        .nav-toggle-label { font-size: 0.9rem; font-weight: 700; color: #1e3c72; letter-spacing: 0.3px; }

        /* Mempertahankan style Nav-Links kamu */
        .nav-links { display: flex; list-style: none; align-items: center; }
        .nav-links a { 
            color: #333; 
            text-decoration: none; 
            padding: 1rem 1.2rem; 
            display: block; 
            font-size: 0.9rem; 
            font-weight: 600; 
            position: relative;
            transition: color 0.3s ease;
        }
        .nav-links a:hover { 
            color: #1e3c72; 
            background: transparent;
        }
        .nav-links a:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #009da5, #1e3c72);
            transform: translateX(-50%);
            transition: width 0.3s ease;
        }
        .nav-links a:hover:after {
            width: 70%;
        }

        /* Mempertahankan Dropdown & Item Akademik (AK|MI) kamu */
        .dropdown { position: relative; }
        .dropdown-content {
            position: absolute; top: 100%; left: 50%; transform: translateX(-50%);
            background: linear-gradient(135deg, #043158 0%, #1a5a6f 100%); 
            min-width: 240px; 
            display: none; 
            z-index: 1000;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            animation: dropdownSlide 0.3s ease;
        }
        @keyframes dropdownSlide {
            from { opacity: 0; transform: translateX(-50%) translateY(-10px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }
        .dropdown:hover .dropdown-content { display: block; }
        .dropdown-content a { 
            color: white !important; 
            font-size: 0.85rem; 
            padding: 12px 20px; 
            border-bottom: 1px solid rgba(255,255,255,0.08);
            transition: all 0.25s ease;
            display: block;
        }
        .dropdown-content a:last-child { border-bottom: none; }
        .dropdown-content a:hover { 
            background: rgba(255,255,255,0.1);
            padding-left: 24px;
        }
        .dropdown-content a.akademik-item { display: flex; gap: 12px; flex-direction: column; }
        .dropdown-content a.akademik-item .ak-prefix { color: #fff; font-weight: 700; font-size: 0.8rem; }
        .dropdown-content a.akademik-item .ak-prefix:first-child { color: #00d4ff; font-weight: 800; letter-spacing: 0.5px; }
        .dropdown-content a.akademik-item .ak-prefix:last-child { color: #b0e0e6; font-size: 0.75rem; font-weight: 500; }

        /* Mempertahankan style Button & Animasi Pulse kamu */
        .register-btn {
            background: #004269 !important; color: white !important; padding: 0.6rem 1.2rem !important;
            border-radius: 20px !important; font-weight: 600 !important; font-size: 0.9rem !important;
            animation: registerPulse 2s ease-in-out infinite; text-decoration: none;
        }
        .login-btn {
            background: transparent !important; color: #1e3c72 !important; padding: 0.55rem 1rem !important;
            border-radius: 18px !important; font-weight: 600 !important; border: 1px solid #1e3c72 !important;
            margin-right: 10px; text-decoration: none;
        }
        @keyframes registerPulse {
            0%, 100% { box-shadow: 0 4px 15px rgba(0, 66, 105, 0.3); }
            50% { box-shadow: 0 6px 25px rgba(0, 66, 105, 0.6); }
        }

        /* --- SEMUA CSS CONTENT (HERO, NEWS, ABOUT, DLL) DARI KODE ASLI KAMU --- */
        .hero { min-height: 80vh; position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; color: white; }
        .carousel-container { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; }
        .carousel-slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1s; background-size: cover; background-position: center; }
        .carousel-slide.active { opacity: 1; }
        .hero-content { position: relative; z-index: 2; text-align: center; max-width: 900px; padding: 20px; }
            .hero-content h1 { font-size: 3rem; font-weight: 800; text-shadow: 0 4px 15px rgba(0,0,0,0.5); }        

            /* Alasan Pilih LP3I section */
            .reasons { padding: 4rem 2rem; background: #f5f8fb; }
            .reasons .container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
            .reasons .section-title { color: #1e3c72; font-size: 1.5rem; font-weight: 700; }
            .reasons-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-top: 1.5rem; }
            .reason-card { background: #fff; border-radius: 12px; padding: 1.25rem; text-align: center; box-shadow: 0 6px 18px rgba(16,24,40,0.06); }
            .reason-card i { font-size: 2rem; color: #1e3c72; margin-bottom: 0.5rem; }
            .reason-card h4 { margin: 0.35rem 0; font-size: 1rem; color: #213C72; }
            .reason-card p { font-size: 0.95rem; color: #556; opacity: 0.95; }

            @media (max-width: 992px) {
                .reasons-grid { grid-template-columns: repeat(2, 1fr); }
            }
            @media (max-width: 576px) {
                .reasons-grid { grid-template-columns: 1fr; }
            }

            /* Partners / Kerjasama Perusahaan */
            .partners { padding: 3.5rem 2rem; background: #ffffff; }
            .partners .container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
            .partners .heading { display:flex; align-items:center; gap:12px; margin-bottom:1rem; }
            .partners .heading .accent { width:6px; height:36px; background:#ff7a18; border-radius:4px; }
            .partners h2 { margin:0; color:#1e3c72; font-size:1.6rem; font-weight:700; }
            .partners p.lead { color:#6b7280; margin-bottom:1.5rem; }
            .partners-grid { display:grid; grid-template-columns: repeat(6, 1fr); gap:1.5rem; align-items:center; }
            .partner-item { display:flex; align-items:center; justify-content:center; padding:12px; background:transparent; }
            .partner-item img { max-width:100%; max-height:56px; opacity:0.95; filter:grayscale(0%); transition: transform .18s ease, opacity .18s ease; }
            .partner-item:hover img { transform: translateY(-6px); opacity:1; }

            /* Single wide partner image (responsive/cropped) */
            .partners-hero { width:100%; overflow:hidden; border-radius:12px; margin-top:1rem; }
            .partners-hero img { width:100%; height:360px; object-fit:cover; display:block; }
            @media (max-width: 768px) { .partners-hero img { height:180px; } }

            @media (max-width: 1100px) { .partners-grid { grid-template-columns: repeat(4, 1fr); } }
            @media (max-width: 768px) { .partners-grid { grid-template-columns: repeat(2, 1fr); } .partner-item img { max-height:48px; } }
            @media (max-width: 420px) { .partners-grid { grid-template-columns: 1fr; } }
            
            /* Promo video styles merged into reasons */
            .reasons .video-block { padding-top: 1.5rem; }
            .reasons .video-wrapper { width: 100%; max-width: 1200px; margin: 0.75rem auto 0 auto; position: relative; padding-top: 56.25%; }
            .reasons .video-wrapper video, .reasons .video-wrapper iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border-radius: 12px; box-shadow: 0 12px 34px rgba(16,24,40,0.08); }
            .reasons .video-caption { text-align: center; margin-top: 0.75rem; color: #556; font-size: 0.95rem; }

            @media (max-width: 768px) {
                .reasons .video-wrapper { padding-top: 56.25%; }
            }
        .cta-button {
            display: inline-block;
            background: #1e3c72;
            color: #fff;
            padding: 0.75rem 1.25rem;
            border-radius: 28px;
            font-weight: 700;
            text-decoration: none;
            margin-top: 1rem;
            box-shadow: 0 6px 18px rgba(30,60,114,0.18);
            transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;
        }
        .cta-button:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(30,60,114,0.28); opacity: 0.98; }
        @media (max-width: 768px) {
            .cta-button { padding: 0.6rem 1rem; font-size: 0.95rem; }
        }

        .news { padding: 5rem 2rem; background: #f8f9fa; }
        .news .container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
        .news .section-title { color: #1e3c72; font-size: 1.5rem; font-weight: 700; }
        .news-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-top: 3rem; }
        .news-card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); opacity: 0; transform: translateY(30px); transition: 0.3s; display: block; text-decoration: none; color: inherit; }
        .news-card.animate { opacity: 1; transform: translateY(0); transition: 0.8s ease-out; }
        .news-image { width: 100%; height: 200px; object-fit: cover; }
        .news-content { padding: 1.5rem; }

        .see-all-btn { display: inline-block; background: #1e3c72; color: #fff; padding: 0.6rem 1.1rem; border-radius: 18px; text-decoration: none; font-weight:700; box-shadow: 0 8px 20px rgba(30,60,114,0.12); }
        .see-all-btn:hover { opacity: 0.95; transform: translateY(-2px); }

        @media (max-width: 900px) {
            nav { border-top: 1px solid #e6e9ef; }
            .nav-container { min-height: 56px; }
            .nav-toggle { display: inline-flex; align-items: center; justify-content: center; }
            .nav-toggle { margin-left: auto; }
            .nav-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #ffffff;
                border-bottom: 1px solid #eee;
                box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
                padding: 0.75rem 1rem 1rem;
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
                z-index: 1200;
            }
            nav.nav-open .nav-menu { display: flex; }
            .nav-links { flex-direction: column; align-items: stretch; width: 100%; }
            .nav-links a { padding: 0.85rem 0.75rem; font-size: 0.9rem; border-radius: 8px; }
            .nav-links a:hover { background: #f4f7fb; }
            .nav-auth { width: 100%; justify-content: flex-start; flex-wrap: wrap; }
            .login-btn, .register-btn { padding: 0.55rem 0.9rem !important; font-size: 0.85rem !important; }
            .dropdown-content {
                position: static;
                transform: none;
                min-width: 0;
                box-shadow: none;
                background: #f6f8fb;
                border-radius: 10px;
                margin: 6px 0 0;
            }
            .dropdown-content a { color: #1e3c72 !important; padding: 10px 14px; }
            .dropdown:hover .dropdown-content { display: none; }
            .dropdown.open > .dropdown-content { display: block; }
        }

        @media (max-width: 768px) {
            .top-bar, .header-contact { display: none; }
            .news-grid { grid-template-columns: 1fr; }
            .hero-content h1 { font-size: 2rem; }
        }

        /* Footer */
        .site-footer { background: #1e3c72; color: #ffffff; padding: 2.5rem 2rem 1rem; }
        .site-footer .container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
        .site-footer .footer-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 2rem; align-items: start; }
        .site-footer .footer-title { font-size: 1.05rem; font-weight: 800; letter-spacing: 0.2px; margin-bottom: 0.75rem; }
        .site-footer .footer-text { color: rgba(255,255,255,0.9); font-size: 0.95rem; line-height: 1.7; }
        .site-footer .footer-contact { display: grid; gap: 0.5rem; }
        .site-footer .footer-contact a,
        .site-footer .footer-contact .footer-item { color: rgba(255,255,255,0.92); text-decoration: none; display: inline-flex; align-items: flex-start; gap: 0.6rem; font-size: 0.95rem; line-height: 1.5; }
        .site-footer .footer-contact a:hover { color: #ffffff; text-decoration: underline; }
        .site-footer .footer-contact i { margin-top: 2px; width: 18px; text-align: center; opacity: 0.95; }
        .site-footer .footer-bottom { border-top: 1px solid rgba(255,255,255,0.16); margin-top: 1.75rem; padding-top: 1rem; display: flex; justify-content: space-between; gap: 0.75rem; flex-wrap: wrap; font-size: 0.9rem; color: rgba(255,255,255,0.85); }
        @media (max-width: 768px) {
            .site-footer { padding: 2.25rem 1.25rem 1rem; }
            .site-footer .container { padding: 0 1rem; }
            .site-footer .footer-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<section class="hero">
    <div class="carousel-container">
        <?php $__currentLoopData = $carouselData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <div class="carousel-slide <?php echo e($index == 0 ? 'active' : ''); ?>" 
               style="background-image: url('<?php echo e(asset(isset($item['image']) && $item['image'] ? $item['image'] : 'storage/image/default-hero.jpg')); ?>')">
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="hero-content">
        <h1>Masa Depan Cerah Dimulai Dari Sini</h1>
        <p>Kuliah Cepat Kerja di Politeknik LP3I Kampus Karawang</p>
        
    </div>
</section>

<section class="reasons" id="alasan">
    <div class="container">
        <h2 class="section-title">Mengapa Memilih LP3I Karawang?</h2>
        <div class="reasons-grid">
            <div class="reason-card">
                <i class="fas fa-rocket"></i>
                <h4>Kuliah Bisa Cepat Kerja</h4>
                <p>Memiliki kerjasama dengan perusahaan serta memiliki kurikulum yang sesuai dengan kebutuhan dunia kerja.</p>
            </div>
            <div class="reason-card">
                <i class="fas fa-award"></i>
                <h4>Sertifikasi Kompetensi</h4>
                <p>Mahasiswa Politeknik LP3I memiliki 4 sertifikasi kompetensi dari Badan Nasional Sertifikasi Profesi (BNSP) dan International Test Center</p>
            </div>
            <div class="reason-card">
                <i class="fas fa-chalkboard-teacher"></i>
                <h4>Dosen Profesional</h4>
                <p>Dosen Politeknik LP3I memiliki sertifikasi dosen dari 
                    Kemendikbud dan Dosen praktisi yang berpengalaman di bidang industri.</p>
            </div>
            <div class="reason-card">
                <i class="fas fa-briefcase"></i>
                <h4>Pusat Karir &amp; Magang</h4>
                <p>Mahasiswa mengikuti proses kuliah kerja industri dan penempatan kerja di industri dan dunia kerja</p>
            </div>
        </div>
    <!-- ═══════════════════════════════════════════════════════════════
         🎯 KEGIATAN SHOWCASE — Glide.js-Inspired Slider Carousel
         Fetches data dynamically from /carousel-kegiatan endpoint
         ═══════════════════════════════════════════════════════════════ -->
    <style>
    /* ── Glide-style Kegiatan Carousel ── */
    .glide-kegiatan { position: relative; padding: 3rem 0 2rem; background: #f8f9fc; overflow: hidden; }
    .glide-kegiatan .gk-header { text-align: center; margin-bottom: 2.2rem; }
    .glide-kegiatan .gk-label {
        display: inline-flex; align-items: center; gap: 6px;
        background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff;
        font-size: .7rem; font-weight: 700; padding: 5px 14px; border-radius: 99px;
        text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: .6rem;
    }
    .glide-kegiatan .gk-label i { font-size: .65rem; }
    .glide-kegiatan .gk-title {
        font-size: 2rem; font-weight: 800; color: #1e3c72; margin: 0; line-height: 1.25;
    }
    .glide-kegiatan .gk-subtitle {
        color: #64748b; font-size: .95rem; margin-top: .35rem; font-weight: 400;
    }

    /* ── Track / Viewport ── */
    .gk-viewport { overflow: hidden; margin: 0 auto; max-width: 1200px; position: relative; }
    .gk-track {
        display: flex; transition: transform .45s cubic-bezier(.25,.8,.25,1); will-change: transform;
        gap: 24px; /* gap between cards */
    }

    /* ── Slide card ── */
    .gk-slide {
        flex: 0 0 calc(33.333% - 16px); /* 3 visible */
        border-radius: 16px; overflow: hidden; position: relative;
        background: #fff; box-shadow: 0 4px 24px rgba(30,60,114,.08);
        transition: transform .35s ease, box-shadow .35s ease, opacity .35s ease;
        cursor: grab; user-select: none; opacity: .55; transform: scale(.92);
    }
    .gk-slide.is-active {
        opacity: 1; transform: scale(1);
        box-shadow: 0 12px 40px rgba(30,60,114,.15);
    }
    .gk-slide:hover { box-shadow: 0 16px 48px rgba(30,60,114,.18); }
    .gk-slide img {
        width: 100%; height: 260px; object-fit: cover; display: block;
        transition: transform .4s ease;
    }
    .gk-slide:hover img { transform: scale(1.04); }
    .gk-slide-caption {
        padding: 1rem 1.2rem 1.2rem; background: #fff;
    }
    .gk-slide-caption h3 {
        font-size: 1rem; font-weight: 700; color: #1e293b; margin: 0 0 .25rem;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .gk-slide-caption .gk-slide-tag {
        display: inline-block; font-size: .7rem; font-weight: 600;
        color: #fff; background: linear-gradient(135deg, #1e3c72, #2a5298);
        padding: 2px 10px; border-radius: 99px; text-transform: uppercase; letter-spacing: .5px;
    }

    /* ── Arrows ── */
    .gk-arrow {
        position: absolute; top: 50%; z-index: 10; width: 48px; height: 48px;
        border-radius: 50%; border: none; cursor: pointer;
        background: #fff; color: #1e3c72; font-size: 1.1rem;
        box-shadow: 0 4px 16px rgba(30,60,114,.12);
        display: flex; align-items: center; justify-content: center;
        transition: all .25s ease; transform: translateY(-50%);
    }
    .gk-arrow:hover { background: #1e3c72; color: #fff; box-shadow: 0 8px 24px rgba(30,60,114,.2); transform: translateY(-50%) scale(1.08); }
    .gk-arrow:active { transform: translateY(-50%) scale(.96); }
    .gk-arrow.prev { left: max(1rem, calc((100% - 1200px)/2 - 60px)); }
    .gk-arrow.next { right: max(1rem, calc((100% - 1200px)/2 - 60px)); }
    .gk-arrow:disabled { opacity: .3; cursor: default; pointer-events: none; }

    /* ── Bullet dots ── */
    .gk-dots { display: flex; justify-content: center; gap: 8px; margin-top: 2rem; }
    .gk-dot {
        width: 10px; height: 10px; border-radius: 50%; border: none; padding: 0;
        background: #cbd5e1; cursor: pointer; transition: all .3s ease;
    }
    .gk-dot.active {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        width: 28px; border-radius: 99px;
    }
    .gk-dot:hover { background: #94a3b8; }
    .gk-dot.active:hover { background: linear-gradient(135deg, #1e3c72, #2a5298); }

    /* ── Empty state ── */
    .gk-empty { text-align: center; padding: 4rem 2rem; color: #94a3b8; font-size: 1rem; }
    .gk-empty i { font-size: 2.5rem; margin-bottom: .6rem; display: block; opacity: .5; }

    /* ── Responsive ── */
    @media (max-width: 1024px) {
        .gk-slide { flex: 0 0 calc(50% - 12px); }
    }
    @media (max-width: 640px) {
        .glide-kegiatan { padding: 2rem 0 1.5rem; }
        .gk-slide { flex: 0 0 calc(85%); }
        .gk-slide img { height: 200px; }
        .gk-arrow { width: 40px; height: 40px; font-size: .95rem; }
        .gk-arrow.prev { left: .5rem; }
        .gk-arrow.next { right: .5rem; }
        .glide-kegiatan .gk-title { font-size: 1.4rem; }
        .gk-track { gap: 14px; }
    }
    </style>

    <div class="glide-kegiatan" id="kegiatan-showcase">
        <div class="gk-header">
            <div class="gk-label"><i class="fas fa-camera"></i> Galeri Kegiatan</div>
            <h2 class="gk-title">Momen Seru di LP3I Karawang</h2>
            <p class="gk-subtitle">Kegiatan, prestasi, dan suasana kampus yang menginspirasi</p>
        </div>

        <div class="gk-viewport" id="gk-viewport">
            <div class="gk-track" id="gk-track">
                <div class="gk-empty" id="gk-empty"><i class="fas fa-images"></i>Memuat kegiatan…</div>
            </div>
        </div>

        <button class="gk-arrow prev" id="gk-prev" style="display:none" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
        <button class="gk-arrow next" id="gk-next" style="display:none" aria-label="Next"><i class="fas fa-chevron-right"></i></button>

        <div class="gk-dots" id="gk-dots"></div>
    </div>

    <script>
    (function(){
        /* ── Config ── */
        const AUTOPLAY   = 4500;
        const PEEK       = 0;        /* no extra peek – gap handles spacing */
        const track      = document.getElementById('gk-track');
        const viewport   = document.getElementById('gk-viewport');
        const dotsWrap   = document.getElementById('gk-dots');
        const emptyEl    = document.getElementById('gk-empty');
        const prevBtn    = document.getElementById('gk-prev');
        const nextBtn    = document.getElementById('gk-next');

        let items = [], dots = [], idx = 0, perView = 3, timer = null, dragging = false, startX = 0, startLeft = 0;

        /* ── Helpers ── */
        function getPerView(){
            const w = window.innerWidth;
            if (w <= 640) return 1;
            if (w <= 1024) return 2;
            return 3;
        }

        function slideWidth(){
            if (!items.length) return 0;
            return items[0].offsetWidth + parseFloat(getComputedStyle(track).gap || 24);
        }

        function maxIdx(){ return Math.max(0, items.length - perView); }

        function moveTo(i, smooth = true){
            idx = Math.max(0, Math.min(i, maxIdx()));
            track.style.transition = smooth ? 'transform .45s cubic-bezier(.25,.8,.25,1)' : 'none';
            track.style.transform = `translateX(-${idx * slideWidth()}px)`;
            updateActive();
            updateDots();
            updateArrows();
        }

        function updateActive(){
            items.forEach((el, i) => {
                el.classList.toggle('is-active', i >= idx && i < idx + perView);
            });
        }

        function updateArrows(){
            prevBtn.disabled = idx <= 0;
            nextBtn.disabled = idx >= maxIdx();
        }

        /* ── Dots ── */
        function buildDots(){
            dotsWrap.innerHTML = '';
            dots = [];
            const total = maxIdx() + 1;
            for (let i = 0; i < total; i++){
                const d = document.createElement('button');
                d.className = 'gk-dot' + (i === 0 ? ' active' : '');
                d.setAttribute('aria-label', `Slide group ${i + 1}`);
                d.addEventListener('click', () => { moveTo(i); resetAuto(); });
                dotsWrap.appendChild(d);
                dots.push(d);
            }
        }
        function updateDots(){
            dots.forEach((d, i) => d.classList.toggle('active', i === idx));
        }

        /* ── Build slides ── */
        function build(data){
            const active = data.filter(d => d.status === 'active' && d.image_path);
            if (!active.length){ emptyEl.innerHTML = '<i class="fas fa-images"></i>Belum ada kegiatan.'; return; }
            emptyEl.style.display = 'none';
            track.innerHTML = '';

            active.forEach(item => {
                const card = document.createElement('div');
                card.className = 'gk-slide is-active';
                card.innerHTML = `
                    <img src="/${item.image_path}" alt="${item.title || 'Kegiatan'}" loading="lazy" draggable="false">
                    <div class="gk-slide-caption">
                        <h3>${item.title || 'Kegiatan'}</h3>
                        <span class="gk-slide-tag">Kegiatan</span>
                    </div>`;
                track.appendChild(card);
                items.push(card);
            });

            perView = getPerView();
            prevBtn.style.display = '';
            nextBtn.style.display = '';
            buildDots();
            moveTo(0, false);
            startAuto();
        }

        /* ── Autoplay ── */
        function startAuto(){
            stopAuto();
            timer = setInterval(() => {
                if (idx >= maxIdx()) moveTo(0);
                else moveTo(idx + 1);
            }, AUTOPLAY);
        }
        function stopAuto(){ clearInterval(timer); }
        function resetAuto(){ stopAuto(); startAuto(); }

        /* ── Events ── */
        prevBtn.addEventListener('click', () => { moveTo(idx - 1); resetAuto(); });
        nextBtn.addEventListener('click', () => { moveTo(idx + 1); resetAuto(); });

        /* Drag / swipe */
        function pointerDown(x){ dragging = true; startX = x; startLeft = idx * slideWidth(); track.style.transition = 'none'; track.style.cursor = 'grabbing'; }
        function pointerMove(x){ if (!dragging) return; const dx = x - startX; track.style.transform = `translateX(${-startLeft + dx}px)`; }
        function pointerUp(x){
            if (!dragging) return; dragging = false; track.style.cursor = '';
            const dx = x - startX;
            if (Math.abs(dx) > 50) { dx < 0 ? moveTo(idx + 1) : moveTo(idx - 1); }
            else moveTo(idx);
            resetAuto();
        }
        track.addEventListener('mousedown',  e => { e.preventDefault(); pointerDown(e.clientX); });
        window.addEventListener('mousemove', e => pointerMove(e.clientX));
        window.addEventListener('mouseup',   e => pointerUp(e.clientX));
        track.addEventListener('touchstart', e => pointerDown(e.touches[0].clientX), { passive: true });
        track.addEventListener('touchmove',  e => pointerMove(e.touches[0].clientX), { passive: true });
        track.addEventListener('touchend',   e => pointerUp(e.changedTouches[0].clientX), { passive: true });

        /* Keyboard */
        document.addEventListener('keydown', e => {
            const rect = viewport.getBoundingClientRect();
            if (rect.bottom < 0 || rect.top > window.innerHeight) return;
            if (e.key === 'ArrowLeft') { moveTo(idx - 1); resetAuto(); }
            if (e.key === 'ArrowRight'){ moveTo(idx + 1); resetAuto(); }
        });

        /* Pause on hover */
        const root = document.getElementById('kegiatan-showcase');
        root.addEventListener('mouseenter', stopAuto);
        root.addEventListener('mouseleave', () => { if (items.length) startAuto(); });

        /* Resize */
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => { perView = getPerView(); buildDots(); moveTo(idx, false); }, 150);
        });

        /* ── Fetch ── */
        fetch('/carousel-kegiatan')
            .then(r => r.json())
            .then(j => { if (j.success) build(j.data); else emptyEl.innerHTML = '<i class="fas fa-images"></i>Gagal memuat.'; })
            .catch(() => { emptyEl.innerHTML = '<i class="fas fa-images"></i>Gagal memuat kegiatan.'; });
    })();
    </script>
    <!-- ═══ END Kegiatan Showcase ═══ -->
        <div class="video-block">
            <div class="video-wrapper">
                <iframe src="https://www.youtube.com/embed/2dmy9PbQpz0" title="Video profil LP3I Karawang" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div class="video-caption">Tonton video profil singkat LP3I Karawang.</div>
        </div>
    </div>
</section>
<!-- Kerjasama Perusahaan -->
<section class="partners" id="partners">
    <div class="container">
        <div class="heading">
            <div class="accent"></div>
            <h2>Mitra Perusahaan<br>
            Menerima Lulusan Kami!</h2>
        </div>
        <p class="lead">Politeknik LP3I telah melakukan kerjasama untuk pelaksanaan Tri Darma Perguruan Tinggi dengan Dunia Usaha dan Dunia Industri (DUDI) baik dari perusahaan swasta dan pemerintah dengan level wilayah Provinsi, Nasional dan Internasional.</p>

            <div class="partners-hero">
                
                <img src="<?php echo e(asset('storage/image/apiliasi.png')); ?>" alt="Kerjasama Perusahaan">
            </div>
    </div>
</section>

<section class="news">
    <div class="container">
        <h2 class="section-title">Berita Terkini</h2>
        <div class="news-grid">
            <?php $__currentLoopData = $newsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $newsImage = null;
                    // prefer explicit image path
                    if (!empty($news['image']) && file_exists(public_path($news['image']))) {
                        $newsImage = asset($news['image']);
                    } elseif (!empty($news['image']) && file_exists(public_path('storage/' . ltrim($news['image'], '/')))) {
                        $newsImage = asset('storage/' . ltrim($news['image'], '/'));
                    } elseif (!empty($news['image_path']) && file_exists(public_path($news['image_path']))) {
                        $newsImage = asset($news['image_path']);
                    } elseif (!empty($news['image_path']) && file_exists(public_path('storage/' . ltrim($news['image_path'], '/')))) {
                        $newsImage = asset('storage/' . ltrim($news['image_path'], '/'));
                    }
                    // fallback to an existing image in public/storage/image
                    if (!$newsImage) {
                        $newsImage = asset('storage/image/landingPage1.png');
                    }
                
                    $newsUrl = $news['link'] ?? (isset($news['slug']) ? url('/news/' . $news['slug']) : (isset($news['id']) ? url('/news/' . $news['id']) : '#'));
                ?>

                <a href="<?php echo e($newsUrl); ?>" class="news-card" aria-label="<?php echo e($news['title'] ?? 'Berita'); ?>">
                    <img src="<?php echo e($newsImage); ?>" class="news-image" alt="<?php echo e($news['title'] ?? 'Berita'); ?>">
                    <div class="news-content">
                    <span class="news-category"><?php echo e($news['category'] ?? ''); ?></span>
                    <h3><?php echo e($news['title'] ?? ''); ?></h3>
                    <p class="news-excerpt"><?php echo e(Str::limit($news['excerpt'] ?? '', 100)); ?></p>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div style="text-align:center; margin-top:1.75rem;">
            <a href="<?php echo e(url('/news')); ?>" class="see-all-btn">Lihat Semua Berita </a>
        </div>
    </div>
</section>

    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
    // Animasi Scroll Header
    window.addEventListener('scroll', function() {
        const nav = document.getElementById('mainNav');
        if (window.scrollY > 60) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });

    // Carousel Logic
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-slide');
    function nextSlide() {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }
    setInterval(nextSlide, 5000);

    // Animasi muncul saat scroll (Intersection Observer)
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            }
        });
    });
    document.querySelectorAll('.news-card').forEach((card) => observer.observe(card));
</script>
</body>
</html><?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/index.blade.php ENDPATH**/ ?>