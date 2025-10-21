<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'is_active' => true,
            'password' => '12345678',
        ]);

        // Create test customer user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@gmail.com',
            'role' => 'customer',
            'is_active' => true,
            'password' => '12345678',
        ]);
    }
}
