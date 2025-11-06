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
                'name' => 'Trailforce Boot Pro',
                'slug' => 'trailforce-boot-pro',
                'category_id' => 1,
                'description' => 'Premium hiking boots for all terrains with advanced grip technology',
                'sku' => 'TBP-1001',
                'price' => 199.99,
                'sale_price' => 179.99,
                'color_id' => 1,
                'main_image' => '/images/products/shoe-1.jpg',
                'features' => [
                    'Waterproof full-grain leather',
                    'Vibram MegaGrip outsole',
                    'Shock-absorbing midsole',
                    'Breathable mesh lining'
                ],
                'specifications' => [
                    'Closure' => 'Speed lacing system',
                    'Sole Material' => 'Vibram rubber',
                    'Upper Material' => 'Full-grain leather',
                    'Heel Height' => '4.5 cm',
                    'Weight' => '450g (per shoe)'
                ],
            ],
            [
                'name' => 'Urban Runner X',
                'slug' => 'urban-runner-x',
                'category_id' => 2,
                'description' => 'Lightweight running shoes for urban environments',
                'sku' => 'URX-2002',
                'price' => 149.99,
                'sale_price' => 129.99,
                'color_id' => 2,
                'main_image' => '/images/products/shoe-2.jpg',
                'features' => [
                    'Breathable knit upper',
                    'Responsive cushioning',
                    'Flexible rubber outsole',
                    'Reflective details for night visibility'
                ],
                'specifications' => [
                    'Closure' => 'Traditional lacing',
                    'Sole Material' => 'Carbon rubber',
                    'Upper Material' => 'Engineered mesh',
                    'Heel Height' => '3.2 cm',
                    'Weight' => '280g (per shoe)'
                ],
            ],
            [
                'name' => 'Classic Court White',
                'slug' => 'classic-court-white',
                'category_id' => 3,
                'description' => 'Timeless tennis-inspired sneakers for casual wear',
                'sku' => 'CCW-3003',
                'price' => 89.99,
                'sale_price' => 74.99,
                'color_id' => 3,
                'main_image' => '/images/products/shoe-3.jpg',
                'features' => [
                    'Premium leather upper',
                    'Padded collar for comfort',
                    'Rubber cupsole',
                    'Minimalist design'
                ],
                'specifications' => [
                    'Closure' => 'Standard lacing',
                    'Sole Material' => 'Vulcanized rubber',
                    'Upper Material' => 'Genuine leather',
                    'Heel Height' => '2.8 cm',
                    'Weight' => '320g (per shoe)'
                ],
            ],
            [
                'name' => 'Trailblazer Hiker',
                'slug' => 'trailblazer-hiker',
                'category_id' => 1,
                'description' => 'Rugged hiking boots for challenging terrains',
                'sku' => 'TBH-4004',
                'price' => 229.99,
                'sale_price' => 199.99,
                'color_id' => 4,
                'main_image' => '/images/products/shoe-4.jpg',
                'features' => [
                    'Waterproof GORE-TEX membrane',
                    'Ankle support system',
                    'Aggressive lug pattern',
                    'Toe protection cap'
                ],
                'specifications' => [
                    'Closure' => 'Quick-lace system',
                    'Sole Material' => 'High-traction rubber',
                    'Upper Material' => 'Nubuck leather',
                    'Heel Height' => '5.0 cm',
                    'Weight' => '520g (per shoe)'
                ],
            ],
            [
                'name' => 'Speed Flex 2.0',
                'slug' => 'speed-flex-2',
                'category_id' => 2,
                'description' => 'High-performance running shoes with energy return',
                'sku' => 'SFX-5005',
                'price' => 169.99,
                'sale_price' => 149.99,
                'color_id' => 5,
                'main_image' => '/images/products/shoe-5.jpg',
                'features' => [
                    'Responsive foam midsole',
                    'Breathable engineered mesh',
                    'Carbon fiber propulsion plate',
                    'Durable rubber outsole'
                ],
                'specifications' => [
                    'Closure' => 'Asymmetrical lacing',
                    'Sole Material' => 'Blown rubber',
                    'Upper Material' => 'Airmesh',
                    'Heel Height' => '3.5 cm',
                    'Weight' => '260g (per shoe)'
                ],
            ],
            [
                'name' => 'Retro Runner OG',
                'slug' => 'retro-runner-og',
                'category_id' => 3,
                'description' => 'Vintage-inspired sneakers with modern comfort',
                'sku' => 'RRO-6006',
                'price' => 119.99,
                'sale_price' => 99.99,
                'color_id' => 6,
                'main_image' => '/images/products/shoe-6.jpg',
                'features' => [
                    'Suede and mesh upper',
                    'EVA foam midsole',
                    'Classic color blocking',
                    'Rubber waffle outsole'
                ],
                'specifications' => [
                    'Closure' => 'Standard lacing',
                    'Sole Material' => 'Vulcanized rubber',
                    'Upper Material' => 'Suede/mesh',
                    'Heel Height' => '3.0 cm',
                    'Weight' => '290g (per shoe)'
                ],
            ],
            [
                'name' => 'All-Terrain Hiker',
                'slug' => 'all-terrain-hiker',
                'category_id' => 1,
                'description' => 'Versatile hiking shoes for all weather conditions',
                'sku' => 'ATH-7007',
                'price' => 159.99,
                'sale_price' => 139.99,
                'color_id' => 7,
                'main_image' => '/images/products/shoe-7.jpg',
                'features' => [
                    'Waterproof and breathable',
                    'Shock-absorbing EVA midsole',
                    'Multi-directional lugs',
                    'Reinforced toe cap'
                ],
                'specifications' => [
                    'Closure' => 'Quick-lace system',
                    'Sole Material' => 'High-abrasion rubber',
                    'Upper Material' => 'Synthetic leather',
                    'Heel Height' => '3.8 cm',
                    'Weight' => '380g (per shoe)'
                ],
            ],
            [
                'name' => 'Marathon Pro',
                'slug' => 'marathon-pro',
                'category_id' => 2,
                'description' => 'Competition-ready running shoes for long distances',
                'sku' => 'MTP-8008',
                'price' => 189.99,
                'sale_price' => 169.99,
                'color_id' => 8,
                'main_image' => '/images/products/shoe-8.jpg',
                'features' => [
                    'Carbon fiber propulsion plate',
                    'Ultra-lightweight foam',
                    'Breathable monofilament mesh',
                    'Durable rubber outsole'
                ],
                'specifications' => [
                    'Closure' => 'Internal sleeve with lace-up',
                    'Sole Material' => 'Pebax foam',
                    'Upper Material' => 'Engineered mesh',
                    'Heel Height' => '3.3 cm',
                    'Weight' => '230g (per shoe)'
                ],
            ],
            [
                'name' => 'Skate Classic',
                'slug' => 'skate-classic',
                'category_id' => 3,
                'description' => 'Durable skate shoes with impact protection',
                'sku' => 'SKC-9009',
                'price' => 79.99,
                'sale_price' => 69.99,
                'color_id' => 9,
                'main_image' => '/images/products/shoe-9.jpg',
                'features' => [
                    'Suede upper with reinforced stitching',
                    'Impact-absorbing insole',
                    'Grippy vulcanized outsole',
                    'Padded collar and tongue'
                ],
                'specifications' => [
                    'Closure' => 'Classic lacing',
                    'Sole Material' => 'Vulcanized rubber',
                    'Upper Material' => 'Suede',
                    'Heel Height' => '2.5 cm',
                    'Weight' => '340g (per shoe)'
                ],
            ],
            [
                'name' => 'Trail King GTX',
                'slug' => 'trail-king-gtx',
                'category_id' => 1,
                'description' => 'Premium waterproof hiking boots with GORE-TEX',
                'sku' => 'TKG-1010',
                'price' => 249.99,
                'sale_price' => 229.99,
                'color_id' => 10,
                'main_image' => '/images/products/shoe-10.jpg',
                'features' => [
                    'GORE-TEX waterproof membrane',
                    'Vibram Megagrip outsole',
                    'Ankle support system',
                    'Moisture-wicking lining'
                ],
                'specifications' => [
                    'Closure' => 'Dual lacing system',
                    'Sole Material' => 'Vibram rubber',
                    'Upper Material' => 'Nubuck leather',
                    'Heel Height' => '5.2 cm',
                    'Weight' => '560g (per shoe)'
                ],
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
