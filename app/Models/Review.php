<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'customer_id',
        'order_id',
        'reviewer_name',
        'reviewer_email',
        'reviewer_location',
        'product_display_name',
        'rating',
        'title',
        'comment',
        'reviewed_at',
        'images',
        'is_verified_purchase',
        'is_approved',
        'show_on_homepage',
        'display_order',
        'is_featured',
        'helpful_count',
        'not_helpful_count',
    ];

    protected $casts = [
        'rating' => 'integer',
        'images' => 'array',
        'is_verified_purchase' => 'boolean',
        'is_approved' => 'boolean',
        'show_on_homepage' => 'boolean',
        'display_order' => 'integer',
        'is_featured' => 'boolean',
        'helpful_count' => 'integer',
        'not_helpful_count' => 'integer',
        'reviewed_at' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified_purchase', true);
    }

    public function scopeHomepage($query)
    {
        return $query->where('show_on_homepage', true)
            ->where('is_approved', true)
            ->orderBy('display_order')
            ->orderByDesc('reviewed_at')
            ->orderByDesc('created_at');
    }
}
