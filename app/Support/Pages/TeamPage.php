<?php

namespace App\Support\Pages;

class TeamPage extends ListingPage
{
    public static function info(): array
    {
        return ['label' => 'Solar Design Engineers Page', 'route' => 'team.index', 'views' => 'frontend.team.sections'];
    }

    protected static function title(): string
    {
        return 'Solar Design Engineers';
    }

    protected static function metaDescription(): string
    {
        return 'Meet the solar design engineers and specialists at SI Green Energy.';
    }

    protected static function listingFields(): array
    {
        return [
            'empty_text' => ['label' => 'Text When Empty', 'type' => 'text', 'default' => 'Team members will be introduced soon.'],
            'bio_heading' => ['label' => 'Details: Biography Heading', 'type' => 'text', 'default' => 'Biography'],
            'qualifications_heading' => ['label' => 'Details: Qualifications Heading', 'type' => 'text', 'default' => 'Qualifications & Experience'],
            'skills_heading' => ['label' => 'Details: Skills Heading', 'type' => 'text', 'default' => 'Professional Skills'],
            'form_heading' => ['label' => 'Details: Contact Form Heading', 'type' => 'text', 'default' => 'Send a Message'],
            'form_button' => ['label' => 'Details: Form Button', 'type' => 'text', 'default' => 'Submit Message'],
        ];
    }
}
