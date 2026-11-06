<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

/**
 * Site-wide content shown on every frontend page (top bar, header, sidebar, footer).
 * Values live in the `settings` table (group "site") and are cached.
 */
class SiteSettings
{
    private const CACHE_KEY = 'site_settings';

    /** Per-request copy of all() (many views read the settings). */
    private static ?array $resolved = null;

    public static function groups(): array
    {
        return [
            'Branding' => [
                'site_name' => ['label' => 'Site Name', 'type' => 'text', 'default' => 'SI Green Energy'],
                'logo' => ['label' => 'Header Logo', 'type' => 'image', 'default' => 'img/logo-1.png'],
                'logo_light' => ['label' => 'Light Logo (sidebar, mobile menu, footer)', 'type' => 'image', 'default' => 'img/logo-2.png'],
                'favicon' => ['label' => 'Favicon', 'type' => 'image', 'default' => 'img/favicon-1.png'],
                'meta_description' => ['label' => 'Default Meta Description', 'type' => 'textarea', 'default' => 'SI Green Energy - Solar & Renewable Energy Solutions'],
            ],
            'Contact' => [
                'email' => ['label' => 'Primary Email (top bar)', 'type' => 'text', 'default' => 'info@sigreenenergy.com'],
                'address' => ['label' => 'Address (top bar)', 'type' => 'text', 'default' => '2464 Royal Ln. Mesa, New Jersey 45463'],
                'address_link' => ['label' => 'Map Link', 'type' => 'url', 'default' => 'https://google.com/maps'],
                'phone' => ['label' => 'Primary Phone', 'type' => 'text', 'default' => '+125 (895) 658 568'],
                'phone_secondary' => ['label' => 'Secondary Phone', 'type' => 'text', 'default' => '+12 (518) 451 45'],
                'support_email' => ['label' => 'Support Email (sidebar, footer)', 'type' => 'text', 'default' => 'support@sigreenenergy.com'],
            ],
            'Header' => [
                'header_button_text' => ['label' => 'Header Button Text', 'type' => 'text', 'default' => 'Talk with us'],
                'header_button_link' => ['label' => 'Header Button Link', 'type' => 'url', 'default' => '/quote'],
                'sidebar_text' => ['label' => 'Sidebar Popup Text', 'type' => 'textarea', 'default' => 'We design, install and maintain clean energy systems for homes and businesses, helping you cut costs and carbon at the same time.'],
            ],
            'Social Links' => [
                'social_facebook' => ['label' => 'Facebook URL', 'type' => 'url', 'default' => 'https://facebook.com/'],
                'social_twitter' => ['label' => 'X / Twitter URL', 'type' => 'url', 'default' => 'https://twitter.com/'],
                'social_behance' => ['label' => 'Behance URL', 'type' => 'url', 'default' => ''],
                'social_linkedin' => ['label' => 'LinkedIn URL', 'type' => 'url', 'default' => 'https://linkedin.com/'],
                'social_instagram' => ['label' => 'Instagram URL', 'type' => 'url', 'default' => ''],
                'social_youtube' => ['label' => 'YouTube URL', 'type' => 'url', 'default' => ''],
            ],
            'Footer' => [
                'footer_address' => ['label' => 'Footer Address', 'type' => 'text', 'default' => '8502 Preston Rd. Inglewood, Maine 98380 US'],
                'footer_background' => ['label' => 'Footer Background Shape', 'type' => 'image', 'default' => 'img/shape/shape-13.png'],
                'copyright' => ['label' => 'Copyright Text', 'type' => 'text', 'default' => 'Copyright :year - All Rights Reserved By SI Green Energy', 'help' => ':year is replaced with the current year'],
            ],
        ];
    }

    public static function fields(): array
    {
        return array_merge(...array_values(static::groups()));
    }

    public static function defaults(): array
    {
        return array_map(fn ($field) => $field['default'] ?? null, static::fields());
    }

    /**
     * All settings with defaults applied (empty saved values are kept, so admins can blank a field).
     */
    public static function all(): array
    {
        if (static::$resolved !== null) {
            return static::$resolved;
        }

        $saved = Cache::rememberForever(self::CACHE_KEY, function () {
            if (!Schema::hasTable('settings')) {
                return [];
            }

            return Setting::where('group', 'site')->pluck('value', 'key')->all();
        });

        $values = array_merge(static::defaults(), array_intersect_key($saved, static::fields()));

        // Images fall back to the theme image when cleared, so the layout never renders an empty <img>.
        foreach (static::fields() as $key => $field) {
            if ($field['type'] === 'image' && empty($values[$key])) {
                $values[$key] = $field['default'];
            }
        }

        return static::$resolved = $values;
    }

    public static function get(string $key, $default = null)
    {
        return static::all()[$key] ?? $default;
    }

    public static function save(array $values): void
    {
        foreach ($values as $key => $value) {
            if (array_key_exists($key, static::fields())) {
                Setting::set($key, $value, static::fields()[$key]['type'], 'site');
            }
        }

        static::flush();
    }

    public static function flush(): void
    {
        static::$resolved = null;
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Social links that have a URL, in display order.
     */
    public static function socialLinks(): array
    {
        $icons = [
            'social_facebook' => 'fab fa-facebook-f',
            'social_twitter' => 'fa-brands fa-x-twitter',
            'social_behance' => 'fab fa-behance',
            'social_linkedin' => 'fab fa-linkedin-in',
            'social_instagram' => 'fab fa-instagram',
            'social_youtube' => 'fab fa-youtube',
        ];

        $settings = static::all();
        $links = [];

        foreach ($icons as $key => $icon) {
            if (!empty($settings[$key])) {
                $links[] = ['url' => $settings[$key], 'icon' => $icon];
            }
        }

        return $links;
    }
}
