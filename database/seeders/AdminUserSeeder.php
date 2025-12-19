<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            ['email' => 'admin@example.com', 'name' => 'Admin', 'username' => 'admin', 'password' => 'password', 'is_admin' => true, 'is_marketing' => false],
            ['email' => 'lp3ikarawang@example.com', 'name' => 'lp3ikarawang', 'username' => 'lp3ikarawang', 'password' => '2025jaya', 'is_admin' => false, 'is_marketing' => true],
            ['email' => 'marketing@example.com', 'name' => 'marketing', 'username' => 'marketing', 'password' => 'cuan2025', 'is_admin' => false, 'is_marketing' => true],
        ];

        foreach ($users as $a) {
            $user = User::firstOrNew(['email' => $a['email']]);
            $user->name = $a['name'];
            $user->username = $a['username'] ?? $a['name'];
            $user->email_verified_at = $user->email_verified_at ?? now();
            $user->password = Hash::make($a['password']);
            $user->is_admin = $a['is_admin'] ?? false;
            $user->is_marketing = $a['is_marketing'] ?? false;
            $user->save();
        }
    }
}
