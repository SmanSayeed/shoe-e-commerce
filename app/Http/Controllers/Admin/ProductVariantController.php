<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductVariantController extends Controller
{
    public function index(Request $request)
    {
        // Only show variants that have a size_id (size variants only)
        $query = ProductVariant::with(['size'])->whereNotNull('size_id');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Stock filter
        if ($request->filled('stock')) {
            if ($request->stock === 'in_stock') {
                $query->where('stock_quantity', '>', 0);
            } elseif ($request->stock === 'out_of_stock') {
                $query->where('stock_quantity', '<=', 0);
            } elseif ($request->stock === 'low_stock') {
                $query->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 10);
            }
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        if ($sortBy === 'name') {
            $query->orderBy('name', $sortDirection);
        } elseif ($sortBy === 'stock') {
            $query->orderBy('stock_quantity', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $variants = $query->paginate(15)->withQueryString();

        $sizes = Size::active()->orderBy('name')->get();

        return view('admin.product-variants.index', compact('variants', 'sizes'));
    }

    public function create()
    {
        $sizes = Size::active()->orderBy('name')->get();

        return view('admin.product-variants.create', compact('sizes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:product_variants,sku',
            'size_id' => 'required|exists:sizes,id',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'weight' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $variantPath = public_path('images/products/variants');
            if (!file_exists($variantPath)) {
                mkdir($variantPath, 0755, true);
            }
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move($variantPath, $imageName);
            $validated['image'] = 'images/products/variants/' . $imageName;
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        // Build attributes array with only size
        $attributes = [];
        if (!empty($validated['size_id'])) {
            $size = Size::find($validated['size_id']);
            $attributes['size'] = $size ? $size->name : null;
        }
        $validated['attributes'] = $attributes;

        ProductVariant::create($validated);

        return redirect()->route('admin.product-variants.index')->with('success', 'Size variant created successfully!');
    }

    public function show(ProductVariant $variant)
    {
        $variant->load(['size']);
        return view('admin.product-variants.show', compact('variant'));
    }

    public function edit(ProductVariant $variant)
    {
        $variant->load(['size']);
        $sizes = Size::active()->orderBy('name')->get();

        return view('admin.product-variants.edit', compact('variant', 'sizes'));
    }

    public function update(Request $request, ProductVariant $variant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => ['required', 'string', 'max:255', Rule::unique('product_variants')->ignore($variant->id)],
            'size_id' => 'required|exists:sizes,id',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'weight' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($variant->image && file_exists(public_path($variant->image))) {
                unlink(public_path($variant->image));
            }

            $variantPath = public_path('images/products/variants');
            if (!file_exists($variantPath)) {
                mkdir($variantPath, 0755, true);
            }
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move($variantPath, $imageName);
            $validated['image'] = 'images/products/variants/' . $imageName;
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : $variant->is_active;

        // Build attributes array with only size
        $attributes = [];
        if (!empty($validated['size_id'])) {
            $size = Size::find($validated['size_id']);
            $attributes['size'] = $size ? $size->name : null;
        }
        $validated['attributes'] = $attributes;

        $variant->update($validated);

        return redirect()->route('admin.product-variants.index')->with('success', 'Size variant updated successfully!');
    }

    public function destroy(ProductVariant $variant)
    {
        // Delete image if exists
        if ($variant->image && file_exists(public_path($variant->image))) {
            unlink(public_path($variant->image));
        }

        $variant->delete();

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Variant deleted successfully!'
            ]);
        }

        return redirect()->route('admin.product-variants.index')->with('success', 'Variant deleted successfully!');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:product_variants,id'
        ]);

        $variants = ProductVariant::whereIn('id', $request->ids)->get();

        foreach ($variants as $variant) {
            // Delete image if exists
            if ($variant->image && file_exists(public_path($variant->image))) {
                unlink(public_path($variant->image));
            }
        }

        ProductVariant::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true, 'message' => 'Selected variants deleted successfully!']);
    }

    public function toggleStatus(ProductVariant $variant)
    {
        $variant->update(['is_active' => !$variant->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'is_active' => $variant->is_active
        ]);
    }

    public function updateStock(Request $request, ProductVariant $variant)
    {
        $validated = $request->validate([
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $oldStock = $variant->stock_quantity;
        $variant->update(['stock_quantity' => $validated['stock_quantity']]);

        return response()->json([
            'success' => true,
            'message' => 'Stock updated successfully from ' . $oldStock . ' to ' . $validated['stock_quantity'],
            'stock_quantity' => $variant->stock_quantity,
            'old_stock' => $oldStock
        ]);
    }
}
