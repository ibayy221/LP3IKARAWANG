<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswa', 'id_user')) {
                $table->unsignedBigInteger('id_user')->nullable()->after('id_mahasiswa');
            }
            if (!Schema::hasColumn('mahasiswa', 'payment_status')) {
                $table->enum('payment_status', ['unpaid','paid'])->default('unpaid')->after('status_verifikasi');
            }
            if (!Schema::hasColumn('mahasiswa', 'payment_amount')) {
                $table->integer('payment_amount')->default(350000)->after('payment_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            if (Schema::hasColumn('mahasiswa', 'id_user')) {
                $table->dropColumn('id_user');
            }
            if (Schema::hasColumn('mahasiswa', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
            if (Schema::hasColumn('mahasiswa', 'payment_amount')) {
                $table->dropColumn('payment_amount');
            }
        });
    }
};