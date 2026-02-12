<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sambutan - LP3I Karawang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
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

        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Hero Section — indigo-dominant */
        .hero {
            min-height: 60vh;
            height: auto;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            padding: 2.5rem 1rem;
            background: linear-gradient(180deg, rgba(0, 23, 232, 0.12), rgba(64,130,109,0.04));
            border-radius: 12px;
            box-shadow: 0 12px 36px rgba(2,6,23,0.08);
        }

        /* Akademik dropdown: prefix (white), separator (white), rest text (red) */
        .dropdown-content a.akademik-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 10px 20px;
        }
        .dropdown-content a.akademik-item .ak-prefix {
            color: #ffffff;
            font-weight: 700;
        }
        .dropdown-content a.akademik-item .ak-sep {
            color: #ffffff;
            margin: 0 6px;
        }
        .dropdown-content a.akademik-item .ak-text {
            color: #e63946; /* red */
            font-weight: 600;
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
            height: 30%;
            background: linear-gradient(180deg, rgba(194, 200, 255, 0.059) 0%, rgba(0, 26, 255, 0.273) 100%);
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
            padding: 1.25rem;
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
            font-size: 1.8rem; /* mobile-first headline */
            font-weight: 800;
            margin-bottom: 0.35rem;
            color: #ffffff;
            text-shadow: 0 6px 18px rgba(24, 0, 130, 0.45);
        }

        /* Programs Section */
        .programs {
            padding: 5rem 2rem;
            background: white;
        }

        .program-card {
            opacity: 0;
            transform: translateY(50px);
            animation-fill-mode: both;
        }

        .program-card.animate {
            animation: slideInUp 0.8s ease-out forwards;
        }

        .program-card.animate:nth-child(1) {
            animation-delay: 0.1s;
        }

        .program-card.animate:nth-child(2) {
            animation-delay: 0.3s;
        }

        .program-card.animate:nth-child(3) {
            animation-delay: 0.5s;
        }

        .program-card.animate:nth-child(4) {
            animation-delay: 0.7s;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #1e3c72;
        }

        .programs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .programs-grid .program-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .programs-grid .program-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .program-icon {
            font-size: 3rem;
            color: #2a5298;
            margin-bottom: 1rem;
        }

        .program-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #1e3c72;
        }

        /* keep additional site CSS (hero, sections) minimal for sambutan layout below */
        .container{max-width:1100px;margin:110px auto 3rem;padding:0 1rem}
        .container{max-width:1100px;margin:110px auto 3rem;padding:0 1rem}
        /* Desktop: place avatar + name on left; Mobile: stack centered */
        .hero{display:flex;align-items:center;gap:2rem;background:transparent}
        .box-avatar{width:200px;height:200px;border:3px solid rgba(0, 0, 169, 0.12);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:28px;background:rgba(255,255,255,0.04);border-radius:12px;color:#fff;overflow:hidden;flex-shrink:0}
        .box-avatar img{width:100%;height:100%;object-fit:cover;display:block;border-radius:10px}
        .leader{margin-left:1rem}
        .leader h1{margin:0;font-size:40px;color:#004269;text-transform:capitalize}
        .leader .subtitle{color:rgba(0, 0, 0, 0.85);margin-top:.4rem;font-size:20px}
        .content{margin-top:2rem;background:rgba(255,255,255,0.98);padding:1.6rem;border-radius:12px;box-shadow:0 12px 36px rgba(2,6,23,0.06);color:#0f172a}
        .content p{line-height:1.8;color:#0f172a}
        @media(max-width:720px){.hero{flex-direction:column;align-items:center;text-align:center}.leader{margin-left:0}}
        @media(min-width:721px){.hero{flex-direction:row;justify-content:flex-start;text-align:left;padding:3.5rem 1rem 2.5rem}.container{padding-left:2rem}}
        .content p{
            justify-content: center;
            text-align: justify;

        }
    </style>
</head>
<body>

@include('partials.header')
<main class="container">
        <section class="hero">
            <div class="box-avatar">
                <img src="{{ asset('storage/image/directur.jpg') }}" alt="Nama Pemimpin">
            </div>
            <div class="leader">
                <h1>Aceng Ajat, S.T., M.M.</h1>
                <div class="subtitle">Branch manager</div>
            </div>
        </section>

        <section class="content">
            <p>
                &nbsp;&nbsp;&nbsp;Assalamu’alaikum Warahmatullahi Wabarakatuh, Salam Sejahtera bagi kita semua,
Selamat datang di LP3I College Kampus Karawang. Sebagai bagian dari keluarga besar LP3I, 
saya merasa bangga dan terhormat dapat menyambut Anda di institusi yang memiliki dedikasi penuh terhadap masa depan generasi muda 
Indonesia.<br>
<br>
Pendidikan bukan hanya soal deretan teori di atas kertas, melainkan tentang bagaimana kita mempersiapkan diri untuk menjadi solusi 
di tengah masyarakat. 
<br><br>
Di LP3I Karawang, kami berkomitmen menyediakan pendidikan vokasi berkualitas yang membekali lulusan dengan 
keterampilan praktis dan profesionalisme tinggi. Kami terus berinovasi dalam kurikulum dan memperluas jaringan kerja sama industri 
untuk memastikan setiap mahasiswa memiliki jalur yang jelas menuju kesuksesan.
Wassalamu’alaikum Warahmatullahi Wabarakatuh.

Salam hangat,

Aceng Ajat, ST. Kepala Kampus LP3I Karawang
            </p>
            
        </section>

    </main>
    
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
    </script>
</body>
</html>
