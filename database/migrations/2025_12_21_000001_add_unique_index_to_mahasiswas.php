<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            if (
                Schema::hasColumn('mahasiswa', 'email')
                && Schema::hasColumn('mahasiswa', 'id_program_studi')
                && Schema::hasColumn('mahasiswa', 'no_tlp')
            ) {
                // Unique composite to reduce accidental duplicates.
                $table->unique(['email', 'id_program_studi', 'no_tlp'], 'mahasiswa_unique_email_program_notlp');
            }
        });
    }

    public function down()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            try {
                $table->dropUnique('mahasiswa_unique_email_program_notlp');
            } catch (\Throwable $e) {
                // Ignore if index does not exist
            }
        });
    }
};