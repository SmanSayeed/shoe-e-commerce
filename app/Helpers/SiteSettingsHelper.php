<?php

namespace App\Helpers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SiteSettingsHelper
{
    /**
     * Get a specific setting value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $settings = static::all();
        return $settings->$key ?? $default;
    }

    /**
     * Get all site settings.
     *
     * @return SiteSetting
     */
    public static function all(): SiteSetting
    {
        return SiteSetting::getSettings();
    }

    /**
     * Get website name.
     *
     * @return string
     */
    public static function websiteName(): string
    {
        return static::get('website_name', 'Shoeshop');
    }

    /**
     * Get logo URL.
     *
     * @return string|null
     */
    public static function logoUrl(): ?string
    {
        return static::all()->logo_url;
    }

    /**
     * Get favicon URL.
     *
     * @return string|null
     */
    public static function faviconUrl(): ?string
    {
        return static::all()->favicon_url;
    }

    /**
     * Get primary email.
     *
     * @return string|null
     */
    public static function primaryEmail(): ?string
    {
        return static::get('primary_email');
    }

    /**
     * Get primary phone.
     *
     * @return string|null
     */
    public static function primaryPhone(): ?string
    {
        return static::get('primary_phone');
    }

    /**
     * Get social media links.
     *
     * @return array
     */
    public static function socialLinks(): array
    {
        return static::get('social_media_links', []);
    }

    /**
     * Get default currency.
     *
     * @return string
     */
    public static function defaultCurrency(): string
    {
        return static::get('default_currency', 'BDT');
    }

    /**
     * Get default language.
     *
     * @return string
     */
    public static function defaultLanguage(): string
    {
        return static::get('default_language', 'en');
    }

    /**
     * Check if maintenance mode is enabled.
     *
     * @return bool
     */
    public static function isMaintenanceMode(): bool
    {
        return static::get('maintenance_mode', false);
    }

    /**
     * Get maintenance message.
     *
     * @return string|null
     */
    public static function maintenanceMessage(): ?string
    {
        return static::get('maintenance_message');
    }

    /**
     * Get Google Analytics ID.
     *
     * @return string|null
     */
    public static function googleAnalyticsId(): ?string
    {
        return static::get('google_analytics_id');
    }

    /**
     * Get custom CSS.
     *
     * @return string|null
     */
    public static function customCss(): ?string
    {
        return static::get('custom_css');
    }

    /**
     * Get custom JavaScript.
     *
     * @return string|null
     */
    public static function customJs(): ?string
    {
        return static::get('custom_js');
    }

    /**
     * Get meta title.
     *
     * @return string|null
     */
    public static function metaTitle(): ?string
    {
        return static::get('meta_title');
    }

    /**
     * Get meta description.
     *
     * @return string|null
     */
    public static function metaDescription(): ?string
    {
        return static::get('meta_description');
    }

    /**
     * Get meta keywords.
     *
     * @return string|null
     */
    public static function metaKeywords(): ?string
    {
        return static::get('meta_keywords');
    }

    /**
     * Get OG image URL.
     *
     * @return string|null
     */
    public static function ogImageUrl(): ?string
    {
        return static::all()->og_image_url;
    }
}

