<?php
	// Expecting `$images` to be passed from controller as a collection of Penempatan models.
	// If not provided or empty, we'll render an empty state (no uploads yet).
	$images = $images ?? [];
?>

<!doctype html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Penempatan Kerja - LP3I Karawang</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
	<style>
		:root { --basic: #004269; --adv: #40826D; --muted: #6b7280; }
		html { font-family: 'Poppins', sans-serif; }
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { font-family: 'Poppins', sans-serif; color: #0f172a; line-height: 1.6; background: linear-gradient(180deg, var(--basic) 0%, rgba(0,66,105,0.08) 28%, #f6f9fc 100%); padding-top: 200px; }
		@media (max-width: 768px) { body { padding-top: 240px; } }
		
		.wrap { max-width: 1200px; margin: 50px auto 0; padding: 2rem 1rem; }
		h1 { color: #004269; margin-bottom: 1.5rem; font-size: 2rem; font-weight: 700; }
		p { color: #445; font-size: 0.95rem; }
		
		.grid { display: grid; grid-template-columns: 1fr; gap: 1.5rem; }
		@media (min-width: 900px) { .grid { grid-template-columns: repeat(1, 1fr); } }
		
		.card { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 8px 28px rgba(2,6,23,0.06); display: flex; align-items: center; gap: 1.5rem; }
		@media (max-width: 768px) { .card { flex-direction: column; } }
		
		.poster { flex: 1; display: flex; align-items: center; justify-content: center; min-height: 250px; }
		.poster a { display: block; cursor: pointer; transition: transform 0.3s ease; }
		.poster a:hover { transform: scale(1.02); }
		.poster img { max-width: 100%; max-height: 300px; border-radius: 8px; box-shadow: 0 10px 30px rgba(2,6,23,0.08); object-fit: cover; }
		
		.meta { flex: 0 0 320px; padding: 0.5rem; }
		.meta h3 { margin: 0 0 0.75rem; color: #004269; font-size: 1.1rem; font-weight: 600; }
		.meta p { margin: 0 0 1.25rem; color: #556; font-size: 0.9rem; }
		
		.actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
		.btn { background: #004269; color: #fff; padding: 0.6rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.25s ease; display: inline-block; border: none; cursor: pointer; }
		.btn:hover { background: #003058; transform: translateY(-2px); box-shadow: 0 8px 16px rgba(0,66,105,0.15); }
		
		.modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); }
		.modal.show { display: flex; align-items: center; justify-content: center; }
		.modal-content { background-color: #fefefe; max-width: 95%; max-height: 90vh; border-radius: 8px; position: relative; overflow: hidden; }
		.modal img { max-width: 100%; max-height: 85vh; display: block; }
		.close { position: absolute; right: 20px; top: 20px; color: white; font-size: 28px; font-weight: bold; cursor: pointer; background: rgba(0,0,0,0.5); width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.2s ease; }
		.close:hover { background: rgba(0,0,0,0.8); }
	</style>
</head>
<body>
	<?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<div class="wrap">
		<h1>Bukti Penempatan Kerja</h1>
		<p style="margin-bottom: 1.75rem;">Berikut beberapa bukti penempatan/kerja nyata alumni. Klik gambar untuk memperbesar atau tombol unduh untuk menyimpan poster.</p>

		<div class="grid">
			<?php if(empty($images) || count($images) === 0): ?>
				<div style="color: #666; padding: 2rem; text-align: center; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(2,6,23,0.04);">
					<i class="fas fa-inbox" style="font-size: 2.5rem; color: #ccc; margin-bottom: 1rem; display: block;"></i>
					<p style="color: #666; margin: 0;">Belum ada item penempatan. Silakan admin unggah bukti penempatan melalui panel admin.</p>
				</div>
			<?php else: ?>
				<?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php
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
				?>
				<div class="card">
					<div class="poster">
						<a href="<?php echo e($url); ?>" target="_blank" rel="noopener" onclick="openModal(event, '<?php echo e($url); ?>')">
							<img src="<?php echo e($url); ?>" alt="<?php echo e($title); ?>" loading="lazy">
						</a>
					</div>
					<div class="meta">
						<h3><?php echo e($title); ?></h3>
						<p><?php echo e($description); ?></p>
						<div class="actions">
							<a class="btn" href="<?php echo e($url); ?>" target="_blank" rel="noopener" download>
								<i class="fas fa-download"></i> Unduh
							</a>
						</div>
					</div>
				</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
		</div>
	</div>

	<!-- Modal for image preview -->
	<div id="imageModal" class="modal">
		<div class="modal-content">
			<span class="close" onclick="closeModal()">&times;</span>
			<img id="modalImage" src="" alt="Full size preview">
		</div>
	</div>

	<script>
		function openModal(event, imageSrc) {
			event.preventDefault();
			document.getElementById('imageModal').classList.add('show');
			document.getElementById('modalImage').src = imageSrc;
		}

		function closeModal() {
			document.getElementById('imageModal').classList.remove('show');
		}

		// Close modal when clicking outside the image
		document.getElementById('imageModal').addEventListener('click', function(event) {
			if (event.target === this) {
				closeModal();
			}
		});
	</script>
</body>
</html>
<?php /**PATH D:\Lp3i\LP3IKARAWANG\resources\views/penempatan.blade.php ENDPATH**/ ?>