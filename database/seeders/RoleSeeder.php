<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Modules\Auth\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
             Role::firstOrCreate(['name' => 'customer']);
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'vendor']);
    }
}