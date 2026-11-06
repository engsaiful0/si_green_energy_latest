<?php

namespace App\Support\Pages;

use App\Support\PageSections;

/**
 * Shared section set of the catalog listing pages (services, solutions, products),
 * based on Slaze service-two.html. The "sidebar" section configures the details pages
 * (service-right-sidebar.html).
 */
abstract class CatalogPage
{
    /** e.g. "Services" */
    abstract protected static function label(): string;

    /** e.g. "Service" */
    abstract protected static function singular(): string;

    /** frontend listing route name */
    abstract protected static function route(): string;

    public static function info(): array
    {
        return [
            'label' => static::label() . ' Page',
            'route' => static::route() . '.index',
            'views' => 'frontend.catalog.sections',
        ];
    }

    public static function pageSection(): array
    {
        return PageSections::pageSettings(true, 'Our ' . static::label(), 'Explore the ' . strtolower(static::label()) . ' offered by SI Green Energy.');
    }

    public static function sections(): array
    {
        $plural = strtolower(static::label());

        return [
            'listing' => [
                'name' => static::label() . ' Grid',
                'description' => 'The ' . $plural . ' list (records are managed in the ' . static::label() . ' module).',
                'fields' => [
                    'per_page' => ['label' => 'Items per Page', 'type' => 'number', 'default' => 9],
                    'link_text' => ['label' => 'Card Link Text', 'type' => 'text', 'default' => 'Details More'],
                    'empty_text' => ['label' => 'Text When Empty', 'type' => 'text', 'default' => 'Nothing has been published here yet.'],
                ],
            ],

            'who_we' => [
                'name' => 'Who We Are (Tabs)',
                'description' => 'Two images with tabbed text and check lists.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Who We Are'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Innovation in Solar Excellence'],
                    'image_one' => ['label' => 'Large Image', 'type' => 'image', 'default' => 'img/pages/who-we-1.jpg'],
                    'image_two' => ['label' => 'Small Image', 'type' => 'image', 'default' => 'img/pages/who-we-2.jpg'],
                    'background_image' => ['label' => 'Background', 'type' => 'image', 'default' => 'img/shape/shape-16.png'],
                ],
                'repeaters' => [
                    'tabs' => [
                        'label' => 'Tabs',
                        'item_label' => 'Tab',
                        'fields' => [
                            'title' => ['label' => 'Tab Title', 'type' => 'text'],
                            'text' => ['label' => 'Text', 'type' => 'textarea'],
                            'points' => ['label' => 'Check List (one per line)', 'type' => 'textarea'],
                        ],
                        'default' => [
                            ['title' => 'Modern Technology', 'text' => 'We use proven, high-efficiency panels, inverters and batteries backed by long manufacturer warranties.', 'points' => "Tier-1 Panels\nSmart Monitoring\nBattery Storage\nCertified Installers"],
                            ['title' => 'Solar Solution', 'text' => 'Every system is designed around your site, your consumption and your budget for the best possible return.', 'points' => "Free Site Survey\nCustom Design\nFinancing Options\nFast Installation"],
                            ['title' => 'Philosophy', 'text' => 'Clean energy should be simple. We handle everything from permits to maintenance so you do not have to.', 'points' => "Transparent Pricing\nLocal Support\nLong-term Care\nSafety First"],
                        ],
                    ],
                ],
            ],

            'faq' => [
                'name' => 'FAQs',
                'description' => 'Questions and answers (also shown on the ' . strtolower(static::singular()) . ' details pages).',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'FAQs'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Unlock Answers Explore FAQs'],
                    'text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Answers to the questions we hear most often from homeowners and businesses.'],
                    'box_icon' => ['label' => 'Highlight Icon', 'type' => 'icon', 'default' => 'flaticon-trophy-1'],
                    'box_number' => ['label' => 'Highlight Number', 'type' => 'text', 'default' => '20'],
                    'box_suffix' => ['label' => 'Highlight Suffix', 'type' => 'text', 'default' => '+'],
                    'box_label' => ['label' => 'Highlight Label', 'type' => 'text', 'default' => 'Winning awards'],
                ],
                'repeaters' => [
                    'items' => [
                        'label' => 'Questions',
                        'item_label' => 'Question',
                        'fields' => [
                            'question' => ['label' => 'Question', 'type' => 'text'],
                            'answer' => ['label' => 'Answer', 'type' => 'textarea'],
                        ],
                        'default' => [
                            ['question' => 'How much solar energy do I need?', 'answer' => 'It depends on your consumption. We review your bills and roof space during a free survey and size the system to match.'],
                            ['question' => 'How long does installation take?', 'answer' => 'Most residential systems are installed in one to three days once permits are approved.'],
                            ['question' => 'What maintenance is required?', 'answer' => 'Very little: periodic cleaning and an annual inspection, which our maintenance plans cover.'],
                        ],
                    ],
                ],
            ],

            'text_slider' => [
                'name' => 'Scrolling Text',
                'description' => 'Large scrolling words strip.',
                'fields' => [
                    'link' => ['label' => 'Words Link', 'type' => 'url', 'default' => '/' . static::route()],
                    'icon_image' => ['label' => 'Separator Icon', 'type' => 'image', 'default' => 'img/icon/star-1.png'],
                ],
                'repeaters' => [
                    'words' => [
                        'label' => 'Words',
                        'item_label' => 'Word',
                        'fields' => ['text' => ['label' => 'Text', 'type' => 'text']],
                        'default' => [['text' => 'Solar Panel'], ['text' => 'Wind Turbines'], ['text' => 'Hydropower'], ['text' => 'Maintenance']],
                    ],
                ],
            ],

            'testimonials' => [
                'name' => 'Testimonials',
                'description' => 'Approved testimonials slider. Managed under Testimonials.',
                'source' => 'testimonials',
                'manage' => ['label' => 'Manage Testimonials', 'route' => 'admin.testimonials.index'],
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Testimonial'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Shining Success Stories'],
                    'limit' => ['label' => 'Number of Testimonials', 'type' => 'number', 'default' => 6],
                ],
            ],

            'sidebar' => [
                'name' => 'Details Page Sidebar',
                'description' => 'Sidebar of each ' . strtolower(static::singular()) . ' details page: category list, downloads and help box.',
                'render' => false,
                'fields' => [
                    'categories_title' => ['label' => 'Category List Title', 'type' => 'text', 'default' => 'Our ' . static::label()],
                    'features_title' => ['label' => 'Features Heading', 'type' => 'text', 'default' => 'Our Core Features'],
                    'faq_title' => ['label' => 'FAQ Heading', 'type' => 'text', 'default' => 'Frequently Asked Questions'],
                    'downloads_title' => ['label' => 'Downloads Title', 'type' => 'text', 'default' => 'Download'],
                    'help_title' => ['label' => 'Help Box Title', 'type' => 'textarea', 'default' => 'Need help choosing the right system?'],
                    'help_label' => ['label' => 'Help Box Label', 'type' => 'text', 'default' => 'Quick Help'],
                    'help_phone' => ['label' => 'Help Box Phone', 'type' => 'text', 'default' => '+125 (895) 658 568'],
                    'help_image' => ['label' => 'Help Box Background', 'type' => 'image', 'default' => 'img/service/service-2.jpg'],
                ],
                'repeaters' => [
                    'downloads' => [
                        'label' => 'Downloads',
                        'item_label' => 'File',
                        'fields' => [
                            'label' => ['label' => 'Label', 'type' => 'text'],
                            'url' => ['label' => 'File URL', 'type' => 'url'],
                            'icon' => ['label' => 'Icon Class', 'type' => 'text', 'help' => 'e.g. fa-light fa-file-pdf'],
                        ],
                        'default' => [],
                    ],
                ],
            ],
        ];
    }
}
