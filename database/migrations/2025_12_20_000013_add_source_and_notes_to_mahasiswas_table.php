<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswa', 'sumber_pendaftaran')) {
                $table->string('sumber_pendaftaran')->nullable();
            }
            if (!Schema::hasColumn('mahasiswa', 'marketing_notes')) {
                $table->text('marketing_notes')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $toDrop = [];
            foreach (['sumber_pendaftaran', 'marketing_notes'] as $col) {
                if (Schema::hasColumn('mahasiswa', $col)) {
                    $toDrop[] = $col;
                }
            }

            if (!empty($toDrop)) {
                $table->dropColumn($toDrop);
            }
        });
    }
};