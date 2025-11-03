<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerProductController extends Controller
{
    /**
     * Show product page with dynamic data.
     */
    public function show($slug = null)
    {
        // If no slug provided, redirect to home
        if (! $slug) {
            return redirect()->route('home');
        }

        // Find product by slug
        $product = Product::with([
            'category',
            'subcategory',
            'childCategory',
            'brand',
            'images'   => function ($query) {
                $query->ordered();
            },
             'variants' => function ($query) {
                 $query->with(['size']);
             },
            'reviews'  => function ($query) {
                $query->with('customer')->latest()->limit(10);
            },
        ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        // If product not found, redirect to home
        if (! $product) {
            return redirect()->route('home')->with('error', 'Product not found');
        }

        // Update view count
        $product->increment('view_count');

        return view('product.show', compact('product'));
    }

    /**
     * Get product data for AJAX requests.
     */
    public function getProductData($id): JsonResponse
    {
        try {
            $product = Product::with([
                'category',
                'subcategory',
                'childCategory',
                'brand',
                'images'   => function ($query) {
                    $query->ordered();
                },
                'variants' => function ($query) {
                    $query->with(['size'])->active();
                },
                'reviews'  => function ($query) {
                    $query->with('customer')->latest()->limit(10);
                },
            ])
                ->where('id', $id)
                ->where('is_active', true)
                ->first();

            if (! $product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            // Update view count
            $product->increment('view_count');

            return response()->json($product);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load product data'], 500);
        }
    }

    /**
     * Show checkout page.
     */
    public function checkout()
    {
        return view('product.checkout');
    }
}
