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

    public function search(Request $request)
    {
        $term = trim((string) $request->query('q', ''));

        if ($term === '') {
            return redirect()->back()->with('error', 'Please enter a product name or SKU.');
        }

        $products = Product::query()
            ->with(['category', 'brand', 'images'])
            ->where('is_active', true)
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                      ->orWhere('sku', 'like', "%{$term}%");
            })
            ->orderByDesc('sales_count')
            ->paginate(24)
            ->withQueryString();

        return view('product.search', [
            'products' => $products,
            'term' => $term,
        ]);
    }

    public function suggest(Request $request): JsonResponse
    {
        $term = trim((string) $request->query('q', ''));

        if (mb_strlen($term) < 2) {
            return response()->json(['data' => []]);
        }

        $products = Product::query()
            ->with(['images' => function ($query) {
                $query->ordered()->limit(1);
            }, 'brand:id,name'])
            ->where('is_active', true)
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                      ->orWhere('sku', 'like', "%{$term}%");
            })
            ->orderByDesc('sales_count')
            ->limit(8)
            ->get(['id', 'name', 'slug', 'sku', 'main_image', 'price', 'sale_price', 'brand_id']);

        $items = $products->map(function (Product $product) {
            $rawImage = $product->main_image
                ?? optional($product->images->first())->image_path
                ?? 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=200&auto=format&fit=crop';

            $imageUrl = str_starts_with($rawImage, 'http') || str_starts_with($rawImage, '//')
                ? $rawImage
                : asset($rawImage);

            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'sku' => $product->sku,
                'brand' => $product->brand?->name,
                'price' => $product->current_price,
                'image' => $imageUrl,
            ];
        });

        return response()->json(['data' => $items]);
    }
}
