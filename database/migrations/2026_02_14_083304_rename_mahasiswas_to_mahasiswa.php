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
        // Drop mahasiswas table since mahasiswa table already exists with data
        Schema::dropIfExists('mahasiswas');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot safely recreate mahasiswas, manual intervention required
    }
};
