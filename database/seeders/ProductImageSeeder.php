<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            // Create multiple images for each product
            $images = [
                [
                    'image_path' => $product->main_image,
                    'alt_text' => $product->name . ' - Main View',
                    'is_primary' => true,
                    'sort_order' => 0,
                ],
                [
                    'image_path' => str_replace('w=800&h=600', 'w=800&h=600&crop=center', $product->main_image),
                    'alt_text' => $product->name . ' - Side View',
                    'is_primary' => false,
                    'sort_order' => 1,
                ],
                [
                    'image_path' => str_replace('w=800&h=600', 'w=800&h=600&crop=top', $product->main_image),
                    'alt_text' => $product->name . ' - Top View',
                    'is_primary' => false,
                    'sort_order' => 2,
                ],
                [
                    'image_path' => str_replace('w=800&h=600', 'w=800&h=600&crop=bottom', $product->main_image),
                    'alt_text' => $product->name . ' - Detail View',
                    'is_primary' => false,
                    'sort_order' => 3,
                ],
            ];

            foreach ($images as $imageData) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imageData['image_path'],
                    'alt_text' => $imageData['alt_text'],
                    'is_primary' => $imageData['is_primary'],
                    'sort_order' => $imageData['sort_order'],
                ]);
            }
        }

        $this->command->info('Product images seeded successfully!');
    }
}
