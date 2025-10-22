<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
// use App\Models\Product;
// use App\Models\Category;
// use App\Models\Brand;
// use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        return view('home');
        
        // TODO: Add data fetching logic later
        // Get featured products (recently added or best sellers)
        // $featuredProducts = Product::with(['images', 'variants'])
        //     ->where('is_featured', true)
        //     ->orWhere('status', 'active')
        //     ->latest()
        //     ->limit(8)
        //     ->get();

        // Get categories for navigation
        // $categories = Category::with('subcategories')
        //     ->where('status', 'active')
        //     ->orderBy('name')
        //     ->get();

        // Get brands
        // $brands = Brand::where('status', 'active')
        //     ->orderBy('name')
        //     ->get();

        // Get recently sold products (from order items)
        // $recentlySold = Product::with(['images', 'variants'])
        //     ->whereHas('orderItems')
        //     ->withCount('orderItems')
        //     ->orderBy('order_items_count', 'desc')
        //     ->limit(6)
        //     ->get();

        // Get statistics for dashboard
        // $stats = [
        //     'total_products' => Product::count(),
        //     'total_categories' => Category::count(),
        //     'total_brands' => Brand::count(),
        //     'total_orders' => Order::count(),
        // ];

        // return view('home', compact(
        //     'featuredProducts',
        //     'categories', 
        //     'brands',
        //     'recentlySold',
        //     'stats'
        // ));
    }
}
