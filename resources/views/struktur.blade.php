<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi - LP3I Karawang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @php use Illuminate\Support\Facades\Storage; @endphp
    <style>
        :root{--basic:#004269;--adv:#40826D;--muted:#6b7280}
        html { font-family: 'Poppins', sans-serif; }
        * { box-sizing: border-box; margin:0; padding:0 }
        body { font-family: 'Poppins', sans-serif; line-height: 1.6; color: #0f172a; background: linear-gradient(180deg,var(--basic) 0%, rgba(0,66,105,0.06) 28%, #f6f9fc 100%) }

        /* Header & Nav (copied from index for consistency) */
        header {
            background: linear-gradient(90deg,var(--basic),var(--adv));
            color: white;
            padding: 0.5rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.28s ease;
        }

        header.scrolled { box-shadow: 0 8px 32px rgba(0,0,0,0.18); }

        nav { display:flex; justify-content:space-between; align-items:center; max-width:1400px; margin:0 auto; padding:0 2rem }

        .logo { display:flex; align-items:center }
        .logo img { height:auto; max-height:48px; width:auto; object-fit:contain }
        .logo img.logo-global { margin-left:12px; max-height:40px }

        .nav-links { display:flex; list-style:none; gap:0; align-items:center }
        .nav-links li { position:relative }
        .nav-links a { color: rgba(255,255,255,0.95); text-decoration:none; padding:0.6rem 1.2rem; display:block; font-weight:500 }

        .mobile-menu-toggle { display:none; background:none; border:none; color:white; font-size:1.5rem; cursor:pointer }

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

        /* Page layout */
        .page { max-width:1100px; margin:110px auto; padding:0 1rem }
        .structure-title{ text-align:center; margin:32px 0 12px }
        .structure-title h1{ font-family:'Poppins',sans-serif; font-size:28px; font-weight:700; line-height:1.05; color:#fafafa; text-transform:uppercase }
        .structure-title .lp3i-blue{ color:#004269; display:block }
        .banner { display:block; border-radius:12px; overflow:hidden; box-shadow:0 12px 36px rgba(2,6,23,0.06) }
        .banner img { width:100%; height:auto; object-fit:contain; display:block }

        .center-card{display:flex;flex-direction:column;align-items:center;gap:1rem;margin-top:20px}
        .center-card-sub{display:flex;flex-direction:column;align-items:flex-end;gap:1rem;margin-top:60px;padding-right:1rem}
        .person-card{background:#fff;border-radius:12px;padding:20px;box-shadow:0 12px 36px rgba(2,6,23,0.06);width:260px;display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:260px;position:relative;z-index:2}
        .person-card.subordinate{width:240px;min-height:160px;padding:14px}
        .person-card img{width:140px;height:140px;object-fit:cover;border-radius:8px;display:block;margin:0 0 12px}
        .person-card h3{margin:0;font-size:1rem;color:var(--basic);line-height:1.2}
        .person-card .role{font-size:.85rem;color:var(--muted);margin-top:6px}

        .grid { display:grid;grid-template-columns:repeat(4,1fr);gap:2rem;margin-top:2rem }
        .grid .person-card{width:100%}

        /* Organization connectors */
        .org-tree { position: relative }
        .center-card { position: relative }
        .center-card .person-card.director { background:#fff }

        .org-tree .grid { position: relative; margin-top: 32px }
        /* SVG overlay will draw connectors precisely between photos (JS) */
        /* remove pseudo-element connectors in favor of SVG lines for accuracy */

        @media(max-width:720px){.banner img{height:200px}.grid{grid-template-columns:1fr}}
        /* ensure SVG lines are drawn behind cards so connectors don't cover them */
        #org-lines{pointer-events:none;z-index:0}
    </style>
</head>
    <body>
    <header>
        <nav>
            <div class="logo">
               
                    <img src="{{ asset('storage/image/LOGO_LP3I.png') }}" alt="LP3I Karawang Logo" />
                
                &nbsp; &nbsp;<img src="{{ asset('storage/image/global.png') }}" alt="Global Logo" class="logo-global" />
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
                        {{-- <a href="#prestasi">Prestasi</a> --}}
                    </div>
                </li>

                {{-- <li class="dropdown">
                    <a href="">Bidang</a>
                    <div class="dropdown-content">
                        <a href="#bidang">Bidang Keahlian</a>
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

    <div class="page">
        <div class="structure-title">
            <h1>STRUKTUR ORGANISASI PERGURUAN TINGGI
                <span class="lp3i-blue">Lp3i College Karawang</span>
            </h1>
        </div><br><br>
        <div class="banner"><img src="{{ asset('storage/image/Map_Organisasi.png') }}" alt="Peta Organisasi"></div>

        <!-- org tree will render below -->
            <div class="org-tree">
                @php
                    $strukturs = \App\Http\Controllers\StrukturOrganisasiController::getOrgData();
                @endphp

                @if ($strukturs['director'])
                <div class="center-card">
                    <div class="person-card director">
                        <img src="{{ $strukturs['director']->foto ? Storage::url($strukturs['director']->foto) : asset('storage/image/directur.jpg') }}" alt="{{ $strukturs['director']->nama }}">
                        <h3>{{ $strukturs['director']->nama }}</h3>
                        <div class="role">{{ $strukturs['director']->role }}</div>
                    </div>
                    
                    @php
                        $subordinatesDirector = $strukturs['staffByParent']->get($strukturs['director']->id) ?? collect();
                    @endphp
                    
                    @if ($subordinatesDirector->count() > 0)
                    <div style="margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.8rem; justify-content: center;">
                        @foreach ($subordinatesDirector as $sub)
                        <div class="person-card subordinate">
                            <img src="{{ $sub->foto ? Storage::url($sub->foto) : asset('storage/image/Pemimpin.jpg') }}" alt="{{ $sub->nama }}" style="width: 100px; height: 100px;">
                            <h3 style="font-size: 0.9rem;">{{ $sub->nama }}</h3>
                            <div class="role" style="font-size: 0.8rem;">{{ $sub->role }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif

                @if ($strukturs['secretary'])
                <div class="center-card-sub">
                    <div class="person-card subordinate">
                        <img src="{{ $strukturs['secretary']->foto ? Storage::url($strukturs['secretary']->foto) : asset('storage/image/Pemimpin.jpg') }}" alt="{{ $strukturs['secretary']->nama }}">
                        <h3>{{ $strukturs['secretary']->nama }}</h3>
                        <div class="role">{{ $strukturs['secretary']->role }}</div>
                    </div>
                    
                    @php
                        $subordinatesSecretary = $strukturs['staffByParent']->get($strukturs['secretary']->id) ?? collect();
                    @endphp
                    
                    @if ($subordinatesSecretary->count() > 0)
                    <div style="margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.8rem; justify-content: flex-end;">
                        @foreach ($subordinatesSecretary as $sub)
                        <div class="person-card subordinate">
                            <img src="{{ $sub->foto ? Storage::url($sub->foto) : asset('storage/image/Pemimpin.jpg') }}" alt="{{ $sub->nama }}" style="width: 100px; height: 100px;">
                            <h3 style="font-size: 0.9rem;">{{ $sub->nama }}</h3>
                            <div class="role" style="font-size: 0.8rem;">{{ $sub->role }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif

                {{-- Heads grid: render up to 4 heads and place their members beneath each head (no connector lines) --}}
                @if (!empty($strukturs['heads']) && $strukturs['heads']->count() > 0)
                <div class="grid">
                    @foreach ($strukturs['heads'] as $head)
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div class="person-card">
                            <img src="{{ $head->foto ? Storage::url($head->foto) : asset('storage/image/Pemimpin.jpg') }}" alt="{{ $head->nama }}">
                            <h3>{{ $head->nama }}</h3>
                            <div class="role">{{ $head->role }}</div>
                        </div>
                        
                        @php
                            $children = $strukturs['staffByParent']->get($head->id) ?? collect();
                        @endphp
                        
                        @if ($children->count() > 0)
                            @foreach ($children as $sub)
                            <div class="person-card" style="border: 2px solid rgba(64,130,109,0.15); padding: 16px; min-height: auto;">
                                <img src="{{ $sub->foto ? Storage::url($sub->foto) : asset('storage/image/Pemimpin.jpg') }}" alt="{{ $sub->nama }}" style="width: 120px; height: 120px;">
                                <h3 style="font-size: 0.95rem;">{{ $sub->nama }}</h3>
                                <div class="role" style="font-size: 0.85rem;">{{ $sub->role }}</div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Orphans: staff tanpa parent --}}
                @php
                    $headIds = collect($strukturs['heads'] ?? [])->pluck('id')->all();
                    $orphans = $strukturs['staff']->filter(function($s) use ($headIds, $strukturs){
                        $hasParent = $strukturs['staffByParent']->contains(function($collection, $parentId) use ($s){
                            return $collection->contains('id', $s->id);
                        });
                        return !$s->parent_id && !in_array($s->id, $headIds) && !$hasParent;
                    });
                @endphp
                @if ($orphans->count() > 0)
                <div style="margin-top: 3rem; display: flex; flex-wrap: wrap; gap: 2rem; justify-content: center;">
                    @foreach ($orphans as $staff)
                    <div class="person-card" style="border: 2px solid rgba(64,130,109,0.15); width: 260px;">
                        <img src="{{ $staff->foto ? Storage::url($staff->foto) : asset('storage/image/Pemimpin.jpg') }}" alt="{{ $staff->nama }}">
                        <h3>{{ $staff->nama }}</h3>
                        <div class="role">{{ $staff->role }}</div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- SVG overlay for connector lines (Director to 4 Heads only) -->
                <svg id="org-lines" style="position:absolute;left:0;top:0;width:100%;height:100%;pointer-events:none;overflow:visible;z-index:0"></svg>
            </div>

                
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

        // Draw precise connector lines: Director to 4 Heads + Corporate Secretary
        function drawOrgLines() {
            try {
                const container = document.querySelector('.org-tree');
                const svg = document.getElementById('org-lines');
                if (!container || !svg) return;

                // clear previous svg children
                while (svg.firstChild) svg.removeChild(svg.firstChild);

                const contRect = container.getBoundingClientRect();
                svg.setAttribute('width', Math.ceil(contRect.width));
                svg.setAttribute('height', Math.ceil(contRect.height));

                // Find director
                const directorBox = container.querySelector('.center-card .person-card.director');
                if (!directorBox) return;

                const dRect = directorBox.getBoundingClientRect();
                const dX = (dRect.left + dRect.right) / 2 - contRect.left;
                const directorBottomY = dRect.bottom - contRect.top;

                // Find first-level person cards in grid (heads only, not subordinates)
                const gridContainer = container.querySelector('.grid');
                if (!gridContainer) return;

                // Get only direct children divs that contain heads
                const headDivs = Array.from(gridContainer.children).filter(child => {
                    return child.style.display === 'flex' && child.style.flexDirection === 'column';
                });

                if (headDivs.length === 0) return;

                // Get first person-card from each column (that's the head)
                const headCards = headDivs.map(div => {
                    const card = div.querySelector('.person-card');
                    if (card) {
                        const r = card.getBoundingClientRect();
                        return { card, x: (r.left + r.right) / 2 - contRect.left, top: r.top - contRect.top };
                    }
                    return null;
                }).filter(h => h !== null);

                if (headCards.length === 0) return;

                const firstX = headCards[0].x;
                const lastX = headCards[headCards.length - 1].x;
                const bendX = (firstX + lastX) / 2;

                // Calculate Y position for horizontal line (above heads)
                const avgTopGrid = headCards.reduce((sum, h) => sum + h.top, 0) / headCards.length;
                const horizY = Math.max(directorBottomY + 20, avgTopGrid - 40);

                // Draw vertical line down from director
                const topSeg = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                topSeg.setAttribute('x1', dX);
                topSeg.setAttribute('y1', directorBottomY);
                topSeg.setAttribute('x2', dX);
                topSeg.setAttribute('y2', horizY + 20);
                topSeg.setAttribute('stroke', '#004269');
                topSeg.setAttribute('stroke-width', '3');
                topSeg.setAttribute('stroke-linecap', 'round');
                svg.appendChild(topSeg);

                // Draw horizontal line across all heads
                const mainH = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                mainH.setAttribute('x1', Math.max(8, firstX - 60));
                mainH.setAttribute('y1', horizY + 20);
                mainH.setAttribute('x2', Math.min(contRect.width - 8, lastX + 60));
                mainH.setAttribute('y2', horizY + 20);
                mainH.setAttribute('stroke', '#004269');
                mainH.setAttribute('stroke-width', '3');
                mainH.setAttribute('stroke-linecap', 'round');
                svg.appendChild(mainH);

                // Draw vertical stubs from horizontal line to each head
                headCards.forEach(hc => {
                    const stub = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                    stub.setAttribute('x1', hc.x);
                    stub.setAttribute('y1', horizY + 20);
                    stub.setAttribute('x2', hc.x);
                    stub.setAttribute('y2', hc.top + 6);
                    stub.setAttribute('stroke', '#004269');
                    stub.setAttribute('stroke-width', '2');
                    stub.setAttribute('stroke-linecap', 'round');
                    svg.appendChild(stub);
                });

                // Draw dashed line to Corporate Secretary
                const secretaryBox = container.querySelector('.center-card-sub .person-card.subordinate');
                if (secretaryBox) {
                    const sRect = secretaryBox.getBoundingClientRect();
                    const sX = (sRect.left + sRect.right) / 2 - contRect.left;
                    const sTop = sRect.top - contRect.top;
                    const sMiddleY = (sRect.top + sRect.bottom) / 2 - contRect.top;

                    // Dashed horizontal from director to secretary (at director level)
                    const dashedH = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                    dashedH.setAttribute('x1', dX);
                    dashedH.setAttribute('y1', directorBottomY + 10);
                    dashedH.setAttribute('x2', sX);
                    dashedH.setAttribute('y2', directorBottomY + 10);
                    dashedH.setAttribute('stroke', '#004269');
                    dashedH.setAttribute('stroke-width', '2');
                    dashedH.setAttribute('stroke-dasharray', '6,4');
                    dashedH.setAttribute('stroke-linecap', 'round');
                    svg.appendChild(dashedH);

                    // Dashed vertical to secretary
                    const dashedV = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                    dashedV.setAttribute('x1', sX);
                    dashedV.setAttribute('y1', directorBottomY + 10);
                    dashedV.setAttribute('x2', sX);
                    dashedV.setAttribute('y2', sTop + 6);
                    dashedV.setAttribute('stroke', '#004269');
                    dashedV.setAttribute('stroke-width', '2');
                    dashedV.setAttribute('stroke-dasharray', '6,4');
                    dashedV.setAttribute('stroke-linecap', 'round');
                    svg.appendChild(dashedV);
                }

            } catch (err) {
                console.error('drawOrgLines error:', err);
            }
        }

        window.addEventListener('load', drawOrgLines);
        window.addEventListener('resize', function(){ setTimeout(drawOrgLines, 120); });
    </script>
</body>
</html>
