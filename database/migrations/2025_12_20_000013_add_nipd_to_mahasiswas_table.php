<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswa', 'nipd')) {
                $table->string('nipd', 32)->nullable();
            }
        });

        if (Schema::hasColumn('mahasiswa', 'nipd')) {
            try {
                Schema::table('mahasiswa', function (Blueprint $table) {
                    $table->unique('nipd', 'mahasiswa_nipd_unique');
                });
            } catch (\Throwable $e) {
                // Ignore if the unique index already exists or cannot be created.
            }
        }
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            try {
                $table->dropUnique('mahasiswa_nipd_unique');
            } catch (\Throwable $e) {
                // Ignore if index does not exist
            }
        });
    }
};
