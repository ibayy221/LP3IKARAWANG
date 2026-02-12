<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Pendaftar - Smart Presenter</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    :root{--basic:#004269;--adv:#40826D;--muted:#6b7280}
    body{font-family:'Poppins',sans-serif;background:linear-gradient(180deg,var(--basic) 0%, rgba(0,66,105,0.10) 30%, #f6f9fc 100%);color:#0f172a}
    .wrap{max-width:1200px;margin:1.5rem auto;padding:1rem}
    .card{background:#fff;padding:.75rem;border-radius:10px;box-shadow:0 6px 24px rgba(15,23,42,0.06);border:1px solid #e6eef6}

    /* Desktop/Mobile defaults: hide mobile-only on desktop, show desktop-only */
    .desktop-only{display:block}
    .mobile-only{display:none}
    .mobile-actions{display:none}

    /* Page header (blue background like other pages) */
    .page-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;padding:.6rem 1rem;border-radius:10px;background:linear-gradient(90deg,var(--basic),var(--adv));color:#fff}
    .page-header h1{margin:0;font-size:1.15rem;color:#fff}
    .page-header p.subtitle{margin:4px 0 0;font-size:.95rem;color:rgba(255,255,255,0.85);font-weight:400}
    /* Compact Add button */
    .page-header .actions a.btn{background:linear-gradient(90deg,var(--adv),var(--basic));color:#fff;padding:.32rem .6rem;border-radius:10px;font-size:.92rem;display:inline-flex;align-items:center;gap:.6rem;border:none;box-shadow:0 6px 18px rgba(64,130,109,0.12)}
    .page-header .actions a.btn .plus{display:inline-block;width:20px;height:20px;border-radius:50%;background:#fff;color:var(--basic);font-weight:700;line-height:20px;text-align:center;font-size:12px}

    /* Remove underlines globally for in-dashboard links/buttons */
    a, a.btn, .action-btn, .menu button{ text-decoration:none; }

    /* Controls: Poppins font for filter controls */
    .controls .form-control{height:44px;padding:.5rem;border-radius:10px;border:1.5px solid #e6eef6;background:#fff;font-family:'Poppins',sans-serif;font-weight:500;box-shadow:0 1px 0 rgba(2,6,23,0.02)} 

    /* Banner */
    .banner-wrap{margin-bottom:1rem}
    .bg-hero{height:100px;border-radius:8px;background-size:cover;background-position:center;box-shadow:0 4px 16px rgba(15,23,42,0.04);opacity:0.95}

    /* Controls */
    .controls{display:flex;flex-wrap:wrap;gap:.5rem;align-items:center;margin-bottom:.75rem}
    .controls .form-control{height:40px;padding:.6rem;border-radius:8px;border:1px solid #eef2f7;font-family:'Poppins',sans-serif;font-weight:500}
    .controls .btn{padding:.5rem .7rem;border-radius:10px;background:linear-gradient(90deg,var(--basic),var(--adv));color:#fff;border:none;font-size:0.92rem}
    .controls .btn:hover{filter:brightness(1.03);transform:translateY(-2px)}
    .controls .btn-small{padding:.36rem .5rem;font-size:.85rem}

    /* Unified button sizing: consistent min-width and height so buttons don't resize with text */
    .page-header .actions a.btn, .controls .btn, .controls .btn-small { min-width:120px; height:44px; display:inline-flex; align-items:center; justify-content:center; box-sizing:border-box; }
    /* Desktop action links (print/export) use same sizing and visual style */
    a#btn-print, a#btn-export, a.btn.btn-small.desktop-only { min-width:120px; height:44px; display:inline-flex; align-items:center; justify-content:center; }

    /* Table */
    table{width:100%;border-collapse:collapse;font-size:0.92rem}
    thead th{padding:.6rem .75rem;border-bottom:1px solid #e6eef6;text-transform:uppercase;font-size:.78rem;color:var(--muted)}
    tbody td{padding:.6rem .75rem;border-bottom:1px solid #f1f5f9;vertical-align:middle}

    /* Cells: enforce single row & truncate */
    .cell{max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .cell-email{max-width:220px}
    .cell-jurusan{max-width:120px}
    .cell-no{max-width:120px}
    .cell-source{max-width:120px}

    /* Status badge */
    .badge{display:inline-flex;align-items:center;gap:.4rem;padding:.18rem .5rem;border-radius:12px;font-size:.82rem}
    .badge.pending{background:#fff7ed;color:#b45309;border:1px solid #fde68a}
    .badge.verified{background:#ecfdf5;color:#065f46;border:1px solid #bbf7d0}
    .badge.rejected{background:#fff1f2;color:#7f1d1d;border:1px solid #fecaca}

    /* Actions */
    .actions{display:flex;align-items:center;gap:.4rem}
    .action-btn{background:#fff;border:1px solid #e6eef6;padding:.38rem .6rem;border-radius:8px;cursor:pointer}
    .action-primary{background:linear-gradient(90deg,var(--basic),var(--adv));color:#fff;border:none;box-shadow:0 8px 20px rgba(0,66,105,0.08)} 
    .action-menu{position:relative}
    .menu{position:absolute;right:0;top:calc(100% + 8px);background:#fff;border:1px solid #eef2f7;border-radius:8px;box-shadow:0 8px 24px rgba(15,23,42,0.08);display:none;min-width:160px;padding:.4rem;z-index:40}
    .menu button{width:100%;text-align:left;padding:.45rem .6rem;border:none;background:transparent;border-radius:6px}
    .menu button:hover{background:#f8fafc}

    /* Responsive */
    @media (max-width:900px){
      .cell{max-width:140px}
      .controls{gap:.4rem}
    }

    /* Mobile (compact) improvements */
    @media (max-width:768px){
      /* Compact header */
      .page-header{padding:.4rem .6rem;border-radius:8px}
      .page-header h1{font-size:1rem}
      .page-header p.subtitle{font-size:.85rem}
      .page-header .actions{flex-direction:column;align-items:flex-end;gap:6px}
      .page-header .actions a.btn{padding:.32rem .45rem;font-size:.82rem;width:auto}

      /* Filters stacked full width */
      .controls{flex-direction:column;align-items:stretch}
      .controls .form-control{width:100%;font-size:.95rem}
      .controls .btn{width:auto;padding:.38rem .5rem}
      .controls .btn-small{padding:.28rem .4rem;font-size:.8rem}

      /* Mobile actions button visible; hide desktop print/export */
      .mobile-actions{display:block}
      .desktop-only{display:none}

      /* Table hidden on mobile, cards shown */
      .desktop-only{display:none}
      .mobile-only{display:block}
      #pendaftar-cards{display:block;margin-bottom:12px}
      .mobile-card{background:#fff;border-radius:10px;padding:.65rem;margin-bottom:.75rem;box-shadow:0 6px 18px rgba(15,23,42,0.04);display:flex;justify-content:space-between;align-items:center;gap:.6rem}
      .mobile-card .left{display:flex;flex-direction:column;gap:.18rem}
      .mobile-card .name{font-weight:700;color:#022e43;font-size:0.98rem}
      .mobile-card .meta{font-size:.85rem;color:#586d7a}
      .mobile-card .right{display:flex;flex-direction:column;align-items:flex-end;gap:.4rem}
      .mobile-card .action-btn{padding:.34rem .5rem;border-radius:8px;font-size:.82rem}

      .mobile-card-detail{padding:.6rem;border-top:1px dashed #eef2f7;background: #fff;margin-bottom:.8rem;border-radius:0 0 10px 10px;max-height:0;overflow:hidden;opacity:0;transition:max-height .32s ease, opacity .28s ease}
      .mobile-card-detail.open{max-height:800px;opacity:1}

      /* Hide desktop action menu within card on mobile */
      .mobile-card .action-menu{display:none}

      /* Reduce table spacing if shown with small width fallback */
      table{font-size:0.9rem}
    }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="page-header">
      <div>
        <h1>Smart Presenter</h1>
        <p class="subtitle">Student data management</p>
      </div>
      <div class="actions">
        <a class="btn" href="<?php echo e(route('marketing.pendaftar.create')); ?>"><span class="plus">+</span> Add</a>
        
      </div>
    </div>

    <div class="banner-wrap">
      <div class="bg-hero" style="background-image:url('<?php echo e(!empty($registrationImageUrl) ? asset(ltrim($registrationImageUrl,'/')) : asset('storage/illustrations/registration-illustration.svg')); ?>')"></div>
    </div>

    <div class="controls">
      <input id="search" class="form-control" placeholder="Search email or name..." />
      <select id="filter-status" class="form-control">
        <option value="">All status</option>
        <option value="pending">Waiting for verification</option>
        <option value="verified">verified</option>
        <option value="rejected">declined</option>
      </select>
      <select id="filter-jurusan" class="form-control">
        <option value="">All study program</option>
        <?php $__currentLoopData = ($jurusans ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($j); ?>"><?php echo e($j); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>

      
      <div style="display:flex;gap:.5rem;align-items:center">
        <button class="btn btn-small" id="btn-search">Serch</button>
         <form id="delete-all-form" method="POST" action="<?php echo e(route('marketing.pendaftar.destroyAll')); ?>" style="display:inline">
          <?php echo csrf_field(); ?>
          <?php echo method_field('DELETE'); ?>
          <button class="btn btn-small desktop-only" id="btn-delete-all" style="background:#ef4444;border:none" onclick="return confirm('Yakin ingin menghapus SEMUA pendaftar? Hanya untuk pengembangan.');">Delet All</button>
        </form>
        <a class="btn btn-small desktop-only" id="btn-print" href="#">Print</a>
        <a  id="btn-export" href="#"></a>

       
        
        

        <!-- Mobile actions dropdown -->
        <div class="mobile-actions" style="position:relative;display:none">
          <button id="mobile-actions-btn" class="btn btn-small">⋮</button>
          <div id="mobile-actions-menu" class="menu" style="display:none;position:absolute;right:0;top:calc(100% + 6px);background:#fff;border:1px solid #eef2f7;border-radius:8px;padding:.4rem;box-shadow:0 8px 24px rgba(15,23,42,0.08);z-index:50">
            <button id="mobile-print" style="display:block;padding:.45rem .6rem;border:none;background:transparent;text-align:left">Print</button>
            <button id="mobile-export" style="display:block;padding:.45rem .6rem;border:none;background:transparent;text-align:left">Export</button>
            <button id="mobile-delete-all" style="display:block;padding:.45rem .6rem;border:none;background:transparent;text-align:left;color:#b91c1c">Hapus Semua (dev)</button>
            <form id="delete-all-form-mobile" method="POST" action="<?php echo e(route('marketing.pendaftar.destroyAll')); ?>" style="display:none"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?></form>
          </div>
        </div>
      </div>
    </div>

    <div id="filter-info" class="filter-info" style="display:none;margin-top:.5rem;color:#586d7a;font-size:.95rem">showing applicant with selected filter</div>
    <div id="fetch-error" style="display:none;margin-top:.5rem;color:#b91c1c;font-size:.95rem"></div> 

    <div class="card">
      <div id="pendaftar-cards" class="mobile-only"></div>
      <div class="desktop-only">
        <table id="pendaftar-table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>NIPD</th>
            <th>No HP</th>
            <th>Bidang Keahlian</th>
            <th>Tanggal Daftar</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="pendaftar-body">
          <tr><td colspan="8" style="text-align:center;color:#666;padding:1.5rem">Memuat…</td></tr>
        </tbody>
      </table>
      </div>
    </div>
  </div>

  <script>
    async function fetchPendaftar() {
      const fd = new FormData();
      fd.append('q', document.getElementById('search').value || '');
      fd.append('status', document.getElementById('filter-status').value || '');
      fd.append('jurusan', document.getElementById('filter-jurusan').value || '');
      const res = await fetch('<?php echo e(route('marketing.pendaftar.list')); ?>', { method: 'POST', body: fd, headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' } });
      const js = await res.json();
      const body = document.getElementById('pendaftar-body');
      const cardsDiv = document.getElementById('pendaftar-cards');
      if (!js.success) {
        // show error message from server or a generic string
        document.getElementById('fetch-error').textContent = js.error || 'Gagal memuat data. Silakan periksa koneksi atau login.';
        document.getElementById('fetch-error').style.display = 'block';
        body.innerHTML = '<tr><td colspan="7" style="text-align:center;color:#666;padding:1.5rem">Gagal memuat data.</td></tr>';
        if (cardsDiv) { cardsDiv.innerHTML = '<div style="text-align:center;color:#666;padding:1rem">Gagal memuat data.</div>'; cardsDiv.style.display = 'none'; }
        document.getElementById('filter-info').style.display = 'none';
        return;
      }

      if (!js.data || js.data.length === 0) {
        body.innerHTML = '<tr><td colspan="8" style="text-align:center;color:#666;padding:1.5rem">Belum ada data.</td></tr>';
        if (cardsDiv) { cardsDiv.innerHTML = '<div style="text-align:center;color:#666;padding:1rem">Belum ada data.</div>'; cardsDiv.style.display = 'none'; }
        document.getElementById('filter-info').style.display = 'none';
        return;
      }
      body.innerHTML = '';
      if (cardsDiv) { cardsDiv.innerHTML = ''; cardsDiv.style.display = ''; }
      // show filter info if user used filters
      function isFilterActive(){ return (document.getElementById('search').value || document.getElementById('filter-status').value || document.getElementById('filter-jurusan').value); }
      const info = document.getElementById('filter-info'); if (info) { info.style.display = isFilterActive() ? 'block' : 'none'; info.textContent = isFilterActive() ? 'Menampilkan pendaftar dengan filter yang dipilih' : 'Menampilkan semua pendaftar'; }

      function translateStatus(s){
        s = (s||'pending').toLowerCase();
        if (s === 'verified') return 'Sudah terverifikasi';
        if (s === 'rejected') return 'Ditolak';
        return 'Menunggu verifikasi';
      }

      js.data.forEach(item => {
        const tr = document.createElement('tr');
        const date = item.created_at ? new Date(item.created_at).toLocaleDateString('id-ID') : null;
        const statusKey = (item.status_verifikasi||'pending').toLowerCase();
        const statusClass = 'status-' + statusKey;
        const statusLabel = translateStatus(statusKey);
        // compute short badge and jurusan abbreviation
        function badgeText(key){ if(!key) return 'Pending'; key = key.toLowerCase(); if(key==='verified') return 'Verified'; if(key==='rejected') return 'Rejected'; return 'Pending'; }
        function abbrev(s){
          if(!s) return '';
          const words = s.trim().split(/\s+/);
          const initials = words.map(w => (w[0] || '')).join('').toUpperCase();
          if (initials.length >= 3) return initials.slice(0,3);
          const compact = s.replace(/\s+/g,'').toUpperCase();
          if (compact.length >= 3) return compact.slice(0,3);
          return compact; // fallback when shorter than 3
        }
        const jurusanShort = item.jurusan ? abbrev(item.jurusan) : '';
        const badge = badgeText(statusKey);

        const safe = v => (v ? v : '-');
        tr.innerHTML = `
          <td><div class="cell" title="${safe(item.nama_mhs)}">${safe(item.nama_mhs)}</div></td>
          <td><div class="cell cell-email" title="${safe(item.email)}">${safe(item.email)}</div></td>
          <td><div class="cell" title="${safe(item.nipd)}">${safe(item.nipd)}</div></td>
          <td><div class="cell cell-no" title="${safe(item.no_hp)}">${safe(item.no_hp)}</div></td>
          <td><div class="cell cell-jurusan" title="${safe(item.jurusan)}">${jurusanShort || '-'}</div></td>
          <td><div class="cell" title="${date || '-'}">${date || '-'}</div></td>
          <td><span class="badge ${statusKey}">${statusLabel}</span></td>
          <td>
              <div class="actions">
                <a class="action-btn action-primary" href="<?php echo e(url('/marketing/pendaftar')); ?>/${item.id}">Detail</a>
                <div class="action-menu">
                  <button class="action-btn" onclick="toggleMenu(this)">•••</button>
                  <div class="menu">
                    <button onclick="changeStatus(${item.id}, 'verified')">Verifikasi</button>
                    <button onclick="changeStatus(${item.id}, 'rejected')">Tolak</button>
                    <div style="height:1px;background:#eef2f7;margin:.4rem 0"></div>
                  </div>
                </div>
              </div>
            </td>
        `; 
        body.appendChild(tr);

        // build mobile card with Aksi dropdown
        if (cardsDiv) {
          const card = document.createElement('div'); card.className = 'mobile-card';
          const left = document.createElement('div'); left.className = 'left';
          const name = document.createElement('div'); name.className = 'name'; name.textContent = safe(item.nama_mhs);
          const meta = document.createElement('div'); meta.className = 'meta'; meta.textContent = (jurusanShort || '-') + ' • ' + statusLabel;
          left.appendChild(name); left.appendChild(meta);

          const right = document.createElement('div'); right.className = 'right';
          const expandBtn = document.createElement('button'); expandBtn.className = 'action-btn'; expandBtn.textContent = '⋮'; expandBtn.onclick = function(e){ e.stopPropagation(); toggleExpand(card); };
          right.appendChild(expandBtn);

          card.appendChild(left); card.appendChild(right);
          cardsDiv.appendChild(card);

          // create detail section (hidden) below card
          const detail = document.createElement('div'); detail.className = 'mobile-card-detail'; detail.style.maxHeight = '0px'; detail.style.overflow = 'hidden'; detail.style.opacity = '0';
          detail.innerHTML = `
            <div style="padding-top:.5rem;font-size:.95rem;color:#334155">
              <div><strong>Email:</strong> ${safe(item.email)}</div>
              <div><strong>NIPD:</strong> ${safe(item.nipd)}</div>
              <div><strong>No HP:</strong> ${safe(item.no_hp)}</div>
              <div><strong>Tanggal:</strong> ${date || '-'}</div>
              
              <div style="margin-top:.5rem;display:flex;gap:.5rem;flex-wrap:wrap">
                <button class="action-btn" onclick="changeStatus(${item.id}, 'verified')">Verifikasi</button>
                <button class="action-btn" onclick="changeStatus(${item.id}, 'rejected')">Tolak</button>
                <button class="action-btn" onclick="markPaid(${item.id})">Tandai Bayar</button>
                <a href="<?php echo e(url('/marketing/pendaftar')); ?>/${item.id}/ktp" class="action-btn">Download KTP</a>
                <a href="<?php echo e(url('/marketing/pendaftar')); ?>/${item.id}/ijazah" class="action-btn">Download Ijazah</a>
                <a href="<?php echo e(url('/marketing/pendaftar')); ?>/${item.id}/akte" class="action-btn">Download Akte</a>
                <a href="<?php echo e(url('/marketing/pendaftar')); ?>/${item.id}/surat-bekerja" class="action-btn">Download Surat</a>
              </div>
            </div>
          `;
          cardsDiv.appendChild(detail);

          // toggle card expand when tapping card body
          card.addEventListener('click', function(){ toggleExpand(card); });
        }
      });
    }

    function toggleExpand(card){
      const next = card.nextElementSibling;
      if(!next || !next.classList.contains('mobile-card-detail')) return;
      const expandBtn = card.querySelector('.action-btn');

      // close any other open details
      document.querySelectorAll('.mobile-card-detail.open').forEach(d => {
        if (d !== next) {
          d.classList.remove('open');
          d.style.maxHeight = '0px';
          d.style.opacity = '0';
          const b = d.previousElementSibling ? d.previousElementSibling.querySelector('.action-btn') : null;
          if (b) b.textContent = '⋮';
        }
      });

      const isOpen = next.classList.toggle('open');
      if (isOpen) {
        // animate open
        next.style.maxHeight = next.scrollHeight + 'px';
        next.style.opacity = '1';
        if (expandBtn) expandBtn.textContent = 'Lihat detail';
        // after transition set to 'Tutup'
        const handler = function(e){ if (e.propertyName === 'max-height') { if (expandBtn) expandBtn.textContent = 'Tutup'; next.removeEventListener('transitionend', handler); } };
        next.addEventListener('transitionend', handler);
        // ensure visible
        setTimeout(()=>{ next.scrollIntoView({behavior:'smooth', block:'start'}); }, 120);
      } else {
        // animate close
        next.style.maxHeight = '0px';
        next.style.opacity = '0';
        if (expandBtn) expandBtn.textContent = '⋮';
      }
    }

    // Mobile actions dropdown handlers
    document.getElementById('mobile-actions-btn').addEventListener('click', function(e){ e.stopPropagation(); const m = document.getElementById('mobile-actions-menu'); m.style.display = (m.style.display === 'block') ? 'none' : 'block'; });
    document.getElementById('mobile-print').addEventListener('click', function(){ const q=document.getElementById('search').value||''; const s=document.getElementById('filter-status').value||''; const j=document.getElementById('filter-jurusan').value||''; window.open('<?php echo e(route('marketing.pendaftar.print')); ?>?q='+encodeURIComponent(q)+'&status='+encodeURIComponent(s)+'&jurusan='+encodeURIComponent(j),'_blank'); });
    document.getElementById('mobile-export').addEventListener('click', function(){ const q=document.getElementById('search').value||''; const s=document.getElementById('filter-status').value||''; const j=document.getElementById('filter-jurusan').value||''; window.location = '<?php echo e(route('marketing.pendaftar.export')); ?>?q='+encodeURIComponent(q)+'&status='+encodeURIComponent(s)+'&jurusan='+encodeURIComponent(j); });
    document.getElementById('mobile-delete-all').addEventListener('click', function(){ if(!confirm('Yakin ingin menghapus SEMUA pendaftar? Hanya untuk pengembangan.')) return; document.getElementById('delete-all-form-mobile').submit(); });

    async function changeStatus(id, status) {
      const labels = { verified: 'Sudah terverifikasi', rejected: 'Ditolak', pending: 'Menunggu verifikasi' };
      const label = labels[status] || status;
      if (!confirm('Ubah status pendaftar ini menjadi "' + label + '"?')) return;
      const fd = new FormData(); fd.append('id', id); fd.append('status', status);
      const res = await fetch('<?php echo e(route('marketing.pendaftar.update')); ?>', { method: 'POST', body: fd, headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' } });
      const js = await res.json();
      if (js.success) { alert('Status berhasil diperbarui'); fetchPendaftar(); } else { alert('Error: ' + (js.error || 'server error')); }
    }

    // Search & controls
    document.getElementById('btn-search').addEventListener('click', function(e){ e.preventDefault(); fetchPendaftar(); });
    document.getElementById('btn-export').addEventListener('click', function(e){ e.preventDefault(); const q=document.getElementById('search').value||''; const s=document.getElementById('filter-status').value||''; const j=document.getElementById('filter-jurusan').value||''; window.location = '<?php echo e(route('marketing.pendaftar.export')); ?>?q='+encodeURIComponent(q)+'&status='+encodeURIComponent(s)+'&jurusan='+encodeURIComponent(j); });
    document.getElementById('btn-print').addEventListener('click', function(e){ e.preventDefault(); const q=document.getElementById('search').value||''; const s=document.getElementById('filter-status').value||''; const j=document.getElementById('filter-jurusan').value||''; window.open('<?php echo e(route('marketing.pendaftar.print')); ?>?q='+encodeURIComponent(q)+'&status='+encodeURIComponent(s)+'&jurusan='+encodeURIComponent(j),'_blank'); });

    async function markPaid(id){
      if (!confirm('Tandai pendaftar ini sudah membayar?')) return;
      const fd = new FormData(); fd.append('payment','paid');
      const res = await fetch('<?php echo e(url('/marketing/pendaftar')); ?>/'+id+'/payment', { method:'POST', body: fd, headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' } });
      const js = await res.json();
      if (js.success) { alert('Status pembayaran diperbarui'); fetchPendaftar(); } else { alert('Error: '+(js.error||'server error')); }
    }

    function toggleMenu(button){
      // close other menus
      document.querySelectorAll('.menu').forEach(m=>{ if (m !== button.nextElementSibling) m.style.display='none'; });
      const menu = button.nextElementSibling; if(!menu) return; menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }

    // close menus when clicking outside
    document.addEventListener('click', function(e){ if(!e.target.closest('.action-menu')){ document.querySelectorAll('.menu').forEach(m=>m.style.display='none'); } });

    // search on Enter
    document.getElementById('search').addEventListener('keydown', function(e){ if(e.key === 'Enter'){ e.preventDefault(); fetchPendaftar(); } });

    document.getElementById('btn-search').addEventListener('click', function(e){ e.preventDefault(); fetchPendaftar(); });
    document.getElementById('btn-export').addEventListener('click', function(e){ e.preventDefault(); const q=document.getElementById('search').value||''; const s=document.getElementById('filter-status').value||''; const j=document.getElementById('filter-jurusan').value||''; window.location = '<?php echo e(route('marketing.pendaftar.export')); ?>?q='+encodeURIComponent(q)+'&status='+encodeURIComponent(s)+'&jurusan='+encodeURIComponent(j); });
    document.getElementById('btn-print').addEventListener('click', function(e){ e.preventDefault(); const q=document.getElementById('search').value||''; const s=document.getElementById('filter-status').value||''; const j=document.getElementById('filter-jurusan').value||''; window.open('<?php echo e(route('marketing.pendaftar.print')); ?>?q='+encodeURIComponent(q)+'&status='+encodeURIComponent(s)+'&jurusan='+encodeURIComponent(j),'_blank'); });

    document.addEventListener('DOMContentLoaded', function(){ try { fetchPendaftar(); } catch (e) { document.getElementById('fetch-error').textContent = 'Gagal memuat daftar pendaftar. Silakan muat ulang atau periksa koneksi.'; document.getElementById('fetch-error').style.display = 'block'; } });
  </script>
</body>
</html><?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/marketing/pendaftar/index.blade.php ENDPATH**/ ?>