<?php

namespace App\Support\Pages;

use App\Support\PageSections;

/**
 * Listing pages whose records come from their own module (projects, blog, team, testimonials).
 * The CMS manages the banner, SEO and a few listing texts.
 */
abstract class ListingPage
{
    abstract public static function info(): array;

    abstract protected static function title(): string;

    abstract protected static function metaDescription(): string;

    /** Extra listing fields (texts, items per page...). */
    abstract protected static function listingFields(): array;

    public static function pageSection(): array
    {
        return PageSections::pageSettings(true, static::title(), static::metaDescription());
    }

    public static function sections(): array
    {
        return [
            'listing' => [
                'name' => 'Listing Settings',
                'description' => 'Texts and options of the ' . strtolower(static::title()) . ' pages.',
                'render' => false,
                'fields' => static::listingFields(),
            ],
        ];
    }
}
