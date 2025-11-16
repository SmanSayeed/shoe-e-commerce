<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Cache;

class Brand extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'website',
        'meta_title',
        'meta_description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name);
            }
        });

        static::updating(function ($brand) {
            if ($brand->isDirty('name') && empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name);
            }
        });

        // Clear cache on save/update/delete
        static::saved(function () {
            Cache::forget('latest_brands');
        });

        static::deleted(function () {
            Cache::forget('latest_brands');
        });
    }

    /**
     * Register media collections for brand logos
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('brand_logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif']);
    }

    /**
     * Register media conversions for brand logos
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')
            ->width(400)
            ->height(200)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('brand_logo');
    }

    /**
     * Get brand logo URL with WebP fallback
     * Checks Spatie Media Library first, then falls back to legacy logo field
     */
    public function getBrandLogoUrlAttribute(): ?string
    {
        // First, try Spatie Media Library
        $media = $this->getFirstMedia('brand_logo');
        if ($media) {
            // Try WebP conversion first, fallback to original
            try {
                $webpUrl = $media->getUrl('webp');
                if ($webpUrl) {
                    return $webpUrl;
                }
            } catch (\Exception $e) {
                // Fallback to original if WebP conversion fails
            }

            return $media->getUrl();
        }

        // Fallback to legacy logo field if media library has no logo
        if ($this->logo) {
            // Check if it's a full URL or relative path
            if (filter_var($this->logo, FILTER_VALIDATE_URL)) {
                return $this->logo;
            }
            // Return asset URL for relative paths
            return asset($this->logo);
        }

        return null;
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
