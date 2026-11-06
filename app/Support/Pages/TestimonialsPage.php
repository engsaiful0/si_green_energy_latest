<?php

namespace App\Support\Pages;

class TestimonialsPage extends ListingPage
{
    public static function info(): array
    {
        return ['label' => 'Testimonials Page', 'route' => 'testimonials', 'views' => 'frontend.testimonials.sections'];
    }

    protected static function title(): string
    {
        return 'Testimonials';
    }

    protected static function metaDescription(): string
    {
        return 'What our customers say about SI Green Energy.';
    }

    protected static function listingFields(): array
    {
        return [
            'per_page' => ['label' => 'Testimonials per Page', 'type' => 'number', 'default' => 10],
            'empty_text' => ['label' => 'Text When Empty', 'type' => 'text', 'default' => 'No testimonials yet.'],
        ];
    }
}
