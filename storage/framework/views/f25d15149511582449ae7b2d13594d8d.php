<!doctype html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>D3 Accounting Information System</title>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--brand-dark:#004269;--brand-accent:#0b7280}
        *{box-sizing:border-box}
        body{margin:0;background:transparent}
        .wrap{max-width:1100px;margin:140px auto;padding:1rem}
        .grid{display:flex;gap:2rem;align-items:flex-start}
        .content{flex:1}
        .aside{margin-top: 30px;display:flex;flex-direction:column;align-items:center;justify-content:center}
        .card{background:linear-gradient(180deg,#ffffff,#f8fbff);border-radius:16px;padding:2.5rem;box-shadow:0 18px 50px rgba(15,23,42,0.08);border:1px solid rgba(2,6,23,0.04)}
        h1{margin:0 0 0.8rem 0;color:var(--brand-dark);font-size:1.8rem}
        h2{color:var(--brand-dark);font-size:1.15rem;margin:1.25rem 0 0.6rem}
        p{margin:0 0 0.8rem 0;color:#16383a}
        ul{margin:0 0 0.8rem 1.1rem;color:#16383a}
        .prospects li{margin:0.45rem 0}
        img.program-img{width:100%;max-width:420px;border-radius:12px;box-shadow:0 12px 30px rgba(2,6,23,0.08);object-fit:cover}
        @media (max-width:900px){.grid{flex-direction:column}.aside{order:2}.content{order:1}.img.program-img{width:70%}}
    </style>
</head>
<body>
	<?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<div class="wrap">
		<div class="card">
			<div class="grid">
				<div class="content">
					<h1>D3 Accounting Information System</h1>

					<h2>Profil Program Studi</h2>
					<p>Program studi AIS menghasilkan lulusan yang kompeten dalam mengelola sistem informasi akuntansi terutama pada bidang akuntansi perusahaan, perpajakan, dan sistem informasi manajemen.</p>

					<h2>Kompetensi</h2>
					<ul>
						<li>Mampu menyusun laporan keuangan sesuai standar akuntansi.</li>
						<li>Mampu mengoperasikan sistem informasi akuntansi dan software terkait.</li>
						<li>Mampu melakukan analisa keuangan dan laporan perpajakan.</li>
					</ul>

					<h2>Prospek Karir</h2>
					<ul class="prospects">
						<li>Staff Akuntansi</li>
						<li>Tax Consultant</li>
						<li>Finance Officer</li>
						<li>Accounting System Analyst</li>
					</ul>
				</div>
				<div class="aside">
					<img class="program-img" src="<?php echo e(asset('storage/image/AIS.jpg')); ?>" alt="Program AIS" onerror="this.onerror=null;this.src='<?php echo e(asset('storage/image/AIS.png')); ?>'">
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/ais.blade.php ENDPATH**/ ?>