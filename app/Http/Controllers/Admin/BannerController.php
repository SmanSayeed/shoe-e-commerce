<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::orderBy('order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = Str::slug($validated['title']) . '-' . time() . '.' . $image->getClientOriginalExtension();
            
            // Ensure the directory exists
            $path = public_path('images/banner');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            
            // Save the image
            $image->move($path, $filename);
            $validated['image'] = $filename;
        }

        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($banner->image && file_exists(public_path('images/banner/' . $banner->image))) {
                unlink(public_path('images/banner/' . $banner->image));
            }

            $image = $request->file('image');
            $filename = Str::slug($validated['title']) . '-' . time() . '.' . $image->getClientOriginalExtension();
            
            // Save the new image
            $image->move(public_path('images/banner'), $filename);
            $validated['image'] = $filename;
        }

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        // Delete the image file
        if ($banner->image && file_exists(public_path('images/banner/' . $banner->image))) {
            unlink(public_path('images/banner/' . $banner->image));
        }

        $banner->delete();

        return response()->json(['success' => 'Banner deleted successfully.']);
    }

    /**
     * Update the banner order.
     */
    public function updateOrder(Request $request)
    {
        $banners = $request->input('banners');
        
        foreach ($banners as $banner) {
            Banner::where('id', $banner['id'])->update(['order' => $banner['order']]);
        }
        
        return response()->json(['success' => 'Order updated successfully.']);
    }
}
