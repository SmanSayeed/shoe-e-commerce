<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $query = Review::with(['product', 'customer.user']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reviewer_name', 'like', "%{$search}%")
                    ->orWhere('reviewer_email', 'like', "%{$search}%")
                    ->orWhere('comment', 'like', "%{$search}%")
                    ->orWhere('product_display_name', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($subQuery) use ($search) {
                        $subQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('rating')) {
            $query->where('rating', (int) $request->input('rating'));
        }

        if ($request->filled('status')) {
            $query->where('is_approved', $request->input('status') === 'approved');
        }

        if ($request->filled('visibility')) {
            $query->where('show_on_homepage', $request->input('visibility') === 'visible');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('reviewed_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('reviewed_at', '<=', $request->input('date_to'));
        }

        $sortBy = $request->input('sort', 'display_order');
        $direction = $request->input('direction', $sortBy === 'display_order' ? 'asc' : 'desc');
        $allowedSorts = ['display_order', 'rating', 'reviewed_at', 'created_at'];
        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'display_order';
            $direction = 'asc';
        }

        $query->orderBy($sortBy, $direction);
        if ($sortBy !== 'display_order') {
            $query->orderBy('display_order');
        }

        $reviews = $query->paginate(15)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function create(): View
    {
        $products = Product::orderBy('name')->pluck('name', 'id');
        $customers = \App\Models\Customer::selectRaw("id, CONCAT(first_name, ' ', last_name) as full_name")
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->pluck('full_name', 'id');
        $review = new Review();

        return view('admin.reviews.create', compact('review', 'products', 'customers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateReview($request);

        Review::create($data);

        return redirect()->route('admin.reviews.index')->with('success', 'Review created successfully.');
    }

    public function edit(Review $review): View
    {
        $products = Product::orderBy('name')->pluck('name', 'id');
        $customers = \App\Models\Customer::selectRaw("id, CONCAT(first_name, ' ', last_name) as full_name")
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->pluck('full_name', 'id');

        return view('admin.reviews.edit', compact('review', 'products', 'customers'));
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        $data = $this->validateReview($request, $review);

        $review->update($data);

        return redirect()->route('admin.reviews.index')->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:reviews,id',
        ]);

        Review::whereIn('id', $validated['ids'])->delete();

        return redirect()->back()->with('success', 'Selected reviews deleted successfully.');
    }

    public function toggleApproval(Review $review): Response
    {
        $review->update(['is_approved' => !$review->is_approved]);

        return response([
            'success' => true,
            'message' => 'Approval status updated.',
            'is_approved' => $review->is_approved,
        ]);
    }

    public function toggleVisibility(Review $review): Response
    {
        $review->update(['show_on_homepage' => !$review->show_on_homepage]);

        return response([
            'success' => true,
            'message' => 'Homepage visibility updated.',
            'show_on_homepage' => $review->show_on_homepage,
        ]);
    }

    private function validateReview(Request $request, ?Review $review = null): array
    {
        $rules = [
            'customer_id' => 'nullable|exists:customers,id',
            'reviewer_name' => 'required|string|max:255',
            'reviewer_email' => 'nullable|email|max:255',
            'reviewer_location' => 'nullable|string|max:255',
            'product_id' => 'nullable|exists:products,id',
            'product_display_name' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string',
            'reviewed_at' => 'nullable|date',
            'display_order' => 'nullable|integer|min:0',
            'is_verified_purchase' => 'nullable|boolean',
            'is_approved' => 'nullable|boolean',
            'show_on_homepage' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ];

        $data = $request->validate($rules);

        $data['is_verified_purchase'] = $request->boolean('is_verified_purchase');
        $data['is_approved'] = $request->boolean('is_approved');
        $data['show_on_homepage'] = $request->boolean('show_on_homepage', true);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['reviewed_at'] = $data['reviewed_at'] ?? now()->toDateString();

        if (!isset($data['display_order'])) {
            $data['display_order'] = (Review::max('display_order') ?? 0) + 1;
        }

        if (empty($data['product_display_name']) && !empty($data['product_id'])) {
            $data['product_display_name'] = optional(Product::find($data['product_id']))->name;
        }

        return $data;
    }
}
