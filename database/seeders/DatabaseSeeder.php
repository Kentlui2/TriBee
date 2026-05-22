<?php

namespace Database\Seeders;

use App\Models\User;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1Default User Account (is_admin set to 0)
        // User::factory(10)->create();
     $this->call(RoleSeeder::class);
     
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // SUB-TASK 2: Cross-Seeder Execution Link
        // Group 2: Product Catalog & Inventory Module Seeder
        $this->call(ProductSeeder::class,);
    }
}