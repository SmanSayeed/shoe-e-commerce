<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, Searchable, InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'child_category_id',
        'brand_id',
        'brand',
        'color_id',
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'main_image',
        'video_url',
        'price',
        'sale_price',
        'cost_price',
        'features',
        'specifications',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'is_featured',
        'view_count',
        'sales_count',
        'sale_start_date',
        'sale_end_date',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'features' => 'array',
        'specifications' => 'array',
        'meta_keywords' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sale_start_date' => 'datetime',
        'sale_end_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Generate slug from product name
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            // Auto-generate SKU in format ST123456
            if (empty($product->sku)) {
                $product->sku = static::generateUniqueSku();
            }
        });

        static::updating(function ($product) {
            // Update slug if name changed
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Generate a unique SKU in format ST123456
     */
    public static function generateUniqueSku(): string
    {
        $maxAttempts = 100;
        $attempt = 0;

        do {
            // Generate 6 random digits - ensure truly random each time
            // Use mt_rand which is automatically seeded in PHP 7.1+
            $randomNumber = mt_rand(100000, 999999);
            $sku = 'ST' . $randomNumber;
            $attempt++;

            // Check if SKU already exists
            $exists = static::where('sku', $sku)->exists();

            if (!$exists) {
                return $sku;
            }

            // If we've tried too many times, use timestamp + random for uniqueness
            if ($attempt >= $maxAttempts) {
                // Use last 4 digits of timestamp + 2 random digits
                $timestamp = substr(time(), -4);
                $randomSuffix = str_pad(mt_rand(10, 99), 2, '0', STR_PAD_LEFT);
                $sku = 'ST' . $timestamp . $randomSuffix;
                
                // Double check this one too
                if (!static::where('sku', $sku)->exists()) {
                    return $sku;
                }
                
                // Last resort: use microtime + random
                $microtime = substr(str_replace('.', '', microtime(true)), -4);
                $randomSuffix = str_pad(mt_rand(10, 99), 2, '0', STR_PAD_LEFT);
                return 'ST' . $microtime . $randomSuffix;
            }
        } while ($attempt < $maxAttempts);

        // Fallback (should never reach here) - use current timestamp + random
        $timestamp = substr(time(), -4);
        $randomSuffix = str_pad(mt_rand(10, 99), 2, '0', STR_PAD_LEFT);
        return 'ST' . $timestamp . $randomSuffix;
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

    public function childCategory(): BelongsTo
    {
        return $this->belongsTo(ChildCategory::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        // First check if product has a main_image set
        if ($this->main_image) {
            return $this->main_image;
        }

        // Otherwise, get the first primary image from product_images table
        return $this->images()->primary()->first()?->image_path;
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

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'product_colors');
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
        return $query->where('track_inventory', false)
                    ->orWhereHas('variants', function($q) {
                        $q->where('stock_quantity', '>', 0);
                    });
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
        return $this->variants()->where('stock_quantity', '>', 0)->exists();
    }

    public function isLowStock()
    {
        if (!$this->track_inventory) {
            return false;
        }
        return $this->variants()
            ->where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', $this->min_stock_level)
            ->exists();
    }

    public function totalStock()
    {
        return $this->variants()->sum('stock_quantity');
    }

    public function availableVariants()
    {
        return $this->variants()->where('stock_quantity', '>', 0)->get();
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'sku' => $this->sku,
            'brand' => $this->brand ?? $this->brand?->name,
            'category' => $this->category?->name,
            'subcategory' => $this->subcategory?->name,
            'child_category' => $this->childCategory?->name,
            'color' => $this->color?->name,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
        ];
    }

    /**
     * Register media collections for brand logos
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('brand_logos')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
            ->useDisk('public');
    }

    /**
     * Register media conversions for brand logos
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('brand_logos');
    }

    /**
     * Get brand logo URL
     */
    public function getBrandLogoUrlAttribute(): ?string
    {
        $media = $this->getFirstMedia('brand_logos');
        return $media ? $media->getUrl() : null;
    }
}
