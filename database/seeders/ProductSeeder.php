<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some brands first
        $brands = [
            ['name' => 'Nike', 'slug' => 'nike', 'is_active' => true],
            ['name' => 'Adidas', 'slug' => 'adidas', 'is_active' => true],
            ['name' => 'Puma', 'slug' => 'puma', 'is_active' => true],
            ['name' => 'Reebok', 'slug' => 'reebok', 'is_active' => true],
            ['name' => 'New Balance', 'slug' => 'new-balance', 'is_active' => true],
            ['name' => 'Converse', 'slug' => 'converse', 'is_active' => true],
            ['name' => 'Vans', 'slug' => 'vans', 'is_active' => true],
            ['name' => 'Dr. Martens', 'slug' => 'dr-martens', 'is_active' => true],
            ['name' => 'Timberland', 'slug' => 'timberland', 'is_active' => true],
            ['name' => 'Clarks', 'slug' => 'clarks', 'is_active' => true],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(['slug' => $brand['slug']], $brand);
        }

        $products = [
            // Men's Sneakers
            [
                'category_slug' => 'mens-shoes',
                'subcategory_slug' => 'mens-sneakers',
                'child_category_slug' => 'mens-lifestyle-sneakers',
                'brand_slug' => 'nike',
                'name' => 'Nike Air Max 270',
                'slug' => 'nike-air-max-270',
                'description' => 'The Nike Air Max 270 delivers incredible all-day comfort with its super-soft foam and plush cushioning. The shoe\'s Max Air unit provides lightweight cushioning with every step.',
                'short_description' => 'Comfortable lifestyle sneakers with visible Air cushioning.',
                'sku' => 'NAM270-BLK-001',
                'main_image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800&h=600&fit=crop',
                'price' => 150.00,
                'sale_price' => 120.00,
                'cost_price' => 90.00,
                'min_stock_level' => 5,
                'weight' => 0.85,
                'dimensions' => '30 x 12 x 10 cm',
                'material' => 'Synthetic leather, mesh, rubber',
                'size_guide' => 'True to size. If you wear a half size, size up for the best fit.',
                'features' => [
                    'Visible Air cushioning',
                    'Breathable mesh upper',
                    'Durable rubber outsole',
                    'Padded tongue and collar'
                ],
                'specifications' => [
                    'Closure' => 'Lace-up',
                    'Sole Material' => 'Rubber',
                    'Upper Material' => 'Synthetic/Mesh',
                    'Heel Height' => '2.5 cm'
                ],
                'meta_title' => 'Nike Air Max 270 | Lifestyle Sneakers',
                'meta_description' => 'Shop Nike Air Max 270 sneakers with visible Air cushioning for all-day comfort.',
                'meta_keywords' => ['nike', 'air max', 'sneakers', 'lifestyle', 'comfort'],
                'is_active' => true,
                'is_featured' => true,
                'track_inventory' => true,
            ],
            [
                'category_slug' => 'mens-shoes',
                'subcategory_slug' => 'mens-sneakers',
                'child_category_slug' => 'mens-athletic-sneakers',
                'brand_slug' => 'adidas',
                'name' => 'Adidas Ultraboost 22',
                'slug' => 'adidas-ultraboost-22',
                'description' => 'The Adidas Ultraboost 22 features responsive cushioning and a sock-like fit that adapts to your foot. Perfect for running and training with superior energy return.',
                'short_description' => 'High-performance running shoes with Boost technology.',
                'sku' => 'AUB22-WHT-002',
                'main_image' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=800&h=600&fit=crop',
                'price' => 180.00,
                'cost_price' => 110.00,
                'min_stock_level' => 3,
                'weight' => 0.75,
                'dimensions' => '32 x 11 x 9 cm',
                'material' => 'Primeknit upper, rubber outsole',
                'features' => [
                    'Boost midsole technology',
                    'Primeknit upper',
                    'Continental rubber outsole',
                    'Lace closure'
                ],
                'specifications' => [
                    'Closure' => 'Lace-up',
                    'Sole Material' => 'Continental Rubber',
                    'Upper Material' => 'Primeknit',
                    'Heel Height' => '3 cm'
                ],
                'meta_title' => 'Adidas Ultraboost 22 | Running Shoes',
                'meta_description' => 'Experience superior comfort and energy return with Adidas Ultraboost 22 running shoes.',
                'meta_keywords' => ['adidas', 'ultraboost', 'running', 'performance', 'boost'],
                'is_active' => true,
                'is_featured' => true,
                'track_inventory' => true,
            ],

            // Women's High Heels
            [
                'category_slug' => 'womens-shoes',
                'subcategory_slug' => 'womens-high-heels',
                'child_category_slug' => 'womens-stiletto-heels',
                'brand_slug' => 'clarks',
                'name' => 'Clarks Laina Rae',
                'slug' => 'clarks-laina-rae',
                'description' => 'Elegant stiletto heels from Clarks featuring premium leather and comfortable cushioning. Perfect for formal occasions and professional settings.',
                'short_description' => 'Elegant stiletto heels with premium leather finish.',
                'sku' => 'CLR-BLK-003',
                'main_image' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=800&h=600&fit=crop',
                'price' => 120.00,
                'cost_price' => 70.00,
                'min_stock_level' => 2,
                'weight' => 0.65,
                'dimensions' => '28 x 8 x 12 cm',
                'material' => 'Genuine leather, synthetic sole',
                'features' => [
                    'Premium leather upper',
                    'Cushioned footbed',
                    'Stiletto heel',
                    'Slip-on design'
                ],
                'specifications' => [
                    'Closure' => 'Slip-on',
                    'Sole Material' => 'Synthetic',
                    'Upper Material' => 'Leather',
                    'Heel Height' => '8.5 cm'
                ],
                'meta_title' => 'Clarks Laina Rae | Elegant Stiletto Heels',
                'meta_description' => 'Step out in style with Clarks Laina Rae elegant stiletto heels.',
                'meta_keywords' => ['clarks', 'heels', 'stiletto', 'leather', 'formal'],
                'is_active' => true,
                'track_inventory' => true,
            ],
            [
                'category_slug' => 'womens-shoes',
                'subcategory_slug' => 'womens-high-heels',
                'child_category_slug' => 'womens-block-heels',
                'brand_slug' => 'puma',
                'name' => 'Puma Mayze Stack',
                'slug' => 'puma-mayze-stack',
                'description' => 'Bold platform heels from Puma with a chunky silhouette. Features premium materials and comfortable padding for all-day wear.',
                'short_description' => 'Bold platform heels with chunky silhouette.',
                'sku' => 'PMS-WHT-004',
                'main_image' => 'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?w=800&h=600&fit=crop',
                'price' => 100.00,
                'cost_price' => 60.00,
                'min_stock_level' => 3,
                'weight' => 0.70,
                'dimensions' => '29 x 10 x 14 cm',
                'material' => 'Synthetic leather, rubber platform',
                'features' => [
                    'Platform heel design',
                    'Padded collar',
                    'Rubber platform sole',
                    'Lace-up closure'
                ],
                'specifications' => [
                    'Closure' => 'Lace-up',
                    'Sole Material' => 'Rubber',
                    'Upper Material' => 'Synthetic',
                    'Heel Height' => '5 cm'
                ],
                'meta_title' => 'Puma Mayze Stack | Platform Heels',
                'meta_description' => 'Make a statement with Puma Mayze Stack platform heels.',
                'meta_keywords' => ['puma', 'platform', 'heels', 'chunky', 'fashion'],
                'is_active' => true,
                'track_inventory' => true,
            ],

            // Kids School Shoes
            [
                'category_slug' => 'kids-shoes',
                'subcategory_slug' => 'kids-school-shoes',
                'child_category_slug' => 'kids-mary-jane-shoes',
                'brand_slug' => 'clarks',
                'name' => 'Clarks Scala Step',
                'slug' => 'clarks-scala-step',
                'description' => 'Durable and comfortable Mary Jane shoes perfect for school. Features easy-to-use buckle closure and flexible sole for active kids.',
                'short_description' => 'Durable Mary Jane shoes for school wear.',
                'sku' => 'CSS-BLK-005',
                'main_image' => 'https://images.unsplash.com/photo-1554735490-5974588cbc4f?w=800&h=600&fit=crop',
                'price' => 45.00,
                'cost_price' => 25.00,
                'min_stock_level' => 5,
                'weight' => 0.45,
                'dimensions' => '22 x 8 x 6 cm',
                'material' => 'Synthetic leather, rubber sole',
                'features' => [
                    'Easy buckle closure',
                    'Flexible rubber sole',
                    'Padded insole',
                    'Durable construction'
                ],
                'specifications' => [
                    'Closure' => 'Buckle',
                    'Sole Material' => 'Rubber',
                    'Upper Material' => 'Synthetic',
                    'Heel Height' => '1 cm'
                ],
                'meta_title' => 'Clarks Scala Step | Kids Mary Jane Shoes',
                'meta_description' => 'Find durable and comfortable Mary Jane shoes for school.',
                'meta_keywords' => ['clarks', 'kids', 'school', 'mary jane', 'uniform'],
                'is_active' => true,
                'track_inventory' => true,
            ],

            // Running Shoes
            [
                'category_slug' => 'sports-athletic',
                'subcategory_slug' => 'running-shoes',
                'child_category_slug' => 'road-running-shoes',
                'brand_slug' => 'nike',
                'name' => 'Nike React Infinity Run',
                'slug' => 'nike-react-infinity-run',
                'description' => 'Nike React Infinity Run provides soft, responsive cushioning with every step. Designed to help reduce injury risk during runs.',
                'short_description' => 'Injury-preventing running shoes with React foam.',
                'sku' => 'NRIR-BLU-006',
                'main_image' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=800&h=600&fit=crop',
                'price' => 160.00,
                'cost_price' => 95.00,
                'min_stock_level' => 4,
                'weight' => 0.68,
                'dimensions' => '31 x 11 x 9 cm',
                'material' => 'Flyknit upper, React foam, rubber',
                'features' => [
                    'React foam cushioning',
                    'Flyknit upper',
                    'Durable rubber outsole',
                    'Wide base for stability'
                ],
                'specifications' => [
                    'Closure' => 'Lace-up',
                    'Sole Material' => 'Rubber',
                    'Upper Material' => 'Flyknit',
                    'Heel Height' => '2.5 cm'
                ],
                'meta_title' => 'Nike React Infinity Run | Road Running Shoes',
                'meta_description' => 'Run comfortably and reduce injury risk with Nike React Infinity Run.',
                'meta_keywords' => ['nike', 'react', 'running', 'injury prevention', 'road'],
                'is_active' => true,
                'is_featured' => true,
                'track_inventory' => true,
            ],

            // Basketball Shoes
            [
                'category_slug' => 'sports-athletic',
                'subcategory_slug' => 'basketball-shoes',
                'child_category_slug' => 'high-top-basketball-shoes',
                'brand_slug' => 'adidas',
                'name' => 'Adidas Harden Vol. 6',
                'slug' => 'adidas-harden-vol-6',
                'description' => 'James Harden signature basketball shoes with responsive cushioning and lockdown support. Perfect for quick cuts and explosive movements on the court.',
                'short_description' => 'Signature basketball shoes with responsive cushioning.',
                'sku' => 'AHV6-RED-007',
                'main_image' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=800&h=600&fit=crop',
                'price' => 140.00,
                'cost_price' => 85.00,
                'min_stock_level' => 3,
                'weight' => 0.82,
                'dimensions' => '33 x 12 x 11 cm',
                'material' => 'Textile upper, rubber outsole',
                'features' => [
                    'Boost cushioning',
                    'Lockdown fit',
                    'Durable outsole',
                    'Ankle support'
                ],
                'specifications' => [
                    'Closure' => 'Lace-up',
                    'Sole Material' => 'Rubber',
                    'Upper Material' => 'Textile',
                    'Heel Height' => '3 cm'
                ],
                'meta_title' => 'Adidas Harden Vol. 6 | Basketball Shoes',
                'meta_description' => 'Dominate the court with Adidas Harden Vol. 6 basketball shoes.',
                'meta_keywords' => ['adidas', 'harden', 'basketball', 'performance', 'court'],
                'is_active' => true,
                'track_inventory' => true,
            ],

            // Men's Boots
            [
                'category_slug' => 'mens-shoes',
                'subcategory_slug' => 'mens-boots',
                'child_category_slug' => 'mens-work-boots',
                'brand_slug' => 'timberland',
                'name' => 'Timberland Pro Work Boots',
                'slug' => 'timberland-pro-work-boots',
                'description' => 'Durable work boots built for tough jobs. Features steel toe protection, slip-resistant sole, and premium leather construction.',
                'short_description' => 'Steel toe work boots with slip-resistant sole.',
                'sku' => 'TPWB-BRN-008',
                'main_image' => 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5e?w=800&h=600&fit=crop',
                'price' => 180.00,
                'cost_price' => 120.00,
                'min_stock_level' => 2,
                'weight' => 1.20,
                'dimensions' => '35 x 14 x 12 cm',
                'material' => 'Premium leather, steel toe, rubber sole',
                'features' => [
                    'Steel toe protection',
                    'Slip-resistant sole',
                    'Premium leather upper',
                    'Comfortable insole'
                ],
                'specifications' => [
                    'Closure' => 'Lace-up',
                    'Sole Material' => 'Rubber',
                    'Upper Material' => 'Leather',
                    'Heel Height' => '4 cm'
                ],
                'meta_title' => 'Timberland Pro Work Boots | Industrial Grade',
                'meta_description' => 'Get industrial-grade protection with Timberland Pro work boots.',
                'meta_keywords' => ['timberland', 'work boots', 'steel toe', 'safety', 'durable'],
                'is_active' => true,
                'track_inventory' => true,
            ],

            // Women's Boots
            [
                'category_slug' => 'womens-shoes',
                'subcategory_slug' => 'womens-boots',
                'child_category_slug' => 'womens-knee-high-boots',
                'brand_slug' => 'dr-martens',
                'name' => 'Dr. Martens 1B99',
                'slug' => 'dr-martens-1b99',
                'description' => 'Iconic Dr. Martens knee-high boots with the classic yellow stitching and air-cushioned sole. Made from premium leather with a comfortable fit.',
                'short_description' => 'Iconic knee-high boots with air-cushioned sole.',
                'sku' => 'DM1B99-BLK-009',
                'main_image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop',
                'price' => 170.00,
                'cost_price' => 100.00,
                'min_stock_level' => 2,
                'weight' => 1.10,
                'dimensions' => '40 x 12 x 35 cm',
                'material' => 'Leather, rubber sole',
                'features' => [
                    'Air-cushioned sole',
                    'Premium leather',
                    'Yellow stitching detail',
                    'Side zipper'
                ],
                'specifications' => [
                    'Closure' => 'Zip/Lace',
                    'Sole Material' => 'Rubber',
                    'Upper Material' => 'Leather',
                    'Heel Height' => '3 cm'
                ],
                'meta_title' => 'Dr. Martens 1B99 | Iconic Knee-High Boots',
                'meta_description' => 'Own a piece of fashion history with Dr. Martens 1B99 boots.',
                'meta_keywords' => ['dr martens', 'boots', 'leather', 'iconic', 'fashion'],
                'is_active' => true,
                'track_inventory' => true,
            ],

            // Formal Shoes
            [
                'category_slug' => 'formal-shoes',
                'subcategory_slug' => 'oxfords',
                'child_category_slug' => 'plain-toe-oxfords',
                'brand_slug' => 'clarks',
                'name' => 'Clarks Tilden Cap',
                'slug' => 'clarks-tilden-cap',
                'description' => 'Classic cap toe oxfords from Clarks featuring premium leather and comfortable cushioning. Perfect for business and formal occasions.',
                'short_description' => 'Classic cap toe oxfords for formal occasions.',
                'sku' => 'CTC-BRN-010',
                'main_image' => 'https://images.unsplash.com/photo-1614252369475-531eba835eb1?w=800&h=600&fit=crop',
                'price' => 110.00,
                'cost_price' => 65.00,
                'min_stock_level' => 3,
                'weight' => 0.80,
                'dimensions' => '30 x 10 x 8 cm',
                'material' => 'Genuine leather, leather sole',
                'features' => [
                    'Cap toe design',
                    'Genuine leather upper',
                    'Leather sole',
                    'Cushioned insole'
                ],
                'specifications' => [
                    'Closure' => 'Lace-up',
                    'Sole Material' => 'Leather',
                    'Upper Material' => 'Leather',
                    'Heel Height' => '2.5 cm'
                ],
                'meta_title' => 'Clarks Tilden Cap | Classic Oxford Shoes',
                'meta_description' => 'Add sophistication to your formal look with Clarks Tilden Cap oxfords.',
                'meta_keywords' => ['clarks', 'oxfords', 'formal', 'leather', 'business'],
                'is_active' => true,
                'track_inventory' => true,
            ],

            // Casual Shoes
            [
                'category_slug' => 'casual-shoes',
                'subcategory_slug' => 'loafers',
                'brand_slug' => 'clarks',
                'name' => 'Clarks Desert Boot',
                'slug' => 'clarks-desert-boot',
                'description' => 'The original Clarks Desert Boot, a timeless classic. Features premium suede, crepe sole, and unmatched comfort for everyday wear.',
                'short_description' => 'Timeless desert boots with crepe sole.',
                'sku' => 'CDB-BEI-011',
                'main_image' => 'https://images.unsplash.com/photo-1520256862855-398228c41684?w=800&h=600&fit=crop',
                'price' => 130.00,
                'cost_price' => 75.00,
                'min_stock_level' => 4,
                'weight' => 0.75,
                'dimensions' => '28 x 11 x 9 cm',
                'material' => 'Suede, crepe sole',
                'features' => [
                    'Premium suede upper',
                    'Crepe rubber sole',
                    'Two-eyelet lacing',
                    'Unlined construction'
                ],
                'specifications' => [
                    'Closure' => 'Lace-up',
                    'Sole Material' => 'Crepe Rubber',
                    'Upper Material' => 'Suede',
                    'Heel Height' => '2 cm'
                ],
                'meta_title' => 'Clarks Desert Boot | Timeless Classic',
                'meta_description' => 'Own a piece of footwear history with the original Clarks Desert Boot.',
                'meta_keywords' => ['clarks', 'desert boot', 'suede', 'casual', 'classic'],
                'is_active' => true,
                'is_featured' => true,
                'track_inventory' => true,
            ],

            // Combat Boots
            [
                'category_slug' => 'boots-ankle-boots',
                'subcategory_slug' => 'combat-boots',
                'child_category_slug' => 'leather-combat-boots',
                'brand_slug' => 'dr-martens',
                'name' => 'Dr. Martens 1460',
                'slug' => 'dr-martens-1460',
                'description' => 'The original Dr. Martens 1460 boot with 8-eyelet lacing. Features the iconic air-cushioned sole and premium leather construction.',
                'short_description' => 'Iconic 8-eyelet combat boots with air-cushioned sole.',
                'sku' => 'DM1460-BLK-012',
                'main_image' => 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5e?w=800&h=600&fit=crop',
                'price' => 150.00,
                'cost_price' => 90.00,
                'min_stock_level' => 3,
                'weight' => 1.00,
                'dimensions' => '32 x 12 x 28 cm',
                'material' => 'Leather, rubber sole',
                'features' => [
                    '8-eyelet lacing',
                    'Air-cushioned sole',
                    'Premium leather',
                    'Yellow stitching'
                ],
                'specifications' => [
                    'Closure' => 'Lace-up',
                    'Sole Material' => 'Rubber',
                    'Upper Material' => 'Leather',
                    'Heel Height' => '3 cm'
                ],
                'meta_title' => 'Dr. Martens 1460 | Iconic Combat Boots',
                'meta_description' => 'Own the original Dr. Martens 1460 combat boots with iconic style.',
                'meta_keywords' => ['dr martens', 'combat boots', 'leather', 'iconic', 'style'],
                'is_active' => true,
                'track_inventory' => true,
            ],

            // Flip Flops
            [
                'category_slug' => 'sandals-flip-flops',
                'subcategory_slug' => 'flip-flops',
                'child_category_slug' => 'beach-flip-flops',
                'brand_slug' => 'vans',
                'name' => 'Vans Classic Slip-On',
                'slug' => 'vans-classic-slip-on',
                'description' => 'The original Vans Classic Slip-On with the iconic checkerboard pattern. Perfect for casual wear and skateboarding.',
                'short_description' => 'Iconic slip-on shoes with checkerboard pattern.',
                'sku' => 'VCSO-BLK-013',
                'main_image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=800&h=600&fit=crop',
                'price' => 55.00,
                'cost_price' => 30.00,
                'min_stock_level' => 6,
                'weight' => 0.50,
                'dimensions' => '26 x 9 x 7 cm',
                'material' => 'Canvas, rubber sole',
                'features' => [
                    'Slip-on design',
                    'Canvas upper',
                    'Vulcanized rubber sole',
                    'Padded collar'
                ],
                'specifications' => [
                    'Closure' => 'Slip-on',
                    'Sole Material' => 'Rubber',
                    'Upper Material' => 'Canvas',
                    'Heel Height' => '1.5 cm'
                ],
                'meta_title' => 'Vans Classic Slip-On | Iconic Style',
                'meta_description' => 'Get the iconic Vans Classic Slip-On with checkerboard pattern.',
                'meta_keywords' => ['vans', 'slip-on', 'canvas', 'casual', 'skate'],
                'is_active' => true,
                'track_inventory' => true,
            ],

            // Slides
            [
                'category_slug' => 'sandals-flip-flops',
                'subcategory_slug' => 'slides',
                'child_category_slug' => 'pool-slides',
                'brand_slug' => 'adidas',
                'name' => 'Adidas Adilette',
                'slug' => 'adidas-adilette',
                'description' => 'Classic Adidas Adilette slides with the iconic three stripes. Perfect for pool, beach, and casual wear with quick-dry materials.',
                'short_description' => 'Classic slides with three stripes design.',
                'sku' => 'AAD-BLK-014',
                'main_image' => 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=800&h=600&fit=crop',
                'price' => 35.00,
                'cost_price' => 20.00,
                'min_stock_level' => 8,
                'weight' => 0.40,
                'dimensions' => '28 x 10 x 5 cm',
                'material' => 'Synthetic, rubber sole',
                'features' => [
                    'Three stripes design',
                    'Quick-dry materials',
                    'Contoured footbed',
                    'Non-slip sole'
                ],
                'specifications' => [
                    'Closure' => 'Slide-on',
                    'Sole Material' => 'Rubber',
                    'Upper Material' => 'Synthetic',
                    'Heel Height' => '1 cm'
                ],
                'meta_title' => 'Adidas Adilette | Classic Slides',
                'meta_description' => 'Get the classic Adidas Adilette slides for pool and casual wear.',
                'meta_keywords' => ['adidas', 'slides', 'pool', 'casual', 'quick-dry'],
                'is_active' => true,
                'track_inventory' => true,
            ],

            // Canvas Shoes
            [
                'category_slug' => 'casual-shoes',
                'subcategory_slug' => 'canvas-shoes',
                'brand_slug' => 'converse',
                'name' => 'Converse All Star High',
                'slug' => 'converse-all-star-high',
                'description' => 'The iconic Converse All Star High Top in classic canvas. Features the legendary rubber toe cap and comfortable cushioning.',
                'short_description' => 'Iconic high-top canvas sneakers.',
                'sku' => 'CASH-BLK-015',
                'main_image' => 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?w=800&h=600&fit=crop',
                'price' => 65.00,
                'cost_price' => 35.00,
                'min_stock_level' => 5,
                'weight' => 0.60,
                'dimensions' => '28 x 10 x 12 cm',
                'material' => 'Canvas, rubber sole',
                'features' => [
                    'High-top design',
                    'Canvas upper',
                    'Rubber toe cap',
                    'Lace-up closure'
                ],
                'specifications' => [
                    'Closure' => 'Lace-up',
                    'Sole Material' => 'Rubber',
                    'Upper Material' => 'Canvas',
                    'Heel Height' => '2 cm'
                ],
                'meta_title' => 'Converse All Star High | Iconic Canvas',
                'meta_description' => 'Own a piece of sneaker history with Converse All Star High.',
                'meta_keywords' => ['converse', 'all star', 'canvas', 'high top', 'classic'],
                'is_active' => true,
                'is_featured' => true,
                'track_inventory' => true,
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('slug', $productData['category_slug'])->first();
            $subcategory = Subcategory::where('slug', $productData['subcategory_slug'])->first();
            $childCategory = isset($productData['child_category_slug']) ?
                ChildCategory::where('slug', $productData['child_category_slug'])->first() : null;
            $brand = Brand::where('slug', $productData['brand_slug'])->first();

            if ($category && $subcategory && $brand) {
                $product = [
                    'category_id' => $category->id,
                    'subcategory_id' => $subcategory->id,
                    'child_category_id' => $childCategory ? $childCategory->id : null,
                    'brand_id' => $brand->id,
                    'name' => $productData['name'],
                    'slug' => $productData['slug'],
                    'description' => $productData['description'],
                    'short_description' => $productData['short_description'],
                    'sku' => $productData['sku'],
                    'main_image' => $productData['main_image'],
                    'price' => $productData['price'],
                    'sale_price' => $productData['sale_price'] ?? null,
                    'cost_price' => $productData['cost_price'] ?? null,
                    'min_stock_level' => $productData['min_stock_level'],
                    'weight' => $productData['weight'] ?? null,
                    'dimensions' => $productData['dimensions'] ?? null,
                    'material' => $productData['material'] ?? null,
                    'size_guide' => $productData['size_guide'] ?? null,
                    'features' => $productData['features'] ?? [],
                    'specifications' => $productData['specifications'] ?? [],
                    'meta_title' => $productData['meta_title'] ?? null,
                    'meta_description' => $productData['meta_description'] ?? null,
                    'meta_keywords' => $productData['meta_keywords'] ?? [],
                    'is_active' => $productData['is_active'],
                    'is_featured' => $productData['is_featured'] ?? false,
                    'is_digital' => $productData['is_digital'] ?? false,
                    'track_inventory' => $productData['track_inventory'],
                ];

                Product::updateOrCreate(
                    ['sku' => $productData['sku']],
                    $product
                );
            }
        }
    }
}
