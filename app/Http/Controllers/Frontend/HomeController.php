<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Review;
use App\Models\Customer;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        // Get new products (created in the last 30 days)
        $newProducts = Product::with(['images', 'variants', 'category', 'brand'])
            ->where('is_active', true)
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Process new products with calculated values
        $processedProducts = $newProducts->map(function($product) {
            return [
                'product' => $product,
                'discountPercentage' => $this->calculateDiscountPercentage($product->price, $product->sale_price),
                'rating' => $this->getProductRating($product),
                'productImage' => $this->getProductImage($product),
            ];
        });

        // Get active banners
        $banners = Banner::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Get best products (featured or best selling)
        $bestProducts = Product::with(['images', 'variants', 'category', 'brand'])
            ->where('is_active', true)
            ->where(function($query) {
                $query->where('is_featured', true)
                      ->orWhere('sales_count', '>', 0);
            })
            ->orderBy('is_featured', 'desc')
            ->orderBy('sales_count', 'desc')
            ->orderBy('view_count', 'desc')
            ->limit(3)
            ->get();

        // Process best products
        $processedBestProducts = $bestProducts->map(function($product) {
            return [
                'product' => $product,
                'discountPercentage' => $this->calculateDiscountPercentage($product->price, $product->sale_price),
                'rating' => $this->getProductRating($product),
                'productImage' => $this->getProductImage($product),
            ];
        });

        // Get special products (on sale)
        $specialProducts = Product::with(['images', 'variants', 'category', 'brand'])
            ->where('is_active', true)
            ->whereNotNull('sale_price')
            ->where('sale_start_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('sale_end_date')
                  ->orWhere('sale_end_date', '>=', now());
            })
            ->orderByRaw('(price - sale_price) / price DESC')
            ->limit(5)
            ->get();

        // Process special products
        $processedSpecialProducts = $specialProducts->map(function($product) {
            return [
                'product' => $product,
                'discountPercentage' => $this->calculateDiscountPercentage($product->price, $product->sale_price),
                'rating' => $this->getProductRating($product),
                'productImage' => $this->getProductImage($product),
            ];
        });

        // Get categories with subcategories
        $categories = Category::with(['subcategories'])
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->limit(4)
            ->get();

        // Get brands dynamically from products (for brands section)
        // Get unique brands with their logos in a single optimized query
        $brandsData = Product::where('is_active', true)
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->with('media')
            ->get()
            ->groupBy('brand')
            ->map(function($products, $brandName) {
                // Get first product with logo for this brand
                $productWithLogo = $products->first(function($product) {
                    try {
                        return !empty($product->brand_logo_url);
                    } catch (\Exception $e) {
                        return false;
                    }
                });
                
                // If we found a product with logo, use it
                if ($productWithLogo) {
                    try {
                        $logoUrl = $productWithLogo->brand_logo_url;
                        return [
                            'name' => $brandName,
                            'logo_url' => $logoUrl, // Can be null if no logo uploaded
                        ];
                    } catch (\Exception $e) {
                        // If error getting logo, still return brand name
                        return [
                            'name' => $brandName,
                            'logo_url' => null,
                        ];
                    }
                }
                
                // If no product with logo, still return brand name (will show as text)
                return [
                    'name' => $brandName,
                    'logo_url' => null,
                ];
            })
            ->filter()
            ->values();

        // Get recent reviews
        $reviews = Review::with(['customer', 'product'])
            ->whereHas('product', function($query) {
                $query->where('is_active', true);
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get recently sold products (simulate with recent orders)
        $recentlySoldProductIds = Order::with('items')
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(7))
            ->pluck('id');

        $processedRecentlySoldProducts = collect();
        if ($recentlySoldProductIds->count() > 0) {
            $recentlySoldProducts = Product::with(['images', 'variants', 'category', 'brand'])
                ->whereIn('id', function($query) use ($recentlySoldProductIds) {
                    $query->select('product_id')
                          ->from('order_items')
                          ->whereIn('order_id', $recentlySoldProductIds);
                })
                ->where('is_active', true)
                ->limit(8)
                ->get();

            // Process recently sold products
            $processedRecentlySoldProducts = $recentlySoldProducts->map(function($product) {
                return [
                    'product' => $product,
                    'discountPercentage' => $this->calculateDiscountPercentage($product->price, $product->sale_price),
                    'rating' => $this->getProductRating($product),
                    'productImage' => $this->getProductImage($product),
                ];
            });
        }

        // Get featured products
        $featuredProducts = Product::with(['images', 'variants'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function($product) {
                return [
                    'product' => $product,
                    'discountPercentage' => $this->calculateDiscountPercentage($product->price, $product->sale_price),
                    'rating' => $this->getProductRating($product),
                    'productImage' => $this->getProductImage($product),
                ];
            });

        // Get all products (limited to 6 for homepage display)
        $allProducts = Product::with(['images', 'variants'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get()
            ->map(function($product) {
                return [
                    'product' => $product,
                    'discountPercentage' => $this->calculateDiscountPercentage($product->price, $product->sale_price),
                    'rating' => $this->getProductRating($product),
                    'productImage' => $this->getProductImage($product),
                ];
            });

        return view('home', [
            'banners' => $banners,
            'newProducts' => $processedProducts,
            'bestProducts' => $processedBestProducts,
            'specialProducts' => $processedSpecialProducts,
            'categories' => $categories,
            'brands' => $brandsData,
            'reviews' => $reviews,
            'featuredProducts' => $featuredProducts,
            'allProducts' => $allProducts
        ]);
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
        // You can implement this based on actual reviews later
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
