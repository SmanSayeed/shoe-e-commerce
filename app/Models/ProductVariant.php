<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'sku',
        'name',
        'attributes',
        'price',
        'sale_price',
        'stock_quantity',
        'image',
        'weight',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'attributes' => 'array',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price ?? $this->product->current_price;
    }

    public function isInStock()
    {
        return $this->stock_quantity > 0;
    }
}
