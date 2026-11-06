<?php

namespace App\Support\Pages;

class TeamPage extends ListingPage
{
    public static function info(): array
    {
        return ['label' => 'Solar Design Engineers Page', 'route' => 'team.index', 'views' => 'frontend.team.sections'];
    }

    public static function cta(): array
    {
        return ['title' => 'Talk to Our Experts', 'text' => 'Discuss your project directly with our solar design team.', 'button_text' => 'Talk to an Engineer'];
    }

    protected static function title(): string
    {
        return 'Solar Design Engineers';
    }

    protected static function metaDescription(): string
    {
        return 'Meet the solar design engineers and specialists at Si Green Energy.';
    }

    protected static function listingFields(): array
    {
        return [
            'empty_text' => ['label' => 'Text When Empty', 'type' => 'text', 'default' => 'Profiles of our solar design engineers will be published here soon. In the meantime, our team is happy to answer your questions.'],
            'bio_heading' => ['label' => 'Details: Biography Heading', 'type' => 'text', 'default' => 'Biography'],
            'qualifications_heading' => ['label' => 'Details: Qualifications Heading', 'type' => 'text', 'default' => 'Qualifications & Experience'],
            'skills_heading' => ['label' => 'Details: Skills Heading', 'type' => 'text', 'default' => 'Professional Skills'],
            'form_heading' => ['label' => 'Details: Contact Form Heading', 'type' => 'text', 'default' => 'Send a Message'],
            'form_button' => ['label' => 'Details: Form Button', 'type' => 'text', 'default' => 'Submit Message'],
        ];
    }
}
