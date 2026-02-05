<!doctype html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>D3 Office Administration automatization</title>
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
					<h1>D3 Office Administration automatization</h1>

					<h2>Peminatan</h2>
					<p>Digital Marketing, Marketing Administration</p>

					<h2>Profil Lulusan</h2>
					<p>Menjadi tenaga Madya Profesional yang memiliki kemampuan di bidang manajemen pemasaran serta mampu menerapkan ilmu pemasaran produk baik barang maupun jasa serta mewujudkan lulusan pemasaran digital yang unggul dan berdaya saing pada tahun 2031.</p>

					<h2>Kompetensi</h2>
					<ul>
						<li>Mampu melakukan kegiatan menjual (selling skills) melalui proses menjual yang benar.</li>
						<li>Mampu melakukan pelayanan pelanggan (customer service) dengan konsep pelayanan prima.</li>
						<li>Mampu melakukan komunikasi bisnis dengan para stakeholder.</li>
						<li>Mampu melakukan promosi, periklanan, dan riset pemasaran.</li>
						<li>Mampu menerapkan pemasaran online dan penggunaan aplikasi digital untuk pemasaran.</li>
					</ul>

					<h2>Capaian Pembelajaran Lulusan (CPL)</h2>
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
					<p>Pada tahun 2031 di tingkat Nasional menjadi program studi vokasi Manajemen Pemasaran yang unggul dan kompeten dalam bidang Pemasaran Digital.</p>

					<h2>Misi</h2>
					<ul>
						<li>Menyelenggarakan pendidikan berbasis vokasi dan link-and-match dengan industri.</li>
						<li>Menciptakan SDM profesional, berkarakter, dan berkompeten di bidang Digital Marketing.</li>
						<li>Melaksanakan penelitian terapan dan pengabdian kepada masyarakat.</li>
						<li>Menjalin kerjasama dengan industri, pemerintah, dan perguruan tinggi.</li>
						<li>Menyelenggarakan pendidikan terintegrasi berbasis teknologi informasi.</li>
						<li>Melaksanakan kegiatan sosial, kemanusiaan, dan keagamaan.</li>
					</ul>

					<h2>Tujuan</h2>
					<ul>
						<li>Mewujudkan kerjasama dengan perusahaan untuk merancang kurikulum berbasis industri.</li>
						<li>Menghasilkan lulusan profesional madya di bidang pemasaran berbasis TI.</li>
						<li>Menerapkan link-and-match melalui dosen profesional, sertifikasi, dan magang industri.</li>
						<li>Menghasilkan penelitian terapan yang tepat guna di bidang pemasaran.</li>
						<li>Menciptakan komunikasi dinamis antara dunia kerja dan industri untuk penyerapan lulusan.</li>
					</ul>

				</div>
				<div class="aside">
					<img class="program-img" src="<?php echo e(asset('storage/image/OAA.jpg')); ?>" alt="Program Manajemen Pemasaran" onerror="this.onerror=null;this.src='<?php echo e(asset('storage/image/OAA.png')); ?>'">
					<br>
					<br>
					<br>
					 <br>
					<br>
					<br>
					<img class="program-img" src="<?php echo e(asset('storage/image/OAA2.jpg')); ?>" alt="Program Manajemen Pemasaran" onerror="this.onerror=null;this.src='<?php echo e(asset('storage/image/OAA.png')); ?>'">
					<br>
					<br>
					<br>
					 <br>
					<br>
					<br>
					<img class="program-img" src="<?php echo e(asset('storage/image/OAA3.jpg')); ?>" alt="Program Manajemen Pemasaran" onerror="this.onerror=null;this.src='<?php echo e(asset('storage/image/OAA.png')); ?>'">
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/oaa.blade.php ENDPATH**/ ?>