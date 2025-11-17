<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    /**
     * Display the Privacy Policy page
     */
    public function privacy()
    {
        return view('frontend.static.privacy', [
            'title' => 'Privacy Policy'
        ]);
    }

    /**
     * Display the Terms and Conditions page
     */
    public function terms()
    {
        return view('frontend.static.terms', [
            'title' => 'Terms and Conditions'
        ]);
    }

    /**
     * Display the Support page
     */
    public function support()
    {
        return view('frontend.static.support', [
            'title' => 'Support'
        ]);
    }
}

