<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sambutan - LP3I Karawang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { font-family: 'Poppins', sans-serif; }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Header (glass effect) */
        header {
            background: linear-gradient(90deg,#1e3c72,#2a5298); /* solid LP3I blue gradient */
            color: rgb(255, 255, 255);
            padding: 0.5rem 0; /* slightly larger for visual balance */
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.28s ease;
        }

        header.scrolled {
            background: linear-gradient(90deg,#1e3c72,#2a5298);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
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
            display: flex;
            align-items: center;
        }

        .logo img {
            height: auto;
            max-height: 48px; /* keep logo visible and not cropped */
            width: auto;
            max-width: 220px;
            object-fit: contain;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.08));
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

        /* Dropdown Styles */
        .dropdown {
            position: relative;
            display: inline-block; /* allow dropdown to size to its trigger */
        }

        /* Desktop-style absolute submenu but hidden by default via opacity/max-height
           so it won't push layout when toggled. Hover behavior applied only on desktop below. */
        .dropdown-content {
            position: absolute;
            top: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            min-width: 220px; /* fixed min width to avoid covering neighbors */
            max-width: 320px;
            width: auto;
            border-radius: 10px;
            z-index: 1000;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
            opacity: 0;
            visibility: hidden;
            max-height: 0;
            transition: opacity .22s ease, max-height .28s ease, visibility .22s, transform .18s ease;
        }

        /* Hover-to-open is only for desktop; mobile uses click toggle (JS adds .active) */
        @media (min-width: 769px) {
            .dropdown:hover .dropdown-content {
                opacity: 1;
                visibility: visible;
                max-height: 480px; /* allow smooth reveal without changing layout */
            }
        }

        /* Mobile specific adjustments: keep submenu out of flow but allow vertical expand
           using .active class toggled by JS. Hover states are ignored on small screens. */
        @media (max-width: 768px) {
            .dropdown-content {
                position: static; /* place inside flow for mobile accordion */
                width: 100%;
                left: 0;
                transform: none;
                background: rgba(255,255,255,0.03);
                border-radius: 0;
                box-shadow: none;
                margin-left: 0;
                border: none;
                max-width: 100%;
                opacity: 0;
                visibility: hidden;
                max-height: 0;
                overflow: hidden;
                transition: opacity .22s ease, max-height .28s ease, visibility .22s;
            }

            .dropdown-content.active {
                opacity: 1;
                visibility: visible;
                max-height: 800px; /* generous for all items */
            }
        }

        .dropdown-content a {
            color: rgba(255, 255, 255, 0.9);
            padding: 10px 20px; /* Adjusted padding */
            text-decoration: none;
            display: block;
            transition: all 0.3s;
            border-radius: 0;
            position: relative;
            overflow: hidden;
            background: transparent;
            border: none;
        }

        .dropdown-content a:hover::before {
            width: 100%;
        }

        .dropdown-content a:hover {
            color: rgba(255, 255, 255, 0.9); /* Keep original color */
            background: transparent; /* Ensure no background on hover */
            transform: none; /* Ensure no transform on hover */
        }
        /* Mobile specific adjustments for dropdown-content a */
        @media (max-width: 768px) {
            .dropdown-content a {
                padding: 0.6rem 2.5rem; /* Indent dropdown items, adjusted padding */
                color: rgba(255, 255, 255, 0.8);
                background: transparent;
                transform: none; /* Remove transform on hover for mobile */
            }
            .dropdown-content a:hover {
                background: transparent; /* Ensure no background on hover for mobile */
                color: rgba(255, 255, 255, 0.8); /* Keep original color for mobile */
                transform: none; /* Ensure no transform on hover for mobile */
            }
        }

        .dropdown > a::after {
            content: ' ▼';
            font-size: 0.7rem;
            margin-left: 3px;
            transition: transform 0.3s;
        }

        /* Only rotate the caret on desktop hover; mobile uses click/toggle */
        @media (min-width: 769px) {
            .dropdown:hover > a::after {
                transform: rotate(180deg);
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
        }

        /* Hero Section — mobile-first improvements */
        .hero {
            min-height: 65vh; /* mobile-first: compact hero */
            height: auto;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #222;
            padding: 2.5rem 1rem;
        }

        /* subtle top-wide overlay (keeps faces in photo visible), add a stronger bottom band via ::after */
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            /* very subtle darkening so the image stays visible */
            background: linear-gradient(180deg, rgba(0,0,0,0.06) 0%, rgba(0,0,0,0.03) 40%, rgba(0,0,0,0.00) 70%);
            z-index: 1;
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 40%; /* gentle band at the bottom for better text contrast */
            background: linear-gradient(180deg, rgba(0,0,0,0.00) 0%, rgba(0,0,0,0.45) 100%);
            z-index: 1;
            pointer-events: none;
        }

        .carousel-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .carousel-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
        }

        .carousel-slide.active { opacity: 1; }

        .carousel-content {
            position: absolute;
            top: 60%; /* move content lower than center */
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            width: 100%;
            max-width: 920px;
            padding: 1.25rem; /* tighter on mobile */
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 576px) {
            .carousel-content { top: 66%; }
        }

        .carousel-indicators {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 3;
        }

        .indicator {
            width: 40px;
            height: 4px;
            border-radius: 2px;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
        }

        .indicator::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(116, 185, 255, 0.8), transparent);
            transition: left 0.6s ease;
        }

        .indicator:hover::before {
            left: 100%;
        }

        .indicator.active {
            background: #74b9ff;
            box-shadow: 0 0 15px rgba(116, 185, 255, 0.6);
        }

        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(81, 0, 255, 0.2);
            border: none;
            color: white;
            font-size: 2rem;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 3;
            backdrop-filter: blur(10px);
            border-radius: 50%;
        }

        .carousel-nav:hover {
            background: rgba(74, 144, 226, 0.5);
        }

        .carousel-nav.prev {
            left: 30px;
        }

        .carousel-nav.next {
            right: 30px;
        }

        .hero-content h1 {
            font-size: 1.6rem; /* mobile-first headline */
            font-weight: 800;
            margin-bottom: 0.35rem;
            color: #ffffff;
            text-shadow: 0 6px 18px rgba(0,0,0,0.45);
        }
        /* keep additional site CSS (hero, sections) minimal for sambutan layout below */
        .container{max-width:1100px;margin:90px auto 3rem;padding:0 1rem}
        .container{max-width:1100px;margin:90px auto 3rem;padding:0 1rem}
        /* Desktop: place avatar + name on left; Mobile: stack centered */
        .hero{display:flex;align-items:center;gap:2rem;background:transparent}
        .box-avatar{width:200px;height:200px;border:3px solid rgba(0,0,0,0.06);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:28px;background:#fff;border-radius:12px;color:#1e3c72;overflow:hidden;flex-shrink:0}
        .box-avatar img{width:100%;height:100%;object-fit:cover;display:block}
        .leader{margin-left:1rem}
        .leader h1{margin:0;font-size:40px;color:#1e3c72;text-transform:capitalize}
        .leader .subtitle{color:rgba(0,0,0,0.6);margin-top:.4rem}
        .content{margin-top:2rem;background:#f9f9fb;padding:1.2rem;border-radius:8px}
        .content p{line-height:1.7;color:#333}
        @media(max-width:720px){.hero{flex-direction:column;align-items:center;text-align:center}.leader{margin-left:0}}
        @media(min-width:721px){.hero{flex-direction:row;justify-content:flex-start;text-align:left;padding:3.5rem 1rem 2.5rem}.container{padding-left:2rem}}
        .content p{
            justify-content: center;
            text-align: justify;

        }
    </style>
</head>
<body>
    

    <!-- Header (same as dashboard) -->
    <header>
        <nav>
            <div class="logo">
                <a href="/">
                    <img src="<?php echo e(asset('storage/image/LOGO_LP3I.png')); ?>" alt="LP3I Karawang Logo" />
                </a>
            </div>
            <button class="mobile-menu-toggle">☰</button>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li class="dropdown">
                    <a href="#profil">Profil</a>
                    <div class="dropdown-content">
                        <a href="/sambutan">Sambutan</a>
                        <a href="/sejarah">Sejarah</a>
                        
                        <a href="/struktur">Struktur Organisasi</a>
                    </div>
                </li>

                <li class="dropdown">
                    <a href="#programs">Program Studi</a>
                    <div class="dropdown-content">
                        <a href="#akuntansi">Akuntansi</a>
                        <a href="#teknik-informatika">Teknik Informatika</a>
                        <a href="#manajemen-bisnis">Manajemen Bisnis</a>
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
                    <a href="#pusat-karir">Pusat Karir</a>
                    <div class="dropdown-content">
                        <a href="#lowongan-kerja">Lowongan Kerja</a>
                        <a href="#magang">Program Magang</a>
                        <a href="#alumni">Alumni</a>
                        <a href="#kerjasama-industri">Kerjasama Industri</a>
                    </div>
                </li>
                <li><a href="/pendaftar/login" class="login-btn"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                
            </ul>
        </nav>
    </header>

    <main class="container">
        <section class="hero">
            <div class="box-avatar">
                <img src="<?php echo e(asset('storage/image/Pemimpin.jpg')); ?>" alt="Nama Pemimpin">
            </div>
            <div class="leader">
                <h1>Nama Pemimpin</h1>
                <div class="subtitle">Branch manager</div>
            </div>
        </section>

        <section class="content">
            <p>
                Assalamu’alaikum Warahmatullahi Wabarakatuh, Salam Sejahtera bagi kita semua,

Selamat datang di LP3I College Kampus Karawang. Sebagai bagian dari keluarga besar LP3I, 
saya merasa bangga dan terhormat dapat menyambut Anda di institusi yang memiliki dedikasi penuh terhadap masa depan generasi muda 
Indonesia.
Pendidikan bukan hanya soal deretan teori di atas kertas, melainkan tentang bagaimana kita mempersiapkan diri untuk menjadi solusi 
di tengah masyarakat. Di LP3I Karawang, kami berkomitmen menyediakan pendidikan vokasi berkualitas yang membekali lulusan dengan 
keterampilan praktis dan profesionalisme tinggi. Kami terus berinovasi dalam kurikulum dan memperluas jaringan kerja sama industri 
untuk memastikan setiap mahasiswa memiliki jalur yang jelas menuju kesuksesan.
Wassalamu’alaikum Warahmatullahi Wabarakatuh.

Salam hangat,

Aceng Ajat, ST. Kepala Kampus LP3I Karawang
            </p>
        </section>
    </main>
    <script>
        // Ensure dropdowns are closed on load and enable mobile toggles (same behavior as index)
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scrolling for internal anchors
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });

            // header scrolled class
            const header = document.querySelector('header');
            if (header) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 100) header.classList.add('scrolled'); else header.classList.remove('scrolled');
                });
            }

            // mobile menu toggle
            const mobileToggle = document.querySelector('.mobile-menu-toggle');
            const navLinks = document.querySelector('.nav-links');
            if (mobileToggle && navLinks) {
                mobileToggle.addEventListener('click', function() {
                    navLinks.classList.toggle('active');
                    document.querySelectorAll('.dropdown-content').forEach(content => content.classList.remove('active'));
                });
            }

            // mobile dropdown toggle
            document.querySelectorAll('.nav-links .dropdown > a').forEach(dropdownToggle => {
                dropdownToggle.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        e.preventDefault();
                        const dropdownContent = this.nextElementSibling;
                        if (dropdownContent && dropdownContent.classList.contains('dropdown-content')) {
                            document.querySelectorAll('.dropdown-content.active').forEach(openDropdown => {
                                if (openDropdown !== dropdownContent) openDropdown.classList.remove('active');
                            });
                            dropdownContent.classList.toggle('active');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
<?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/sambutan.blade.php ENDPATH**/ ?>