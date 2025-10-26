<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all existing products
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please run ProductSeeder first.');
            return;
        }

        // Get available colors and sizes
        $colors = Color::all();
        $sizes = Size::all();

        // Define stock quantity ranges for different scenarios
        $stockRanges = [
            'high_stock' => [50, 100],    // Popular items
            'medium_stock' => [20, 49],   // Regular items
            'low_stock' => [5, 19],       // Limited items
            'out_of_stock' => [0, 0],     // Some items out of stock
        ];

        $this->command->info("Creating variants for {$products->count()} products...");

        foreach ($products as $product) {
            // Skip if product doesn't track inventory
            if (!$product->track_inventory) {
                continue;
            }

            // Create 3-8 variants per product (random number)
            $variantCount = rand(3, 8);
            $createdVariants = 0;

            // Get random colors and sizes for this product
            $productColors = $colors->random(min($variantCount, $colors->count()));
            $productSizes = $sizes->random(min($variantCount, $sizes->count()));

            for ($i = 0; $i < $variantCount; $i++) {
                // Get random color and size, ensuring we don't exceed available options
                $color = $productColors[$i % $productColors->count()];
                $size = $productSizes[$i % $productSizes->count()];

                // Generate unique SKU for this variant
                $variantSku = $this->generateVariantSku($product->sku, $color->code, $size->code);

                // Determine stock quantity based on product popularity (simulated)
                $stockType = $this->getStockType($product, $i);
                $stockQuantity = rand($stockRanges[$stockType][0], $stockRanges[$stockType][1]);

                // Create variant name
                $variantName = $product->name;
                if ($color->name !== 'One Size') {
                    $variantName .= ' - ' . $color->name;
                }
                if ($size->name !== 'One Size') {
                    $variantName .= ' - Size ' . $size->name;
                }

                // Build attributes array
                $attributes = [];
                if ($color->id) {
                    $attributes['color'] = $color->name;
                }
                if ($size->id) {
                    $attributes['size'] = $size->name;
                }

                // Determine if this variant should be active (95% chance)
                $isActive = rand(1, 100) <= 95;

                try {
                    ProductVariant::firstOrCreate(
                        ['sku' => $variantSku],
                        [
                            'product_id' => $product->id,
                            'color_id' => $color->id,
                            'size_id' => $size->id,
                            'name' => $variantName,
                            'attributes' => $attributes,
                            'price' => $product->price,
                            'sale_price' => $product->sale_price,
                            'stock_quantity' => $stockQuantity,
                            'image' => null,
                            'weight' => $product->weight,
                            'is_active' => $isActive,
                            'sort_order' => $i,
                        ]
                    );

                    $createdVariants++;
                } catch (\Exception $e) {
                    // This should rarely happen now, but keeping for safety
                    $this->command->warn("Skipped variant for product {$product->name}: " . $e->getMessage());
                }
            }

            $this->command->info("Created {$createdVariants} variants for: {$product->name}");
        }

        $this->command->info('Product variant seeding completed!');
    }

    /**
     * Generate a unique SKU for the variant.
     */
    private function generateVariantSku(string $baseSku, string $colorCode, string $sizeCode): string
    {
        // Clean the codes to ensure they're URL-friendly
        $colorCode = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $colorCode));
        $sizeCode = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $sizeCode));

        // Create variant SKU
        return $baseSku . '-' . $colorCode . '-' . $sizeCode;
    }

    /**
     * Determine stock type based on product and variant index.
     */
    private function getStockType(Product $product, int $variantIndex): string
    {
        // Featured products tend to have higher stock
        if ($product->is_featured) {
            return ['high_stock', 'medium_stock'][array_rand(['high_stock', 'medium_stock'])];
        }

        // Randomly distribute stock levels, but ensure some variety
        $rand = rand(1, 100);

        if ($rand <= 10) return 'out_of_stock';  // 10% chance
        if ($rand <= 30) return 'low_stock';     // 20% chance (30-10=20)
        if ($rand <= 70) return 'medium_stock';  // 40% chance (70-30=40)
        return 'high_stock';                     // 30% chance (100-70=30)
    }
}
