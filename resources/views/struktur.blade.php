<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi - LP3I Karawang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { font-family: 'Poppins', sans-serif; }
        * { box-sizing: border-box; margin:0; padding:0 }
        body { font-family: 'Poppins', sans-serif; line-height: 1.6; color: #333; background:#f6f9fb }

        /* Header & Nav (copied from index for consistency) */
        header {
            background: linear-gradient(90deg,#1e3c72,#2a5298);
            color: white;
            padding: 0.44rem 0;
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

        .nav-links { display:flex; list-style:none; gap:0; align-items:center }
        .nav-links li { position:relative }
        .nav-links a { color: rgba(255,255,255,0.95); text-decoration:none; padding:0.6rem 1.2rem; display:block; font-weight:500 }

        .mobile-menu-toggle { display:none; background:none; border:none; color:white; font-size:1.5rem; cursor:pointer }

        /* Dropdown */
        .dropdown-content { position:absolute; top:calc(100% + 8px); left:50%; transform:translateX(-50%); background:rgba(255,255,255,0.06); backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px); min-width:220px; max-width:320px; width:auto; border-radius:10px; z-index:1000; overflow:hidden; border:1px solid rgba(255,255,255,0.06); opacity:0; visibility:hidden; max-height:0; transition:opacity .22s ease, max-height .28s ease, visibility .22s, transform .18s }
        .dropdown-content a { display:block; color:rgba(255,255,255,0.95); padding:.6rem 1rem }

        @media (min-width: 769px) {
            .dropdown:hover .dropdown-content { opacity:1; visibility:visible; max-height:480px }
        }

        @media (max-width:768px) {
            .mobile-menu-toggle { display:block }
            .nav-links { display:none }
            .nav-links.active { display:flex; flex-direction:column; gap:0; width:100% }
            .dropdown-content { position:static; width:100%; left:0; transform:none; background:rgba(255,255,255,0.03); border-radius:0; box-shadow:none; margin-left:0; border:none; max-width:100%; opacity:0; visibility:hidden; max-height:0 }
            .dropdown-content.active { opacity:1; visibility:visible; max-height:800px }
        }

        /* Page layout */
        .page { max-width:1100px; margin:100px auto; padding:0 1rem }
        .structure-title{ text-align:center; margin:32px 0 12px }
        .structure-title h1{ font-family:'Poppins',sans-serif; font-size:28px; font-weight:700; line-height:1.05; color:#0f1724; text-transform:uppercase }
        .structure-title .lp3i-blue{ color:#1e3c72; display:block }
        .banner { display:block; border-radius:10px; overflow:hidden }
        .banner img { width:100%; height:300px; object-fit:cover; display:block }

        .center-card{display:flex;flex-direction:column;align-items:center;gap:1rem;margin-top:1.5rem}
        .person-card{background:#fff;border-radius:10px;padding:20px;box-shadow:0 10px 30px rgba(16,24,40,0.06);width:260px;display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:260px;position:relative;z-index:1}
        .person-card img{width:140px;height:140px;object-fit:cover;border-radius:6px;display:block;margin:0 0 12px}
        .person-card h3{margin:0;font-size:1rem;color:#1e3c72;line-height:1.2}
        .person-card .role{font-size:.85rem;color:#6b7280;margin-top:6px}

        .grid { display:grid;grid-template-columns:repeat(2,1fr);gap:2rem;margin-top:2rem }
        .grid .person-card{width:100%}

        /* Organization connectors */
        .org-tree { position: relative }
        .center-card { position: relative }
        .center-card .person-card.director { background:#fff }

        .org-tree .grid { position: relative; margin-top: 32px }
        /* SVG overlay will draw connectors precisely between photos (JS) */
        /* remove pseudo-element connectors in favor of SVG lines for accuracy */

        @media(max-width:720px){.banner img{height:200px}.grid{grid-template-columns:1fr}}
    </style>
</head>
    <body>
    <header>
        <nav>
            <div class="logo">
                <a href="/">
                    <img src="{{ asset('storage/image/LOGO_LP3I.png') }}" alt="LP3I Karawang Logo" />
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
                        {{-- <a href="#prestasi">Prestasi</a> --}}
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
                {{-- <li><a href="#pendaftaran" class="register-btn"><i class="fas fa-clipboard-check"></i> Daftar Sekarang</a></li> --}}
            </ul>
        </nav>
    </header>

    <div class="page">
        <div class="structure-title">
            <h1>STRUKTUR ORGANISASI PERGURUAN TINGGI
                <span class="lp3i-blue">Lp3i Karawang</span>
            </h1>
        </div>
        <div class="banner"><img src="{{ asset('storage/image/Map_Organisasi.png') }}" alt="Peta Organisasi"></div>

        <!-- org tree will render below -->
            <div class="org-tree">
                <div class="center-card">
                    <div class="person-card director">
                        <img src="{{ asset('storage/image/Pemimpin.jpg') }}" alt="Pemimpin">
                        <h3>Dr. sapey1</h3>
                        <div class="role">Direktur</div>
                    </div>
                </div>

                <div class="grid">
                    <div class="person-card">
                        <img src="{{ asset('storage/image/Pemimpin.jpg') }}" alt="Wakil Akademik">
                        <h3>sapey2</h3>
                        <div class="role">Wakil Direktur Akademik</div>
                    </div>
                    <div class="person-card">
                        <img src="{{ asset('storage/image/Pemimpin.jpg') }}" alt="Wakil Non Akademik">
                        <h3>sapey3</h3>
                        <div class="role">Wakil Direktur Non Akademik</div>
                    </div>
                </div>
                    <!-- SVG overlay for connector lines -->
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

        // Draw precise connector lines between director and member photos using SVG
        function drawOrgLines() {
            const svg = document.getElementById('org-lines');
            const container = document.querySelector('.org-tree');
            if (!svg || !container) return;
            // clear previous
            while (svg.firstChild) svg.removeChild(svg.firstChild);

            const directorBox = container.querySelector('.center-card .person-card');
            const memberBoxes = Array.from(container.querySelectorAll('.grid .person-card'));
            if (!directorBox || memberBoxes.length === 0) return;

            const contRect = container.getBoundingClientRect();
            // ensure svg size covers container
            svg.setAttribute('width', Math.ceil(contRect.width));
            svg.setAttribute('height', Math.ceil(contRect.height));

            const dRect = directorBox.getBoundingClientRect();
            const dX = (dRect.left + dRect.right) / 2 - contRect.left;
            const dY = dRect.bottom - contRect.top; // start from bottom of director box

            // compute member box tops and centers (we will connect to the top edge of each box)
            const memberCenters = memberBoxes.map(box => {
                const r = box.getBoundingClientRect();
                return {
                    x: (r.left + r.right) / 2 - contRect.left,
                    top: r.top - contRect.top,
                    centerY: (r.top + r.bottom) / 2 - contRect.top
                };
            });

            // horizontal line y position: a bit above the top of member boxes (so it connects to the box, not the photo)
            const avgTop = memberCenters.reduce((s,c)=>s+c.top,0)/memberCenters.length;
            const horizY = avgTop - 12;

            const firstX = memberCenters[0].x;
            const lastX = memberCenters[memberCenters.length-1].x;

            // draw vertical line from director down to horizontal line
            const vLine = document.createElementNS('http://www.w3.org/2000/svg','line');
            vLine.setAttribute('x1', dX);
            vLine.setAttribute('y1', dY);
            vLine.setAttribute('x2', dX);
            vLine.setAttribute('y2', horizY);
            vLine.setAttribute('stroke', '#1e3c72');
            vLine.setAttribute('stroke-width', '3');
            vLine.setAttribute('stroke-linecap', 'round');
            svg.appendChild(vLine);

            // draw horizontal line across member centers
            const hLine = document.createElementNS('http://www.w3.org/2000/svg','line');
            // extend horizontal a bit beyond first/last member so it visually meets the box edges
            const extend = Math.min(60, (lastX - firstX) * 0.25 || 40);
            const hx1 = Math.max(8, firstX - extend);
            const hx2 = Math.min(Math.max(firstX,lastX) + extend, contRect.width - 8);
            hLine.setAttribute('x1', hx1);
            hLine.setAttribute('y1', horizY);
            hLine.setAttribute('x2', hx2);
            hLine.setAttribute('y2', horizY);
            hLine.setAttribute('stroke', '#1e3c72');
            hLine.setAttribute('stroke-width', '3');
            hLine.setAttribute('stroke-linecap', 'round');
            svg.appendChild(hLine);

            // draw vertical stubs from horizontal line down to the top edge of each member box
            memberCenters.forEach(mc => {
                const stub = document.createElementNS('http://www.w3.org/2000/svg','line');
                stub.setAttribute('x1', mc.x);
                stub.setAttribute('y1', horizY);
                stub.setAttribute('x2', mc.x);
                stub.setAttribute('y2', mc.top + 6); // small inset so line meets box area, not the exact edge
                stub.setAttribute('stroke', '#1e3c72');
                stub.setAttribute('stroke-width', '2');
                stub.setAttribute('stroke-linecap', 'round');
                svg.appendChild(stub);
            });
        }

        window.addEventListener('load', drawOrgLines);
        window.addEventListener('resize', function(){ setTimeout(drawOrgLines, 120); });
    </script>
</body>
</html>
