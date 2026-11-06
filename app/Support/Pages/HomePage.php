<?php

namespace App\Support\Pages;

use App\Support\PageSections;

/**
 * Homepage (Slaze "Solar Energy" home, index-2.html).
 */
class HomePage
{
    public static function info(): array
    {
        return [
            'label' => 'Home Page',
            'route' => 'home',
            'views' => 'frontend.home.sections',
        ];
    }

    public static function sections(): array
    {
        return [
            'banner' => [
                'source' => 'sliders',
                'name' => 'Banner Slider',
                'description' => 'Hero slider. Slides are managed under Sliders.',
                'manage' => ['label' => 'Manage Slides', 'route' => 'admin.sliders.index'],
                'fields' => [
                    'shape_image' => ['label' => 'Decorative Shape', 'type' => 'image', 'default' => 'img/shape/shape-3.png'],
                ],
                'repeaters' => [
                    'counters' => [
                        'label' => 'Counters',
                        'item_label' => 'Counter',
                        'fields' => [
                            'value' => ['label' => 'Number', 'type' => 'text', 'help' => 'e.g. 38,846'],
                            'label' => ['label' => 'Label', 'type' => 'text'],
                        ],
                        'default' => [
                            ['value' => '38,846', 'label' => 'Successfully done'],
                            ['value' => '24,456', 'label' => 'Installed Capacity'],
                        ],
                    ],
                ],
            ],

            'features' => [
                'name' => 'Features',
                'description' => 'Trusted-partner strip below the banner.',
                'fields' => [
                    'title' => ['label' => 'Title', 'type' => 'text', 'default' => 'Your Trusted Energy Partner'],
                    'client_image' => ['label' => 'Clients Image', 'type' => 'image', 'default' => 'img/avatar/user.png'],
                    'client_text' => ['label' => 'Clients Text', 'type' => 'text', 'default' => '12,000+ Customer Reviews'],
                    'background_image' => ['label' => 'Background Shape', 'type' => 'image', 'default' => 'img/shape/shape-10.png'],
                ],
                'repeaters' => [
                    'items' => [
                        'label' => 'Feature Items',
                        'item_label' => 'Feature',
                        'fields' => [
                            'icon' => ['label' => 'Icon Class', 'type' => 'icon'],
                            'title' => ['label' => 'Title', 'type' => 'text'],
                            'text' => ['label' => 'Text', 'type' => 'textarea'],
                        ],
                        'default' => [
                            ['icon' => 'flaticon-profit', 'title' => 'Financial Savings', 'text' => 'Lower your energy bills from day one with efficient solar systems.'],
                            ['icon' => 'flaticon-best-customer-experience', 'title' => 'Well Experienced', 'text' => 'Certified engineers with years of renewable energy experience.'],
                        ],
                    ],
                ],
            ],

            'about' => [
                'name' => 'About',
                'description' => 'Who we are, skill bars, success rate and video.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Who we are'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Solar Passion Unveiled Our Story'],
                    'text' => ['label' => 'Text', 'type' => 'textarea', 'default' => "Our design philosophy is more than aesthetics; it's a dynamic process that delves into the heart of each project, understanding its needs, values, and aspirations."],
                    'image_main' => ['label' => 'Main Image', 'type' => 'image', 'default' => 'img/about/about-1.jpg'],
                    'image_secondary' => ['label' => 'Secondary Image', 'type' => 'image', 'default' => 'img/about/about-2.jpg'],
                    'progress_percent' => ['label' => 'Success Rate (%)', 'type' => 'number', 'default' => 87],
                    'progress_label' => ['label' => 'Success Rate Label', 'type' => 'text', 'default' => 'Project Success Rate'],
                    'button_text' => ['label' => 'Button Text', 'type' => 'text', 'default' => 'Unlock Power'],
                    'button_link' => ['label' => 'Button Link', 'type' => 'url', 'default' => '/about'],
                    'video_url' => ['label' => 'Video URL (YouTube)', 'type' => 'url', 'default' => 'https://youtube.com/watch?v=0WC-tD-njcA'],
                    'video_label' => ['label' => 'Video Label', 'type' => 'text', 'default' => 'Watch Video'],
                    'shape_light' => ['label' => 'Background Shape (Light)', 'type' => 'image', 'default' => 'img/shape/shape-11.png'],
                    'shape_dark' => ['label' => 'Background Shape (Dark)', 'type' => 'image', 'default' => 'img/shape/shape-11-dark.png'],
                    'image_shape' => ['label' => 'Image Shape', 'type' => 'image', 'default' => 'img/shape/shape-12.png'],
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
                            ['label' => 'Wind Turbines', 'percent' => 60],
                        ],
                    ],
                ],
            ],

            'services' => [
                'source' => 'services',
                'name' => 'Services',
                'description' => 'Published services (featured first). Services are managed under Services.',
                'manage' => ['label' => 'Manage Services', 'route' => 'admin.services.index'],
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => "We're the best"],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Solar Energy Services'],
                    'limit' => ['label' => 'Number of Services', 'type' => 'number', 'default' => 3],
                    'link_text' => ['label' => 'Card Link Text', 'type' => 'text', 'default' => 'Details More'],
                    'background_image' => ['label' => 'Section Background', 'type' => 'image', 'default' => 'img/shape/shape-9.png'],
                    'card_background' => ['label' => 'Card Background', 'type' => 'image', 'default' => 'img/shape/shape-5.png'],
                ],
            ],

            'cta' => [
                'name' => 'Call to Action',
                'description' => 'Phone call-to-action banner.',
                'fields' => [
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => "Harness the Sun\nGet Solar Power Today!"],
                    'icon' => ['label' => 'Icon Class', 'type' => 'icon', 'default' => 'flaticon-phone-call'],
                    'contact_label' => ['label' => 'Contact Label', 'type' => 'text', 'default' => 'Free contact 24/7'],
                    'phone' => ['label' => 'Phone', 'type' => 'text', 'default' => '+123 (568) 584 856'],
                    'background_image' => ['label' => 'Background', 'type' => 'image', 'default' => 'img/shape/shape-6.png'],
                ],
            ],

            'why_choose' => [
                'name' => 'Why Choose Us',
                'description' => 'Reasons to choose us, with image and contact line.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Why Choose Us'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Solar Leaders Your Ideal Partner'],
                    'text' => ['label' => 'Text', 'type' => 'textarea', 'default' => "Trust is not just a word for us; it's a commitment woven into the fabric of our interactions. Clients place their confidence in us because we consistently deliver."],
                    'button_text' => ['label' => 'Button Text', 'type' => 'text', 'default' => 'Own Tomorrow'],
                    'button_link' => ['label' => 'Button Link', 'type' => 'url', 'default' => '/about'],
                    'contact_text' => ['label' => 'Contact Text', 'type' => 'textarea', 'default' => "If you have any questions\nFeel free to contact"],
                    'phone' => ['label' => 'Phone', 'type' => 'text', 'default' => '+123 (548) 5256'],
                    'image' => ['label' => 'Image', 'type' => 'image', 'default' => 'img/pages/choose-us-1.jpg'],
                ],
                'repeaters' => [
                    'items' => [
                        'label' => 'Reasons',
                        'item_label' => 'Reason',
                        'fields' => [
                            'icon' => ['label' => 'Icon Class', 'type' => 'icon'],
                            'title' => ['label' => 'Title', 'type' => 'text'],
                        ],
                        'default' => [
                            ['icon' => 'flaticon-deal', 'title' => 'Partner Awaits'],
                            ['icon' => 'flaticon-talk', 'title' => 'Meets Commitment'],
                            ['icon' => 'flaticon-global-shipping', 'title' => 'Global Expertise'],
                        ],
                    ],
                ],
            ],

            'portfolio' => [
                'source' => 'projects',
                'name' => 'Project Gallery',
                'description' => 'Published projects (featured first). Projects are managed under Projects.',
                'manage' => ['label' => 'Manage Projects', 'route' => 'admin.projects.index'],
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Our Work'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Solar Project Gallery'],
                    'button_text' => ['label' => 'Button Text', 'type' => 'text', 'default' => 'View All Projects'],
                    'button_link' => ['label' => 'Button Link', 'type' => 'url', 'default' => '/projects/4-columns'],
                    'limit' => ['label' => 'Number of Projects', 'type' => 'number', 'default' => 6],
                ],
            ],

            'work_process' => [
                'name' => 'Work Process',
                'description' => 'Step-by-step process cards.',
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'How It Works'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Our Work Process'],
                ],
                'repeaters' => [
                    'steps' => [
                        'label' => 'Steps',
                        'item_label' => 'Step',
                        'fields' => [
                            'label' => ['label' => 'Step Label', 'type' => 'text', 'help' => 'e.g. Step 01'],
                            'title' => ['label' => 'Title', 'type' => 'text'],
                            'text' => ['label' => 'Text', 'type' => 'textarea'],
                            'image' => ['label' => 'Image', 'type' => 'image'],
                        ],
                        'default' => [
                            ['label' => 'Step 01', 'title' => 'Solar Assessment', 'text' => 'Evaluate energy needs and site feasibility.', 'image' => 'img/pages/work-1.jpg'],
                            ['label' => 'Step 02', 'title' => 'Innovative Design', 'text' => 'Collaborate on customized solar solutions.', 'image' => 'img/pages/work-2.jpg'],
                            ['label' => 'Step 03', 'title' => 'Efficient Installation', 'text' => 'Implement seamless solar panel installations.', 'image' => 'img/pages/work-3.jpg'],
                            ['label' => 'Step 04', 'title' => 'Triumph Transition', 'text' => 'Monitor and maintain solar systems.', 'image' => 'img/pages/work-4.jpg'],
                        ],
                    ],
                ],
            ],

            'team' => [
                'source' => 'team',
                'name' => 'Team',
                'description' => 'Active team members (featured first). Members are managed under Team Members.',
                'manage' => ['label' => 'Manage Team', 'route' => 'admin.team.index'],
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => "We're the best"],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Solar Design Engineers'],
                    'limit' => ['label' => 'Number of Members', 'type' => 'number', 'default' => 4],
                ],
            ],

            'testimonials' => [
                'source' => 'testimonials',
                'name' => 'Testimonials',
                'description' => 'Approved testimonials (featured first). Managed under Testimonials.',
                'manage' => ['label' => 'Manage Testimonials', 'route' => 'admin.testimonials.index'],
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'Testimonial'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Capturing Our Success Stories'],
                    'limit' => ['label' => 'Number of Testimonials', 'type' => 'number', 'default' => 6],
                    'background_image' => ['label' => 'Background', 'type' => 'image', 'default' => 'img/shape/shape-8.png'],
                ],
            ],

            'brands' => [
                'source' => 'partners',
                'name' => 'Partner Logos',
                'description' => 'Active partner logos slider. Managed under Partners.',
                'manage' => ['label' => 'Manage Partners', 'route' => 'admin.partners.index'],
                'fields' => [
                    'limit' => ['label' => 'Number of Logos', 'type' => 'number', 'default' => 12],
                ],
            ],

            'blog' => [
                'source' => 'blog',
                'name' => 'Latest Blog',
                'description' => 'Latest published blog posts. Managed under Blog Posts.',
                'manage' => ['label' => 'Manage Blog Posts', 'route' => 'admin.blog-posts.index'],
                'fields' => [
                    'subtitle' => ['label' => 'Subtitle', 'type' => 'text', 'default' => 'From the Blog'],
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Latest News & Blog'],
                    'button_text' => ['label' => 'Button Text', 'type' => 'text', 'default' => 'More Blog'],
                    'button_link' => ['label' => 'Button Link', 'type' => 'url', 'default' => '/blog'],
                    'limit' => ['label' => 'Number of Posts', 'type' => 'number', 'default' => 3],
                ],
            ],

            'footer_cta' => [
                'name' => 'Footer Call to Action',
                'description' => 'Call-to-action box above the footer.',
                'fields' => [
                    'title' => ['label' => 'Title', 'type' => 'textarea', 'default' => 'Harness the Sun Get Solar Power Today!'],
                    'button_text' => ['label' => 'Button Text', 'type' => 'text', 'default' => 'Start Today'],
                    'button_link' => ['label' => 'Button Link', 'type' => 'url', 'default' => '/quote'],
                    'help_label' => ['label' => 'Help Label', 'type' => 'text', 'default' => 'Need any help'],
                    'phone' => ['label' => 'Phone', 'type' => 'text', 'default' => '+123 (548) 5256'],
                    'image' => ['label' => 'Image', 'type' => 'image', 'default' => 'img/avatar/avatar-5.png'],
                    'background_image' => ['label' => 'Background', 'type' => 'image', 'default' => 'img/shape/shape-7.png'],
                ],
            ],
        ];
    }

    /**
     * Fields that are only used for SEO on the homepage.
     */
    public static function pageSection(): array
    {
        return PageSections::pageSettings(false, 'Home', 'SI Green Energy - Solar & Renewable Energy Solutions');
    }
}
