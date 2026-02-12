<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'marketing@gmail.com';

        if (User::where('email', $email)->exists()) {
            $this->command->info("Admin user already exists: {$email}");
            return;
        }

        User::create([
            'name' => 'Marketing Admin',
            'username' => 'marketing',
            'email' => $email,
            'password' => Hash::make('123456'),
            'is_admin' => true,
        ]);

        $this->command->info("Admin user created: {$email}");
    }
}
