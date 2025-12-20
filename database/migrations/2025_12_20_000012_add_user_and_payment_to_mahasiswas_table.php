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
                $table->enum('payment_status', ['unpaid','paid'])->default('unpaid')->after('status_verifikasi');
                $table->integer('payment_amount')->default(350000)->after('payment_status');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (Schema::hasColumn('mahasiswas', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn(['user_id','payment_status','payment_amount']);
            }
        });
    }
};