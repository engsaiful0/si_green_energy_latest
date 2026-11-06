<?php

namespace App\Support\Pages;

use App\Support\PageSections;

/**
 * Company Profile page (Slaze about.html).
 */
class CompanyProfilePage
{
    public static function info(): array
    {
        return [
            'label' => 'Company Profile',
            'route' => 'company-profile',
            'views' => 'frontend.company-profile.sections',
        ];
    }

    public static function pageSection(): array
    {
        return PageSections::pageSettings(true, 'Company Profile', 'Si Green Energy is a Chattogram-based solar energy company that designs, supplies and installs solar power systems for homes, businesses and industry in Bangladesh.');
    }

    public static function cta(): array
    {
        return [
            'title' => 'Talk to Our Solar Experts',
            'text' => 'Whether you are planning a rooftop system for your home or a larger installation for your business, we are happy to help.',
            'button_text' => 'Contact Si Green Energy',
        ];
    }

    public static function sections(): array
    {
        $home = HomePage::sections();

        return [
            'features' => array_merge($home['features'], ['view' => 'frontend.home.sections.features']),

            'about' => [
                'name' => 'About the Company',
                'description' => 'Company introduction with two images and key points.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Who We Are'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Si Green Energy: Solar Engineering for Bangladesh'],
                    'text' => ['label' => 'Description', 'type' => 'textarea', 'default' => "Si Green Energy is a solar energy company based in Chattogram, Bangladesh. We help households, businesses, industries and farms generate their own clean electricity with solar power.\n\nOur work covers the full project: energy assessment, system design, supply of panels, inverters, batteries and mounting structures, installation, commissioning and after-sales maintenance."],
                    'button_text' => ['label' => 'Button Text', 'type' => 'text', 'default' => 'Our Solutions'],
                    'button_link' => ['label' => 'Button Link', 'type' => 'url', 'default' => '/solutions'],
                    'image_one' => ['label' => 'Large Image', 'type' => 'image', 'default' => 'img/about/about-5.jpg'],
                    'image_two' => ['label' => 'Small Image', 'type' => 'image', 'default' => 'img/about/about-6.jpg'],
                ],
                'repeaters' => [
                    'points' => [
                        'label' => 'Key Points',
                        'item_label' => 'Point',
                        'fields' => ['text' => ['label' => 'Text', 'type' => 'text']],
                        'default' => [
                            ['text' => 'Residential, commercial and industrial solar'],
                            ['text' => 'On-grid, off-grid and hybrid systems'],
                            ['text' => 'Design, installation and maintenance'],
                            ['text' => 'Based in Chattogram, Bangladesh'],
                        ],
                    ],
                ],
            ],

            'counters' => [
                'name' => 'Counters',
                'description' => 'Key figures with icons. Only use figures you can verify.',
                'fields' => [
                    'background_image' => ['label' => 'Background', 'type' => 'image', 'default' => 'img/shape/shape-18.png'],
                ],
                'repeaters' => [
                    'items' => [
                        'label' => 'Counters',
                        'item_label' => 'Counter',
                        'fields' => [
                            'icon' => ['label' => 'Icon Class', 'type' => 'icon'],
                            'value' => ['label' => 'Number', 'type' => 'text'],
                            'suffix' => ['label' => 'Suffix', 'type' => 'text', 'help' => 'e.g. + or k'],
                            'label' => ['label' => 'Label', 'type' => 'text'],
                        ],
                        'default' => [
                            ['icon' => 'flaticon-maintenance', 'value' => '10', 'suffix' => '', 'label' => 'Solar Services'],
                            ['icon' => 'flaticon-solar-energy', 'value' => '10', 'suffix' => '', 'label' => 'Solution Types'],
                            ['icon' => 'flaticon-solar-panels', 'value' => '8', 'suffix' => '', 'label' => 'Product Categories'],
                            ['icon' => 'flaticon-location-1', 'value' => '1', 'suffix' => '', 'label' => 'Office in Chattogram'],
                        ],
                    ],
                ],
            ],

            'experience' => [
                'name' => 'Expertise',
                'description' => 'Expertise text with optional progress bars and an image.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Our Expertise'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Solar Systems Designed for Local Conditions'],
                    'text' => ['label' => 'Text', 'type' => 'textarea', 'default' => "Heat, humidity, monsoon rain and frequent load-shedding all affect how a solar system should be designed in Bangladesh. We take them into account when we choose components, size batteries and design mounting structures.\n\nWe work on rooftop systems for homes and offices, larger rooftop and ground-mounted systems for factories, solar irrigation for agriculture and solar street lighting."],
                    'image' => ['label' => 'Image', 'type' => 'image', 'default' => 'img/pages/experience.jpg'],
                    'background_image' => ['label' => 'Background', 'type' => 'image', 'default' => 'img/shape/shape-20.jpg'],
                ],
                'repeaters' => [
                    'skills' => [
                        'label' => 'Progress Bars (optional)',
                        'item_label' => 'Bar',
                        'fields' => [
                            'label' => ['label' => 'Label', 'type' => 'text'],
                            'percent' => ['label' => 'Percent', 'type' => 'number'],
                        ],
                        'default' => [],
                    ],
                ],
            ],

            'mission' => [
                'name' => 'Mission & Vision',
                'description' => 'Company mission and vision with an image.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Mission & Vision'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Making Solar Power Practical and Accessible'],
                    'text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'We believe clean energy should be easy to understand, dependable in daily use and well supported after installation.'],
                    'mission_icon' => ['label' => 'Mission Icon', 'type' => 'icon', 'default' => 'flaticon-targeting'],
                    'mission_title' => ['label' => 'Mission Title', 'type' => 'text', 'default' => 'Our Mission'],
                    'mission_text' => ['label' => 'Mission Text', 'type' => 'textarea', 'default' => 'To deliver well-engineered solar power systems that help our customers in Bangladesh use clean, dependable energy.'],
                    'vision_icon' => ['label' => 'Vision Icon', 'type' => 'icon', 'default' => 'flaticon-achievement'],
                    'vision_title' => ['label' => 'Vision Title', 'type' => 'text', 'default' => 'Our Vision'],
                    'vision_text' => ['label' => 'Vision Text', 'type' => 'textarea', 'default' => 'A Bangladesh where homes, businesses and farms run on clean, locally generated solar energy.'],
                    'badge_number' => ['label' => 'Badge Number (optional)', 'type' => 'text', 'default' => ''],
                    'badge_text' => ['label' => 'Badge Text', 'type' => 'text', 'default' => 'Engineering-led solar solutions'],
                    'image' => ['label' => 'Image', 'type' => 'image', 'default' => 'img/pages/consultation.jpg'],
                    'badge_image' => ['label' => 'Badge Image', 'type' => 'image', 'default' => 'img/avatar/user.png'],
                    'card_background' => ['label' => 'Card Background', 'type' => 'image', 'default' => 'img/shape/shape-19.png'],
                    'shape_light' => ['label' => 'Background Shape (Light)', 'type' => 'image', 'default' => 'img/shape/shape-11.png'],
                    'shape_dark' => ['label' => 'Background Shape (Dark)', 'type' => 'image', 'default' => 'img/shape/shape-11-dark.png'],
                ],
            ],

            'team' => array_merge($home['team'], ['view' => 'frontend.home.sections.team']),
            'testimonials' => array_merge($home['testimonials'], ['view' => 'frontend.home.sections.testimonials']),
        ];
    }
}
