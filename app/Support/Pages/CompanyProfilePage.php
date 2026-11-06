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
        return PageSections::pageSettings(true, 'Company Profile', 'Who we are: our story, mission, vision and the team behind SI Green Energy.');
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
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'About us'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Rays of Progress & Solar Success'],
                    'text' => ['label' => 'Description', 'type' => 'textarea', 'default' => 'SI Green Energy designs, installs and maintains solar and renewable energy systems for homes, businesses and industry, helping every client move to clean, affordable power.'],
                    'button_text' => ['label' => 'Button Text', 'type' => 'text', 'default' => 'Contact Us'],
                    'button_link' => ['label' => 'Button Link', 'type' => 'url', 'default' => '/contact'],
                    'image_one' => ['label' => 'Large Image', 'type' => 'image', 'default' => 'img/about/about-5.jpg'],
                    'image_two' => ['label' => 'Small Image', 'type' => 'image', 'default' => 'img/about/about-6.jpg'],
                ],
                'repeaters' => [
                    'points' => [
                        'label' => 'Key Points',
                        'item_label' => 'Point',
                        'fields' => ['text' => ['label' => 'Text', 'type' => 'text']],
                        'default' => [['text' => 'Certified Engineers'], ['text' => 'Award Winning Company']],
                    ],
                ],
            ],

            'counters' => [
                'name' => 'Counters',
                'description' => 'Company figures with icons.',
                'fields' => [
                    'background_image' => ['label' => 'Background', 'type' => 'image', 'default' => 'img/shape/shape-18.png'],
                ],
                'repeaters' => [
                    'items' => [
                        'label' => 'Counters',
                        'item_label' => 'Counter',
                        'fields' => [
                            'icon' => ['label' => 'Icon Class', 'type' => 'icon'],
                            'value' => ['label' => 'Number', 'type' => 'text', 'help' => 'e.g. 1.2 or 700'],
                            'suffix' => ['label' => 'Suffix', 'type' => 'text', 'help' => 'e.g. k or +'],
                            'label' => ['label' => 'Label', 'type' => 'text'],
                        ],
                        'default' => [
                            ['icon' => 'flaticon-project', 'value' => '1.2', 'suffix' => 'k', 'label' => 'Projects Completed'],
                            ['icon' => 'flaticon-customer-review', 'value' => '700', 'suffix' => '+', 'label' => 'Client Reviews'],
                            ['icon' => 'flaticon-rating', 'value' => '175', 'suffix' => '+', 'label' => 'Team Members'],
                            ['icon' => 'flaticon-trophy', 'value' => '91', 'suffix' => '+', 'label' => 'Awards Won'],
                        ],
                    ],
                ],
            ],

            'experience' => [
                'name' => 'Experience',
                'description' => 'Experience text with skill bars and an image.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Our Experience'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Solar Team Experience'],
                    'text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'From rooftop systems to utility-scale plants, our engineers bring years of hands-on experience to every installation.'],
                    'image' => ['label' => 'Image', 'type' => 'image', 'default' => 'img/pages/experience.jpg'],
                    'background_image' => ['label' => 'Background', 'type' => 'image', 'default' => 'img/shape/shape-20.jpg'],
                ],
                'repeaters' => [
                    'skills' => [
                        'label' => 'Skill Bars',
                        'item_label' => 'Skill',
                        'fields' => [
                            'label' => ['label' => 'Label', 'type' => 'text'],
                            'percent' => ['label' => 'Percent', 'type' => 'number'],
                        ],
                        'default' => [
                            ['label' => 'Hybrid Energy', 'percent' => 76],
                            ['label' => 'Solar Panel', 'percent' => 85],
                            ['label' => 'Wind Turbines', 'percent' => 60],
                        ],
                    ],
                ],
            ],

            'mission' => [
                'name' => 'Mission & Vision',
                'description' => 'Company mission and vision with an image.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Mission & Vision'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'High Quality Solar Energy Solutions'],
                    'text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'We exist to make clean energy simple, reliable and affordable for everyone.'],
                    'mission_icon' => ['label' => 'Mission Icon', 'type' => 'icon', 'default' => 'flaticon-targeting'],
                    'mission_title' => ['label' => 'Mission Title', 'type' => 'text', 'default' => 'Company Mission'],
                    'mission_text' => ['label' => 'Mission Text', 'type' => 'textarea', 'default' => 'Deliver dependable renewable energy systems that cut costs and carbon.'],
                    'vision_icon' => ['label' => 'Vision Icon', 'type' => 'icon', 'default' => 'flaticon-achievement'],
                    'vision_title' => ['label' => 'Vision Title', 'type' => 'text', 'default' => 'Company Vision'],
                    'vision_text' => ['label' => 'Vision Text', 'type' => 'textarea', 'default' => 'A future where every home and business runs on clean energy.'],
                    'badge_number' => ['label' => 'Badge Number', 'type' => 'text', 'default' => '25,000'],
                    'badge_text' => ['label' => 'Badge Text', 'type' => 'text', 'default' => 'Satisfied Customers'],
                    'image' => ['label' => 'Image', 'type' => 'image', 'default' => 'img/pages/consultation.jpg'],
                    'badge_image' => ['label' => 'Badge Image', 'type' => 'image', 'default' => 'img/avatar/user.png'],
                    'card_background' => ['label' => 'Card Background', 'type' => 'image', 'default' => 'img/shape/shape-19.png'],
                    'shape_light' => ['label' => 'Background Shape (Light)', 'type' => 'image', 'default' => 'img/shape/shape-11.png'],
                    'shape_dark' => ['label' => 'Background Shape (Dark)', 'type' => 'image', 'default' => 'img/shape/shape-11-dark.png'],
                ],
            ],

            'team' => array_merge($home['team'], ['view' => 'frontend.home.sections.team']),
            'testimonials' => array_merge($home['testimonials'], ['view' => 'frontend.home.sections.testimonials']),
            'footer_cta' => array_merge($home['footer_cta'], ['view' => 'frontend.home.sections.footer_cta']),
        ];
    }
}
