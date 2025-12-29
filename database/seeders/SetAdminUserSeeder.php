<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SetAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $username = 'lp3ikarawang';
        // Temporary password (please change after first login)
        $tempPassword = 'LP3I_admin_!2025';

        $user = User::where('username', $username)->first();

        if ($user) {
            $user->is_admin = true;
            $user->password = Hash::make($tempPassword);
            $user->save();
            echo "Updated existing user '{$username}' as admin.\n";
        } else {
            // Create the user if it doesn't exist (safe defaults)
            $user = User::create([
                'name' => 'Admin LP3I',
                'username' => $username,
                'email' => 'admin@lp3ikarawang.local',
                'password' => Hash::make($tempPassword),
            ]);
            $user->is_admin = true;
            $user->save();
            echo "Created and updated user '{$username}' as admin.\n";
        }

        echo "Temporary password: {$tempPassword}\n";
    }
}
