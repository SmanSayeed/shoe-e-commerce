<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
       public function index()
    {
        return view('admin.sub-categories');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create-sub-category');
    }
}
