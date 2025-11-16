<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the Coupon model exists before using it
        if (!class_exists(Coupon::class)) {
            return;
        }

        // Ensure seeder is idempotent when run multiple times
        Coupon::updateOrCreate(
            ['code' => 'SAVE10'],
            [
                'type' => 'fixed',
                'value' => 10,
                'is_active' => true,
            ]
        );

        Coupon::updateOrCreate(
            ['code' => 'PERCENT20'],
            [
                'type' => 'percent',
                'value' => 20,
                'is_active' => true,
            ]
        );

        // Create additional random coupons only if none exist yet
        if (Coupon::count() <= 2) {
            Coupon::factory(5)->create();
        }
    }
}
