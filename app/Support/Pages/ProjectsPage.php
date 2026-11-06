<?php

namespace App\Support\Pages;

class ProjectsPage extends ListingPage
{
    public static function info(): array
    {
        return ['label' => 'Projects Page', 'route' => 'projects.index', 'views' => 'frontend.projects.sections'];
    }

    protected static function title(): string
    {
        return 'Projects';
    }

    protected static function metaDescription(): string
    {
        return 'Solar and renewable energy projects delivered by SI Green Energy.';
    }

    protected static function listingFields(): array
    {
        return [
            'per_page' => ['label' => 'Projects per Page', 'type' => 'number', 'default' => 9],
            'all_label' => ['label' => 'All Categories Filter Label', 'type' => 'text', 'default' => 'All'],
            'empty_text' => ['label' => 'Text When Empty', 'type' => 'text', 'default' => 'No projects have been published yet.'],
            'about_heading' => ['label' => 'Details: Description Heading', 'type' => 'text', 'default' => 'About Project'],
            'challenge_heading' => ['label' => 'Details: Challenge Heading', 'type' => 'text', 'default' => 'The Challenges'],
            'solution_heading' => ['label' => 'Details: Solution Heading', 'type' => 'text', 'default' => 'The Solutions'],
            'results_heading' => ['label' => 'Details: Results Heading', 'type' => 'text', 'default' => 'The Results'],
        ];
    }
}
