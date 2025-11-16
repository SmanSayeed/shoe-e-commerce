# Site Settings System - Complete Blueprint & Implementation Guide

## 📋 Table of Contents
1. [Overview](#overview)
2. [Architecture](#architecture)
3. [Database Structure](#database-structure)
4. [Backend Implementation](#backend-implementation)
5. [Frontend Integration](#frontend-integration)
6. [Step-by-Step Implementation Guide](#step-by-step-implementation-guide)
7. [Best Practices](#best-practices)
8. [Troubleshooting](#troubleshooting)

---

## 🎯 Overview

The Site Settings system is a **singleton-based configuration management system** that allows administrators to manage all website settings from a centralized admin dashboard. It provides:

- **Centralized Configuration**: All site settings in one place
- **Dynamic Frontend Updates**: Changes reflect immediately on the frontend
- **Caching**: High-performance caching for fast access
- **Type Safety**: Automatic type casting (boolean, integer, JSON, etc.)
- **File Management**: Logo, favicon, and OG image uploads
- **SEO Management**: Meta tags, Open Graph, and canonical URLs
- **Theme Customization**: Dynamic color schemes
- **Maintenance Mode**: Built-in maintenance mode toggle

---

## 🏗️ Architecture

### System Components

```
┌─────────────────────────────────────────────────────────────┐
│                    Admin Dashboard                           │
│  (resources/views/admin/site-settings/index.blade.php)      │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│              SiteSettingController                          │
│  (app/Http/Controllers/Admin/SiteSettingController.php)     │
│  - index() - Display settings form                          │
│  - update() - Save settings                                 │
│  - deleteLogo() - Delete logo                               │
│  - deleteFavicon() - Delete favicon                         │
│  - toggleMaintenanceMode() - Toggle maintenance             │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│              UpdateSiteSettingRequest                        │
│  (app/Http/Requests/Admin/UpdateSiteSettingRequest.php)     │
│  - Validation rules                                          │
│  - Custom error messages                                    │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│                  SiteSetting Model                           │
│  (app/Models/SiteSetting.php)                               │
│  - Singleton pattern (getSettings())                        │
│  - Automatic cache management                                │
│  - File URL accessors (logo_url, favicon_url)               │
│  - Type casting (JSON, boolean, datetime)                    │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│              Database: site_settings table                  │
│  - Single row (singleton)                                   │
│  - All settings in one record                              │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│            SiteSettingsHelper                                │
│  (app/Helpers/SiteSettingsHelper.php)                       │
│  - Static helper methods                                    │
│  - Easy access from views                                   │
│  - Graceful error handling                                  │
└──────────────────────┬──────────────────────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────┐
│              Frontend Components                             │
│  - Header (logo, website name)                              │
│  - Footer (contact, social links, copyright)                │
│  - Layouts (meta tags, CSS variables, custom CSS/JS)        │
└─────────────────────────────────────────────────────────────┘
```

### Key Design Patterns

1. **Singleton Pattern**: Only one settings record exists in the database
2. **Repository Pattern**: Helper class abstracts data access
3. **Cache-Aside Pattern**: Settings cached for 1 hour, cleared on update
4. **Accessor Pattern**: Model accessors for computed values (URLs)

---

## 💾 Database Structure

### Migration: `create_site_settings_table.php`

```php
Schema::create('site_settings', function (Blueprint $table) {
    $table->id();
    
    // Website Information
    $table->string('website_name')->default('Your Site');
    $table->string('website_tagline')->nullable();
    $table->text('website_description')->nullable();
    
    // Logo and Favicon
    $table->string('logo_path')->nullable();
    $table->string('favicon_path')->nullable();
    
    // Contact Information
    $table->string('primary_email')->nullable();
    $table->string('secondary_email')->nullable();
    $table->string('primary_phone')->nullable();
    $table->string('secondary_phone')->nullable();
    $table->text('physical_address')->nullable();
    $table->text('business_hours')->nullable();
    
    // Social Media Links (JSON)
    $table->json('social_media_links')->nullable();
    
    // Localization
    $table->string('default_currency', 3)->default('USD');
    $table->string('default_language', 10)->default('en');
    $table->json('supported_languages')->nullable();
    $table->string('timezone')->default('UTC');
    
    // SEO Settings
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();
    $table->text('meta_keywords')->nullable();
    $table->string('og_title')->nullable();
    $table->text('og_description')->nullable();
    $table->string('og_image')->nullable();
    $table->text('canonical_url')->nullable();
    
    // Maintenance Mode
    $table->boolean('maintenance_mode')->default(false);
    $table->text('maintenance_message')->nullable();
    $table->timestamp('maintenance_scheduled_at')->nullable();
    $table->timestamp('maintenance_scheduled_until')->nullable();
    
    // Additional Settings
    $table->text('footer_text')->nullable();
    $table->string('copyright_notice')->nullable();
    $table->string('primary_color')->default('#3B82F6');
    $table->string('secondary_color')->default('#1E293B');
    $table->string('accent_color')->default('#EF4444');
    $table->string('google_analytics_id')->nullable();
    $table->text('custom_css')->nullable();
    $table->text('custom_js')->nullable();
    $table->json('email_notification_preferences')->nullable();
    
    $table->timestamps();
    $table->softDeletes();
    
    $table->index('maintenance_mode');
});
```

### Key Points:
- **Single Row**: Only one record should exist (enforced by singleton pattern)
- **Nullable Fields**: Most fields are nullable for flexibility
- **JSON Fields**: Complex data stored as JSON (social_media_links, supported_languages)
- **Soft Deletes**: Settings can be soft-deleted (though rarely used)

---

## 🔧 Backend Implementation

### 1. Model: `SiteSetting.php`

**Key Features:**
- Singleton pattern with `getSettings()` method
- Automatic cache management (1 hour TTL)
- Cache clearing on save/update/delete
- File URL accessors (logo_url, favicon_url, og_image_url)
- Type casting for JSON, boolean, datetime fields
- Mutators for data validation (social_media_links, supported_languages)

**Core Methods:**

```php
// Get or create singleton instance (cached)
public static function getSettings(): self
{
    return Cache::remember('site_settings', 3600, function () {
        return static::firstOrCreate([], [
            'website_name' => 'Your Site',
            'default_currency' => 'USD',
            'default_language' => 'en',
            'timezone' => 'UTC',
            'primary_color' => '#3B82F6',
            'secondary_color' => '#1E293B',
            'accent_color' => '#EF4444',
        ]);
    });
}

// Clear cache
public static function clearCache(): void
{
    Cache::forget('site_settings');
}

// Automatic cache clearing on model events
protected static function boot(): void
{
    parent::boot();
    
    static::saved(function () {
        static::clearCache();
    });
    
    static::deleted(function () {
        static::clearCache();
    });
}
```

### 2. Controller: `SiteSettingController.php`

**Key Features:**
- Image upload handling (logo, favicon, OG image)
- Image resizing and optimization using Intervention Image
- Old file cleanup on upload
- Transaction support for data integrity
- Error logging

**Core Methods:**

```php
// Display settings form
public function index()
{
    $settings = SiteSetting::getSettings();
    return view('admin.site-settings.index', compact('settings'));
}

// Update settings
public function update(UpdateSiteSettingRequest $request)
{
    try {
        DB::beginTransaction();
        
        $settings = SiteSetting::getSettings();
        $data = $request->validated();
        
        // Handle file uploads
        if ($request->hasFile('logo')) {
            $oldLogo = $settings->logo_path;
            $logoPath = $this->handleImageUpload($request->file('logo'), 'logos', 300, 300);
            $data['logo_path'] = $logoPath;
            
            // Delete old logo
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
        }
        
        // Update settings
        $settings->update($data);
        SiteSetting::clearCache();
        
        DB::commit();
        
        return redirect()->route('admin.site-settings.index')
            ->with('success', 'Site settings updated successfully!');
            
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Failed to update site settings', ['error' => $e->getMessage()]);
        
        return redirect()->back()
            ->with('error', 'Failed to update site settings. Please try again.')
            ->withInput();
    }
}

// Handle image upload with resizing
private function handleImageUpload($file, string $folder, ?int $width = null, ?int $height = null): string
{
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    $path = "site-settings/{$folder}/{$filename}";
    
    // Handle SVG files (no resizing)
    if ($file->getClientOriginalExtension() === 'svg') {
        Storage::disk('public')->putFileAs("site-settings/{$folder}", $file, $filename);
        return $path;
    }
    
    // Resize and optimize using Intervention Image
    $manager = new ImageManager(new Driver());
    $image = $manager->read($file->getRealPath());
    
    if ($width && $height) {
        $image->cover($width, $height);
    }
    
    $tempPath = sys_get_temp_dir() . '/' . uniqid('img_', true) . '.' . $file->getClientOriginalExtension();
    $image->save($tempPath, 90);
    $imageContent = file_get_contents($tempPath);
    
    Storage::disk('public')->put($path, $imageContent);
    
    if (file_exists($tempPath)) {
        @unlink($tempPath);
    }
    
    return $path;
}
```

### 3. Form Request: `UpdateSiteSettingRequest.php`

**Key Features:**
- Comprehensive validation rules
- Custom error messages
- Authorization check (admin only)
- Data preparation (maintenance_mode checkbox handling)

**Example Validation Rules:**

```php
public function rules(): array
{
    return [
        'website_name' => ['required', 'string', 'max:255'],
        'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
        'favicon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,ico', 'max:1024'],
        'primary_email' => ['nullable', 'email', 'max:255'],
        'primary_phone' => ['nullable', 'string', 'max:20'],
        'social_media_links.facebook' => ['nullable', 'url', 'max:255'],
        'default_currency' => ['required', 'string', Rule::in(['USD', 'EUR', 'GBP', 'BDT'])],
        'primary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        // ... more rules
    ];
}
```

### 4. Helper: `SiteSettingsHelper.php`

**Key Features:**
- Static helper methods for easy access
- Graceful error handling with fallbacks
- Type-safe getters for common settings
- Convenience methods (websiteName(), logoUrl(), etc.)

**Example Methods:**

```php
// Get all settings
public static function all(): SiteSetting
{
    try {
        return SiteSetting::getSettings();
    } catch (\Exception $e) {
        Log::error('Error loading site settings: ' . $e->getMessage());
        // Fallback to defaults
        return new SiteSetting();
    }
}

// Get specific setting
public static function get(string $key, $default = null)
{
    $settings = static::all();
    return $settings->$key ?? $default;
}

// Convenience methods
public static function websiteName(): string
{
    return static::get('website_name', 'Your Site');
}

public static function logoUrl(): ?string
{
    try {
        $settings = static::all();
        return $settings->logo_url ?? null;
    } catch (\Exception $e) {
        return null;
    }
}

public static function primaryColor(): string
{
    return static::get('primary_color', '#3B82F6');
}
```

---

## 🎨 Frontend Integration

### 1. Admin Dashboard View

**Location:** `resources/views/admin/site-settings/index.blade.php`

**Features:**
- Tabbed interface (General, Branding, Contact, Social, SEO, etc.)
- Image preview and upload
- Color pickers for theme colors
- Real-time validation
- Success/error messages

**Key Sections:**
- **General**: Website name, tagline, description
- **Branding**: Logo, favicon upload with preview
- **Contact**: Emails, phones, address, business hours
- **Social**: Social media links (Facebook, Instagram, etc.)
- **SEO**: Meta tags, Open Graph, canonical URL
- **Theme**: Primary, secondary, accent colors
- **Advanced**: Custom CSS, JavaScript, Google Analytics

### 2. Frontend Components Usage

**Header Component:**
```blade
@php
    $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
    $websiteName = \App\Helpers\SiteSettingsHelper::websiteName();
    $primaryColor = \App\Helpers\SiteSettingsHelper::primaryColor();
@endphp

@if($logoUrl)
    <img src="{{ $logoUrl }}" alt="{{ $websiteName }}">
@else
    <span>{{ $websiteName }}</span>
@endif
```

**Footer Component:**
```blade
@php
    $footerText = \App\Helpers\SiteSettingsHelper::footerText();
    $primaryEmail = \App\Helpers\SiteSettingsHelper::primaryEmail();
    $primaryPhone = \App\Helpers\SiteSettingsHelper::primaryPhone();
    $socialLinks = \App\Helpers\SiteSettingsHelper::socialLinks();
    $copyright = \App\Helpers\SiteSettingsHelper::copyrightNotice();
@endphp

<p>{{ $footerText }}</p>
<a href="mailto:{{ $primaryEmail }}">{{ $primaryEmail }}</a>
<a href="tel:{{ $primaryPhone }}">{{ $primaryPhone }}</a>

@foreach($socialLinks as $platform => $url)
    @if($url)
        <a href="{{ $url }}" target="_blank">{{ $platform }}</a>
    @endif
@endforeach

<p>{{ str_replace('{year}', date('Y'), $copyright) }}</p>
```

**Layout File (Meta Tags, CSS Variables):**
```blade
@php
    $settings = \App\Helpers\SiteSettingsHelper::all();
@endphp

<head>
    <title>{{ $settings->meta_title ?? $title ?? 'Default Title' }}</title>
    <meta name="description" content="{{ $settings->meta_description }}">
    <meta name="keywords" content="{{ is_array($settings->meta_keywords) ? implode(', ', $settings->meta_keywords) : $settings->meta_keywords }}">
    
    <!-- Open Graph -->
    <meta property="og:title" content="{{ $settings->og_title ?? $settings->meta_title }}">
    <meta property="og:description" content="{{ $settings->og_description ?? $settings->meta_description }}">
    @if($settings->og_image_url)
        <meta property="og:image" content="{{ $settings->og_image_url }}">
    @endif
    
    <!-- Favicon -->
    @if($settings->favicon_url)
        <link rel="icon" href="{{ $settings->favicon_url }}">
    @endif
    
    <!-- Theme Colors as CSS Variables -->
    <style>
        :root {
            --color-primary: {{ $settings->primary_color }};
            --color-secondary: {{ $settings->secondary_color }};
            --color-accent: {{ $settings->accent_color }};
        }
    </style>
    
    <!-- Custom CSS -->
    @if($settings->custom_css)
        <style>{!! $settings->custom_css !!}</style>
    @endif
    
    <!-- Google Analytics -->
    @if($settings->google_analytics_id)
        <!-- Google Analytics code here -->
    @endif
</head>

<body>
    <!-- Page content -->
    
    <!-- Custom JavaScript -->
    @if($settings->custom_js)
        <script>{!! $settings->custom_js !!}</script>
    @endif
</body>
```

---

## 📝 Step-by-Step Implementation Guide

### Step 1: Create Migration

```bash
php artisan make:migration create_site_settings_table
```

**Migration File:**
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            // Add all columns as shown in Database Structure section
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
```

### Step 2: Create Model

```bash
php artisan make:model SiteSetting
```

**Model File:** See `app/Models/SiteSetting.php` section above.

### Step 3: Create Seeder (Optional)

```bash
php artisan make:seeder SiteSettingSeeder
```

**Seeder File:**
```php
<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        if (SiteSetting::count() > 0) {
            return;
        }

        SiteSetting::create([
            'website_name' => 'Your Site',
            'default_currency' => 'USD',
            'default_language' => 'en',
            'timezone' => 'UTC',
            'primary_color' => '#3B82F6',
            'secondary_color' => '#1E293B',
            'accent_color' => '#EF4444',
            // ... other defaults
        ]);
    }
}
```

### Step 4: Create Helper Class

**File:** `app/Helpers/SiteSettingsHelper.php`

See Helper section above for complete implementation.

**Register Helper (Optional):**

Add to `composer.json`:
```json
{
    "autoload": {
        "files": [
            "app/Helpers/SiteSettingsHelper.php"
        ]
    }
}
```

Then run: `composer dump-autoload`

### Step 5: Create Form Request

```bash
php artisan make:request Admin/UpdateSiteSettingRequest
```

**Form Request:** See `UpdateSiteSettingRequest.php` section above.

### Step 6: Create Controller

```bash
php artisan make:controller Admin/SiteSettingController
```

**Controller:** See `SiteSettingController.php` section above.

### Step 7: Create Routes

**In `routes/web.php` (inside admin middleware group):**

```php
Route::get('/site-settings', [SiteSettingController::class, 'index'])->name('site-settings.index');
Route::put('/site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');
Route::delete('/site-settings/logo', [SiteSettingController::class, 'deleteLogo'])->name('site-settings.delete-logo');
Route::delete('/site-settings/favicon', [SiteSettingController::class, 'deleteFavicon'])->name('site-settings.delete-favicon');
Route::post('/site-settings/toggle-maintenance', [SiteSettingController::class, 'toggleMaintenanceMode'])->name('site-settings.toggle-maintenance');
```

### Step 8: Create Admin View

**File:** `resources/views/admin/site-settings/index.blade.php`

Create a comprehensive form with:
- Tabbed interface
- File upload fields (logo, favicon, OG image)
- Color pickers
- Text inputs, textareas
- Validation error display
- Success/error messages

### Step 9: Integrate in Frontend

**Update Header:**
```blade
@php
    $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
    $websiteName = \App\Helpers\SiteSettingsHelper::websiteName();
@endphp
```

**Update Footer:**
```blade
@php
    $footerText = \App\Helpers\SiteSettingsHelper::footerText();
    $primaryEmail = \App\Helpers\SiteSettingsHelper::primaryEmail();
    // ... etc
@endphp
```

**Update Layout:**
```blade
@php
    $settings = \App\Helpers\SiteSettingsHelper::all();
@endphp
<!-- Add meta tags, CSS variables, custom CSS/JS -->
```

### Step 10: Run Migration and Seeder

```bash
php artisan migrate
php artisan db:seed --class=SiteSettingSeeder
```

---

## ✅ Best Practices

### 1. Caching Strategy
- **Cache Duration**: 1 hour (3600 seconds)
- **Cache Key**: `site_settings`
- **Cache Clearing**: Automatic on save/update/delete
- **Fallback**: Direct database query if cache fails

### 2. Error Handling
- Always wrap helper calls in try-catch blocks
- Provide sensible defaults for all settings
- Log errors for debugging
- Never let settings errors break the frontend

### 3. File Management
- Store files in `storage/app/public/site-settings/`
- Use organized folders: `logos/`, `favicons/`, `og-images/`
- Delete old files when uploading new ones
- Support SVG files (no resizing needed)
- Optimize images (90% quality, proper dimensions)

### 4. Validation
- Validate all inputs in Form Request
- Use appropriate validation rules (email, url, regex for colors)
- Provide custom error messages
- Validate file types and sizes

### 5. Security
- Only allow admin users to update settings
- Validate file uploads (type, size)
- Sanitize custom CSS/JS before saving
- Use prepared statements (Laravel handles this)

### 6. Performance
- Cache settings for 1 hour
- Use eager loading if needed
- Optimize images on upload
- Minimize database queries

### 7. Type Safety
- Use proper casts in model (JSON, boolean, datetime)
- Validate types in Form Request
- Use accessors for computed values (URLs)

---

## 🔍 Troubleshooting

### Issue: Settings not updating on frontend

**Solution:**
1. Clear cache: `php artisan cache:clear`
2. Check if `SiteSetting::clearCache()` is called after update
3. Verify cache driver is working: `php artisan tinker` → `Cache::get('site_settings')`

### Issue: Images not displaying

**Solution:**
1. Check storage link: `php artisan storage:link`
2. Verify file path in database
3. Check `logo_url` accessor in model
4. Verify Storage disk is 'public'

### Issue: Cache not clearing

**Solution:**
1. Check model boot method has cache clearing events
2. Manually clear: `SiteSetting::clearCache()`
3. Check cache driver configuration

### Issue: Validation errors

**Solution:**
1. Check Form Request rules
2. Verify field names match database columns
3. Check custom error messages

### Issue: Helper methods returning null

**Solution:**
1. Check if settings record exists in database
2. Verify helper method implementation
3. Check error logs for exceptions
4. Ensure fallback values are provided

---

## 📦 Dependencies

### Required Packages

```json
{
    "require": {
        "intervention/image": "^3.0",
        "laravel/framework": "^10.0"
    }
}
```

### Installation

```bash
composer require intervention/image
```

### Storage Link

```bash
php artisan storage:link
```

---

## 🚀 Advanced Features

### 1. Maintenance Mode

```php
// In middleware or route
if (SiteSettingsHelper::isMaintenanceMode()) {
    return response()->view('maintenance', [
        'message' => SiteSettingsHelper::maintenanceMessage()
    ], 503);
}
```

### 2. Multi-Language Support

```php
$supportedLanguages = SiteSettingsHelper::all()->supported_languages;
$currentLanguage = SiteSettingsHelper::defaultLanguage();
```

### 3. Currency Formatting

```php
$currency = SiteSettingsHelper::defaultCurrency();
$formatted = number_format($price, 2) . ' ' . $currency;
```

### 4. Timezone Handling

```php
$timezone = SiteSettingsHelper::all()->timezone;
date_default_timezone_set($timezone);
```

---

## 📚 Summary

The Site Settings system provides:

✅ **Centralized Configuration** - All settings in one place  
✅ **Dynamic Updates** - Changes reflect immediately  
✅ **High Performance** - Caching for fast access  
✅ **Type Safety** - Automatic type casting  
✅ **File Management** - Logo, favicon, OG image uploads  
✅ **SEO Ready** - Meta tags, Open Graph support  
✅ **Theme Customization** - Dynamic colors  
✅ **Maintenance Mode** - Built-in toggle  
✅ **Error Handling** - Graceful fallbacks  
✅ **Security** - Admin-only access, validation  

This blueprint provides everything needed to replicate the system in any Laravel project!

---

**Last Updated:** November 14, 2025  
**Version:** 1.0.0

