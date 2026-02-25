<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('mahasiswa') || !Schema::hasColumn('mahasiswa', 'nipd')) {
            return;
        }

        // Production uses MySQL; make nipd nullable so NIPD can be assigned only on verification.
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE `mahasiswa` MODIFY `nipd` VARCHAR(255) NULL');
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('mahasiswa') || !Schema::hasColumn('mahasiswa', 'nipd')) {
            return;
        }

        // Do not force NOT NULL on rollback; that would break pending applicants.
        // Intentionally left as a no-op.
    }
};
