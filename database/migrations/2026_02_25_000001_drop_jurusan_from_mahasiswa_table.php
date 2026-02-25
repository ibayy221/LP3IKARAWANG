<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('mahasiswa', 'jurusan')) {
            Schema::table('mahasiswa', function (Blueprint $table) {
                $table->dropColumn('jurusan');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('mahasiswa', 'jurusan')) {
            Schema::table('mahasiswa', function (Blueprint $table) {
                $table->string('jurusan')->nullable();
            });
        }
    }
};
