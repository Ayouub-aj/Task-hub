<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed users using Faker only.
     */
    public function run(): void
    {
        // Create a predictable admin user.
        User::updateOrCreate(
            ['email' => 'admin@taskhub.local'],
            [
                'name' => 'Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        // Seed additional realistic users.
        User::factory()->count(9)->create();
    }
}
