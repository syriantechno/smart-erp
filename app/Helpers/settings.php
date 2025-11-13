<?php

use App\Models\Setting;

/**
 * Get setting value by key
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
if (!function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        static $settings = null;

        if ($settings === null) {
            try {
                $settings = Setting::all()->pluck('value', 'key')->toArray();
            } catch (\Exception $e) {
                // If settings table doesn't exist, return default
                return $default;
            }
        }

        return $settings[$key] ?? $default;
    }
}

/**
 * Set setting value
 *
 * @param string $key
 * @param mixed $value
 * @param string $type
 * @param string $description
 * @return bool
 */
if (!function_exists('set_setting')) {
    function set_setting(string $key, $value, string $type = 'string', string $description = '')
    {
        return Setting::set($key, $value, $type, $description);
    }
}

/**
 * Get active theme
 *
 * @return string
 */
if (!function_exists('active_theme')) {
    function active_theme()
    {
        return setting('theme', 'icewall');
    }
}

/**
 * Get active layout
 *
 * @return string
 */
if (!function_exists('active_layout')) {
    function active_layout()
    {
        return setting('layout', 'side-menu');
    }
}

/**
 * Check if dark mode is enabled
 *
 * @return bool
 */
if (!function_exists('is_dark_mode')) {
    function is_dark_mode()
    {
        return setting('dark_mode', false);
    }
}

/**
 * Get primary color
 *
 * @return string
 */
if (!function_exists('primary_color')) {
    function primary_color()
    {
        return setting('primary_color', '#1e40af');
    }
}

/**
 * Get secondary color
 *
 * @return string
 */
if (!function_exists('secondary_color')) {
    function secondary_color()
    {
        return setting('secondary_color', '#7c3aed');
    }
}

/**
 * Get accent color
 *
 * @return string
 */
if (!function_exists('accent_color')) {
    function accent_color()
    {
        return setting('accent_color', '#06b6d4');
    }
}
