<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Men\'s Shoes',
                'slug' => 'mens-shoes',
                'description' => 'Discover our extensive collection of men\'s footwear including sneakers, dress shoes, boots, and casual shoes.',
                'image' => 'images/categories/mens-shoes.jpg',
                'meta_title' => 'Men\'s Shoes | Premium Footwear Collection',
                'meta_description' => 'Shop the latest collection of men\'s shoes including sneakers, dress shoes, boots, and casual footwear. Find your perfect pair today.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Women\'s Shoes',
                'slug' => 'womens-shoes',
                'description' => 'Explore our stylish collection of women\'s footwear featuring heels, flats, sneakers, boots, and sandals.',
                'image' => 'images/categories/womens-shoes.jpg',
                'meta_title' => 'Women\'s Shoes | Fashionable Footwear Collection',
                'meta_description' => 'Browse our trendy collection of women\'s shoes including heels, flats, sneakers, boots, and sandals. Step out in style.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Kids\' Shoes',
                'slug' => 'kids-shoes',
                'description' => 'Find comfortable and durable shoes for children including school shoes, sneakers, and casual footwear.',
                'image' => 'images/categories/kids-shoes.jpg',
                'meta_title' => 'Kids\' Shoes | Comfortable Children\'s Footwear',
                'meta_description' => 'Shop our collection of kids\' shoes including school shoes, sneakers, and casual footwear. Comfort and durability guaranteed.',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
