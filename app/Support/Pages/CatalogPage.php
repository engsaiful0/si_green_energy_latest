<?php

namespace App\Support\Pages;

use App\Support\Company;
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
        return PageSections::pageSettings(true, 'Our ' . static::label(), 'Explore the ' . strtolower(static::label()) . ' offered by Si Green Energy.');
    }

    public static function cta(): array
    {
        return match (static::route()) {
            'products' => ['title' => 'Need Help Choosing the Right Equipment?', 'text' => 'Tell us what you want to power and we will recommend suitable panels, inverters and batteries.', 'button_text' => 'Request a Quotation'],
            'solutions' => ['title' => 'Request a Solar Solution', 'text' => 'Share your site details and energy needs, and our engineers will propose a solution that fits.', 'button_text' => 'Request a Solution'],
            default => ['title' => 'Get a Free Solar Consultation', 'text' => 'Talk to our engineers about design, installation or maintenance of your solar system.', 'button_text' => 'Book a Consultation'],
        };
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
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Solar Systems Built Around Your Needs'],
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
                            ['title' => 'Our Approach', 'text' => 'We start with your electricity bills, load profile and site conditions, then design a system that matches how you actually use power.', 'points' => "Site survey\nLoad assessment\nClear proposal\nNo-obligation advice"],
                            ['title' => 'Quality', 'text' => 'We select established panel, inverter and battery technologies and install them with proper mounting, cabling and electrical protection.', 'points' => "Proven technologies\nCorrect cable sizing\nDC and AC protection\nSecure mounting"],
                            ['title' => 'Support', 'text' => 'Solar systems need periodic care. We provide cleaning, inspection, troubleshooting and repair after installation.', 'points' => "Maintenance visits\nPerformance checks\nFault finding\nLocal team in Chattogram"],
                        ],
                    ],
                ],
            ],

            'faq' => [
                'name' => 'FAQs',
                'description' => 'Questions and answers (also shown on the ' . strtolower(static::singular()) . ' details pages).',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'FAQs'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Frequently Asked Questions'],
                    'text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Answers to the questions we hear most often from homeowners and businesses in Bangladesh.'],
                    'box_icon' => ['label' => 'Highlight Icon', 'type' => 'icon', 'default' => 'flaticon-trophy-1'],
                    'box_number' => ['label' => 'Highlight Number (optional)', 'type' => 'text', 'default' => '', 'help' => 'Leave empty to hide the highlight box.'],
                    'box_suffix' => ['label' => 'Highlight Suffix', 'type' => 'text', 'default' => ''],
                    'box_label' => ['label' => 'Highlight Label', 'type' => 'text', 'default' => ''],
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
                            ['question' => 'What size of solar system do I need?', 'answer' => 'It depends on how much electricity you use, when you use it, and the space available. We review your electricity bills and loads during a site survey and size the system accordingly.'],
                            ['question' => 'Should I choose an on-grid, off-grid or hybrid system?', 'answer' => 'On-grid systems work with the utility supply and need no batteries. Off-grid systems run independently with batteries. Hybrid systems combine both, so they can keep essential loads running during power cuts. We recommend the right type after understanding your needs.'],
                            ['question' => 'Do solar panels work during the monsoon?', 'answer' => 'Yes. Panels still produce electricity on cloudy days, although output is lower than in full sunshine. Systems are sized with seasonal variation in mind.'],
                            ['question' => 'What maintenance does a solar system need?', 'answer' => 'Mainly regular cleaning of the panels to remove dust, and periodic inspection of connections, protection devices, inverters and batteries. We offer maintenance and inspection services.'],
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
                        'default' => [['text' => 'Solar Panels'], ['text' => 'Inverters'], ['text' => 'Battery Storage'], ['text' => 'Installation'], ['text' => 'Maintenance']],
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
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'What Our Customers Say'],
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
                    'help_phone' => ['label' => 'Help Box Phone', 'type' => 'text', 'default' => Company::PHONE],
                    'help_image' => ['label' => 'Help Box Background', 'type' => 'image', 'default' => 'img/service/service-4.jpg'],
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
