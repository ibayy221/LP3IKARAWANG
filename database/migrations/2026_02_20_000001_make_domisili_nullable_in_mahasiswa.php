<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite in tests already has domisili nullable (and doesn't support SHOW COLUMNS).
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            return;
        }

        if (!Schema::hasColumn('mahasiswa', 'domisili')) {
            return;
        }

        try {
            Schema::table('mahasiswa', function (Blueprint $table) {
                $table->string('domisili')->nullable()->default('')->change();
            });
        } catch (\Throwable $e) {
            // Some drivers/setups may not support column changes (e.g. missing doctrine/dbal).
            // Keep migration non-fatal.
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            return;
        }

        if (!Schema::hasColumn('mahasiswa', 'domisili')) {
            return;
        }

        try {
            Schema::table('mahasiswa', function (Blueprint $table) {
                $table->string('domisili')->nullable(false)->default(null)->change();
            });
        } catch (\Throwable $e) {
            // Keep migration non-fatal if column changes aren't supported.
        }
    }
};
