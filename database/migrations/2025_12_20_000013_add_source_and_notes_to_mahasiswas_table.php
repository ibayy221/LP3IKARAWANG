<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->string('sumber_pendaftaran')->nullable()->after('jurusan');
            $table->text('marketing_notes')->nullable()->after('sumber_pendaftaran');
        });
    }

    public function down()
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropColumn(['sumber_pendaftaran','marketing_notes']);
        });
    }
};