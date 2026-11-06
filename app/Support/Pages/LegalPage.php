<?php

namespace App\Support\Pages;

use App\Support\Company;
use App\Support\PageSections;

/**
 * Text pages (privacy policy, terms). The body is one long text field: paragraphs are separated
 * by a blank line, and a short line without a full stop is shown as a sub-heading.
 */
abstract class LegalPage
{
    abstract protected static function title(): string;

    abstract protected static function route(): string;

    abstract protected static function body(): string;

    public static function info(): array
    {
        return ['label' => static::title(), 'route' => static::route(), 'views' => 'frontend.legal.sections'];
    }

    public static function pageSection(): array
    {
        return PageSections::pageSettings(true, static::title(), static::title() . ' of the ' . Company::NAME . ' website.');
    }

    public static function cta(): array
    {
        return ['title' => 'Questions? Contact Our Team', 'text' => 'Contact Si Green Energy and we will be glad to help.', 'button_text' => 'Contact Us'];
    }

    public static function sections(): array
    {
        return [
            'content' => [
                'name' => 'Page Text',
                'description' => 'The text of the page.',
                'fields' => [
                    'updated' => ['label' => 'Last Updated (shown above the text)', 'type' => 'text', 'default' => now()->format('F Y')],
                    'body' => ['label' => 'Text', 'type' => 'longtext', 'default' => static::body(), 'help' => 'Separate paragraphs with a blank line. A short line without a full stop becomes a heading.'],
                ],
            ],
        ];
    }
}
