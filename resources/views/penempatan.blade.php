@php
	// Expecting `$images` to be passed from controller as a collection of Penempatan models.
	// If not provided or empty, we'll render an empty state (no uploads yet).
	$images = $images ?? [];
@endphp

<!doctype html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Penempatan Kerja - LP3I Karawang</title>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
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




		body{font-family:'Poppins',sans-serif;background:#f4f6f8;color:#123;margin:0 ;}
		.wrap{max-width:1200px;margin:0 auto}
		h1{color:#004269;margin-bottom:1rem}
		.grid{display:grid;grid-template-columns:1fr;gap:1.25rem}
		@media(min-width:900px){.grid{grid-template-columns:repeat(1,1fr)}}
		.card{background:white;border-radius:12px;padding:1rem;box-shadow:0 8px 28px rgba(2,6,23,0.06);display:flex;align-items:center;gap:1rem}
		.poster{flex:1;display:flex;align-items:center;justify-content:center}
		.poster img{max-width:80%;height:80%;border-radius:8px;box-shadow:0 10px 30px rgba(2,6,23,0.08)}
		.meta{width:320px;padding:0.5rem 1rem}
		.meta h3{margin:0 0 0.5rem;color:#0b7280}
		.meta p{margin:0 0 0.75rem;color:#556}
		.actions{display:flex;gap:0.5rem}
		.btn{background:#004269;color:#fff;padding:0.6rem 0.9rem;border-radius:8px;text-decoration:none;font-weight:600}
		.btn.secondary{background:#0b7280}
	</style>
</head>
<body>

 <header>
        <nav>
            <div class="logo">
                
                    <img src="{{ asset('storage/image/LOGO_LP3I.png') }}" alt="LP3I Karawang Logo" />
                    &nbsp;&nbsp;<img src="{{ asset('storage/image/global.png') }}" alt="Global Logo" class="logo-global" />

               
            </div>
            {{-- <button class="mobile-menu-toggle">☰</button> --}}
            <ul class="nav-links">
                <li>
					<a href="/">Home</a>
				</li>
                {{-- <li class="dropdown">
                    <a href="#profil">Profil</a>
                    <div class="dropdown-content">
                        <a href="/sambutan">Sambutan</a>
                        <a href="/sejarah">Sejarah</a>
                        {{-- <a href="#prestasi">Prestasi</a> --}}
                        {{-- <a href="/struktur">Struktur Organisasi</a>
                    </div>
                </li>  --}}

                {{-- <li class="dropdown">
                    <a href="">Bidang</a>
                    <div class="dropdown-content">
                        <a href="#programs">Bidang Keahlian</a>
                    </div>
                </li>

                <li class="dropdown">
                    <a href="#">E |</a>
                    <div class="dropdown-content">
                        <a href="#akademik" class="akademik-item"><span class="ak-prefix">E|</span><span class="ak-text">Akademik</span></a>
                        <a href="#management" class="akademik-item"><span class="ak-prefix">E|</span><span class="ak-text">Management</span></a>
                        <a href="#student" class="akademik-item"><span class="ak-prefix">E|</span><span class="ak-text">Student</span></a>
                    </div>
                </li>

                <li class="dropdown">
                    <a href="#pusat-karir">Pusat Karir</a>
                    <div class="dropdown-content">
                        <a href="#pedoman">Pedoman Lowongan Kerja</a>
                        <a href="#magang">Bukti Penempatan kerja</a>
                    </div>
                </li> --}}
                <li><a href="/pendaftar/login" class="login-btn"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                {{-- <li><a href="#pendaftaran" class="register-btn"><i class="fas fa-clipboard-check"></i> Daftar Sekarang</a></li> --}}
            </ul>
        </nav>
    </header>
	<br>
	<br>
	<br>
	<br>

	<div class="wrap">
		<h1>Bukti Penempatan Kerja</h1>
		<p style="color:#445;margin-bottom:1.25rem">Berikut beberapa bukti penempatan/kerja nyata alumni. Klik gambar untuk memperbesar atau tombol unduh untuk menyimpan poster.</p>

		<div class="grid">
			@if(empty($images) || count($images) === 0)
				<div style="color:#666;padding:1rem">Belum ada item penempatan. Silakan admin unggah bukti penempatan melalui panel admin.</div>
			@else
				@foreach($images as $img)
				@php
					$isString = is_string($img);
					if ($isString) {
						$url = \Illuminate\Support\Str::startsWith($img, 'http') ? $img : asset($img);
						$title = 'Poster Penempatan';
						$description = 'Poster ini menunjukkan bukti nyata alumni yang telah bekerja sebelum atau setelah lulus.';
					} else {
						// Model instance: support several stored path formats
						$raw = $img->image_path ?? '';
						if (!empty($raw)) {
							if (\Illuminate\Support\Str::startsWith($raw, 'http')) {
								$url = $raw;
							} elseif (\Illuminate\Support\Str::startsWith($raw, '/storage') || \Illuminate\Support\Str::startsWith($raw, 'storage/')) {
								$url = asset(ltrim($raw, '/'));
							} else {
								// if stored as 'penempatan/xyz' or 'upload/..' assume storage path
								$url = asset('storage/' . ltrim($raw, '/'));
							}
						} else {
							$url = '';
						}
						$title = $img->title ?? 'Poster Penempatan';
						$description = $img->description ?? '';
					}
				@endphp
				<div class="card">
					<div class="poster">
						<a href="{{ $url }}" target="_blank" rel="noopener">
							<img src="{{ $url }}" alt="{{ $title }}">
						</a>
					</div>
					<div class="meta">
						<h3>{{ $title }}</h3>
						<p>{{ $description }}</p>
						<div class="actions">
							<a class="btn" href="{{ $url }}" target="_blank" rel="noopener" download>Unduh</a>
						</div>
					</div>
				</div>
				@endforeach
			@endif
		</div>
	</div>
</body>
</html>
