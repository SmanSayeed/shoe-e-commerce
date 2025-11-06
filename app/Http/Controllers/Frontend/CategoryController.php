<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display the specified category with its products
     */
    public function show(Category $category)
    {
        // Ensure category is active
        if (!$category->is_active) {
            abort(404, 'Category not found');
        }

        // Get category with relationships
        $category->load([
            'subcategories' => function($query) {
                $query->where('is_active', true)->orderBy('name');
            }
        ]);

        // Get products in this category
        $products = Product::with(['images', 'variants', 'category', 'brand'])
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('frontend.categories.show', compact('category', 'products'));
    }
}
