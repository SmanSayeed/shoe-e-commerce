<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
              [
                'name' => 'Trailforce Boot',
                'slug' => 'trailforce-boot',   
                'category_id' => 1,  
                'description' => 'Trailforce Boot',     
                'sku' => 'FLT-0001',
                'price' => 185,
                'sale_price' => 165,
                'color_id' => 1,
                'features' => [
                    'Waterproof leather upper',
                    'Steel toe reinforcement',
                    'Vibram traction outsole',
                ],
                'specifications' => [
                    'Closure' => 'Lace-up',
                    'Sole Material' => 'Rubber',
                    'Upper Material' => 'Leather',
                    'Heel Height' => '4.1 cm',
                ],
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
