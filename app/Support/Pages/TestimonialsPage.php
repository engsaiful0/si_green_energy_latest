<?php

namespace App\Support\Pages;

class TestimonialsPage extends ListingPage
{
    public static function info(): array
    {
        return ['label' => 'Testimonials Page', 'route' => 'testimonials', 'views' => 'frontend.testimonials.sections'];
    }

    public static function cta(): array
    {
        return ['title' => 'Ready to Start Your Solar Project?', 'text' => 'Talk to Si Green Energy about clean, reliable solar power for your home or business.', 'button_text' => 'Get a Free Solar Consultation'];
    }

    protected static function title(): string
    {
        return 'Testimonials';
    }

    protected static function metaDescription(): string
    {
        return 'Customer feedback about solar systems designed and installed by Si Green Energy.';
    }

    protected static function listingFields(): array
    {
        return [
            'per_page' => ['label' => 'Testimonials per Page', 'type' => 'number', 'default' => 10],
            'empty_text' => ['label' => 'Text When Empty', 'type' => 'text', 'default' => 'Customer feedback will be published here soon.'],
        ];
    }
}
