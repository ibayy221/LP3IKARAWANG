<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejarah - LP3I Karawang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { font-family: 'Poppins', sans-serif; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Poppins',sans-serif;color:#333;line-height:1.6}
        header{background:linear-gradient(90deg,#1e3c72,#2a5298);color:#fff;padding:0.5rem 0;position:fixed;width:100%;top:0;z-index:1000}
        nav{display:flex;justify-content:space-between;align-items:center;max-width:1400px;margin:0 auto;padding:0 2rem}
        .logo img{max-height:48px}
        .nav-links{display:flex;list-style:none;align-items:center}
        .nav-links a{color:rgba(255,255,255,0.95);text-decoration:none;padding:.6rem 1.2rem;font-weight:500}
        .dropdown{position:relative}
        .dropdown-content{position:absolute;top:calc(100% + 8px);left:50%;transform:translateX(-50%);background:rgba(255,255,255,0.06);backdrop-filter:blur(12px);border-radius:10px;padding:6px;min-width:220px;max-width:320px;border:1px solid rgba(255,255,255,0.06);opacity:0;visibility:hidden;max-height:0;overflow:hidden;transition:opacity .22s ease, max-height .28s ease, visibility .22s, transform .18s ease}
        .dropdown-content a{display:block;color:rgba(255,255,255,0.95);padding:.6rem 1rem}

        @media (min-width: 769px) {
            .dropdown:hover .dropdown-content { opacity: 1; visibility: visible; max-height: 480px; }
        }

        @media (max-width: 768px) {
            .dropdown-content { position: static; width: 100%; left: 0; transform: none; background: rgba(255,255,255,0.03); border-radius: 0; box-shadow: none; margin-left: 0; border: none; max-width: 100%; opacity: 0; visibility: hidden; max-height: 0; overflow: hidden; transition: opacity .22s ease, max-height .28s ease, visibility .22s; }
            .dropdown-content.active { opacity: 1; visibility: visible; max-height: 800px; }
        }
        .container{max-width:1100px;margin:100px auto;padding:0 1rem}
        .banner img{width:100%;height:320px;object-fit:cover;border-radius:8px}
        .content{margin-top:1.25rem;background:#fff;padding:1.5rem;border-radius:8px;box-shadow:0 6px 20px rgba(0,0,0,0.04)}
        .content h1{color:#1e3c72;margin-bottom:.5rem}
        .content p{color:#333;margin-bottom:.9rem}
        @media(max-width:720px){.banner img{height:200px}}
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo"><a href="/"><img src="{{ asset('storage/image/LOGO_LP3I.png') }}" alt="LP3I"></a></div>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li class="dropdown">
                    <a href="#profil">Profil</a>
                    <div class="dropdown-content">
                        <a href="/sambutan">Sambutan</a>
                        <a href="/sejarah">Sejarah</a>
                        {{-- <a href="#prestasi">Prestasi</a> --}}
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
        <div class="banner">
            <img src="{{ asset('storage/image/landingPage1.png') }}" alt="Sejarah LP3I Karawang">
        </div>

        <article class="content">
            <h1>Sejarah Singkat LP3I Karawang</h1>
            <p>
                LP3I College Kampus Karawang berdiri dengan visi untuk menghadirkan pendidikan vokasi yang relevan dengan kebutuhan industri. Sejak awal, institusi ini fokus pada pengembangan keterampilan praktis dan kolaborasi dengan perusahaan lokal untuk memastikan lulusan siap kerja.
            </p>
            <p>
                Perjalanan kami dimulai dengan beberapa program studi unggulan dan terus berkembang seiring waktu. Komitmen terhadap kualitas pengajaran dan fasilitas modern menjadi pilar utama dalam mengembangkan sumber daya manusia yang kompeten.
            </p>
            <p>
                (Tambahkan detail sejarah lengkap di sini sesuai arsip institusi.)
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
