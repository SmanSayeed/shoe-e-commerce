<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'brand_id',
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'price',
        'sale_price',
        'cost_price',
        'stock_quantity',
        'min_stock_level',
        'weight',
        'dimensions',
        'material',
        'color',
        'size_guide',
        'features',
        'specifications',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'is_featured',
        'is_digital',
        'track_inventory',
        'rating',
        'review_count',
        'view_count',
        'sales_count',
        'sale_start_date',
        'sale_end_date',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'rating' => 'decimal:2',
        'features' => 'array',
        'specifications' => 'array',
        'meta_keywords' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_digital' => 'boolean',
        'track_inventory' => 'boolean',
        'sale_start_date' => 'datetime',
        'sale_end_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'SKU-' . strtoupper(Str::random(8));
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('sale_price')
                    ->where('sale_start_date', '<=', now())
                    ->where(function ($q) {
                        $q->whereNull('sale_end_date')
                          ->orWhere('sale_end_date', '>=', now());
                    });
    }

    public function getCurrentPriceAttribute()
    {
        if ($this->isOnSale()) {
            return $this->sale_price;
        }
        return $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->isOnSale() && $this->price > 0) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    public function isOnSale()
    {
        return $this->sale_price &&
               $this->sale_start_date <= now() &&
               ($this->sale_end_date === null || $this->sale_end_date >= now());
    }

    public function isInStock()
    {
        if (!$this->track_inventory) {
            return true;
        }
        return $this->stock_quantity > 0;
    }

    public function isLowStock()
    {
        return $this->track_inventory && $this->stock_quantity <= $this->min_stock_level;
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'sku' => $this->sku,
            'brand' => $this->brand?->name,
            'category' => $this->category?->name,
            'subcategory' => $this->subcategory?->name,
            'material' => $this->material,
            'color' => $this->color,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
        ];
    }
}
