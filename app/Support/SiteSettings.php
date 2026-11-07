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
                'site_name' => ['label' => 'Site Name', 'type' => 'text', 'default' => Company::NAME],
                'logo' => ['label' => 'Header Logo (white, on the green block)', 'type' => 'image', 'default' => 'img/brand-si/logo-white.svg'],
                'logo_light' => ['label' => 'Logo for Dark Backgrounds (footer, side panel, mobile menu)', 'type' => 'image', 'default' => 'img/brand-si/logo-light.svg'],
                'favicon' => ['label' => 'Favicon', 'type' => 'image', 'default' => 'img/brand-si/favicon.svg'],
                'meta_description' => ['label' => 'Default Meta Description', 'type' => 'textarea', 'default' => 'Si Green Energy designs, supplies and installs solar power systems for homes, businesses and industry in Chattogram and across Bangladesh.'],
            ],
            'Contact' => [
                'phone' => ['label' => 'Primary Mobile Number', 'type' => 'text', 'default' => Company::PHONE],
                'phone_secondary' => ['label' => 'Secondary Mobile Number', 'type' => 'text', 'default' => Company::PHONE_2],
                'email' => ['label' => 'Primary Email', 'type' => 'text', 'default' => Company::EMAIL],
                'support_email' => ['label' => 'Secondary Email', 'type' => 'text', 'default' => Company::EMAIL_2],
                'address' => ['label' => 'Office Address', 'type' => 'text', 'default' => Company::ADDRESS],
                'address_link' => ['label' => 'Map Link', 'type' => 'url', 'default' => Company::MAP_LINK],
            ],
            'Header' => [
                'header_button_text' => ['label' => 'Header Button Text', 'type' => 'text', 'default' => 'Solar Calculator'],
                'header_button_link' => ['label' => 'Header Button Link', 'type' => 'url', 'default' => '/solar-calculator'],
                'sidebar_text' => ['label' => 'Side Panel Text', 'type' => 'textarea', 'default' => 'Si Green Energy plans, supplies and installs solar power systems for homes, businesses and industry, with engineering support from the first site survey to long-term maintenance.'],
            ],
            'Social Links' => [
                'social_facebook' => ['label' => 'Facebook URL', 'type' => 'url', 'default' => Company::FACEBOOK],
                'social_twitter' => ['label' => 'X / Twitter URL', 'type' => 'url', 'default' => ''],
                'social_behance' => ['label' => 'Behance URL', 'type' => 'url', 'default' => ''],
                'social_linkedin' => ['label' => 'LinkedIn URL', 'type' => 'url', 'default' => ''],
                'social_instagram' => ['label' => 'Instagram URL', 'type' => 'url', 'default' => ''],
                'social_youtube' => ['label' => 'YouTube URL', 'type' => 'url', 'default' => ''],
            ],
            'Footer' => [
                'footer_address' => ['label' => 'Footer Address', 'type' => 'text', 'default' => Company::ADDRESS],
                'footer_background' => ['label' => 'Footer Background Shape', 'type' => 'image', 'default' => 'img/shape/shape-13.png'],
                'copyright' => ['label' => 'Copyright Text', 'type' => 'text', 'default' => 'Copyright :year - All Rights Reserved By Si Green Energy', 'help' => ':year is replaced with the current year'],
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
