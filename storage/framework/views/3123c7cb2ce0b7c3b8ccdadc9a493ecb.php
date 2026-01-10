<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejarah - LP3I Karawang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--basic:#004269;--adv:#40826D;--muted:#6b7280}
        html { font-family: 'Poppins', sans-serif; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Poppins',sans-serif;color:#0f172a;line-height:1.6;background:linear-gradient(180deg,var(--basic) 0%, rgba(0,66,105,0.08) 28%, #f6f9fc 100%)}
        header{background:linear-gradient(90deg,var(--basic),var(--adv));color:#fff;padding:0.6rem 0;position:fixed;width:100%;top:0;z-index:1000}
        nav{display:flex;justify-content:space-between;align-items:center;max-width:1400px;margin:0 auto;padding:0 2rem}
        .logo img{max-height:48px}
        .nav-links{display:flex;list-style:none;align-items:center}
        .nav-links a{color:rgba(255,255,255,0.95);text-decoration:none;padding:.6rem 1.2rem;font-weight:500}
        .dropdown{position:relative}
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
            color: rgba(0, 0, 0, 0.9);
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
        .container{max-width:1100px;margin:110px auto;padding:0 1rem}
        .banner img{width:100%;height:320px;object-fit:cover;border-radius:12px;box-shadow:0 12px 36px rgba(2,6,23,0.06)}
        .content{margin-top:1.25rem;background:#fff;padding:1.6rem;border-radius:12px;box-shadow:0 12px 36px rgba(2,6,23,0.06)}
        .content h1{color:var(--basic);margin-bottom:.5rem}
        .content p{color:#0f172a;margin-bottom:.9rem}
        @media(max-width:720px){.banner img{height:200px}}

        /* Login Button Styling (adjacent to register) */
        .login-btn {
            display: inline-flex !important;
            align-items: center;
            gap: 0.5rem;
            background: #004269 !important;
            color: white !important;
            padding: 0.55rem 1rem !important;
            text-decoration: none !important;
            border-radius: 18px !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            transition: all 0.25s ease;
            border: 1px solid rgba(255,255,255,0.12) !important;
            cursor: pointer !important;
            white-space: nowrap;
        }

        .login-btn:hover {
            background: rgba(255,255,255,0.06) !important;
            transform: translateY(-1px);
            box-shadow: none !important;
        }

    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="<?php echo e(asset('storage/image/LOGO_LP3I.png')); ?>" alt="LP3I">
            &nbsp; &nbsp;<img src="<?php echo e(asset('storage/image/global.png')); ?>" alt="Global Logo" class="logo-global" />

            </div>
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

                
                <li><a href="/pendaftar/login" class="login-btn"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                
            </ul>
        </nav>
    </header>

    <main class="container">
        <div class="banner">
            <img src="<?php echo e(asset('storage/image/gedung.jpeg')); ?>" alt="Sejarah LP3I Karawang">
        </div>

        <article class="content">
            <h1>Sejarah Singkat LP3I Karawang</h1>
            <p>
                LP3I College Kampus Karawang berdiri dengan visi untuk menghadirkan pendidikan vokasi yang relevan dengan kebutuhan industri. Sejak awal, institusi ini fokus pada pengembangan keterampilan praktis dan kolaborasi dengan perusahaan lokal untuk memastikan lulusan siap kerja.
            </p>
            <p>
                Perjalanan kami dimulai dengan beberapa program studi unggulan dan terus berkembang seiring waktu. Komitmen terhadap kualitas pengajaran dan fasilitas modern menjadi pilar utama dalam mengembangkan sumber daya manusia yang kompeten.
            </p>
        </article>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });

            const header = document.querySelector('header');
            if (header) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 100) header.classList.add('scrolled'); else header.classList.remove('scrolled');
                });
            }

            const mobileToggle = document.querySelector('.mobile-menu-toggle');
            const navLinks = document.querySelector('.nav-links');
            if (mobileToggle && navLinks) {
                mobileToggle.addEventListener('click', function() {
                    navLinks.classList.toggle('active');
                    document.querySelectorAll('.dropdown-content').forEach(content => content.classList.remove('active'));
                });
            }

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
<?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/sejarah.blade.php ENDPATH**/ ?>