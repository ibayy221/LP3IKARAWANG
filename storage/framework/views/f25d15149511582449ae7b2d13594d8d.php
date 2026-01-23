<!doctype html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>D3 D3 Accounting Information System</title>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
	<style>
		:root{--brand-dark:#004269;--brand-accent:#0b7280}
		/* body{font-family:'Poppins',sans-serif;margin:0;background:#f8fafc;color:#072033;line-height:1.6;padding:2rem} */
		/* .wrap{max-width:1100px;margin:0 auto;background:transparent} */
		.grid{display:flex;gap:2rem;align-items:flex-start}
		.content{flex:1}
		.aside{margin-top: 30px;display:flex;flex-direction:column;align-items:center;justify-content:center}
		.card{background:#ffffff;border-radius:12px;padding:2rem;box-shadow:0 12px 36px rgba(2,6,23,0.06);border:1px solid rgba(2,6,23,0.04)}
		h1{margin:0 0 0.6rem 0;color:var(--brand-dark);font-size:1.6rem}
		h2{color:var(--brand-dark);font-size:1.1rem;margin:1.2rem 0 0.6rem}
		p{margin:0 0 0.6rem 0;color:#16383a}
		ul{margin:0 0 0.8rem 1.1rem;color:#16383a}
		.prospects li{margin:0.35rem 0}
		img.program-img{width:200%;max-width:420px;border-radius:10px;box-shadow:0 12px 30px rgba(2,6,23,0.08);object-fit:cover}
		.image-stack{display:flex;flex-direction:column;gap:12px;align-items:center}
		.gallery{width:50%;max-width:500px;display:flex;flex-direction:column;gap:10px;align-items:center;margin-top:6px}
		.thumbnail{width:45%;max-width:240px;border-radius:8px;object-fit:cover;box-shadow:0 8px 20px rgba(2,6,23,0.06)}
		@media (max-width:900px){.grid{flex-direction:column}.aside{order:2}.content{order:1}.img.program-img{width:70%}}
	</style>

	<style>
        :root{--basic:#004269;--adv:#40826D;--muted:#6b7280}
        html { font-family: 'Poppins', sans-serif; }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #0f172a;
            background: linear-gradient(180deg,var(--basic) 0%, rgba(0,66,105,0.10) 30%, #f6f9fc 100%);
        }

        /* Header (indigo brand) */
        header {
            background: linear-gradient(90deg,var(--basic),var(--adv));
            color: #fff;
            padding: 0.6rem 0; /* slightly larger for visual balance */
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
            color: rgba(255, 255, 255, 0.95);
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
<header>
        <nav>
            <div class="logo">
                <a href="/">
                    <img src="<?php echo e(asset('storage/image/LOGO_LP3I.png')); ?>" alt="LP3I Karawang Logo" />
                    &nbsp;&nbsp;<img src="<?php echo e(asset('storage/image/global.png')); ?>" alt="Global Logo" class="logo-global" />

                </a>
            </div>
            <button class="mobile-menu-toggle">☰</button>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                

                <li class="dropdown">
                    <a href="">Bidang Keahlian</a>
                    <div class="dropdown-content">
                        <a href="/ais">Accounting Information System</a>
						<a href="/ase">Application Software Engineering</a>
						<a href="/oaa">Office Administration automatization</a>
                    </div>
                </li>

                

				
				<li><a href="#pendaftaran" class="login-btn"><i class="fas fa-clipboard-check"></i>Daftar</a></li>
                <li><a href="/pendaftar/login" class="login-btn"><i class="fas fa-sign-in-alt"></i>Login</a></li>
            </ul>
        </nav>
    </header>

	<div class="wrap">
		<div class="card">
			<div class="grid">
				<div class="content">
					<h1>D3 Accounting Information System</h1>

					<h2>Peminatan</h2>
					<p>1. Peminatan Manajemen Keuangan</p>
                    <p>2. Peminatan Manajemen Perbankan</p>

					<h2>Profil Lulusan</h2>
					<p>Program Studi Manajemen Keuangan Perbankan mempersiapkan profesional muda di tingkat Ahli Madya yang mampu menerapkan prinsip prinsip keuangan dan perbankan sesuai dengan kebutuhan dunia usaha dan dunia industri dengan berlandaskan budi pekerti luhur, integritas dan profesionalisme di bidang keuangan dan perbankan.</p>

					<h2>Kompetensi</h2>
					<ul>
						<li>Mampu merancang dan menjalankan sistem keuangan perusahaan</li>
						<li>Mampu menjalankan seluruh kegiatan operasional perbankan</li>
						<li>Mampu melahirkan unit bisnis atau koperasi baru yang memiliki Karakter dan daya saing dengan usaha serupa</li>
						<li>Memiliki kemampuan bahasa inggris yang baik</li>
						
					</ul>

					<h2>Program Studi Manajemen Keuangan Perbankan Capaian Pembelajaran Lulusan (CPL)</h2>
					<h3>A. Aspek Sikap</h3>
					<ul>
						<li>Bertaqwa kepada Tuhan Yang Maha Esa dan menunjukkan sikap religius.</li>
						<li>Menjunjung tinggi nilai kemanusiaan, etika, dan moral dalam bekerja.</li>
						<li>Berkontribusi dalam peningkatan mutu kehidupan bermasyarakat dan berbangsa.</li>
					</ul>

					<h3>B. Aspek Keterampilan Umum (D3/Level 5)</h3>
					<ul>
						<li>Mampu menunjukkan kinerja optimal sesuai bidang keahlian dan menyusun laporan kinerja.</li>
						<li>Mampu bekerja di bawah tekanan dengan orientasi pencapaian target dan bekerja sama tim.</li>
						<li>Mampu melakukan supervisi dan pengembangan kompetensi kerja.</li>
					</ul>

					<h3>C. Pengetahuan Umum (D3/Level 5)</h3>
					<ul>
						<li>Menguasai konsep dasar Ilmu Ekonomi dan Manajemen Pemasaran.</li>
						<li>Menguasai prinsip selling, customer service, promosi, public relations, e-commerce, dan perencanaan pemasaran.</li>
						<li>Menguasai manajemen ritel, strategi pemasaran, perilaku konsumen, dan aplikasi komputer untuk pemasaran.</li>
					</ul>

					<h3>D. Keterampilan Khusus</h3>
					<ul>
						<li>Mampu menerapkan pemasaran online, riset pemasaran, dan kebijakan pemasaran berbasis data.</li>
						<li>Mampu berwirausaha dan mengoperasikan aplikasi pemasaran digital.</li>
						<li>Mampu melakukan perencanaan anggaran dan komunikasi bisnis lintas budaya.</li>
					</ul>

					<h2>Pilihan Peminatan / Konsentrasi</h2>
					<ul>
						<li>Digital Marketing</li>
						<li>Marketing Administration</li>
					</ul>

					<h2>Prospek Karir / Posisi Jabatan</h2>
					<ul class="prospects">
						<li>Marketing officer / staf Pemasaran</li>
						<li>Marketing Analyst</li>
						<li>Social Media Marketing</li>
						<li>Entrepreneur</li>
						<li>Supervisi Retail</li>
						<li>Retail consultant</li>
						<li>Admin Marketing</li>
						<li>Graphic Designer</li>
						<li>Photographer & video editor</li>
					</ul>

					<h2>Visi</h2>
					<p>Pada Tahun 2031 menjadi PRODI bereputasi di tingkat nasional dengan melahirkan lulusan berakhlak dan menguasai bidang Financial Technology.</p>

					<h2>Misi</h2>
					<ul>
						<li>Menyelenggarakan pendidikan Manajemen Keuangan Perbankan yang berpusat pada peserta didik, menggunakan pendeketan link and match dengan pemanfaatan teknologi</li>
						<li>Menyelenggarakan penelitian di bidang manajemen keuangan, perbankan, koperasi dan UMKM yang bermanfaat bagi pengembangan IPTEK dan kesejahteraan masyarakat</li>
						<li>Meningkatkan kualitas sistem penjamin mutu untuk mendukung pencapaian institusi</li>
						<li>Menyebarluaskan artikel hasil penelitian di bidang manajemen keuangan, perbankan, koperasi dan UMKM baik melalui forum ilmiah maupun jurnal nasional dan internasional</li>
						<li>Menyelenggarakan kegiatan pengabdian kepada masyarakat dalam rangka mengembangkan hasil penelitian di bidang manajemen keuangan, perbankan, koperasi dan UMKM yang berorientasi pada proses pemberdayaan masyarakat</li>
						<li>Menyelenggarakan tata pamong yang mandiri, akuntabel, dan transparan yang menjamin peningkatan kualitas berkelanjutan</li>
					</ul>

					<h2>Tujuan</h2>
					<ul>
						<li>Menghasilkan lulusan ahli madya di bidang Keuangan, Perbankan, serta Koperasi dan UMKM yang dinamis dan tanggap terhadap kemajuan teknologi berlandaskan akhlakul karimah dan budi pekerti luhur.</li>
						<li>Melaksanakan proses belajar mengajar dengan pendekatan penelitian terapan serta peningkatan pelayanan kepada masyarakat.</li>
						<li>Melahirkan tenaga ahli berkualitas yang siap kerja sesuai dengan kebutuhan dunia usaha dan dunia industri.</li>
						<li>Menghasilkan penelitian unggulan yang berguna bagi masyaraat luas dalam bidang Keuangan, Perbankan serta koperasi dan UMKM.</li>
						
					</ul>

				</div>
				
				<div class="aside">
					<img class="program-img" src="<?php echo e(asset('storage/image/AIS.jpg')); ?>" alt="Program Manajemen Pemasaran" onerror="this.onerror=null;this.src='<?php echo e(asset('storage/image/AIS.png')); ?>'">
                    <br>
                    <br>
                    <br>
                     <br>
                    <br>
                    <br>
                    <img class="program-img" src="<?php echo e(asset('storage/image/AIS2.jpg')); ?>" alt="Program Manajemen Pemasaran" onerror="this.onerror=null;this.src='<?php echo e(asset('storage/image/AIS.png')); ?>'">
                    <br>
                    <br>
                     <br>
                    <br>
                    <br>
                    <br>
                    <img class="program-img" src="<?php echo e(asset('storage/image/AIS3.jpg')); ?>" alt="Program Manajemen Pemasaran" onerror="this.onerror=null;this.src='<?php echo e(asset('storage/image/AIS.png')); ?>'">
					
						
					
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/ais.blade.php ENDPATH**/ ?>