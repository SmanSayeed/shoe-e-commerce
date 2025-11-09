<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display the specified category with its products and subcategories
     */
    public function show($categorySlug, $subcategorySlug = null)
    {
        // Get the category
        $category = Category::where('slug', $categorySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $subcategory = null;
        $products = collect();

        // If subcategory slug is provided
        if ($subcategorySlug) {
            $subcategory = Subcategory::where('category_id', $category->id)
                ->where('slug', $subcategorySlug)
                ->where('is_active', true)
                ->firstOrFail();

            // Get products for this subcategory
            $products = Product::with(['images', 'variants', 'category', 'brand'])
                ->whereHas('subcategory', function($query) use ($subcategory) {
                    $query->where('id', $subcategory->id);
                })
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        } else {
            // Get all active subcategories for this category
            $category->load(['subcategories' => function($query) {
                $query->where('is_active', true)
                      ->orderBy('name')
                      ->withCount('products');
            }]);

            // Get products for this category (including those in subcategories)
            $products = Product::with(['images', 'variants', 'category', 'brand', 'subcategory'])
                ->where('category_id', $category->id)
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        }

        // Get all active categories for the sidebar
        $categories = Category::with(['subcategories' => function($query) {
            $query->where('is_active', true)->orderBy('name');
        }])->where('is_active', true)
          ->orderBy('name')
          ->get();

        return view('frontend.categories.show', [
            'category' => $category,
            'subcategory' => $subcategory,
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => $category->id,
            'activeSubcategory' => $subcategory ? $subcategory->id : null
        ]);
    }
}
