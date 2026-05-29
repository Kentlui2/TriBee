<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            [
                'zone_name' => 'Metro Manila',
                'zip_code_pattern' => '1xxx',
                'flat_rate' => 50.00,
                'estimated_days' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'zone_name' => 'North Luzon',
                'zip_code_pattern' => '2xxx',
                'flat_rate' => 100.00,
                'estimated_days' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'zone_name' => 'South Luzon',
                'zip_code_pattern' => '3xxx',
                'flat_rate' => 100.00,
                'estimated_days' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'zone_name' => 'Visayas',
                'zip_code_pattern' => '4xxx|5xxx',
                'flat_rate' => 150.00,
                'estimated_days' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'zone_name' => 'Mindanao',
                'zip_code_pattern' => '6xxx|7xxx|8xxx|9xxx',
                'flat_rate' => 150.00,
                'estimated_days' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        DB::table('shipping_zones')->insert($zones);
    }
}