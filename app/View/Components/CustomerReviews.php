<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Review;
use App\Models\Product;

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
        return Review::with(['user', 'product'])
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->limit(4)
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
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'productName' => $review->product ? $review->product->name : 'Product',
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
        if ($review->user) {
            return $review->user->name;
        }
        
        // If no user, use a generic name
        return 'Customer';
    }

    /**
     * Get sample reviews for demonstration
     */
    private function getSampleReviews()
    {
        $sampleReviews = [
            [
                'customerName' => 'Arafat',
                'rating' => 5.0,
                'comment' => 'Loved the leather and finishing. Worth every penny!',
                'productName' => 'Leather Shoes'
            ],
            [
                'customerName' => 'Sakib',
                'rating' => 4.5,
                'comment' => 'Bag quality is top‑notch and delivery was fast.',
                'productName' => 'Office Bag'
            ],
            [
                'customerName' => 'Faruque',
                'rating' => 5.0,
                'comment' => 'Shoes are comfortable and elegant. Great value!',
                'productName' => 'Formal Shoes'
            ],
            [
                'customerName' => 'Mitu',
                'rating' => 4.8,
                'comment' => 'Excellent craftsmanship on the belt. Feels premium.',
                'productName' => 'Leather Belt'
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
