<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$m = \App\Models\Mahasiswa::where('user_id', 33)->first();
echo json_encode($m ? $m->only(['id','nama_mhs','file_path']) : null) . PHP_EOL;
