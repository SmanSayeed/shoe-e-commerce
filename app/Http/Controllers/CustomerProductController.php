<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerProductController extends Controller
{
    // Placeholder controller kept for potential future use in admin area.

    /**
     * Show product page.
     */
    public function show()
    {
        return view('product.show');
    }

    /**
     * Show checkout page.
     */
    public function checkout()
    {
        return view('product.checkout');
    }
}
