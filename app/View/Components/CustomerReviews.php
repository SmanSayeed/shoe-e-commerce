<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Review;

class CustomerReviews extends Component
{
    public $reviews;
    public $processedReviews;

    public function __construct()
    {
        // Get customer reviews
        $this->reviews = $this->getReviews();

        // Process reviews with calculated values
        $this->processedReviews = $this->getProcessedReviews();
    }

    /**
     * Get customer reviews
     */
    private function getReviews()
    {
        return Review::with(['customer.user', 'product'])
            ->homepage()
            ->limit(10)
            ->get();
    }

    /**
     * Get processed reviews with calculated values
     */
    private function getProcessedReviews()
    {
        // Only return real reviews from database
        return $this->reviews->map(function ($review) {
            return [
                'review' => $review,
                'customerName' => $this->getCustomerName($review),
                'location' => $review->reviewer_location,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'productName' => $this->getProductName($review),
                'reviewedAt' => $review->reviewed_at ?? $review->created_at,
            ];
        });
    }

    /**
     * Get customer name from review
     */
    private function getCustomerName($review)
    {
        if ($review->reviewer_name) {
            return $review->reviewer_name;
        }

        if ($review->customer && $review->customer->user) {
            return $review->customer->user->name;
        }

        // If no user, use a generic name
        return 'Customer';
    }

    private function getProductName($review)
    {
        if ($review->product_display_name) {
            return $review->product_display_name;
        }

        if ($review->product) {
            return $review->product->name;
        }

        return 'Product';
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.customer-reviews');
    }
}
