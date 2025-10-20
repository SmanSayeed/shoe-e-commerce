<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Placeholder controller kept for potential future use in admin area.

    /**
     * Show product page and capture id from query string.
     */
    public function show(Request $request)
    {
        $id = $request->query('id', 'no-id');
        
        // Try to return the view, fallback to simple response if there are issues
        try {
            return view('product.show', ['id' => $id]);
        } catch (\Exception $e) {
            return response('<h1>Product Page</h1><p>ID: ' . $id . '</p><p>Error: ' . $e->getMessage() . '</p>');
        }
    }
}
