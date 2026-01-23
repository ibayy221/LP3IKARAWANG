<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Drop tables
DB::statement('DROP TABLE IF EXISTS organisations');
DB::statement('DROP TABLE IF EXISTS password_resets');

echo "Tables dropped successfully\n";
