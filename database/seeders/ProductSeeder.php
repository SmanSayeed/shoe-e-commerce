<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
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
        // Get all available shoe images
        $shoeImages = [
            '/images/products/shoe-1.jpg',
            '/images/products/shoe-2.jpg',
            '/images/products/shoe-3.jpg',
            '/images/products/shoe-4.jpg',
            '/images/products/shoe-5.jpg',
            '/images/products/shoe-6.jpg',
            '/images/products/shoe-7.jpg',
            '/images/products/shoe-8.jpg',
            '/images/products/shoe-9.jpg',
            '/images/products/shoe-10.jpg',
            '/images/products/shoe-11.jpg',
            '/images/products/shoe-12.jpg',
            '/images/products/shoe-17.jpg',
            '/images/products/shoe-18.jpg',
            '/images/products/show-13.jpg',
            '/images/products/show-14.jpg',
            '/images/products/show-15.jpg',
            '/images/products/show-16.jpg',
        ];

        // Get brands, colors, and sizes
        $brands = Brand::where('is_active', true)->get();
        $colors = Color::where('is_active', true)->get();
        $sizes = Size::where('is_active', true)->get();

        // Deterministic sample products to exercise the storefront filters
        $this->seedFilterTestProducts($shoeImages);

        // Product templates with different categories
        $productTemplates = [
            // Men's Shoes
            [
                'categories' => [
                    ['mens-shoes', 'mens-sneakers', 'mens-lifestyle-sneakers'],
                    ['mens-shoes', 'mens-sneakers', 'mens-athletic-sneakers'],
                    ['mens-shoes', 'mens-boots', 'mens-work-boots'],
                    ['mens-shoes', 'mens-boots', 'mens-casual-boots'],
                ],
                'names' => [
                    'Air Max Comfort', 'Urban Runner', 'Classic Leather Boot', 'Casual Chelsea Boot',
                    'Performance Trainer', 'Lifestyle High-Top', 'Work Safety Boot', 'Desert Combat Boot',
                    'Retro Basketball', 'Minimalist Loafer', 'Hiking Trail Boot', 'Formal Oxford',
                ],
                'price_range' => [80, 200],
            ],
            // Women's Shoes
            [
                'categories' => [
                    ['womens-shoes', 'womens-sneakers', 'womens-lifestyle-sneakers'],
                    ['womens-shoes', 'womens-high-heels', 'womens-stiletto-heels'],
                    ['womens-shoes', 'womens-high-heels', 'womens-block-heels'],
                    ['womens-shoes', 'womens-boots', 'womens-knee-high-boots'],
                    ['womens-shoes', 'womens-boots', 'womens-ankle-boots'],
                    ['womens-shoes', 'womens-flats', 'womens-ballet-flats'],
                ],
                'names' => [
                    'Elegant Stiletto', 'Platform Heel', 'Knee-High Fashion', 'Ankle Bootie',
                    'Ballet Flat', 'Wedge Sandal', 'Block Heel Pump', 'Over-the-Knee Boot',
                    'Mary Jane Flat', 'Espadrille Wedge', 'Fashion Sneaker', 'Loafer Classic',
                ],
                'price_range' => [60, 180],
            ],
            // Kids Shoes
            [
                'categories' => [
                    ['kids-shoes', 'kids-sneakers', 'kids-athletic-sneakers'],
                    ['kids-shoes', 'kids-school-shoes', 'kids-mary-jane-shoes'],
                    ['kids-shoes', 'kids-school-shoes', 'kids-loafers'],
                    ['kids-shoes', 'kids-sandals', 'kids-casual-sandals'],
                ],
                'names' => [
                    'Kids Athletic', 'School Mary Jane', 'Tiny Loafer', 'Play Sandal',
                    'Growing Sneaker', 'Uniform Oxford', 'Casual Velcro', 'Water Shoe',
                    'First Walker', 'Toddler Boot', 'Pre-School Sneaker', 'Kindergarten Mary Jane',
                ],
                'price_range' => [25, 70],
            ],
            // Sports & Athletic
            [
                'categories' => [
                    ['sports-athletic', 'running-shoes', 'road-running-shoes'],
                    ['sports-athletic', 'running-shoes', 'trail-running-shoes'],
                    ['sports-athletic', 'basketball-shoes', 'high-top-basketball-shoes'],
                    ['sports-athletic', 'training-shoes', 'cross-training-shoes'],
                ],
                'names' => [
                    'Road Runner Pro', 'Trail Blazer', 'Court King', 'Training Elite',
                    'Distance Flyer', 'Mountain Trekker', 'Jump Shot High', 'Gym Master',
                    'Speed Demon', 'Endurance Pro', 'Agility Trainer', 'Power Lift',
                ],
                'price_range' => [90, 220],
            ],
            // Casual & Formal
            [
                'categories' => [
                    ['casual-shoes', 'canvas-shoes', null],
                    ['casual-shoes', 'loafers', null],
                    ['formal-shoes', 'oxfords', 'plain-toe-oxfords'],
                    ['formal-shoes', 'derbies', 'wingtip-derbies'],
                ],
                'names' => [
                    'Canvas Classic', 'Suede Loafer', 'Cap Toe Oxford', 'Wingtip Derby',
                    'Penny Loafer', 'Boat Shoe', 'Brogue Oxford', 'Monk Strap',
                    'Wholecut Oxford', 'Chukka Boot', 'Desert Boot', 'Driving Shoe',
                ],
                'price_range' => [70, 160],
            ],
            // Boots & Ankle Boots
            [
                'categories' => [
                    ['boots-ankle-boots', 'combat-boots', 'leather-combat-boots'],
                    ['boots-ankle-boots', 'ankle-boots', 'leather-ankle-boots'],
                    ['boots-ankle-boots', 'work-boots', 'safety-work-boots'],
                    ['boots-ankle-boots', 'fashion-boots', 'knee-high-fashion-boots'],
                ],
                'names' => [
                    'Combat Ready', 'Ankle Leather', 'Safety First', 'Fashion Knee-High',
                    'Military Boot', 'Riding Boot', 'Steel Toe Work', 'Fashion Combat',
                    'Chelsea Boot', 'Chukka Leather', 'Motorcycle Boot', 'Fashion Ankle',
                ],
                'price_range' => [85, 195],
            ],
            // Sandals & Flip Flops
            [
                'categories' => [
                    ['sandals-flip-flops', 'sandals', null],
                    ['sandals-flip-flops', 'flip-flops', 'beach-flip-flops'],
                    ['sandals-flip-flops', 'slides', 'pool-slides'],
                    ['sandals-flip-flops', 'espadrilles', 'wedge-espadrilles'],
                ],
                'names' => [
                    'Beach Comfy', 'Pool Slide', 'Casual Sandal', 'Wedge Espadrille',
                    'Flip Flop Fun', 'Slide Easy', 'Sandal Comfort', 'Espadrille Style',
                    'Summer Slide', 'Beach Flip', 'Pool Ready', 'Casual Wedge',
                ],
                'price_range' => [15, 45],
            ],
        ];

        $createdProducts = 0;
        $imageIndex = 0;

        // Create 50 products
        while ($createdProducts < 50) {
            // Select random template
            $template = $productTemplates[array_rand($productTemplates)];

            // Select random category combination
            $categoryData = $template['categories'][array_rand($template['categories'])];

            // Get category objects
            $category = Category::where('slug', $categoryData[0])->first();
            $subcategory = Subcategory::where('slug', $categoryData[1])->first();
            $childCategory = $categoryData[2] ? ChildCategory::where('slug', $categoryData[2])->first() : null;

            if (!$category || !$subcategory) {
                continue; // Skip if categories don't exist
            }

            // Select random brand
            $brand = $brands->random();

            // Generate product data
            $productName = $template['names'][array_rand($template['names'])] . ' ' . $brand->name;
            $slug = \Str::slug($productName . '-' . $createdProducts);
            $sku = 'PRD-' . str_pad($createdProducts + 1, 4, '0', STR_PAD_LEFT);

            // Random price within range
            $price = rand($template['price_range'][0], $template['price_range'][1]);
            $costPrice = round($price * 0.6); // 60% of selling price
            $salePrice = rand(0, 10) > 7 ? round($price * 0.8) : null; // 20% off sometimes

            // Select random image
            $mainImage = $shoeImages[$imageIndex % count($shoeImages)];
            $imageIndex++;

            // Create product
            $product = Product::create([
                'category_id' => $category->id,
                'subcategory_id' => $subcategory->id,
                'child_category_id' => $childCategory ? $childCategory->id : null,
                'brand_id' => $brand->id,
                'name' => $productName,
                'slug' => $slug,
                'description' => "Experience exceptional comfort and style with the {$productName}. Crafted with premium materials and innovative design, this shoe delivers outstanding performance for everyday wear.",
                'short_description' => "Premium {$brand->name} footwear with superior comfort and style.",
                'sku' => $sku,
                'main_image' => $mainImage,
                'price' => $price,
                'sale_price' => $salePrice,
                'cost_price' => $costPrice,
                'min_stock_level' => rand(2, 8),
                'weight' => rand(40, 120) / 100, // 0.4 to 1.2 kg
                'dimensions' => rand(25, 35) . ' x ' . rand(8, 12) . ' x ' . rand(6, 15) . ' cm',
                'material' => $this->getRandomMaterial(),
                'size_guide' => 'True to size. If you wear a half size, size up for the best fit.',
                'features' => $this->getRandomFeatures(),
                'specifications' => $this->getRandomSpecifications(),
                'meta_title' => "{$productName} | {$brand->name} Shoes",
                'meta_description' => "Shop {$productName} from {$brand->name}. Premium quality footwear with exceptional comfort.",
                'meta_keywords' => [$brand->name, 'shoes', 'footwear', 'comfort', 'style'],
                'is_active' => true,
                'is_featured' => rand(0, 10) > 8, // 20% chance of being featured
                'track_inventory' => true,
            ]);

            // Create variants (2-3 sizes and colors)
            $this->createProductVariants($product, $sizes, $colors);

            $createdProducts++;
        }
    }

    private function seedFilterTestProducts(array $shoeImages): void
    {
        $datasets = [
            [
                'name' => 'Filter Test Velocity Runner',
                'slug' => 'filter-test-velocity-runner',
                'brand_slug' => 'nike',
                'category_slug' => 'mens-shoes',
                'subcategory_slug' => 'mens-sneakers',
                'child_category_slug' => 'mens-athletic-sneakers',
                'sku' => 'FLT-0001',
                'price' => 140,
                'sale_price' => 119,
                'features' => [
                    'Engineered mesh upper',
                    'Zoom air unit cushioning',
                    'Stability frame midsole',
                ],
                'specifications' => [
                    'Closure' => 'Lace-up',
                    'Sole Material' => 'Rubber',
                    'Upper Material' => 'Mesh',
                    'Heel Height' => '3.2 cm',
                ],
                'variants' => [
                    ['color_code' => 'BLACK', 'size_code' => 'M8', 'price' => 140, 'sale_price' => 118, 'stock' => 18],
                    ['color_code' => 'ROYAL_BLUE', 'size_code' => 'M9', 'price' => 142, 'sale_price' => 119, 'stock' => 14],
                    ['color_code' => 'WHITE', 'size_code' => 'M10', 'price' => 139, 'sale_price' => 117, 'stock' => 12],
                ],
            ],
            [
                'name' => 'Filter Test Streetwise Sneaker',
                'slug' => 'filter-test-streetwise-sneaker',
                'brand_slug' => 'adidas',
                'category_slug' => 'mens-shoes',
                'subcategory_slug' => 'mens-sneakers',
                'child_category_slug' => 'mens-lifestyle-sneakers',
                'sku' => 'FLT-0002',
                'price' => 110,
                'sale_price' => null,
                'features' => [
                    'Premium leather overlays',
                    'Responsive cloud foam insole',
                    'Heritage three-stripe design',
                ],
                'specifications' => [
                    'Closure' => 'Lace-up',
                    'Sole Material' => 'TPR',
                    'Upper Material' => 'Leather',
                    'Heel Height' => '2.4 cm',
                ],
                'variants' => [
                    ['color_code' => 'BROWN', 'size_code' => 'M8.5', 'price' => 112, 'sale_price' => null, 'stock' => 10],
                    ['color_code' => 'GRAY', 'size_code' => 'M9.5', 'price' => 110, 'sale_price' => null, 'stock' => 16],
                    ['color_code' => 'BURGUNDY', 'size_code' => 'M10.5', 'price' => 108, 'sale_price' => null, 'stock' => 9],
                ],
            ],
            [
                'name' => 'Filter Test Trailforce Boot',
                'slug' => 'filter-test-trailforce-boot',
                'brand_slug' => 'timberland',
                'category_slug' => 'mens-shoes',
                'subcategory_slug' => 'mens-boots',
                'child_category_slug' => 'mens-work-boots',
                'sku' => 'FLT-0003',
                'price' => 185,
                'sale_price' => 165,
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
                'variants' => [
                    ['color_code' => 'FOREST_GREEN', 'size_code' => 'M9', 'price' => 189, 'sale_price' => 168, 'stock' => 8],
                    ['color_code' => 'BROWN', 'size_code' => 'M10', 'price' => 185, 'sale_price' => 162, 'stock' => 11],
                ],
            ],
            [
                'name' => 'Filter Test Glide Trainer',
                'slug' => 'filter-test-glide-trainer',
                'brand_slug' => 'under-armour',
                'category_slug' => 'sports-athletic',
                'subcategory_slug' => 'training-shoes',
                'child_category_slug' => null,
                'sku' => 'FLT-0004',
                'price' => 95,
                'sale_price' => 89,
                'features' => [
                    'Micro G foam cushioning',
                    '360 mesh ventilation',
                    'Midfoot lockdown band',
                ],
                'specifications' => [
                    'Closure' => 'Lace-up',
                    'Sole Material' => 'EVA',
                    'Upper Material' => 'Mesh',
                    'Heel Height' => '2.1 cm',
                ],
                'variants' => [
                    ['color_code' => 'ROYAL_BLUE', 'size_code' => 'M7.5', 'price' => 96, 'sale_price' => 88, 'stock' => 20],
                    ['color_code' => 'GRAY', 'size_code' => 'M8.5', 'price' => 95, 'sale_price' => 89, 'stock' => 22],
                    ['color_code' => 'RED', 'size_code' => 'M9.5', 'price' => 98, 'sale_price' => 90, 'stock' => 18],
                ],
            ],
            [
                'name' => 'Filter Test Breeze Sandal',
                'slug' => 'filter-test-breeze-sandal',
                'brand_slug' => 'crocs',
                'category_slug' => 'sandals-flip-flops',
                'subcategory_slug' => 'slides',
                'child_category_slug' => 'pool-slides',
                'sku' => 'FLT-0005',
                'price' => 45,
                'sale_price' => null,
                'features' => [
                    'Lightweight EVA construction',
                    'Adjustable heel strap',
                    'Textured comfort footbed',
                ],
                'specifications' => [
                    'Closure' => 'Slip-on',
                    'Sole Material' => 'EVA',
                    'Upper Material' => 'Synthetic',
                    'Heel Height' => '1.4 cm',
                ],
                'variants' => [
                    ['color_code' => 'PINK', 'size_code' => 'W7', 'price' => 44, 'sale_price' => null, 'stock' => 25],
                    ['color_code' => 'BEIGE', 'size_code' => 'W8', 'price' => 45, 'sale_price' => null, 'stock' => 19],
                    ['color_code' => 'LIGHT_GRAY', 'size_code' => 'W9', 'price' => 46, 'sale_price' => null, 'stock' => 21],
                ],
            ],
            [
                'name' => 'Filter Test Playground Sneaker',
                'slug' => 'filter-test-playground-sneaker',
                'brand_slug' => 'skechers',
                'category_slug' => 'kids-shoes',
                'subcategory_slug' => 'kids-sneakers',
                'child_category_slug' => null,
                'sku' => 'FLT-0006',
                'price' => 60,
                'sale_price' => 52,
                'features' => [
                    'Hook-and-loop strap closure',
                    'Memory foam cushioning',
                    'Reinforced toe bumper',
                ],
                'specifications' => [
                    'Closure' => 'Velcro',
                    'Sole Material' => 'Rubber',
                    'Upper Material' => 'Mesh',
                    'Heel Height' => '2.0 cm',
                ],
                'variants' => [
                    ['color_code' => 'PURPLE', 'size_code' => 'K3', 'price' => 60, 'sale_price' => 52, 'stock' => 17],
                    ['color_code' => 'NAVY', 'size_code' => 'K4', 'price' => 61, 'sale_price' => 53, 'stock' => 15],
                    ['color_code' => 'RED', 'size_code' => 'K5', 'price' => 59, 'sale_price' => 51, 'stock' => 20],
                ],
            ],
        ];

        foreach ($datasets as $index => $data) {
            $category = Category::where('slug', $data['category_slug'])->where('is_active', true)->first();
            $subcategory = Subcategory::where('slug', $data['subcategory_slug'])->where('is_active', true)->first();
            $childCategory = $data['child_category_slug']
                ? ChildCategory::where('slug', $data['child_category_slug'])->where('is_active', true)->first()
                : null;
            $brand = Brand::where('slug', $data['brand_slug'])->where('is_active', true)->first();

            if (! $category || ! $subcategory || ! $brand) {
                continue;
            }

            $product = Product::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'category_id' => $category->id,
                    'subcategory_id' => $subcategory->id,
                    'child_category_id' => $childCategory?->id,
                    'brand_id' => $brand->id,
                    'name' => $data['name'],
                    'description' => "Purpose-built to validate category filtering, the {$data['name']} offers consistent attributes for automated QA flows while remaining a realistic catalogue entry.",
                    'short_description' => 'Deterministic demo product seeded for filter QA scenarios.',
                    'sku' => $data['sku'],
                    'main_image' => $shoeImages[$index % count($shoeImages)],
                    'price' => $data['price'],
                    'sale_price' => $data['sale_price'],
                    'cost_price' => (int) round($data['price'] * 0.6),
                    'min_stock_level' => 5,
                    'weight' => 0.9,
                    'dimensions' => '32 x 10 x 12 cm',
                    'material' => 'Mixed synthetic and natural fabrics',
                    'size_guide' => 'True to size for filter test assortment.',
                    'features' => $data['features'],
                    'specifications' => $data['specifications'],
                    'meta_title' => $data['name'] . ' | Filter QA Fixture',
                    'meta_description' => 'Seeded product crafted to validate storefront filtering journeys.',
                    'meta_keywords' => ['filter test', 'demo inventory', 'seed data'],
                    'is_active' => true,
                    'is_featured' => false,
                    'track_inventory' => true,
                ]
            );

            $product->variants()->delete();

            foreach ($data['variants'] as $variant) {
                $color = Color::where('code', $variant['color_code'])->where('is_active', true)->first();
                $size = Size::where('code', $variant['size_code'])->where('is_active', true)->first();

                if (! $color || ! $size) {
                    continue;
                }

                ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id' => $color->id,
                    'size_id' => $size->id,
                    'sku' => $product->sku . '-' . $color->code . '-' . $size->code,
                    'name' => $product->name . ' - ' . $color->name . ' - ' . $size->name,
                    'price' => $variant['price'],
                    'sale_price' => $variant['sale_price'],
                    'stock_quantity' => $variant['stock'],
                    'weight' => $product->weight,
                    'is_active' => true,
                    'attributes' => [
                        'color' => $color->name,
                        'size' => $size->name,
                    ],
                ]);
            }
        }
    }

    private function createProductVariants(Product $product, $sizes, $colors)
    {
        // Select 2-3 random colors
        $selectedColors = $colors->random(rand(2, 3));

        // Select 2-3 random sizes based on product category
        $sizePool = $this->getSizePoolForCategory($product->category->slug, $sizes);
        if ($sizePool->count() == 0) {
            return; // Skip if no sizes available for this category
        }
        $selectedSizes = $sizePool->random(min(rand(2, 3), $sizePool->count()));

        foreach ($selectedColors as $color) {
            foreach ($selectedSizes as $size) {
                // Create variant
                $variantPrice = $product->price + rand(-10, 20); // Slight price variation
                $variantCost = $product->cost_price + rand(-5, 10);

                ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id' => $color->id,
                    'size_id' => $size->id,
                    'sku' => $product->sku . '-' . strtoupper($color->code) . '-' . strtoupper($size->code),
                    'name' => $product->name . ' - ' . $color->name . ' - ' . $size->name,
                    'price' => max($variantPrice, $product->price * 0.9), // Don't go below 90% of base price
                    'sale_price' => $product->sale_price ? $product->sale_price + rand(-5, 5) : null,
                    'stock_quantity' => rand(5, 25),
                    'weight' => $product->weight + (rand(-10, 10) / 100), // Slight weight variation
                    'is_active' => true,
                    'attributes' => [
                        'color' => $color->name,
                        'size' => $size->name,
                    ],
                ]);
            }
        }
    }

    private function getSizePoolForCategory($categorySlug, $sizes)
    {
        switch ($categorySlug) {
            case 'mens-shoes':
            case 'sports-athletic':
            case 'formal-shoes':
            case 'casual-shoes':
            case 'boots-ankle-boots':
                // Men's sizes
                return $sizes->filter(function ($size) {
                    return str_starts_with($size->code, 'M');
                });
            case 'womens-shoes':
            case 'sandals-flip-flops':
                // Women's sizes
                return $sizes->filter(function ($size) {
                    return str_starts_with($size->code, 'W');
                });
            case 'kids-shoes':
                // Kids' sizes
                return $sizes->filter(function ($size) {
                    return str_starts_with($size->code, 'K');
                });
            default:
                return $sizes->take(5); // Fallback
        }
    }

    private function getRandomMaterial()
    {
        $materials = [
            'Synthetic leather, rubber sole',
            'Genuine leather, rubber outsole',
            'Canvas, vulcanized rubber',
            'Mesh, foam, rubber',
            'Suede, crepe rubber',
            'Nubuck leather, rubber',
            'Textile, EVA foam',
            'Premium leather, air-cushioned sole',
        ];
        return $materials[array_rand($materials)];
    }

    private function getRandomFeatures()
    {
        $featurePool = [
            'Breathable upper',
            'Cushioned insole',
            'Durable outsole',
            'Padded collar',
            'Lightweight construction',
            'Flexible sole',
            'Shock absorption',
            'Quick-dry materials',
            'Anti-slip grip',
            'Seamless design',
            'Reinforced toe cap',
            'Memory foam',
        ];

        $numFeatures = rand(3, 5);
        $selectedFeatures = array_rand(array_flip($featurePool), $numFeatures);
        return array_values($selectedFeatures);
    }

    private function getRandomSpecifications()
    {
        return [
            'Closure' => ['Lace-up', 'Slip-on', 'Buckle', 'Zip'][rand(0, 3)],
            'Sole Material' => ['Rubber', 'EVA', 'PU', 'TPR'][rand(0, 3)],
            'Upper Material' => ['Synthetic', 'Leather', 'Canvas', 'Mesh'][rand(0, 3)],
            'Heel Height' => rand(1, 5) . ' cm',
        ];
    }
}
