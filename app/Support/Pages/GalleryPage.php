<?php

namespace App\Support\Pages;

class GalleryPage extends ListingPage
{
    public static function info(): array
    {
        return ['label' => 'Gallery Page', 'route' => 'gallery', 'views' => 'frontend.gallery.sections'];
    }

    public static function cta(): array
    {
        return ['title' => 'Get Expert Solar Solutions Today', 'text' => 'Tell us about your site and our engineers will recommend the right solar system.', 'button_text' => 'Get a Free Consultation'];
    }

    protected static function title(): string
    {
        return 'Gallery';
    }

    protected static function metaDescription(): string
    {
        return 'Photo gallery of solar panel installation, solar equipment and engineering work from Si Green Energy.';
    }

    protected static function listingFields(): array
    {
        return [
            'intro' => ['label' => 'Introduction (optional)', 'type' => 'textarea', 'default' => ''],
            'all_label' => ['label' => 'All Categories Filter Label', 'type' => 'text', 'default' => 'All'],
            'limit' => ['label' => 'Maximum Images Shown', 'type' => 'number', 'default' => 120],
            'empty_text' => ['label' => 'Text When Empty', 'type' => 'text', 'default' => 'Gallery images will be published here soon.'],
        ];
    }
}
