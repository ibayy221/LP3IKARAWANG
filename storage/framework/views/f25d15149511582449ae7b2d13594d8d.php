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
        .wrap{max-width:1100px;margin:0 auto;padding:1.5rem}
        .card{background:linear-gradient(180deg,#ffffff,#f8fbff);border-radius:16px;padding:2.25rem;box-shadow:0 18px 50px rgba(15,23,42,0.08);border:1px solid rgba(2,6,23,0.04)}
        .article{column-count:2;column-gap:2.5rem;column-rule:1px solid rgba(2,6,23,0.06)}
        .article > *{break-inside:avoid}
        h1{margin:0 0 0.8rem 0;color:var(--brand-dark);font-size:1.8rem}
        h1{column-span:all}
		h2{color:var(--brand-dark);font-size:1.15rem;margin:1.25rem 0 0.6rem}
		h3{color:var(--brand-dark);font-size:1rem;margin:1rem 0 0.4rem}
        p{margin:0 0 0.8rem 0;color:#16383a}
        p{line-height:1.7;text-align:justify}
        ul{margin:0 0 0.8rem 1.1rem;color:#16383a}
        .prospects li{margin:0.45rem 0}
        figure{margin:0 0 1.2rem 0}
        figure .article-img{width:100%;border-radius:12px;box-shadow:0 12px 30px rgba(2,6,23,0.08);object-fit:cover;display:block}
        figure figcaption{margin-top:0.5rem;font-size:0.85rem;color:#445;opacity:0.85}
        @media (max-width:900px){
            .card{padding:1.5rem}
            .article{column-count:1;column-rule:none}
            p{text-align:left}
        }
    </style>
</head>
<body>
	<?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<div class="wrap">
		<div class="card">
			<div class="article">
				<h1>D3 Accounting Information System</h1>

				<h2>Peminatan</h2>
				<p>Digital Marketing, Marketing Administration</p>

				<h2>Profil Lulusan</h2>
				<p>Menjadi tenaga Madya Profesional yang memiliki kemampuan di bidang manajemen pemasaran serta mampu menerapkan ilmu pemasaran produk baik barang maupun jasa serta mewujudkan lulusan pemasaran digital yang unggul dan berdaya saing pada tahun 2031.</p>

				<figure>
					<img class="article-img" src="<?php echo e(asset('storage/image/AIS.jpg')); ?>" alt="Program AIS" onerror="this.onerror=null;this.src='<?php echo e(asset('storage/image/AIS.png')); ?>'">
					<figcaption>Suasana perkuliahan dan praktik sistem informasi.</figcaption>
				</figure>

				<h2>Kompetensi</h2>
				<ul>
					<li>Mampu melakukan kegiatan menjual (selling skills) melalui proses menjual yang benar.</li>
					<li>Mampu melakukan pelayanan pelanggan (customer service) dengan konsep pelayanan prima.</li>
					<li>Mampu melakukan komunikasi bisnis dengan para stakeholder.</li>
					<li>Mampu melakukan promosi, periklanan, dan riset pemasaran.</li>
					<li>Mampu menerapkan pemasaran online dan penggunaan aplikasi digital untuk pemasaran.</li>
				</ul>

				<figure>
					<img class="article-img" src="<?php echo e(asset('storage/image/AIS2.jpg')); ?>" alt="Kegiatan akademik AIS" onerror="this.onerror=null;this.src='<?php echo e(asset('storage/image/AIS.png')); ?>'">
					<figcaption>Kolaborasi mahasiswa dalam proyek dan studi kasus.</figcaption>
				</figure>

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

				<figure>
					<img class="article-img" src="<?php echo e(asset('storage/image/AIS3.jpg')); ?>" alt="Aktivitas mahasiswa AIS" onerror="this.onerror=null;this.src='<?php echo e(asset('storage/image/AIS.png')); ?>'">
					<figcaption>Praktik komunikasi bisnis dan layanan pelanggan.</figcaption>
				</figure>

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
		</div>
	</div>
</body>
</html>

<?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/ais.blade.php ENDPATH**/ ?>