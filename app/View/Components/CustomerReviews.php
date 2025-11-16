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
        // If we have real reviews, use them
        if ($this->reviews->count() > 0) {
            return $this->reviews->map(function($review) {
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

        // Fallback: Generate sample reviews if no real reviews exist
        return $this->getSampleReviews();
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
     * Get sample reviews for demonstration
     */
    private function getSampleReviews()
    {
        $sampleReviews = [
            [
                'customerName' => 'Arafat Rahman',
                'rating' => 5.0,
                'comment' => 'Absolutely love the quality of these leather shoes! The craftsmanship is outstanding and they feel incredibly comfortable. The delivery was super fast too. Highly recommend SSB Leather!',
                'productName' => 'Premium Leather Oxford Shoes'
            ],
            [
                'customerName' => 'Faruque Hassan',
                'rating' => 5.0,
                'comment' => 'These formal shoes are exactly what I was looking for. Comfortable from day one, elegant design, and the leather quality is top-notch. Will definitely order again!',
                'productName' => 'Classic Formal Dress Shoes'
            ],
            [
                'customerName' => 'Mitu Akter',
                'rating' => 4.9,
                'comment' => 'The leather belt is beautifully crafted with attention to detail. It feels premium and durable. The customer service was also excellent. Very satisfied with my purchase!',
                'productName' => 'Genuine Leather Belt'
            ],
            [
                'customerName' => 'Fatima Begum',
                'rating' => 5.0,
                'comment' => 'I\'m so impressed with the handbag quality! The leather is soft yet durable, and the design is timeless. It\'s become my go-to bag for all occasions. Thank you SSB Leather!',
                'productName' => 'Elegant Leather Handbag'
            ]
        ];

        return collect($sampleReviews);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.customer-reviews');
    }
}
