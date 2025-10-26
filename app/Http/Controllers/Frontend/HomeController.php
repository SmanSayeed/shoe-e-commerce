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
    }
}
