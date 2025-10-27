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

        // Process products for display
        $processedProducts = $products->through(function($product) {
            return [
                'product' => $product,
                'discountPercentage' => $this->calculateDiscountPercentage($product->price, $product->sale_price),
                'rating' => $this->getProductRating($product),
                'productImage' => $this->getProductImage($product),
            ];
        });

        return view('frontend.categories.subcategory', compact('category', 'subcategory', 'products', 'processedProducts'));
    }

    /**
     * Calculate discount percentage
     */
    private function calculateDiscountPercentage($originalPrice, $salePrice)
    {
        if (!$salePrice || $salePrice >= $originalPrice) {
            return 0;
        }

        return round((($originalPrice - $salePrice) / $originalPrice) * 100);
    }

    /**
     * Get product rating (you can implement this based on reviews)
     */
    private function getProductRating($product)
    {
        // For now, return a random rating between 3.5 and 5.0
        return number_format(rand(350, 500) / 100, 1);
    }

    /**
     * Get product image URL
     */
    private function getProductImage($product)
    {
        // First try main_image from product
        if ($product->main_image) {
            return $product->main_image;
        }

        // Then try product images relationship
        if ($product->images && $product->images->count() > 0) {
            return $product->images->first()->image_path;
        }

        // Fallback to a default image
        return 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=400&auto=format&fit=crop';
    }
}
