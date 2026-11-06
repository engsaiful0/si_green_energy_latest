<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Builds the <title>, meta description and keywords for frontend pages.
 * Precedence: record SEO fields > CMS page "Banner & SEO" section > site defaults.
 */
class Seo
{
    /**
     * SEO for a CMS page (home, contact, blog listing, ...).
     */
    public static function page(string $page, ?string $heading = null): array
    {
        $settings = PageSections::settings($page);
        $site = SiteSettings::all();
        $heading = $heading ?: ($settings['title'] ?? $site['site_name']);

        return [
            'title' => $settings['meta_title'] ?: static::withSiteName($heading),
            'description' => $settings['meta_description'] ?: $site['meta_description'],
            'keywords' => $settings['meta_keywords'] ?? '',
        ];
    }

    /**
     * SEO for a single record (post, project, service...). Falls back to the record text.
     */
    public static function record(string $title, ?string $metaTitle, ?string $metaDescription, ?string $fallbackDescription = null): array
    {
        return [
            'title' => $metaTitle ?: static::withSiteName($title),
            'description' => $metaDescription ?: Str::limit(trim(strip_tags((string) $fallbackDescription)), 160),
            'keywords' => '',
        ];
    }

    public static function withSiteName(string $title): string
    {
        $siteName = SiteSettings::get('site_name');

        return $title === $siteName ? $title : $title . ' - ' . $siteName;
    }
}
