<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Brand seeder
        Brand::factory()->count(15)->create();

        // User seeder
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('Admin1234!'),
        ]);
    }
}
