<?php
	// Gather available poster images from public/upload/news
	$images = [];
	$dir = public_path('upload/news');
	if (is_dir($dir)) {
		foreach (scandir($dir) as $f) {
			if (in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp','gif'])) {
				$images[] = 'upload/news/' . $f;
			}
		}
	}
	// Prefer files that look like 'Cuplikan' or 'global' if available
	usort($images, function($a, $b){
		$p = ['Cuplikan','cuplikan','global','Global','poster','Poster'];
		$pa = 0; $pb = 0;
		foreach($p as $s) { if (strpos($a,$s)!==false) $pa+=2; if (strpos($b,$s)!==false) $pb+=2; }
		return $pb <=> $pa; // higher score first
	});

	// Fallback: if no images found, show placeholder
	if (empty($images)) {
		$images[] = 'https://via.placeholder.com/720x1020?text=Poster+Belum+Tersedia';
	}
?>

<!doctype html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Penempatan Kerja - LP3I Karawang</title>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
	<style>
		body{font-family:'Poppins',sans-serif;background:#f4f6f8;color:#123;margin:0;padding:2rem}
		.wrap{max-width:1100px;margin:0 auto}
		h1{color:#004269;margin-bottom:1rem}
		.grid{display:grid;grid-template-columns:1fr;gap:1.25rem}
		@media(min-width:900px){.grid{grid-template-columns:repeat(2,1fr)}}
		.card{background:white;border-radius:12px;padding:1rem;box-shadow:0 8px 28px rgba(2,6,23,0.06);display:flex;align-items:center;gap:1rem}
		.poster{flex:1;display:flex;align-items:center;justify-content:center}
		.poster img{max-width:100%;height:auto;border-radius:8px;box-shadow:0 10px 30px rgba(2,6,23,0.08)}
		.meta{width:320px;padding:0.5rem 1rem}
		.meta h3{margin:0 0 0.5rem;color:#0b7280}
		.meta p{margin:0 0 0.75rem;color:#556}
		.actions{display:flex;gap:0.5rem}
		.btn{background:#004269;color:#fff;padding:0.6rem 0.9rem;border-radius:8px;text-decoration:none;font-weight:600}
		.btn.secondary{background:#0b7280}
	</style>
</head>
<body>
	<div class="wrap">
		<h1>Bukti Penempatan Kerja</h1>
		<p style="color:#445;margin-bottom:1.25rem">Berikut beberapa bukti penempatan/kerja nyata alumni. Klik gambar untuk memperbesar atau tombol unduh untuk menyimpan poster.</p>

		<div class="grid">
			<?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="card">
					<div class="poster">
						<a href="<?php echo e((Str::startsWith($img, 'http') ? $img : asset($img))); ?>" target="_blank" rel="noopener">
							<img src="<?php echo e((Str::startsWith($img, 'http') ? $img : asset($img))); ?>" alt="Poster Penempatan">
						</a>
					</div>
					<div class="meta">
						<h3>Poster Penempatan</h3>
						<p>Poster ini menunjukkan bukti nyata alumni yang telah bekerja sebelum atau setelah lulus.</p>
						<div class="actions">
							<a class="btn" href="<?php echo e((Str::startsWith($img, 'http') ? $img : asset($img))); ?>" target="_blank" rel="noopener" download>Unduh</a>
							
						</div>
					</div>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>
</body>
</html>
<?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/penempatan.blade.php ENDPATH**/ ?>