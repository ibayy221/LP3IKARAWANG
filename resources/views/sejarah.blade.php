<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejarah - LP3I Karawang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* CSS DASAR */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; line-height: 1.6; color: #333; }

        /* --- HEADER 3 LAYER --- */
        header { width: 100%; z-index: 1000; position: relative; }

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

        .mid-header { background: #1e3c72; padding: 15px 0; color: white; }
        .mid-header .container { display: flex; justify-content: space-between; align-items: center; max-width: 1400px; margin: 0 auto; padding: 0 2rem; }
        .logo img { max-height: 55px; width: auto; object-fit: contain; }
        .header-contact { display: flex; gap: 30px; }
        .contact-item { display: flex; align-items: center; gap: 10px; }
        .contact-item i { font-size: 1.9rem; color: #00a8e8; }
        .contact-text strong { display: block; font-size: 0.85rem; margin-bottom: 2px; }
        .contact-text span { font-size: 0.75rem; opacity: 0.8; display: block; }

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

        .container{max-width:1100px;margin:110px auto;padding:0 1rem}
        .banner img{width:100%;height:320px;object-fit:cover;border-radius:12px;box-shadow:0 12px 36px rgba(2,6,23,0.06)}
        .content{margin-top:1.25rem;background:#fff;padding:1.6rem;border-radius:12px;box-shadow:0 12px 36px rgba(2,6,23,0.06)}
        .content h1{color:#004269;margin-bottom:.5rem}
        .content p{color:#0f172a;margin-bottom:.9rem}
        @media(max-width:720px){.banner img{height:200px}}
        @media (max-width: 768px) { .header-contact { display: none; } }
    </style>
</head>
<body>
    @include('partials.header')


    <main class="container">
        <div class="banner">
            <img src="{{ asset('storage/image/gedung.jpeg') }}" alt="Sejarah LP3I Karawang">
        </div>

        <article class="content">
            <h1>Sejarah Singkat LP3I College Karawang</h1>
            <p>
                LP3I College Kampus Karawang berdiri dengan visi untuk menghadirkan pendidikan vokasi yang relevan dengan kebutuhan industri. Sejak awal, institusi ini fokus pada pengembangan keterampilan praktis dan kolaborasi dengan perusahaan lokal untuk memastikan lulusan siap kerja.
            </p>
            <p>
                Perjalanan kami dimulai dengan beberapa program studi unggulan dan terus berkembang seiring waktu. Komitmen terhadap kualitas pengajaran dan fasilitas modern menjadi pilar utama dalam mengembangkan sumber daya manusia yang kompeten.
            </p>
            {{-- <h1>Visi & Misi Lp3i College Karawang</h1> --}}
            <h1>Visi</h1>
            <p>
                Menjadikan lembaga pendidikan vocasi terbaik dan mencetak lulusan berkualitas, berakhlak, adaptif, dan kompeten.
            </p>
            <h1>Misi</h1>
            <p>
                - Menjadi lembaga pendidikan vokasi terbaik di wilayah PURWASUKA " Purwakarta, Subang, dan Karawang." <br>
                - Mencetak lulusan yang beretika, sopan dan santun. <br>
                - Membentuk pribadi yang memeiliki pengetahuan, keterampilan serta berjiwa wirausaha untuk kemajuan bangsa indonesia. <br>
                - Membentuk lulusan yang kompeten, profesional serta mampu bersaing di dunia usaha dan industri. <br>
                - Memiliki jaringan terbesar di jawa barat. <br>
                - Memberikan kesejahtraan dan rasa tentram bagi kariawan dan keluarga. <br>
                - Memiliki sumbar daya manusia yang berahlak, adaptif dan kompeten.
            </p>
        </article>
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
