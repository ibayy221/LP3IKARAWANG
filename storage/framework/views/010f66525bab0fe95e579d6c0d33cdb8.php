<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi - LP3I Karawang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <?php use Illuminate\Support\Facades\Storage; ?>
    <style>
        :root{--basic:#004269;--adv:#40826D;--muted:#6b7280}
        html { font-family: 'Poppins', sans-serif; }
        * { box-sizing: border-box; margin:0; padding:0 }
        body { font-family: 'Poppins', sans-serif; line-height: 1.6; color: #0f172a; background: linear-gradient(180deg,var(--basic) 0%, rgba(0,66,105,0.06) 28%, #f6f9fc 100%) }

        /* Header & Nav (copied from index for consistency) */
        header { width: 100%; z-index: 1000; position: relative; }

        .topbar { background: #009da5; color: white; padding: 6px 0; font-size: 0.95rem; font-weight: 600; }
        .topbar .container { max-width: 1400px; margin: 0 auto; padding: 0 2rem; display:flex; justify-content:space-between; align-items:center; gap:1rem; }
        .topbar-left, .topbar-right { display:flex; align-items:center; gap:1rem; }
        .topbar a { color: white; text-decoration: none; display:inline-flex; align-items:center; gap:0.5rem; padding:4px 8px; border-radius:6px; }
        .topbar a:hover { background: rgba(255,255,255,0.08); }
        @media (max-width: 768px) { .topbar .container { flex-direction: column; align-items: flex-start; gap:8px; } }

        .mid-header { background: #1e3c72; padding: 15px 0; color: white; }
        .mid-header .container { display: flex; justify-content: space-between; align-items: center; max-width: 1400px; margin: 0 auto; padding: 0 2rem; }
        .logo { display:flex; align-items:center }
        .logo img { height:auto; max-height:48px; width:auto; object-fit:contain }
        .logo img.logo-global { margin-left:12px; max-height:40px }
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

        .nav-links { display: flex; list-style: none; gap: 0; align-items: center; }
        .nav-links li { position: relative; }
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
        .nav-links a:hover { color: #1e3c72; background: transparent; }
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
        .nav-links a:hover:after { width: 70%; }

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
        @media (max-width: 768px) { .header-contact { display: none; } }
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
        <div class="topbar">
            <div class="container">
                <div class="topbar-left"><a href="<?php echo e(route('virtual')); ?>">Virtual</a></div>
                <div class="topbar-right">
                    <a href="<?php echo e(route('student')); ?>">E | Student</a>
                    <a href="<?php echo e(route('akademik')); ?>">E | Akademik</a>
                    <a href="<?php echo e(route('lecture')); ?>">E | Lecture</a>
                </div>
            </div>
        </div>

        <div class="mid-header">
            <div class="container">
                <div class="logo">
                    <img src="<?php echo e(asset('storage/image/LOGO_LP3I.png')); ?>" alt="LP3I Karawang">
                    <img src="<?php echo e(asset('storage/image/global.png')); ?>" alt="Global">
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
                    <div class="contact-item">
                        <i class="fab fa-instagram"></i>
                        <a href="https://www.instagram.com/lp3ikarawang" target="_blank" class="contact-text" style="text-decoration: none; color: inherit;">
                            <strong>@lp3ikarawang</strong>
                            <span>Follow Instagram</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <nav id="mainNav">
            <div class="nav-container">
                <ul class="nav-links">
                    <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li class="dropdown">
                        <a href="<?php echo e(route('sambutan')); ?>">Profil</a>
                        <div class="dropdown-content">
                            <a href="<?php echo e(route('sambutan')); ?>">Sambutan</a>
                            <a href="<?php echo e(route('sejarah')); ?>">Sejarah & Visi Misi</a>
                            <a href="<?php echo e(route('struktur')); ?>">Struktur Organisasi</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo e(route('ais')); ?>">Akademik</a>
                        <div class="dropdown-content">
                            <a href="<?php echo e(route('ais')); ?>" class="akademik-item"><span class="ak-prefix">AIS</span><span class="ak-prefix">Accounting Information System</span></a>
                            <a href="<?php echo e(route('ase')); ?>" class="akademik-item"><span class="ak-prefix">ASE</span><span class="ak-prefix">Application Software Engineering</span></a>
                            <a href="<?php echo e(route('oaa')); ?>" class="akademik-item"><span class="ak-prefix">OAA</span><span class="ak-prefix">Office Administration</span></a>
                        </div>
                    </li>
                    <li><a href="<?php echo e(route('penempatan')); ?>">Pusat Karir</a></li>
                </ul>

                <div class="nav-auth">
                    <a href="<?php echo e(route('pendaftar.login')); ?>" class="login-btn">Login</a>
                    <a href="<?php echo e(route('mahasiswa.create')); ?>" class="register-btn"><i class="fas fa-user-plus"></i> Daftar Sekarang</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="page">
        <div class="structure-title">
            <h1>STRUKTUR ORGANISASI PERGURUAN TINGGI
                <span class="lp3i-blue">Lp3i College Karawang</span>
            </h1>
        </div><br><br>
        <div class="banner"><img src="<?php echo e(asset('storage/image/Map_Organisasi.png')); ?>" alt="Peta Organisasi"></div>

        <!-- org tree will render below -->
            <div class="org-tree">
                <?php
                    $strukturs = \App\Http\Controllers\StrukturOrganisasiController::getOrgData();
                ?>

                <?php if($strukturs['director']): ?>
                <div class="center-card">
                    <div class="person-card director">
                        <img src="<?php echo e($strukturs['director']->foto ? Storage::url($strukturs['director']->foto) : asset('storage/image/directur.jpg')); ?>" alt="<?php echo e($strukturs['director']->nama); ?>">
                        <h3><?php echo e($strukturs['director']->nama); ?></h3>
                        <div class="role"><?php echo e($strukturs['director']->role); ?></div>
                    </div>
                    
                    <?php
                        $subordinatesDirector = $strukturs['staffByParent']->get($strukturs['director']->id) ?? collect();
                    ?>
                    
                    <?php if($subordinatesDirector->count() > 0): ?>
                    <div style="margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.8rem; justify-content: center;">
                        <?php $__currentLoopData = $subordinatesDirector; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="person-card subordinate">
                            <img src="<?php echo e($sub->foto ? Storage::url($sub->foto) : asset('storage/image/Pemimpin.jpg')); ?>" alt="<?php echo e($sub->nama); ?>" style="width: 100px; height: 100px;">
                            <h3 style="font-size: 0.9rem;"><?php echo e($sub->nama); ?></h3>
                            <div class="role" style="font-size: 0.8rem;"><?php echo e($sub->role); ?></div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if($strukturs['secretary']): ?>
                <div class="center-card-sub">
                    <div class="person-card subordinate">
                        <img src="<?php echo e($strukturs['secretary']->foto ? Storage::url($strukturs['secretary']->foto) : asset('storage/image/Pemimpin.jpg')); ?>" alt="<?php echo e($strukturs['secretary']->nama); ?>">
                        <h3><?php echo e($strukturs['secretary']->nama); ?></h3>
                        <div class="role"><?php echo e($strukturs['secretary']->role); ?></div>
                    </div>
                    
                    <?php
                        $subordinatesSecretary = $strukturs['staffByParent']->get($strukturs['secretary']->id) ?? collect();
                    ?>
                    
                    <?php if($subordinatesSecretary->count() > 0): ?>
                    <div style="margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.8rem; justify-content: flex-end;">
                        <?php $__currentLoopData = $subordinatesSecretary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="person-card subordinate">
                            <img src="<?php echo e($sub->foto ? Storage::url($sub->foto) : asset('storage/image/Pemimpin.jpg')); ?>" alt="<?php echo e($sub->nama); ?>" style="width: 100px; height: 100px;">
                            <h3 style="font-size: 0.9rem;"><?php echo e($sub->nama); ?></h3>
                            <div class="role" style="font-size: 0.8rem;"><?php echo e($sub->role); ?></div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                
                <?php if(!empty($strukturs['heads']) && $strukturs['heads']->count() > 0): ?>
                <div class="grid">
                    <?php $__currentLoopData = $strukturs['heads']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $head): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div class="person-card">
                            <img src="<?php echo e($head->foto ? Storage::url($head->foto) : asset('storage/image/Pemimpin.jpg')); ?>" alt="<?php echo e($head->nama); ?>">
                            <h3><?php echo e($head->nama); ?></h3>
                            <div class="role"><?php echo e($head->role); ?></div>
                        </div>
                        
                        <?php
                            $children = $strukturs['staffByParent']->get($head->id) ?? collect();
                        ?>
                        
                        <?php if($children->count() > 0): ?>
                            <?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="person-card" style="border: 2px solid rgba(64,130,109,0.15); padding: 16px; min-height: auto;">
                                <img src="<?php echo e($sub->foto ? Storage::url($sub->foto) : asset('storage/image/Pemimpin.jpg')); ?>" alt="<?php echo e($sub->nama); ?>" style="width: 120px; height: 120px;">
                                <h3 style="font-size: 0.95rem;"><?php echo e($sub->nama); ?></h3>
                                <div class="role" style="font-size: 0.85rem;"><?php echo e($sub->role); ?></div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                
                <?php
                    $headIds = collect($strukturs['heads'] ?? [])->pluck('id')->all();
                    $orphans = $strukturs['staff']->filter(function($s) use ($headIds, $strukturs){
                        $hasParent = $strukturs['staffByParent']->contains(function($collection, $parentId) use ($s){
                            return $collection->contains('id', $s->id);
                        });
                        return !$s->parent_id && !in_array($s->id, $headIds) && !$hasParent;
                    });
                ?>
                <?php if($orphans->count() > 0): ?>
                <div style="margin-top: 3rem; display: flex; flex-wrap: wrap; gap: 2rem; justify-content: center;">
                    <?php $__currentLoopData = $orphans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="person-card" style="border: 2px solid rgba(64,130,109,0.15); width: 260px;">
                        <img src="<?php echo e($staff->foto ? Storage::url($staff->foto) : asset('storage/image/Pemimpin.jpg')); ?>" alt="<?php echo e($staff->nama); ?>">
                        <h3><?php echo e($staff->nama); ?></h3>
                        <div class="role"><?php echo e($staff->role); ?></div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

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
<?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/struktur.blade.php ENDPATH**/ ?>