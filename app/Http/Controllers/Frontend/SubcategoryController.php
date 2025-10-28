<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Show products for the selected category.
     */
    public function categoryProducts(string $slug)
    {
        try {
            $category = Category::where('slug', $slug)
                ->where('is_active', true)
                ->first();

            if (! $category) {
                return redirect()->route('home')->with('error', 'Category not found.');
            }

            $products = Product::with([
                'brand',
                'images' => function ($query) {
                    $query->orderBy('sort_order');
                },
            ])
                ->where('category_id', $category->id)
                ->where('is_active', true)
                ->latest()
                ->paginate(12);

            return view('product.category', compact('category', 'products'));
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('home')->with('error', 'Unable to load category products at the moment.');
        }
    }

    /**
     * Display the specified subcategory with its products
     */
    public function show(Category $category, Subcategory $subcategory)
    {
        // Ensure both category and subcategory are active
        if (!$category->is_active || !$subcategory->is_active) {
            abort(404, 'Category or subcategory not found');
        }

        // Ensure subcategory belongs to the category
        if ($subcategory->category_id !== $category->id) {
            abort(404, 'Subcategory not found in this category');
        }

        // Get subcategory with relationships
        $subcategory->load([
            'childCategories' => function($query) {
                $query->where('is_active', true)->orderBy('name');
            }
        ]);

        // Get products in this subcategory
        $products = Product::with(['images', 'variants', 'category', 'brand'])
            ->where('subcategory_id', $subcategory->id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

            return view('frontend.categories.subcategory', compact('category', 'subcategory', 'products'));
    }
}
