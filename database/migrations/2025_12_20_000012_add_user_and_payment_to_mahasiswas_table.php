<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswas', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('mahasiswas', 'payment_status')) {
                $table->enum('payment_status', ['unpaid','paid'])->default('unpaid')->after('status_verifikasi');
            }
            if (!Schema::hasColumn('mahasiswas', 'payment_amount')) {
                $table->integer('payment_amount')->default(350000)->after('payment_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (Schema::hasColumn('mahasiswas', 'user_id')) {
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('mahasiswas', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
            if (Schema::hasColumn('mahasiswas', 'payment_amount')) {
                $table->dropColumn('payment_amount');
            }
        });
    }
};