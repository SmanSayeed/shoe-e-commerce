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

    public function scopeWithProduct($query)
    {
        return $query->with(['product', 'color', 'size']);
    }

    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%")
              ->orWhereHas('product', function($productQuery) use ($search) {
                  $productQuery->where('name', 'like', "%{$search}%");
              });
        });
    }

    public function scopeFilterByStatus($query, $status)
    {
        if ($status === 'active') {
            return $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            return $query->where('is_active', false);
        }
        return $query;
    }

    public function scopeFilterByStock($query, $stockFilter)
    {
        switch ($stockFilter) {
            case 'in_stock':
                return $query->where('stock_quantity', '>', 0);
            case 'out_of_stock':
                return $query->where('stock_quantity', '<=', 0);
            case 'low_stock':
                return $query->where('stock_quantity', '>', 0)
                           ->whereRaw('stock_quantity <= (SELECT min_stock_level FROM products WHERE products.id = product_variants.product_id)');
            default:
                return $query;
        }
    }

    public function getDisplayNameAttribute()
    {
        $parts = [$this->name];

        if ($this->color) {
            $parts[] = $this->color->name;
        }

        if ($this->size) {
            $parts[] = $this->size->name;
        }

        return implode(' - ', $parts);
    }
}
