@php
    $carouselData = isset($carouselData) ? $carouselData : (isset($carousel) ? $carousel : []);
    $newsData = isset($newsData) ? $newsData : [];
@endphp
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
        header { width: 100%; z-index: 1000; position: relative; }

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
        .contact-text strong { display: block; font-size: 0.85rem; }
        .contact-text span { font-size: 0.75rem; opacity: 0.8; }

        /* Layer 3: Nav Utama (Putih & Sticky saat scroll) */
        nav { 
            background: white; 
            border-bottom: 1px solid #eee; 
            position: sticky; 
            top: 0; 
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        nav.scrolled { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
        .nav-container { display: flex; justify-content: space-between; align-items: center; max-width: 1400px; margin: 0 auto; padding: 0 1.5rem; }

        /* Mempertahankan style Nav-Links kamu */
        .nav-links { display: flex; list-style: none; align-items: center; }
        .nav-links a { 
            color: #333; 
            text-decoration: none; 
            padding: 1rem 1.2rem; 
            display: block; 
            font-size: 0.9rem; 
            font-weight: 600; 
        }
        .nav-links a:hover { color: #1e3c72; background: #f8f9fa; }

        /* Mempertahankan Dropdown & Item Akademik (AK|MI) kamu */
        .dropdown { position: relative; }
        .dropdown-content {
            position: absolute; top: 100%; left: 50%; transform: translateX(-50%);
            background: #043158; min-width: 220px; display: none; z-index: 1000;
        }
        .dropdown:hover .dropdown-content { display: block; }
        .dropdown-content a { color: white !important; font-size: 0.85rem; padding: 10px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .dropdown-content a.akademik-item { display: flex; gap: 8px; }
        .dropdown-content a.akademik-item .ak-prefix { color: #fff; font-weight: 700; }
        .dropdown-content a.akademik-item .ak-text { color: #e63946; font-weight: 600; }

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
            .reasons .video-wrapper { width: 100%; max-width: 980px; margin: 0.75rem auto 0 auto; position: relative; padding-top: 56.25%; }
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
        .news-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-top: 3rem; }
        .news-card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); opacity: 0; transform: translateY(30px); transition: 0.3s; display: block; text-decoration: none; color: inherit; }
        .news-card.animate { opacity: 1; transform: translateY(0); transition: 0.8s ease-out; }
        .news-image { width: 100%; height: 200px; object-fit: cover; }
        .news-content { padding: 1.5rem; }

        .see-all-btn { display: inline-block; background: #1e3c72; color: #fff; padding: 0.6rem 1.1rem; border-radius: 18px; text-decoration: none; font-weight:700; box-shadow: 0 8px 20px rgba(30,60,114,0.12); }
        .see-all-btn:hover { opacity: 0.95; transform: translateY(-2px); }

        @media (max-width: 768px) {
            .top-bar, .header-contact { display: none; }
            .news-grid { grid-template-columns: 1fr; }
            .hero-content h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>

<header>
    <!-- legacy top-bar removed; using assistant topbar below -->
        <div class="topbar">
            <div class="container">
                <div class="topbar-left"><a href="{{ route('virtual') }}"> Virtual</a></div>
                <div class="topbar-right">
                    <a href="{{ route('student') }}">E | Student</a>
                    <a href="{{ route('akademik') }}">E | Akademik</a>
                    <a href="{{ route('lecture') }}">E | Lecture</a>
                </div>
            </div>
        </div>

    <div class="mid-header">
        <div class="container">
            <div class="logo">
                
                <img src="{{ asset('storage/image/LOGO_LP3I.png') }}" alt="LP3I Karawang">
                <img src="{{ asset('storage/image/global.png') }}" alt="Global">
            </div>
            <div class="header-contact">
                <div class="contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <div class="contact-text">
                        <strong>0851-1770-4112</strong>
                        <span>Hubungi Wa Kami</span>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <div class="contact-text">
                        <strong>karawang@lp3i.id</strong>
                        <span>Email Resmi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav id="mainNav">
        <div class="nav-container">
            <ul class="nav-links">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="dropdown">
                        <a href="{{ route('sambutan') }}">Profil</a>
                    <div class="dropdown-content">
                            <a href="{{ route('sambutan') }}">Sambutan</a>
                            <a href="{{ route('sejarah') }}">Sejarah & Visi Misi</a>
                            <a href="{{ route('struktur') }}">Struktur Organisasi</a>
                    </div>
                </li>
                    <li class="dropdown">
                        <a href="{{ route('ais') }}">Akademik</a>
                    <div class="dropdown-content">
                            <a href="{{ route('ais') }}" class="akademik-item"><span class="ak-prefix">AIS</span><span class="ak-prefix">Accounting Information System</span></a>
                            <a href="{{ route('ase') }}" class="akademik-item"><span class="ak-prefix">ASE</span><span class="ak-prefix">Application Software Engineering</span></a>
                            <a href="{{ route('oaa') }}" class="akademik-item"><span class="ak-prefix">OAA</span><span class="ak-prefix">Office Administration</span></a>
                    </div>
                </li>
                    <li><a href="{{ route('penempatan') }}">Pusat Karir</a></li>
            </ul>

            <div class="nav-auth">
                <a href="{{ route('pendaftar.login') }}" class="login-btn">Login</a>
                <a href="{{ route('mahasiswa.create') }}" class="register-btn"><i class="fas fa-user-plus"></i> Daftar Sekarang</a>
            </div>
        </div>
    </nav>
</header>

<section class="hero">
    <div class="carousel-container">
        @foreach($carouselData as $index => $item)
           <div class="carousel-slide {{ $index == 0 ? 'active' : '' }}" 
               style="background-image: url('{{ asset(isset($item['image']) && $item['image'] ? $item['image'] : 'storage/image/default-hero.jpg') }}')">
        </div>
        @endforeach
    </div>
    <div class="hero-content">
        <h1>Masa Depan Cerah Dimulai Dari Sini</h1>
        <p>Kuliah Cepat Kerja di Politeknik LP3I Kampus Karawang</p>
        {{-- <a href="{{ url('/#programs') }}" class="cta-button">Jelajahi Program</a> --}}
    </div>
</section>

<section class="reasons" id="alasan">
    <div class="container">
        <h2 class="section-title">Mengapa Memilih LP3I Karawang?</h2>
        <div class="reasons-grid">
            <div class="reason-card">
                <i class="fas fa-rocket"></i>
                <h4>Kuliah Cepat Kerja</h4>
                <p>Pembelajaran praktis yang mempersiapkan karier.</p>
            </div>
            <div class="reason-card">
                <i class="fas fa-award"></i>
                <h4>Program Terakreditasi</h4>
                <p>Program studi dengan akreditasi dan kurikulum relevan.</p>
            </div>
            <div class="reason-card">
                <i class="fas fa-chalkboard-teacher"></i>
                <h4>Dosen Profesional</h4>
                <p>Tenaga pengajar berpengalaman dari industri.</p>
            </div>
            <div class="reason-card">
                <i class="fas fa-briefcase"></i>
                <h4>Pusat Karir &amp; Magang</h4>
                <p>Dukungan penempatan kerja dan magang untuk mahasiswa.</p>
            </div>
        </div>
    
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
                {{-- Use a single wide partner image (recommended size: 1920x1080). Place the image at: public/storage/image/partners/partners-wide.jpg --}}
                <img src="{{ asset('storage/image/apiliasi.png') }}" alt="Kerjasama Perusahaan">
            </div>
    </div>
</section>

<section class="news">
    <div class="container">
        <h2 class="section-title">Berita Terkini</h2>
        <div class="news-grid">
            @foreach($newsData as $news)
                @php
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
                @endphp

                <a href="{{ $newsUrl }}" class="news-card" aria-label="{{ $news['title'] ?? 'Berita' }}">
                    <img src="{{ $newsImage }}" class="news-image" alt="{{ $news['title'] ?? 'Berita' }}">
                    <div class="news-content">
                    <span class="news-category">{{ $news['category'] ?? '' }}</span>
                    <h3>{{ $news['title'] ?? '' }}</h3>
                    <p class="news-excerpt">{{ Str::limit($news['excerpt'] ?? '', 100) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div style="text-align:center; margin-top:1.75rem;">
            <a href="{{ url('/news') }}" class="see-all-btn">Lihat Semua Berita </a>
        </div>
    </div>
</section>
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
</html>