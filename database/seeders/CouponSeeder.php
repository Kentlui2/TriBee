<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Modules\Cart\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        Coupon::create([
            'code' => 'WELCOME10',
            'name' => 'Welcome Discount',
            'description' => '10% off your first order',
            'type' => 'percentage',
            'value' => 10,
            'min_order_amount' => 500,
            'max_discount_amount' => 500,
            'usage_limit' => 100,
            'per_user_limit' => 1,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'SAVE500',
            'name' => '₱500 Off',
            'description' => 'Get ₱500 off on orders above ₱5,000',
            'type' => 'fixed',
            'value' => 500,
            'min_order_amount' => 5000,
            'usage_limit' => 50,
            'per_user_limit' => 1,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'FLASH20',
            'name' => 'Flash Sale 20%',
            'description' => '20% off - limited time only',
            'type' => 'percentage',
            'value' => 20,
            'min_order_amount' => 1000,
            'max_discount_amount' => 1000,
            'usage_limit' => 30,
            'per_user_limit' => 1,
            'expires_at' => now()->addDays(3),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'LOYAL5',
            'name' => 'Loyalty Discount',
            'description' => '5% off for our loyal customers',
            'type' => 'percentage',
            'value' => 5,
            'min_order_amount' => 0,
            'usage_limit' => null,
            'per_user_limit' => 5,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'FREESHIP',
            'name' => 'Free Shipping',
            'description' => 'Free shipping on your order',
            'type' => 'fixed',
            'value' => 100,
            'min_order_amount' => 1500,
            'usage_limit' => 200,
            'per_user_limit' => 2,
            'is_active' => true,
        ]);
    }
}