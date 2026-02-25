<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Smart Presenter - Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    /* Page background + subtle gradient */
    body{font-family:'Poppins',sans-serif;background: linear-gradient(180deg,#f0f6fb 0%, #f8fafc 100%); color:#0f172a;}

    /* Wrap to contain content and watermark */
    .wrap{max-width:1100px;margin:3rem auto;padding:1.5rem;position:relative}
    /* Watermark moved to bottom-right and placed behind content (non-overlapping). Hidden on small screens. */
    .wrap::before{ content:''; position:absolute; right:-20px; bottom:-20px; width:260px; height:260px; background-image: url("<?php echo e(asset('storage/image/landingPage1.png')); ?>"); background-size:contain; background-repeat:no-repeat; opacity:0.05; pointer-events:none; filter:grayscale(60%); z-index:0; }
    .card{z-index:1}
    @media (max-width:768px){ .wrap::before{ display:none; } }

    /* Card styling: rounded, soft shadow, top accent */
    .card{background:#fff;padding:1.5rem;border-radius:16px;box-shadow:0 12px 36px rgba(15,23,42,0.08); position:relative; overflow:hidden}
    .card::before{ content:''; position:absolute; left:0; top:0; height:6px; width:100%; background: linear-gradient(90deg,#004269,#009DA5); border-top-left-radius:16px; border-top-right-radius:16px; }

    /* Header */
    .site-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;padding:.2rem 0}
    .site-header .title{font-size:1.15rem;color:#023b57;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .site-header .actions{display:flex;align-items:center;gap:.5rem}
    .site-header .hdr-btn{background:transparent;border:1px solid rgba(2,6,23,0.06);padding:.35rem .5rem;border-radius:8px;color:#023b57;cursor:pointer}
    .site-header .hdr-btn:hover{background:rgba(0,66,105,0.04)}
    .site-header .hdr-menu{position:relative}
    .site-header .hdr-menu .menu{position:absolute;right:0;top:calc(100% + 8px);background:#fff;border:1px solid #eef2f7;border-radius:8px;box-shadow:0 8px 24px rgba(15,23,42,0.08);display:none;min-width:160px;padding:.4rem;z-index:80}
    .site-header .hdr-menu .menu button{width:100%;text-align:left;padding:.45rem .6rem;border:none;background:transparent;border-radius:6px}

    .dashboard-header h1{ margin:0 0 .25rem 0; font-size:1.4rem; color:#023b57; font-weight:700; }
    .dashboard-header p.lead{ margin:0; color:#586d7a; font-size:.98rem; }

    @media (max-width:768px){ .stats{ grid-template-columns:1fr; } .wrap::before{ display:none; } .site-header{padding:.1rem 0} .site-header .title{font-size:0.98rem} .dashboard-header h1{ font-size:1.02rem } .site-header .actions{margin-left:.5rem} }

    /* Stats grid */
    .stats{ display:grid; grid-template-columns: repeat(3,1fr); gap:1rem; margin:1rem 0; }
    .stat-card{ background: linear-gradient(180deg,#fff,#fbfdff); border-radius:12px; padding:.9rem; display:flex; align-items:center; gap:.75rem; box-shadow: 0 6px 18px rgba(3, 53, 72, 0.04); border: 1px solid rgba(0,66,105,0.04); }
    .stat-icon{ width:48px; height:48px; border-radius:8px; display:flex; align-items:center; justify-content:center; background:linear-gradient(180deg,#00426910,#009DA520); color:#004269; }
    .stat-number{ font-size:1.1rem; font-weight:700; color:#022e43; }
    .stat-label{ font-size:.85rem; color:#586d7a; }

    .card-body p{ color:#334155; margin:0; }

    /* Buttons: pill, brand color, hover lift */
    .btn{ padding:.55rem .95rem; border-radius:999px; background:#004269; color:#fff; border:none; display:inline-block; text-decoration:none; box-shadow: 0 6px 18px rgba(0,66,105,0.08); transition: transform .12s ease, box-shadow .12s ease; }
    .btn:hover{ transform: translateY(-3px); box-shadow: 0 14px 28px rgba(0,66,105,0.12); }
    .btn:active{ transform:none; box-shadow: 0 6px 12px rgba(0,66,105,0.06); }

    /* Header menu small item */
    .hdr-btn{padding:.3rem .45rem;border-radius:8px;border:1px solid rgba(0,0,0,0.04);background:#fff}
    .hdr-btn:focus{outline:none;box-shadow:0 6px 18px rgba(0,66,105,0.06)}
    .hdr-menu .menu button{font-size:.95rem;padding:.5rem .65rem}

    /* Responsive tweaks */
    @media (max-width:768px){ .stats{ grid-template-columns:1fr; } .wrap::before{ display:none; } .dashboard-header h1{ font-size:1.35rem; } }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="site-header">
      <div class="title">Smart Presenter</div>
      <div class="actions">
        <div class="hdr-menu">
          <button id="hdr-actions-btn" class="hdr-btn">⋮</button>
          <div id="hdr-menu" class="menu" style="display:none;">
            <form method="POST" action="<?php echo e(url('/marketing/logout')); ?>"><?php echo csrf_field(); ?><button type="submit">Logout</button></form>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="dashboard-header">
        <h1>Dashboard</h1>
        <p class="lead">Manage prospective students, monitor enrollment performance, and follow up on leads efficiently.</p>
      </div>

      <div class="stats" aria-hidden="false">
        <div class="stat-card">
          <div class="stat-icon" aria-hidden="true">
            <!-- user/group icon -->
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 12c2.761 0 5-2.239 5-5s-2.239-5-5-5-5 2.239-5 5 2.239 5 5 5z" stroke="#004269" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" /><path d="M4 20c0-2.761 3.582-5 8-5s8 2.239 8 5" stroke="#004269" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" /></svg>
          </div>
          <div>
            <div class="stat-number"><?php echo e(number_format($totalPendaftar)); ?></div>
            <div class="stat-label">Total Pendaftar</div>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon" aria-hidden="true">
            <!-- book icon -->
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" stroke="#004269" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/><path d="M6 3h12v14H6z" stroke="#004269" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div>
            <div class="stat-number"><?php echo e($jurusanTerbanyak); ?></div>
            <div class="stat-label">Jurusan Terbanyak</div>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon" aria-hidden="true">
            <!-- calendar icon -->
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="16" rx="2" stroke="#004269" stroke-width="1.2"/><path d="M16 3v4M8 3v4" stroke="#004269" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <div>
            <div class="stat-number"><?php echo e($pendaftarToday); ?></div>
            <div class="stat-label">Today's Registrar</div>
          </div>
        </div>
      </div>

      <div class="card-body">
        <p>Welcome to Smart Presenter. Here you can manage your list of registrants..</p>
        <div style="text-align:center;margin-top:1rem">
          <a class="btn" href="<?php echo e(route('marketing.pendaftar.index')); ?>">Open applicant</a>
        </div>
      </div>
    </div>
  </div>
  <script>
    // Header actions menu
    document.getElementById('hdr-actions-btn').addEventListener('click', function(e){ e.stopPropagation(); const m = document.getElementById('hdr-menu'); m.style.display = (m.style.display === 'block') ? 'none' : 'block'; });
    document.addEventListener('click', function(e){ if(!e.target.closest('.hdr-menu')){ const m = document.getElementById('hdr-menu'); if(m) m.style.display = 'none'; } });
  </script>
</body>
</html><?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/marketing/dashboard.blade.php ENDPATH**/ ?>