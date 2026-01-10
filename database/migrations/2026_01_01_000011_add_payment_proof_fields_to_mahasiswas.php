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
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswas', 'payment_proof_path')) {
                $table->string('payment_proof_path')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('mahasiswas', 'payment_bank_origin')) {
                $table->string('payment_bank_origin')->nullable()->after('payment_proof_path');
            }
            if (!Schema::hasColumn('mahasiswas', 'payment_account_name')) {
                $table->string('payment_account_name')->nullable()->after('payment_bank_origin');
            }
            if (!Schema::hasColumn('mahasiswas', 'payment_sender_name')) {
                $table->string('payment_sender_name')->nullable()->after('payment_account_name');
            }
            if (!Schema::hasColumn('mahasiswas', 'payment_transfer_date')) {
                $table->date('payment_transfer_date')->nullable()->after('payment_sender_name');
            }
            if (!Schema::hasColumn('mahasiswas', 'payment_expires_at')) {
                $table->timestamp('payment_expires_at')->nullable()->after('payment_transfer_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            foreach (['payment_proof_path','payment_bank_origin','payment_account_name','payment_sender_name','payment_transfer_date','payment_expires_at'] as $col) {
                if (Schema::hasColumn('mahasiswas', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
