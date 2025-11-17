<?php

namespace Database\Seeders;

use App\Models\ChildCategory;
use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChildCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $childCategories = [
            // Men's Sneakers Child Categories
            [
                'subcategory_slug' => 'mens-sneakers',
                'name' => 'Lifestyle Sneakers',
                'slug' => 'mens-lifestyle-sneakers',
                'description' => 'Casual lifestyle sneakers for everyday wear.',
                'image' => 'images/childcategories/mens-lifestyle-sneakers.jpg',
                'meta_title' => 'Men\'s Lifestyle Sneakers | Casual Comfort',
                'meta_description' => 'Discover casual lifestyle sneakers perfect for everyday comfort and style.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'subcategory_slug' => 'mens-sneakers',
                'name' => 'Athletic Sneakers',
                'slug' => 'mens-athletic-sneakers',
                'description' => 'Performance athletic sneakers for sports and training.',
                'image' => 'images/childcategories/mens-athletic-sneakers.jpg',
                'meta_title' => 'Men\'s Athletic Sneakers | Performance Wear',
                'meta_description' => 'Gear up with performance athletic sneakers for sports and training.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'subcategory_slug' => 'mens-sneakers',
                'name' => 'High-Top Sneakers',
                'slug' => 'mens-high-top-sneakers',
                'description' => 'Stylish high-top sneakers with ankle support.',
                'image' => 'images/childcategories/mens-high-top-sneakers.jpg',
                'meta_title' => 'Men\'s High-Top Sneakers | Ankle Support',
                'meta_description' => 'Get stylish high-top sneakers with excellent ankle support and protection.',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($childCategories as $childCategoryData) {
            $subcategory = Subcategory::where('slug', $childCategoryData['subcategory_slug'])->first();

            if ($subcategory) {
                $childCategory = [
                    'subcategory_id' => $subcategory->id,
                    'name' => $childCategoryData['name'],
                    'slug' => $childCategoryData['slug'],
                    'description' => $childCategoryData['description'],
                    'image' => $childCategoryData['image'],
                    'meta_title' => $childCategoryData['meta_title'],
                    'meta_description' => $childCategoryData['meta_description'],
                    'is_active' => $childCategoryData['is_active'],
                    'sort_order' => $childCategoryData['sort_order'],
                ];

                ChildCategory::updateOrCreate(
                    ['slug' => $childCategoryData['slug']],
                    $childCategory
                );
            }
        }
    }
}
