<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TestPendaftarSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Creating test pendaftar (idempotent)...');

        $u = User::firstOrCreate(
            ['email' => 'pendaftar_test@example.com'],
            ['name' => 'Auto Test', 'password' => Hash::make('secret123'), 'is_applicant' => true]
        );

        $m = Mahasiswa::firstOrCreate(
            ['email' => 'pendaftar_test@example.com'],
            ['nama_mhs' => 'Auto Test', 'user_id' => $u->id, 'payment_status' => 'unpaid', 'payment_amount' => 350000]
        );

        $this->command->info("Created user {$u->id} and mahasiswa {$m->id}");

        // Trigger verification via Marketing controller
        try {
            (new \App\Http\Controllers\Marketing\MarketingPendaftarController())->updateStatus(new Request(['id' => $m->id, 'status' => 'verified']));
            $this->command->info('updateStatus called');
        } catch (\Exception $e) {
            $this->command->error('updateStatus failed: '.$e->getMessage());
        }

        // Simulate pendaftar marking payment
        try {
            Auth::loginUsingId($u->id);
            (new \App\Http\Controllers\PendaftarDashboardController())->markPaid(new Request());
            $this->command->info('markPaid called');
        } catch (\Exception $e) {
            $this->command->error('markPaid failed: '.$e->getMessage());
        }

        $m2 = Mahasiswa::find($m->id);
        $this->command->info('Final status_verifikasi: '.($m2->status_verifikasi ?? 'NULL'));
        $this->command->info('Final payment_status: '.($m2->payment_status ?? 'NULL'));
    }
}
