<?php

if (!function_exists('site')) {
    /**
     * Get a site setting value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function site(string $key, $default = null)
    {
        return \App\Helpers\SiteSettingsHelper::get($key, $default);
    }
}

