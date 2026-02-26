<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class MarketingUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [ 'email' => 'marketing@gmail.com' ],
            [
                'name' => 'Marketing',
                'username' => 'marketing',
                'email' => 'marketing@gmail.com',
                'password' => Hash::make('123456'),
                'is_marketing' => true,
                'is_admin' => false,
            ]
        );
    }
}
